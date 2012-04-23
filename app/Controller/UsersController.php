<?php
class UsersController extends AppController {
  public $name = 'Users';
  public $helpers = array('Form', 'Html');
  public $uses = array('User', 'ReportedUser', 'UserMetadata');

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

  function generateRandom($length) {
    $random= "";
    $list = "ABCDEFGHIJKLMNOPQRSTUVWXYZabcdefghijklmnopqrstuvwxyz1234567890";

    for($i = 0; $i < $length; $i++)  {    
       $random .= substr($list,rand(0, strlen($list)-1), 1);  
    }  
    return $random;
  }

  public function login() {
    if ($this->request->data) {
      $user = $this->User->findByUsername($this->request->data['User']['username']);
      if(!$user) {
        $this->Session->setFlash('There is no account with that username.');
      }
      if(!($user['User']['permissions'] & Configure::read('permissions.login'))) {
        $this->Session->setFlash('This account has been banned or has not yet been validated.');
      }
      $hash = hash("sha256", $this->request->data['User']['password']);
      if($user && $user['User']['password'] == $hash) {
        CakeSession::write('User.id', $user['User']['id']);
        CakeSession::write('User.username', $user['User']['username']);
        CakeSession::write('User.permissions', $user['User']['permissions']);
        if(!isset($this->request->data['noredirect'])) {
          $this->redirect('/');
        }
      } else {
        $this->Session->setFlash("Incorrect login attempt");
      }
    }
  }

