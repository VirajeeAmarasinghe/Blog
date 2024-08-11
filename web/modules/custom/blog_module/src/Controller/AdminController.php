<?php
namespace Drupal\blog_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\node\Entity\Node;
use Drupal\Core\Link;
use Drupal\Core\Url;

class AdminController extends ControllerBase
{
    public function manage()
    {
        // Custom logic for managing blog posts.
        return [
            '#markup' => 'Admin Blog Management Page',
        ];
    }

    public function viewAllPosts()
    {
        $header = [
            ['data' => $this->t('Title'), 'field' => 'title'],
            ['data' => $this->t('Author'), 'field' => 'uid'],
            ['data' => $this->t('Status')],
            ['data' => $this->t('Operations')],
        ];

        $rows = [];
        $query = \Drupal::entityQuery('node')
            ->condition('type', 'blog_post')
            ->sort('created', 'DESC');
        $nids = $query->execute();

        foreach ($nids as $nid) {
            $node = Node::load($nid);
            $rows[] = [
                'title' => Link::createFromRoute($node->getTitle(), 'entity.node.canonical', ['node' => $node->id()]),
                'author' => $node->getOwner()->getDisplayName(),
                'status' => $node->get('status')->value ? $this->t('Published') : $this->t('Draft'),
                'operations' => [
                    'data' => [
                        Link::createFromRoute($this->t('Edit'), 'entity.node.edit_form', ['node' => $node->id()]),
                        Link::createFromRoute($this->t('Delete'), 'entity.node.delete_form', ['node' => $node->id()]),
                    ],
                    'sortable' => FALSE,
                ],
            ];
        }

        $build['blog_post_table'] = [
            '#type' => 'table',
            '#header' => $header,
            '#rows' => $rows,
            '#empty' => $this->t('No blog posts available.'),
        ];

        return $build;
    }
}
