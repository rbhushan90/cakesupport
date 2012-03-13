<?php
class Answer extends AppModel {
  public $name = 'Answer';

  public $belongsTo = array(
    'AnswerQuestion' => array(
      'className' => 'Question',
      'foreignKey' => 'question_id',
      'counterCache' => 'answer_count'
    ),
    'AnswerUser' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    )
  );

  public $validate = array(
    'body' => 'notEmpty'
  );
}
?>
