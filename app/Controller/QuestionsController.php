<?php
class QuestionsController extends AppController {
  public $name = 'Questions';
  public $helpers = array('Html', 'Form');
  public $uses = array('Question', 'User', 'Answer', 'Faq', 'ReportedQuestion', 'Tag');

  public function index() {
    $this->set('questions', $this->Question->find('all',
      array('order' => 'Question.id desc')));
    $this->set('tags', $this->Tag->find('all'));
  }

  public function unanswered() {
    $cond = array('Question.answer_count' => 0);
    $this->set('questions', $this->Question->find('all', array('conditions' => $cond)));
    $this->set('tags', $this->Tag->find('all'));
  }

  public function unaccepted() {
    $cond = array('accepted' => NULL);
    $this->set('questions', $this->Question->find('all', array('conditions' => $cond)));
    $this->set('tags', $this->Tag->find('all'));
  }

  public function view($id = null) {
    $this->Question->id = $id;
    $q = $this->Question->read();
    $this->request->data['Answer']['question_id'] = $id;
    if($q == null) {
      $this->Session->setFlash('This question does not exist or has been deleted');
      $this->redirect('/questions');
    }

    for ($i=count($q['QuestionAnswer'])-1; $i >= 0; $i--) {
      $this->User->id = $q['QuestionAnswer'][$i]['user_id'];
      $user = $this->User->read();
      $q['QuestionAnswer'][$i]['username'] = $user['User']['username'];
    }

    $faq = $this->Faq->find('first', array('conditions'=>array('question_id' => $id)));
    if(empty($faq)){
      $q['faq'] = false;
    } else {
      $q['faq'] = true;
      $q['faq_id'] = $faq['Faq']['id'];
    }

    $this->set('question', $q);
  }

  public function answer() {
    print_r($this->request->data);
  }

  public function report($id = null) {
    $this->Question->id = $id;
    $q = $this->Question->read();
    if($this->Session->read('User.id')) {
      $this->Session->setFlash("This quetsion has been reported.");
      $rc = array();
      $rc['ReportedQuestion']['question_id'] = $q['Question']['id'];
      $rc['ReportedQuestion']['user_id'] = $this->Session->read('User.id');
      $this->ReportedQuestion->save($rc);
      $this->redirect(array('controller' => 'questions', 'action' => 'view', $q['Question']['id']));
    } else {
      $this->Session->setFlash("You need to be logged in to do that.");
      $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }
  }

  public function edit($id = null) {
    $this->Question->id = $id;
    $q = $this->Question->read();
    if($q == null) {
      $this->Session->setFlash('This question does not exist or has been deleted');
      $this->redirect('/questions');
    }

    if($this->request->is('get')) {
      $this->request->data = $q;
      $this->set('tags', $this->Question->Tag->find('list'));
    } else {
      if($this->Session->read('User.id') == $q['User']['id'] || $this->Session->read('User.permissions') & Configure::read('permissions.QAMod')) {
        $this->request->data['Question']['modified'] = date('Y-m-d H:i:s');
        if($this->Question->save($this->request->data)) {
          $this->Session->setFlash('Your post has been updated');
          $this->redirect(array('action' => 'view', $id));
        } else {
          $this->Session->setFlash('There was a problem updating this post');
          $this->redirect(array('action' => 'view', $id));
        }
      } else {
        $this->Session->setFlash('This post does not belong to you');
        $this->redirect(array('action' => 'view', $id));
      }
    }
  }

  public function remove($id = null) {
    $this->Question->id = $id;
    $q = $this->Question->read();
    if($q) {
      if($this->Session->read('User.id') == $q['User']['id'] || $this->Session->read('User.permissions') & Configure::read('permissions.QAMod')) {
        if($this->Question->delete($id)) {
          //remove from faq if necessary
          $faq = $this->Faq->find('first', array('conditions'=>array('Faq.question_id' => $id)));
          $this->Faq->delete($faq['Faq']['id']);
          $this->Session->setFlash('Post deleted');
          $this->redirect('/');
        } else {
          $this->Session->setFlash('There was a problem deleting this post');
          $this->redirect(array('action' => 'view', $id));
        }
      } else {
        $this->Session->setFlash('This post does not belong to you');
        $this->redirect(array('action' => 'view', $id));
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
      $this->set('tags', $this->Question->Tag->find('list'));
      if($this->request->is('post')) {
        $this->request->data['Question']['user_id'] = $this->Session->read('User.id');
        if($this->Question->save($this->request->data)) {
          $this->Session->setFlash('Your question has been added');
          $this->redirect(array('controller'=>'questions', 'action'=>'index'));
        } else {
          $this->Session->setFlash('Could not add your question');
          $this->redirect(array('controller'=>'questions', 'action'=>'index'));
        }
      }
    }
  }

}
?>
