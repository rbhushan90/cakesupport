<?php
class Post extends AppModel {
  public $name = 'Post';

  public $belongsTo = array(
    'User' => array(
      'className' => 'User',
    )
  );

  public $hasMany = array(
    'PostComment' => array(
      'className' => 'Comment',
      'order' => 'PostComment.created DESC',
      'dependent' => true
    )
  );

  public $hasAndBelongsToMany = array(
    'Tag' => array(
      'className' => 'Tag',
      'unique' => 'true'
    ),
    'Category' => array(
      'className' => 'Category',
      'unique' => 'true'
    )
  );

  public $validate = array(
    'title' => 'notEmpty',
    'body' => 'notEmpty'
  );

}
?>
