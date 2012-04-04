<?php
class CommentsController extends AppController {
  public $name = 'Comment';
  public $helpers = array('Html', 'Form', 'Session');
  public $uses = array('Comment', 'Post', 'User', 'ReportedComment');

  public function post() {
    if(!$this->Session->read('User.id')) {
      $this->setFlash('You must be registered to post a comment');
      $this->redirect('/login');
    }
    $this->request->data['Comment']['user_id'] = $this->Session->read('User.id');
    $this->request->data['Comment']['body'] = htmlspecialchars($this->request->data['Comment']['body']); 

    if($this->Comment->save($this->request->data)) {
      $this->Session->setFlash('Comment posted');
    } else {
      $this->Session->setFlash('Could not add comment. Please try again later');
    }
    $this->redirect(array('controller' => 'posts', 'action' => 'view', $this->data['Comment']['post_id']));
  }

  public function remove($id = null) {
    $this->Comment->id = $id;
    $com = $this->Comment->read();
    if($com['user_id'] == $this->Session->read('user.id') || $this->Session->read('User.permissions') & Configre::read('permissions.blogMod')) {
      if(!$this->Comment->delete($id)) {
        $this->Session->setFlash('Could not delete comment. Please try again later.');
      }
    } else {
      $this->Session->setFlash('You cannot delete somebody else\'s comment.');
    }
    $this->redirect(array('controller' => 'posts', 'action' => 'view', $com['Comment']['post_id']));
  }

  public function report($id = null) {
    $this->Comment->id = $id;
    $com = $this->Comment->read();
    if($this->Session->read('User.id')) {
      $this->Session->setFlash("This comment has been reported.");
      $rc = array();
      $rc['ReportedComment']['comment_id'] = $com['Comment']['id'];
      $rc['ReportedComment']['user_id'] = $this->Session->read('User.id');
      $this->ReportedComment->save($rc);
      $this->redirect(array('controller' => 'posts', 'action' => 'view', $com['Comment']['post_id']));
    } else {
      $this->Session->setFlash("You need to be logged in to do that.");
      $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }
  }
}

?>
