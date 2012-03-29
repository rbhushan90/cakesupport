<?php
class FaqController extends AppController {
  public $name = 'Faqs';
  public $helpers = array('Html', 'Form');
  public $uses = array('Faq', 'Question', 'User', 'Answer');

  public function index() {
    //debug($this, true);
    $faqs = $this->Faq->find('all', array('order' => 'Faq.id desc'));
    $q = array();
    for($i=count($faqs)-1; $i>=0; $i--){
      $this->Question->id = $faqs[$i]['Faq']['question_id'];
      $q[$i]['question_id'] = $faqs[$i]['Faq']['question_id'];
      $tmp = $this->Question->read();
      $q[$i]['title'] = $tmp['Question']['title'];
      $q[$i]['body'] = $tmp['Question']['body'];
      $this->Answer->id = $faqs[$i]['Faq']['answer_id'];
      $tmp = $this->Answer->read();
      $q[$i]['answer'] = $tmp['Answer']['body'];
    }
    $this->set('faqs', $q);
  }

  public function add() {
    if(!(CakeSession::read('User.username')) || !($this->Session->read('User.permissions') & 1) ) {
      $this->Session->setFlash("You must be an admin to add to the FAQ");
      $this->redirect('/login');
    } else {
      if($this->request->is('post')) {
        $qid = $this->passedArgs[0];
        $this->request->data['Faq']['question_id'] = $qid;
        // Find accepted answer if one exists
        $answers = $this->Answer->find('all', array('conditions' => array('question_id' => $qid)));
        foreach($answers as $ans){
          if($ans['Answer']['accepted']==1){
            $this->request->data['Faq']['answer_id'] = $ans['Answer']['id'];
          }
        }
        if($this->Faq->save($this->request->data)) {
          $this->Session->setFlash('Question has been added to the FAQ');
          $this->redirect('/');
        } else {
          $this->Session->setFlash('Could not add the question to the FAQ');
        }
      }
    }
  }

  public function remove($id = null) {
    $this->Faq->id = $id;
    $q = $this->Faq->read();
    if($q) {
      if($this->Session->read('User.id') == $q['User']['id'] || $this->Session->read('User.permissions') & 1) {
        if($this->Faq->delete($id)) {
          $this->Session->setFlash('Question deleted from FAQ');
          $this->redirect('/');
        } else {
          $this->Session->setFlash('There was a problem deleting this question');
          $this->redirect(array('action' => 'view', $id));
        }
      } else {
        $this->Session->setFlash('This post does not belong to you');
        $this->redirect(array('controller' => 'question', 'action' => 'view', $id));
      }
    } else {
      $this->Session->setFlash('No such question exists');
        $this->redirect('/');
    }
  }


}
?>
