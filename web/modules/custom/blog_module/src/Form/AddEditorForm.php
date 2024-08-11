<?php
namespace Drupal\blog_module\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;
use Drupal\user\Entity\User;

class AddEditorForm extends FormBase
{

    public function getFormId()
    {
        return 'add_editor_form';
    }

    public function buildForm(array $form, FormStateInterface $form_state)
    {
        $form['username'] = [
            '#type' => 'textfield',
            '#title' => $this->t('Username'),
            '#required' => TRUE,
        ];

        $form['email'] = [
            '#type' => 'email',
            '#title' => $this->t('Email'),
            '#required' => TRUE,
        ];

        $form['password'] = [
            '#type' => 'password',
            '#title' => $this->t('Password'),
            '#required' => TRUE,
        ];

        $form['submit'] = [
            '#type' => 'submit',
            '#value' => $this->t('Add Editor'),
        ];

        return $form;
    }

    public function validateForm(array &$form, FormStateInterface $form_state)
    {

    }

    public function submitForm(array &$form, FormStateInterface $form_state)
    {
        $values = $form_state->getValues();

        $user = User::create([
            'name' => $values['username'],
            'mail' => $values['email'],
            'pass' => $values['password'],
            'status' => 1,
            'roles' => ['editor'], // Assign the Editor role.
        ]);

        $user->save();

        \Drupal::messenger()->addMessage($this->t('The editor %username has been added.', ['%username' => $values['username']]));

        $form_state->setRedirect('blog_module.user_listing'); // Redirect to user listing page.
    }
}
