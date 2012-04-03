<?php
class AnswersController extends AppController {
  public $name = 'Answers';
  public $helpers = array('Html', 'Form', 'Session');
  public $uses = array('Question', 'User', 'Answer', 'Faq', 'ReportedAnswer');

  public function post() {
    if(!$this->Session->read('User.id')) {
      $this->setFlash('You must be registered to post an answer');
      $this->redirect('/login');
    }
    $this->request->data['Answer']['user_id'] = $this->Session->read('User.id');
    $this->request->data['Answer']['body'] = htmlspecialchars($this->request->data['Answer']['body']); 

    if($this->Answer->save($this->request->data)) {
      $this->redirect(array('controller' => 'questions', 'action' => 'view', $this->data['Answer']['question_id']));
    } else {
      $this->Session->setFlash('Could not save answer');
      $this->redirect(array('controller' => 'questions', 'action' => 'view', 
          $this->request->data['Answer']['question_id'])); 
    }
  }

  public function remove($id = null) {
    $this->Answer->id = $id;
    $ans = $this->Answer->read();
    if($ans['user_id'] == $this->Session->read('user.id') || $this->Session->read('User.permissions') & User::$permissionMasks['canDeleteAnswers']) {
      if(!$this->Answer->delete($id)) {
        $this->Session->setFlash('Could not delete answer');
      }
    } else {
      $this->Session->setFlash('You cannot delete somebody else\'s answer.');
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
      $this->redirect(array('controller' => 'questions', 'action' => 'view', $ans['Answer']['question_id']));
    } else {
      $this->Session->setFlash("You need to be logged in to do that.");
      $this->redirect(array('controller' => 'users', 'action' => 'login'));
    }
  }

  public function accept($id = null) {
    $this->Answer->id = $id;
    $ans = $this->Answer->read();
    if($ans == null) {
      $this->Session->setFlash("This answer does not exist.");
      $this->redirect('/questions');
    }

    if(!($this->Session->read('User.permissions') & User::$permissionMasks['canAcceptAnswers'])) {
      $this->Session->setFlash("You do not have the appropriate permissions");
      $this->redirect(array('controller' => 'questions', 'action' => 'view', $ans['Answer']['question_id']));
    }

    $ans['Answer']['accepted'] = true;
    $aid = $ans['Answer']['id'];
    $this->Answer->save($ans);
    $qid = $ans['Answer']['question_id'];
    $this->Question->id = $qid;
    $q = $this->Question->read();

    $faq = $this->Faq->find('first', array('conditions'=>array('Faq.question_id'=>$qid)));
    if($faq) {
      $faq['Faq']['answer_id'] = $aid;
      $this->Faq->save($faq);
    }

    $qAnswers = $q['QuestionAnswer'];
    foreach($qAnswers as $arr){
      if($arr['id']!=$aid){
        $this->Answer->id = $arr['id'];
        $ans = $this->Answer->read();
        if($ans != null) {
          $ans['Answer']['accepted'] = false;
          $this->Answer->save($ans);
        }
      }
    }

    $this->redirect(array('controller' => 'questions', 'action' => 'view', $q['Question']['id']));
  }

}

?>
