<?php
class ReportedAnswer extends AppModel {
  public $name = 'ReportedAnswer';

  public $belongsTo = array(
    'ReportedAnswerUser' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    ),

    'ReportedAnswerContent' => array(
      'className' => 'Answer',
      'foreignKey' => 'answer_id',
      'dependent' => true
    )
  );
}
?>
