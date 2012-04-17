<?php
class Answer extends AppModel {
  public $name = 'Answer';

  public $belongsTo = array(
    'Question' => array(
      'className' => 'Question',
      'counterCache' => 'answer_count'
    ),
    'User' => array(
      'className' => 'User',
      'counterCache' => 'answer_count'
    )
  );

  public $validate = array(
    'body' => 'notEmpty'
  );
}
?>
