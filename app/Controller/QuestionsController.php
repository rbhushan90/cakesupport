<?php
class QuestionsController extends AppController {
  public $name = 'Questions';
  public $helpers = array('Html', 'Form');
  public $uses = array('Question', 'User', 'Answer', 'Faq', 'ReportedQuestion', 'Tag', 'QuestionTag');

  public function index() {
    $this->set('questions', $this->Question->find('all',
      array('order' => 'Question.id desc')));
  }

  public function unanswered() {
    $cond = array('answer_count' => 0);
    $this->set('questions', $this->Question->find('all', array('conditions' => $cond)));
  }

  public function unaccepted() {
    $cond = array('accepted' => NULL);
    $this->set('questions', $this->Question->find('all', array('conditions' => $cond)));
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
    $tags = $this->Tag->find('all');
    $question_tags = $this->QuestionTag->find('all', array('conditions'=>array('question_id'=>$id)));
    if($this->request->is('get')) {
      $this->request->data = $q;
      $t = array();
      foreach($tags as $tag){
        $t[$tag['Tag']['id']] = $tag['Tag']['name'];
      }
      $this->set('tags', $t);
      $qt = array();
      foreach($question_tags as $qtag){
        $qt[$qtag['QuestionTag']['tag_id']] = true;
      }
      $this->set('question_tags', $qt);
    } else {
      if($this->Session->read('User.id') == $q['User']['id'] || $this->Session->read('User.permissions') & Configure::read('permissions.QAMod')) {
        $this->request->data['Question']['modified'] = date('Y-m-d H:i:s');
        if($this->Question->save($this->request->data)) {
          $this->Session->setFlash('Your post has been updated');
          //update question tags table
          $question_id = $this->Question->id;
          foreach($tags as $tag){
            $name = $tag['Tag']['name'];
            $tag_id = $tag['Tag']['id'];
            $question_tag = $this->QuestionTag->find('first', array('conditions'=>array('question_id'=>$question_id, 'tag_id'=>$tag_id)));
            if($this->request->data['Question'][$name]==1){
              if(empty($question_tag)){
                $this->QuestionTag->create();
                $this->QuestionTag->set(array(
                  'question_id' => $question_id,
                  'tag_id' => $tag['Tag']['id']
                ));
                $this->QuestionTag->save();
              }
            } else{
              if(!empty($question_tag)){
                // delete record from table
                $this->QuestionTag->delete($question_tag['QuestionTag']['id']);
              }
            }
          }
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
          // remove question tags if necessary
          $question_tags = $this->QuestionTag->find('all', array('conditions'=>array('question_id'=>$id)));
          foreach($question_tags as $qt){
            $this->QuestionTag->delete($qt['QuestionTag']['id']);
          }
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
      $tags = $this->Tag->find('all');
      if($this->request->is('post')) {
        $this->request->data['Question']['user_id'] = $this->Session->read('User.id');
        if($this->Question->save($this->request->data)) {
          $this->Session->setFlash('Your question has been added');
          // update Question Tags table
          $qid = $this->Question->id;
          foreach($tags as $tag){
            $name = $tag['Tag']['name'];
            if($this->request->data['Question'][$name]==1){
              // This tag was selected, add record to PostTag db table
              $this->QuestionTag->create();
              $this->QuestionTag->set(array(
                'question_id' => $qid,
                'tag_id' => $tag['Tag']['id']
              ));
              $this->QuestionTag->save();
            }
          }
          $this->redirect(array('controller'=>'questions', 'action'=>'index'));
        } else {
          $this->Session->setFlash('Could not add your question');
          $this->redirect(array('controller'=>'questions', 'action'=>'index'));
        }
      } else {
        //Get request
        $t = array();
        foreach($tags as $tag){
          $t[$tag['Tag']['id']] = $tag['Tag']['name'];
        }
        $this->set('tags', $t);
      }
    }
  }

}
?>
