<?php
class ReportedUser extends AppModel {
  public $name = 'ReportedUser';

  public $belongsTo = array(
    'ReportedUserUser' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    ),

    'ReportedUserContent' => array(
      'className' => 'User',
      'foreignKey' => 'reportee_id',
      'dependent' => true
    )
  );
}
?>
