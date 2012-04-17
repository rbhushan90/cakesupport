<?php
class ReportedQuestion extends AppModel {
  public $name = 'ReportedQuestion';

  public $belongsTo = array(
    'User' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    ),

    'Question' => array(
      'className' => 'Question',
      'foreignKey' => 'question_id',
      'dependent' => true
    )
  );
}
?>
