<?php
class AnswersController extends AppController {
  public $name = 'Answers';
  public $helpers = array('Html', 'Form', 'Session');
  public $uses = array('Question', 'User', 'Answer', 'ReportedAnswer');

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

  public function post() {
    if(!$this->Session->read('User.id')) {
      $this->setFlash('You must be registered to post an answer');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
    $this->request->data['Answer']['user_id'] = $this->Session->read('User.id');
    $this->request->data['Answer']['body'] = htmlspecialchars($this->request->data['Answer']['body']); 

    if($this->Answer->save($this->request->data)) {
      $this->redirect(array('controller' => 'questions', 'action' => 'view', $this->data['Answer']['question_id']));
    } else {
      $this->Session->setFlash('Could not save answer');
      $this->errorredirect(array('controller' => 'questions', 'action' => 'view', $this->data['Answer']['question_id']), '500 Server Error');
      return;
    }
  }

  public function remove($id = null) {
    $this->Answer->id = $id;
    $ans = $this->Answer->read();
    if($ans['user_id'] == $this->Session->read('user.id') || $this->Session->read('User.permissions') & Configre::read('permissions.QAMod')) {
      if(!$this->Answer->delete($id)) {
        $this->errorredirect(array('controller' => 'questions', 'action' => 'view', $this->data['Answer']['question_id']), '500 Server Error');
      }
    } else {
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
    $this->redirect(array('controller' => 'questions', 'action' => 'view', $ans['Answer']['question_id']));
  }

  public function report($id = null) {
    $this->Answer->id = $id;
    $ans = $this->Answer->read();
    if($this->Session->read('User.id')) {
      $this->Session->setFlash("This answer has been reported.");
      $rc = array();
      $rc['ReportedAnswer']['answer_id'] = $ans['Answer']['id'];
      $rc['ReportedAnswer']['user_id'] = $this->Session->read('User.id');
      $this->ReportedAnswer->save($rc);
      $this->errorredirect(array('controller' => 'questions', 'action' => 'view', $this->data['Answer']['question_id']), '275 Unnecessary');
    } else {
      $this->Session->setFlash("You need to be logged in to do that.");
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
  }

  public function accept($id = null) {
    $this->Answer->id = $id;
    $ans = $this->Answer->read();
    if($ans == null) {
      $this->Session->setFlash("This answer does not exist.");
      $this->errorRedirect('/questions');
    }

    if(!($this->Session->read('User.permissions') & Configure::read('permissions.acceptAnswers'))) {
      $this->Session->setFlash("You do not have the appropriate permissions");
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }

    $ans['Answer']['accepted'] = true;
    $this->Answer->save($ans);
    $qid = $ans['Answer']['question_id'];
    $this->Question->id = $qid;
    $q = $this->Question->read();

    if($q['Question']['accepted']) {
      $this->Answer->id = $q['Question']['accepted'];
      $oldans = $this->Answer->read();
      $oldans['Answer']['accepted'] = 0;
      $this->Answer->save($oldans);
    }

    $q['Question']['accepted'] = $ans['Answer']['id'];
    $this->Question->save($q);

    $this->redirect(array('controller' => 'questions', 'action' => 'view', $q['Question']['id']));
  }

}

?>