  public function password() {
    if($this->request->data['User']['id'] != CakeSession::read('User.id')) {
      $this->Session->setFlash('You cannot change somebody else\'s password');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
    if(strlen($this->request->data['User']['password']) < 8) {
      $this->Session->setFlash('New password is too short');
      $this->errorRedirect(array('controller' => 'users', 'action' => 'view', $this->request->data['User']['id']), '375 Unnecessary');
      return;
    }
    if($this->request->data['User']['confirm'] != $this->request->data['User']['password']) {
      $this->Session->setFlash('Confirmation password does not match');
      $this->errorRedirect(array('controller' => 'users', 'action' => 'view', $this->request->data['User']['id']), '375 Unnecessary');
      return;
    }
    $this->User->id = $this->request->data['User']['id'];
    $user = $this->User->read();
    if(!$user) {
      $this->Session->setFlash('Unknown user.');
      $this->errorRedirect(array('controller' => 'users', 'action' => 'view', $user['User']['id']), '375 Unnecessary');
      return;
    }
    $user['User']['password'] = hash("sha256", $this->request->data['User']['password']);
    if($this->User->save($user)) {
      $this->Session->setFlash('Password changed.');
    } else {
      $this->Session->setFlash('Could not change password.');
    }

    $this->errorRedirect(array('controller' => 'users', 'action' => 'view', $user['User']['id']), '375 Unnecessary');
  }

  public function permissions() {
    $this->User->id = $this->request->data['User']['id'];
    $user = $this->User->read();

    if(!$user) {
      $this->Session->setFlash('There is no account with that username.');
      $this->errorRedirect('/');
      return;
    }
    if(!(CakeSession::read('User.permissions') & Configure::read('permissions.userMod'))) {
      $this->Session->setFlash('You do not have administrator privileges.');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
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
      $this->request->data['User']['permissions'] = 0;
      $this->request->data['User']['password'] = hash("sha256", $this->request->data['User']['password']);

      if ($this->User->save($this->request->data)) {
        $this->Session->setFlash('A validation email has been sent to verify your email address');

        $user = $this->User->read();
        $md = array();
        $md['UserMetadata']['user_id'] = $user['User']['id'];
        $md['UserMetadata']['verification'] = $this->generateRandom(10);
        $this->UserMetadata->save($md);

        App::uses('CakeEmail', 'Network/Email');
        $email = new CakeEmail('registration');
        $email->template('welcome');
        $email->to($user['User']['email']);
        $email->subject('GMM Registration');
        $vars = array();
        $vars['fname'] = $user['User']['first_name'];
        $vars['url'] = 'http://' . $_SERVER['SERVER_NAME'] . '/users/verify/' . $user['User']['id'] . '/' . $md['UserMetadata']['verification'];
        $email->viewVars($vars);
        $email->send();

        $this->redirect('/');
      } else {
        $this->request->data['User']['password'] = $temp;
      }
    }
  }

  public function reset($id = null, $code = null) {
    if($code != null) {
      $this->UserMetadata->user_id = $id;
      $md = $this->UserMetadata->read();
      if($code != $md['UserMetadata']['reset_code']) {
        CakeSession::write('reset_id', $id);
        CakeSession::write('reset_code', $code);
      }
    } else {
      $reset_code = CakeSession::read('reset_code');
      $reset_id = CakeSession::read('reset_id');
      if(!$reset_code || !$reset_id) {
        return;
      }
      $this->User->id = $reset_id;
      $user = $this->User->read();

      if($user['UserMetadata']['reset_code'] != $reset_code) {
        CakeSession::delete('reset_code');
        CakeSession::delete('reset_id');
        $this->Session->setFlash('The reset code does not match. Please follow the link from your email or request another password reset.');
        $this->redirect('/');
      }
      if($this->request->data['User']['password'] == $this->request->data['User']['confirm']) {
        $user['User']['password'] = hash("sha256", $this->request->data['User']['password']);
        $user['UserMetadata']['reset_code'] = NULL;
        if($this->User->save($user)) {
          CakeSession::delete('reset_code');
          CakeSession::delete('reset_id');

          $this->login();
          $this->Session->setFlash('Your password was successfully changed.');
          $this->redirect('/');
        } else {
          $this->Session->setFlash('Could not change your password. Pleasy try again.');
        }
      } else {
        $this->Session->setFlash('Your password does not match the confirmation password');
      }
    }
  }

  public function forgot() {
    if($this->request->is('post')) {
      $usermail = $this->request->data['User']['usermail'];
      $this->User->recursive = 0;
      if(strrpos($usermail, '@') === false) {
        $user = $this->User->find('first', array('conditions' => array('User.username' => $usermail)));
      } else {
        $user = $this->User->find('first', array('conditions' => array('User.email' => $usermail)));
      }
      if(!$user) {
        $this->Session->setFlash('Could not find the requested user.');
        $this->errorRedirect('/users/forgot', '375 Unnecessary');
        return;
      }
      $user['UserMetadata']['reset_code'] = $this->generateRandom(10);
      $this->UserMetadata->save($user);

      App::uses('CakeEmail', 'Network/Email');
      $email = new CakeEmail('support');
      $email->template('password');
      $email->emailFormat('both');
      $email->to($user['User']['email']);
      $email->subject('Login Assistance');
      $vars = array();
      $vars['fname'] = $user['User']['first_name'];
      $vars['username'] = $user['User']['username'];
      $vars['url'] = 'http://' . $_SERVER['SERVER_NAME'] . '/users/reset/' . $user['User']['id'] . '/' . $user['UserMetadata']['reset_code'];
      $email->viewVars($vars);
      $email->send();

      $this->Session->setFlash('An email has been sent to your registered address with account details.');
      $this->redirect('/');
    }
  }

  public function verify($uid, $vcode) {
    $this->User->id = $uid;
    $user = $this->User->read();
    if(!$user) {
      $this->Session->setFlash('The requested user could not be found');
    } else {
      $this->UserMetadata->user_id = $uid;
      $md = $this->UserMetadata->read();
      if($md['UserMetadata']['verification'] == $vcode && $vcode != '') {
        $user['User']['permissions'] = 1;
        $this->User->save($user);
        $this->Session->setFlash('Email address validated');
        $md['UserMetadata']['verification'] = NULL;
        $this->UserMetadata->save($md);
        $this->request->data = $user;
        $this->login();
      }
    }
    $this->redirect('/');
  }

  public function deactivate($id = null) {
    $this->User->id = $id;
    $user = $this->User->read();
    if(!$user) {
      $this->Session->setFlash('There is no account with that username.');
      $this->errorRedirect('/');
      return;
    }
    if(CakeSession::read('User.permissions') & Configure::read('permissions.userMod')) {
      $user['User']['permissions'] = 0;
      $this->User->save($user);
      $this->errorRedirect('/admin/allusers', '375 Unnecessary');
    } else {
      $this->Session->setFlash('You do not have permission to (de)activate user accounts.');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
  }

  public function activate($id = null) {
    $this->User->id = $id;
    $user = $this->User->read();
    if(!$user) {
      $this->Session->setFlash('There is no account with that username.');
      $this->redirect('/');
    }
    if(CakeSession::read('User.permissions') & Configure::read('permissions.userMod')) {
      $user['User']['permissions'] |= 1;
      $this->User->save($user);
      $this->errorRedirect('/admin/allusers', '375 Unnecessary');
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
    $this->request->data['User']['id'] = $id;
    $this->set('user', $user);
  }

  public function viewanswers($id = null) {
    if((CakeSession::read('User.permissions') & Configure::read('permissions.userMod')) || (CakeSession::read('User.id') == $id)) {
      $this->view($id);
    } else {
      $this->Session->setFlash('You do not have permission to view this page.');
      $this->redirect('/');
    }
  }

  public function viewcomments($id = null) {
    if((CakeSession::read('User.permissions') & Configure::read('permissions.userMod')) || (CakeSession::read('User.id') == $id)) {
      $this->view($id);
    } else {
      $this->Session->setFlash('You do not have permission to view this page.');
      $this->redirect('/');
    }
  }

  public function viewquestions($id = null) {
    if((CakeSession::read('User.permissions') & Configure::read('permissions.userMod')) || (CakeSession::read('User.id') == $id)) {
      $this->view($id);
    } else {
      $this->Session->setFlash('You do not have permission to view this page.');
      $this->redirect('/');
    }
  }

}
?>
