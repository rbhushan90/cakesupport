<?php
class UsersController extends AppController {
  public $name = 'Users';
  public $helpers = array('Form', 'Html');

  public function login() {
    if ($this->request->is('post')) {
      $user = $this->User->findByUsername($this->request->data['User']['username']);
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

  private function verify($user) {
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

  public function logout() {
    CakeSession::delete('User');
    $this->redirect('/');
  }

  public function view($id = null) {
    $this->User->id = $id;
    $user = $this->User->read();
    $this->request->data['Answer']['question_id'] = $id;
    if($user == null) {
      $this->Session->setFlash('This user does not exist or has been deleted');
      $this->redirect('/');
    }

    $this->set('user', $user);
  }

  public function viewanswers($id = null) {
    $this->view($id);
  }

  public function viewquestions($id = null) {
    $this->view($id);
  }

}
?>
