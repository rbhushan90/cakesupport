<?php
class Post extends AppModel {
  public $name = 'Post';
  public $useTable = 'blog_posts';

  public $belongsTo = array(
    'PostUser' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    )
  );

  public $hasMany = array(
    'PostComment' => array(
      'className' => 'Comment',
      'foreignKey' => 'post_id',
      'order' => 'PostComment.created DESC',
      'dependent' => true
    )
  );

  public $hasAndBelongsToMany = array(
    'Tag' => array(
      'className' => 'Tag',
      'joinTable' => 'post_tags',
      'foreignKey' => 'post_id',
      'unique' => 'true'
    ),
    'Category' => array(
      'className' => 'Category',
      'joinTable' => 'post_cats',
      'foreignKey' => 'post_id',
      'unique' => 'true'
    )
  );

  public $validate = array(
    'title' => 'notEmpty',
    'body' => 'notEmpty'
  );

}
?>
