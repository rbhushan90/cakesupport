<?php
class UserMetadata extends AppModel {
  public $name = 'UserMetadata';
  public $primaryKey = 'user_id';

  public $belongsTo = array(
    'User' => array(
      'className' => 'User',
    )
  );

}
?>
