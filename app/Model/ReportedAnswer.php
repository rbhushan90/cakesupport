<?php
class ReportedAnswer extends AppModel {
  public $name = 'ReportedAnswer';

  public $belongsTo = array(
    'User' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    ),

    'Answer' => array(
      'className' => 'Answer',
      'foreignKey' => 'answer_id',
      'dependent' => true
    )
  );
}
?>
