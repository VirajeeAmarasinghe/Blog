<?php

namespace Drupal\blog_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Symfony\Component\HttpFoundation\Response;

class BlogController extends ControllerBase
{
    public function editorPosts()
    {
        // Get the current user.
        $current_user = \Drupal::currentUser();

        // Query to get blog posts authored by the current user.
        $query = \Drupal::entityQuery('node')
            ->condition('type', 'blog_post')
            ->condition('uid', $current_user->id());
        $nids = $query->execute();

        // Load the nodes.
        $nodes = Node::loadMultiple($nids);

        // Render the list of blog posts.
        $output = [];
        foreach ($nodes as $node) {
            $output[] = $node->toLink()->toString();
        }

        return [
            '#theme' => 'item_list',
            '#items' => $output,
            '#title' => $this->t('My Blog Posts'),
        ];
    }

    /**
     * Renders the preview of a blog post.
     *
     * @param \Drupal\node\Entity\Node $node
     *   The blog post node entity.
     *
     * @return \Symfony\Component\HttpFoundation\Response
     *   The response containing the rendered blog post.
     */
    public function preview(Node $node)
    {
        // Check if the node is of type 'blog_post'
        if ($node->bundle() !== 'blog_post') {
            throw new \Symfony\Component\HttpKernel\Exception\NotFoundHttpException();
        }

        // Render the node view
        $view = \Drupal::entityTypeManager()
            ->getViewBuilder('node')
            ->view($node, 'full');

        // Render the page
        return new Response(render($view));
    }
}
