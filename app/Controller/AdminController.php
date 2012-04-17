<?php
class AdminController extends AppController {
  public $name = 'Admin';
  public $helpers = array('Html', 'Form');
  public $uses = array('User', 'ReportedAnswer', 'ReportedQuestion','ReportedComment','ReportedUser');

  public function answers() {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.admin'))) {
      $this->Session->setFlash('You do not have the permissions to view the admin panel.');
      $this->redirect('/');
    }
    $this->set('answers', $this->ReportedAnswer->find('all'));
  }

  public function questions() {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.admin'))) {
      $this->Session->setFlash('You do not have the permissions to view the admin panel.');
      $this->redirect('/');
    }
    $this->set('questions', $this->ReportedQuestion->find('all'));
  }

  public function comments() {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.admin'))) {
      $this->Session->setFlash('You do not have the permissions to view the admin panel.');
      $this->redirect('/');
    }
    $this->set('comments', $this->ReportedComment->find('all'));
  }

  public function users() {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.admin'))) {
      $this->Session->setFlash('You do not have the permissions to view the admin panel.');
      $this->redirect('/');
    }
    $this->set('users', $this->ReportedUser->find('all'));
  }

  public function unreport($type, $id) {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.admin'))) {
      $this->Session->setFlash('You do not have the permissions to delete reports.');
      $this->redirect('/');
    }
    
    if(in_array($type, array('ReportedAnswer', 'ReportedQuestion','ReportedComment','ReportedUser'), true)){
      $this->$type->delete($id);
      $this->Session->setFlash('Report has been deleted.');
    }
    else{
      $this->Session->setFlash('Invalid report type specified.');
    }
    
    $this->redirect('/admin');
  }

  public function allusers() {
    $this->set('users', $this->User->find('all'));
    //$cond = array('answer_count' => 0);
    //$this->set('questions', $this->Question->find('all', array('conditions' => $cond)));
  }

}
?>
