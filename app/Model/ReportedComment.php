<?php
class ReportedComment extends AppModel {
  public $name = 'ReportedComment';

  public $belongsTo = array(
    'ReportedCommentUser' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    ),

    'ReportedCommentContent' => array(
      'className' => 'Comment',
      'foreignKey' => 'comment_id',
      'dependent' => true
    )
  );
}
?>
