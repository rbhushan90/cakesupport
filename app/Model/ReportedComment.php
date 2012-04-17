<?php
class ReportedComment extends AppModel {
  public $name = 'ReportedComment';

  public $belongsTo = array(
    'User' => array(
      'className' => 'User',
      'foreignKey' => 'user_id'
    ),

    'Comment' => array(
      'className' => 'Comment',
      'foreignKey' => 'comment_id',
      'dependent' => true
    )
  );
}
?>
