<?php
class Report extends AppModel {
  public $name = 'Report';

  public $belongsTo = array(
    'ReportUser' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    ),

    'ReportQuestion' => array(
      'className' => 'Question',
      'foreignKey' => 'question_id',
      'dependent' => true
    )
  );

  public $validate = array();
}
?>
