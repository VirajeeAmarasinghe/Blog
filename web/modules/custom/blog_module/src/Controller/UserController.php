<?php
namespace Drupal\blog_module\Controller;

use Drupal\Core\Controller\ControllerBase;
use Drupal\user\Entity\User;
use Symfony\Component\HttpFoundation\RedirectResponse;
use Symfony\Component\HttpFoundation\Request;
use Drupal\Core\Url;

class UserController extends ControllerBase
{

    public function listing()
    {
        // Load all users.
        $users = User::loadMultiple();

        // Prepare the table rows.
        $rows = [];
        foreach ($users as $user) {
            $rows[] = [
                'username' => $user->getAccountName(),
                'email' => $user->getEmail(),
                'status' => $user->isActive() ? $this->t('Active') : $this->t('Blocked'),
                'operations' => [
                    'data' => [
                        '#type' => 'operations',
                        '#links' => $this->getUserOperations($user),
                    ],
                ],
            ];
        }

        // Build the table.
        $build['user_table'] = [
            '#type' => 'table',
            '#header' => [$this->t('Username'), $this->t('Email'), $this->t('Status'), $this->t('Operations')],
            '#rows' => $rows,
        ];

        return $build;
    }

    private function getUserOperations(User $user)
    {
        // Define operations like Edit, Block, Unblock.
        $operations = [];
        $operations['edit'] = [
            'title' => $this->t('Edit'),
            'url' => $user->toUrl('edit-form'),
        ];

        if ($user->isActive()) {
            $operations['block'] = [
                'title' => $this->t('Block'),
                'url' => Url::fromRoute('user.admin_block', ['user' => $user->id()]),
            ];
        } else {
            $operations['unblock'] = [
                'title' => $this->t('Unblock'),
                'url' => Url::fromRoute('user.admin_unblock', ['user' => $user->id()]),
            ];
        }

        return $operations;
    }

    public function suspend($user)
    {
        $account = User::load($user);

        if ($account) {
            // Block the user account.
            $account->block();
            $account->save();

            \Drupal::messenger()->addMessage($this->t('User %name has been suspended.', ['%name' => $account->getAccountName()]));
        } else {
            \Drupal::messenger()->addMessage($this->t('User not found.'), 'error');
        }

        // Redirect back to the user listing page.
        return new RedirectResponse(Url::fromRoute('blog_module.user_listing')->toString());
    }



}
