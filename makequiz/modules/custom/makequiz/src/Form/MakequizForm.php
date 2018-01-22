<?php

namespace Drupal\makequiz\Form;

use Drupal\Core\Form\FormBase;
use Drupal\Core\Form\FormStateInterface;

/**
 * Provides a form with two steps.
 *
 * This example demonstrates a multistep form with text input elements. We
 * extend FormBase which is the simplest form base class used in Drupal.
 *
 * @see \Drupal\Core\Form\FormBase
 */
class MakequizForm extends FormBase {
  

  //get all node ids to retrieve all the questions added so far
  public function getnodes() {
    $nids = \Drupal::entityQuery('node')->condition('type','question')->execute();
    $nodes =  \Drupal\node\Entity\Node::loadMultiple($nids);
    return $nodes;
  }
  
  /**
   * {@inheritdoc}
   */
  public function getFormId() {
    return 'makequiz_form';
  }

  /**
   * {@inheritdoc}
   */
  public function buildForm(array $form, FormStateInterface $form_state) {
    
    // Get the nodes
    $nodes = self::getnodes();
    $page_length = count($nodes);

    // Considering the initial page
    $page_length++;
    if ($form_state->has('page_num') && $form_state->get('page_num') == $page_length) {
      return self::submitPage($form, $form_state);
    }
    
    if ($form_state->has('page_num')) {
      $x = $form_state->get('page_num');
      $option = array();
      $optionvalues = array();
      $nodearray = array();

      // nodes[] keys are set by nid, so in order to set the indices starting from 0
      // copy nodes[] to nodesarray[]
      foreach($nodes as $n) {
        $nodearray[] = $n;
      }
    
      // $x holds the lastpage number
      $question = $nodearray[$x - 1]->get('body')->getValue();

      // The question resides in body->x-default->0->value [ No need to specify x-default ]
      $quest = $question[0]['value'];
      $options = $nodearray[$x - 1]->get('field_options')->getValue();
      $optval = array();
      foreach($options as $opt) {
        $optval[] = $opt['target_revision_id'];
      }
      $option = db_select('paragraph_revision__field_option', 't')
          ->fields('t',array('field_option_value'))->condition('revision_id', $optval, 'IN')->execute()
          ->fetchAll(); 
      foreach($option as $opt) {
        $optionvalues[] = $opt->field_option_value;
      }
      
      //Add fields to the form
      $form['description'] = [
        '#type' => 'item',
        '#title' => $this->t('Give your answer'),
      ];
  
      $form['Question'] = [
        '#title' => $this->t('First Name'),
        '#description' => $this->t('Enter your first name.'),
        '#markup' => $quest,
      ];
      $form['type'] = array(
        '#type' => 'radios',      
        '#default_value' => NULL,
        '#options' => $optionvalues,
      );
  
      
      // Group submit handlers in an actions element with a key of "actions" so
      // that it gets styled correctly, and so that other modules may add actions
      // to the form. This is not required, but is convention.
      $form['actions'] = [
        '#type' => 'actions',
      ];
  
      // Don't show back button for first question
      if ($x > 1) {
        $form['actions']['back'] = [
          '#type' => 'submit',
          '#button_type' => 'info',
          '#value' => $this->t('Back'),
          // Custom submission handler for 'Back' button.
          '#submit' => ['::previousPage'],
        ];
      }

      $form['actions']['next'] = [
        '#type' => 'submit',
        '#button_type' => 'primary',
        '#value' => $this->t('Next'),
        // Custom submission handler for page 1.
        '#submit' => ['::nextPage'],
        // Custom validation handler for page 1.
        //'#validate' => ['::fapiExampleMultistepFormNextValidate'],
      ];
  
      return $form;


    }
    else {
      $form_state->set('page_num', 0);
      $form['description'] = [
        '#type' => 'item',
        '#title' => $this->t('A basic multistep form (page 1)'),
      ];
  
      $form['first_name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('First Name'),
        '#description' => $this->t('Enter your first name.'),
        '#required' => TRUE,
      ];
  
      $form['last_name'] = [
        '#type' => 'textfield',
        '#title' => $this->t('Last Name'),
        '#description' => $this->t('Enter your last name.'),
      ];
  
      
      // Group submit handlers in an actions element with a key of "actions" so
      // that it gets styled correctly, and so that other modules may add actions
      // to the form. This is not required, but is convention.
      $form['actions'] = [
        '#type' => 'actions',
      ];

      $form['actions']['next'] = [
        '#type' => 'submit',
        '#button_type' => 'primary',
        '#value' => $this->t('Next'),
        // Custom submission handler for page 1.
        '#submit' => ['::nextPage'],
        // Custom validation handler for page 1.
        //'#validate' => ['::fapiExampleMultistepFormNextValidate'],
      ];
  
      return $form;
    }
    
    
  }

  /**
   * {@inheritdoc}
   */
  public function submitForm(array &$form, FormStateInterface $form_state) {
    $page_values = $form_state->get('page_values');

    drupal_set_message($this->t('The form has been submitted.', [
      '@first' => $page_values['first_name'],
      '@last' => $page_values['last_name'],
    ]));

    drupal_set_message($this->t('You can share the link with your friends'));
  }

  /**
   * Provides custom validation handler for page 1.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function fapiExampleMultistepFormNextValidate(array &$form, FormStateInterface $form_state) {
    $birth_year = $form_state->getValue('birth_year');

    if ($birth_year != '' && ($birth_year < 1900 || $birth_year > 2000)) {
      // Set an error for the form element with a key of "birth_year".
      $form_state->setErrorByName('birth_year', $this->t('Enter a year between 1900 and 2000.'));
    }
  }

  /**
   * Provides custom submission handler for page 1.
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function nextPage(array &$form, FormStateInterface $form_state) {
    
    //get last page number
    $x = $form_state->getStorage();
    $cur_page = $x['page_num'];

    $form_state
     /* ->set('page_values', [
        // Keep only first step values to minimize stored data.
        'first_name' => $form_state->getValue('first_name'),
        'last_name' => $form_state->getValue('last_name'),
      ])*/
      ->set('page_num', $cur_page + 1)
      ->setRebuild(TRUE);
  }

  /**
   * Builds the second step form (page 2).
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   *
   * @return array
   *   The render array defining the elements of the form.
   */
  public function submitPage(array &$form, FormStateInterface $form_state) {

    $form['description'] = [
      '#type' => 'item',
      '#title' => $this->t('Quiz creation submit'),
    ];

    $form['back'] = [
      '#type' => 'submit',
      '#button_type' => 'link',
      '#value' => $this->t('Back'),
      // Custom submission handler for 'Back' button.
      '#submit' => ['::previousPage'],
    ];
    $form['submit'] = [
      '#type' => 'submit',
      '#button_type' => 'success',
      '#value' => $this->t('Submit'),
    ];

    return $form;
  }

  /**
   * Provides custom submission handler for 'Back' button (page 2).
   *
   * @param array $form
   *   An associative array containing the structure of the form.
   * @param \Drupal\Core\Form\FormStateInterface $form_state
   *   The current state of the form.
   */
  public function previousPage(array &$form, FormStateInterface $form_state) {

    // Get the last visited page number
    $x = $form_state->getStorage();
    $previous_page = $x['page_num'];
    $previous_page--;

    $form_state
      // Restore values for the first step.
      // ->setValues($form_state->get('page_values'))
      ->set('page_num', $previous_page)
      ->setRebuild(TRUE);
  }

}
