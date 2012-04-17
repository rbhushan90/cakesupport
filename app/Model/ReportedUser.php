<?php
class ReportedUser extends AppModel {
  public $name = 'ReportedUser';

  public $belongsTo = array(
    'User' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    ),

    'Reportee' => array(
      'className' => 'User',
      'foreignKey' => 'reportee_id',
      'dependent' => true
    )
  );
}
?>
