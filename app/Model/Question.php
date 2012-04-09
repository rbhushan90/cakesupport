<?php
class Question extends AppModel {
  public $name = 'Question';

  public $belongsTo = array(
    'User' => array(
      'className' => 'User',
      'foreignKey' => 'user_id',
      'counterCache' => 'question_count'
    )
  );

  public $hasMany = array(
    'QuestionAnswer' => array(
      'className' => 'Answer',
      'foreignKey' => 'question_id',
      'order' => 'QuestionAnswer.accepted DESC, QuestionAnswer.created DESC',
      'dependent' => true
    )
  );

  public $hasAndBelongsToMany = array(
    'Tag' => array(
      'className' => 'Tag',
      'joinTable' => 'question_tags',
      'foreignKey' => 'question_id',
      'unique' => 'true'
    )
  );

  public $validate = array(
    'title' => 'notEmpty',
    'body' => 'notEmpty'
  );
}
?>
