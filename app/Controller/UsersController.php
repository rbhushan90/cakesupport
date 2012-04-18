<?php
class UsersController extends AppController {
  public $name = 'Users';
  public $helpers = array('Form', 'Html');
  public $uses = array('User', 'ReportedUser');

  public function login() {
    if ($this->request->is('post')) {
      $user = $this->User->findByUsername($this->request->data['User']['username']);
      if(!$user) {
        $this->Session->setFlash('There is no account with that username.');
      }
      if(!($user['User']['permissions'] & Configure::read('permissions.login'))) {
        $this->Session->setFlash('This account has been banned. Please contact support.');
        $this->redirect('/');
      }
      $hash = hash("sha256", $this->request->data['User']['password']);
      if($user && $user['User']['password'] == $hash) {
        CakeSession::write('User.id', $user['User']['id']);
        CakeSession::write('User.username', $user['User']['username']);
        CakeSession::write('User.permissions', $user['User']['permissions']);
        $this->redirect('/');
      } else {
        $this->Session->setFlash("Incorrect login attempt");
      }
    }
  }

  public function permissions() {
    $this->User->id = $this->request->data['User']['id'];
    $user = $this->User->read();

    if(!$user) {
      $this->Session->setFlash('There is no account with that username.');
    }
    if(!(CakeSession::read('User.permissions') & Configure::read('permissions.admin'))) {
      $this->Session->setFlash('You do not have administrator privileges.');
      $this->redirect(array('controller' => 'users', 'action' => 'view', $user['User']['id']));
    }
    $permission = 0;
    foreach($this->request->data['User']['Permissions:'] as $perm) {
      $permission |= $perm;
    }
    $user['User']['permissions'] = $permission;
    $this->User->save($user);
    if(CakeSession::read('User.id') == $this->User->id) {
      CakeSession::write('User.permissions', $permissions);
    }
    $this->Session->setFlash('Permissions modified');
    $this->redirect(array('controller' => 'users', 'action' => 'view', $user['User']['id']));
  }

  public function register() {
    if ($this->request->is('post')) {
      $temp = $this->request->data['User']['password'];
      $this->request->data['User']['password'] = hash("sha256", $this->request->data['User']['password']);

      if ($this->User->save($this->request->data)) {
        $this->request->data['User']['password'] = $temp;
        $this->login();
        $this->redirect('/');
      }
    }
  }

  public function deactivate($id = null) {
    if(!$user) {
      $this->Session->setFlash('There is no account with that username.');
      $this->redirect('/');
    }
    if(CakeSession::read('User.permissions') & Configure::read('permissions.admin')) {
      $this->User->id = $id;
      $user = $this->User->read();
      $user['User']['permissions'] &= (-2);
      $this->User->save($user);
      $this->redirect('/admin');
    } else {
      $this->Session->setFlash('You do not have permission to (de)activate user accounts.');
      $this->redirect('/');
    }
  }

  public function activate($id = null) {
    if(CakeSession::read('User.permissions') & Configure::read('permissions.admin')) {
      $this->User->id = $id;
      $user = $this->User->read();
      $user['User']['permissions'] |= 1;
      $this->User->save($user);
      $this->redirect('/admin');
    } else {
      $this->Session->setFlash('You do not have permission to (de)activate user accounts.');
      $this->redirect('/');
    }
  }

  public function report($id = null) {
    $this->User->id = $id;
    $user = $this->User->read();
    if($this->Session->read('User.id')) {
      $this->Session->setFlash("This user has been reported.");
      $rc = array();
      $rc['ReportedUser']['reportee_id'] = $id;
      $rc['ReportedUser']['user_id'] = $this->Session->read('User.id');
      $this->ReportedUser->save($rc);
      $this->redirect(array('controller' => 'users', 'action' => 'view', $id));
    } else {
      $this->Session->setFlash("You need to be logged in to do that.");
      $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }
  }


  public function logout() {
    CakeSession::delete('User');
    $this->redirect('/');
  }

  public function view($id = null) {
    $this->User->id = $id;
    $user = $this->User->read();
    if($user == null) {
      $this->Session->setFlash('This user does not exist or has been deleted');
      $this->redirect('/');
    }

    $this->set('user', $user);
  }

  public function viewanswers($id = null) {
    if((CakeSession::read('User.permissions') & Configure::read('permissions.admin')) || (CakeSession::read('User.id') == $user['User']['id'])) {
      $this->view($id);
    } else {
      $this->Session->setFlash('You do not have permission to view this page.');
      $this->redirect('/');
    }
  }

  public function viewcomments($id = null) {
    if((CakeSession::read('User.permissions') & Configure::read('permissions.admin')) || (CakeSession::read('User.id') == $user['User']['id'])) {
      $this->view($id);
    } else {
      $this->Session->setFlash('You do not have permission to view this page.');
      $this->redirect('/');
    }
  }

  public function viewquestions($id = null) {
    if((CakeSession::read('User.permissions') & Configure::read('permissions.admin')) || (CakeSession::read('User.id') == $user['User']['id'])) {
      $this->view($id);
    } else {
      $this->Session->setFlash('You do not have permission to view this page.');
      $this->redirect('/');
    }
  }

}
?>
