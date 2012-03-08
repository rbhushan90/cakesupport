<?php
class QuestionsController extends AppController {
  public $name = 'Questions';
  public $helpers = array('Html', 'Form');
  public $uses = array('Question', 'User', 'Answer');

  public function index() {
    $this->set('questions', $this->Question->find('all',
      array('order' => 'Question.id desc')));
  }

  public function view($id = null) {
    $this->Question->id = $id;
    $q = $this->Question->read();
    $this->request->data['Answer']['question_id'] = $id;
    if($q == null) {
      $this->Session->setFlash('This question does not exist or has been deleted');
      $this->redirect('/');
    }

    for ($i=count($q['QuestionAnswer'])-1; $i >= 0; $i--) {
      $this->User->id = $q['QuestionAnswer'][$i]['user_id'];
      $user = $this->User->read();
      $q['QuestionAnswer'][$i]['username'] = $user['User']['username'];
    }

    $this->set('question', $q);
  }

  public function answer() {
    print_r($this->request->data);
  }

  public function edit($id = null) {
    $this->Question->id = $id;
    if($this->Question->read() == null) {
      $this->Session->setFlash('This question does not exist or has been deleted');
      $this->redirect('/');
    }
    if($this->request->is('get')) {
      $this->request->data = $this->Question->read();
    } else {
      if($this->Question->save($this->request->data)) {
        $this->Session->setFlash('Your post has been updated');
        $this->redirect('/');
      } else {
        $this->Session->setFlash('Unable to update your post');
      }
    }
  }

  public function remove($id = null) {
    $this->Question->id = $id;
    $q = $this->Question->read();
    if($q) {
      if($q['User']['id'] != $this->Session->read('User.id')) {
        $this->Session->setFlash('This post does not belong to you');
        $this->redirect(array('action' => 'view', $id));
      } else {
        if($this->Question->delete($id)) {
          $this->Session->setFlash('Post deleted');
          $this->redirect('/');
        } else {
          $this->Session->setFlash('There was a problem deleting this post');
          $this->redirect(array('action' => 'view', $id));
        }
      }
    } else {
      $this->Session->setFlash('No such question exists');
        $this->redirect('/');
    }
  }

  public function add() {
    if(!(CakeSession::read('User.username'))) {
      $this->Session->setFlash("You must be logged in to post a question");
      $this->redirect('/login');
    } else {
      if($this->request->is('post')) {
        $this->request->data['Question']['user_id'] = $this->Session->read('User.id');
        if($this->Question->save($this->request->data)) {
          $this->Session->setFlash('Your question has been added');
          $this->redirect('/');
        } else {
          $this->Session->setFlash('Could not add your question');
        }
      }
    }
  }

}
?>
