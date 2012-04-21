<?php
class UserMetadata extends AppModel {
  public $name = 'UserMetadata';

  public $belongsTo = array(
    'User' => array(
      'className' => 'User',
    )
  );

}
?>
