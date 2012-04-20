<?php
class AdminController extends AppController {
  public $name = 'Admin';
  public $helpers = array('Html', 'Form');
  public $uses = array('User', 'ReportedAnswer', 'ReportedQuestion','ReportedComment','ReportedUser');

  public function beforeFilter() {
    if($this->request->is('ajax')) {
      $this->layout = 'content';
    }
  }

  function errorRedirect($url = '/', $code = '404 Not Found') {
    if($this->request->is('ajax')) {
      $this->header('HTTP/1.1 ' . $code);
    } else {
      $this->redirect($url);
    }
  }

  public function answers() {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.admin'))) {
      $this->Session->setFlash('You do not have the permissions to view the admin panel.');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
    $this->set('answers', $this->ReportedAnswer->find('all'));
  }

  public function questions() {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.admin'))) {
      $this->Session->setFlash('You do not have the permissions to view the admin panel.');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
    $this->set('questions', $this->ReportedQuestion->find('all'));
  }

  public function comments() {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.admin'))) {
      $this->Session->setFlash('You do not have the permissions to view the admin panel.');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
    $this->set('comments', $this->ReportedComment->find('all'));
  }

  public function users() {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.admin'))) {
      $this->Session->setFlash('You do not have the permissions to view the admin panel.');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
    $this->set('users', $this->ReportedUser->find('all'));
  }

  public function unreport($type, $id) {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.admin'))) {
      $this->Session->setFlash('You do not have the permissions to delete reports.');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
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
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.admin'))) {
      $this->Session->setFlash('You do not have the permissions to view the admin panel.');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
    $options = array('order' => 'User.id desc', 'conditions' => array('User.permissions <> 0'));
    if($this->request->data) {
      if($this->request->data['User']['inactive'] == '1') {
        $options['conditions'] = array();
      }
      $searchstr = $this->request->data['User']['search'];
      $options['conditions']['or'] = array(
            "User.email LIKE" => "%$searchstr%",
            "User.username LIKE" => "%$searchstr%"
      );
    }
    $this->set('users', $this->User->find('all', $options));
  }

}
?>
