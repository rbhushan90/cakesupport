<?php
class Comment extends AppModel {
  public $name = 'Comment';

  public $belongsTo = array(
    'CommentPost' => array(
      'className' => 'Post',
      'foreignKey' => 'post_id',
      'counterCache' => 'comment_count'
    ),
    'CommentUser' => array(
      'className' => 'User',
      'foreignKey' => 'user_id',
      'counterCache' => 'comment_count'
    )
  );

  public $validate = array(
    'body' => 'notEmpty'
  );
}
?>
