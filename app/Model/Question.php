<?php
class Question extends AppModel {
  public $name = 'Question';

  public $belongsTo = array(
    'User' => array(
      'className' => 'User',
      'counterCache' => 'question_count'
    )
  );

  public $hasMany = array(
    'QuestionAnswer' => array(
      'className' => 'Answer',
      'order' => 'QuestionAnswer.accepted DESC, QuestionAnswer.created DESC',
      'dependent' => true
    )
  );

  public $hasOne = array(
    'AcceptedAnswer' => array(
      'className' => 'Answer',
      'conditions' => 'Question.accepted = AcceptedAnswer.id',
      'dependent' => true
    )
  );

  public $hasAndBelongsToMany = array(
    'Tag' => array(
      'className' => 'Tag',
      'unique' => 'true'
    )
  );

  public $validate = array(
    'title' => 'notEmpty',
    'body' => 'notEmpty'
  );
}
?>
