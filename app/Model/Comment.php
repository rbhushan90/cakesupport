<?php
class Comment extends AppModel {
  public $name = 'Comment';

  public $belongsTo = array(
    'Post' => array(
      'className' => 'Post',
      'counterCache' => 'comment_count'
    ),
    'User' => array(
      'className' => 'User',
      'counterCache' => 'comment_count'
    )
  );

  public $validate = array(
    'body' => 'notEmpty'
  );
}
?>
