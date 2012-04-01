<?php
class BlogPost extends AppModel {
  public $name = 'BlogPost';

  public $belongsTo = array(
    'BlogPostUser' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    )
  );

}
?>
