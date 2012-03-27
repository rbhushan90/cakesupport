<?php
class ReportedQuestion extends AppModel {
  public $name = 'ReportedQuestion';

  public $belongsTo = array(
    'ReportedQuestionUser' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    ),

    'ReportedQuestionContent' => array(
      'className' => 'Question',
      'foreignKey' => 'question_id',
      'dependent' => true
    )
  );
}
?>
