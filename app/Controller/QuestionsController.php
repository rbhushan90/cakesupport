<?php
class QuestionsController extends AppController {
  public $name = 'Questions';
  public $helpers = array('Html', 'Form');
  public $uses = array('Question', 'User', 'Answer', 'ReportedQuestion', 'Tag');

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

  public function filterTags($name, $tagfn) {
    $selTag = CakeSession::read($name);
    CakeSession::write('cat', '0');
    if($selTag && $selTag != 0) {
      $options['joins'][] = array(
          'table' => 'questions_tags',
          'alias' => 'QuestionTag',
          'type' => 'inner',
          'conditions' => array('Question.id = QuestionTag.question_id')
        );
      $options['joins'][] = array(
          'table' => 'tags',
          'alias' => 'Tag',
          'type' => 'inner',
          'conditions' => array('QuestionTag.tag_id = Tag.id')
        );

      $options['conditions'] = array('Tag.id' => $selTag);
      //return $options;
    } else {
      $selTag = 0;
    }
    //$options['order'] = array('Question.id desc');
    $options['order'] = array('Question.id' => 'desc'); //Pagination requires different order format
    $options['limit'] = 5;
    $this->set('selTag', $selTag);
    $this->set('tagfn', $tagfn);
    return $options;
  }

  public function index() {
    $options = $this->filterTags('questionTag', '2');
    CakeSession::write('postTag', '0');
    CakeSession::write('faqTag', '0');
    $this->paginate = $options;
    $this->set('questions', $this->paginate('Question'));
    $this->set('tags', $this->Tag->find('all'));
  }

  public function unanswered() {
    $options = $this->filterTags('questionTag', '3');
    CakeSession::write('postTag', '0');
    CakeSession::write('faqTag', '0');
    $options['conditions']['Question.answer_count'] = 0;
    $this->paginate = $options;
    $this->set('questions', $this->paginate('Question'));
    $this->set('tags', $this->Tag->find('all'));
  }

  public function unaccepted() {
    $options = $this->filterTags('questionTag', '4');
    CakeSession::write('postTag', '0');
    CakeSession::write('faqTag', '0');
    $options['conditions']['Question.accepted'] = NULL;
    $this->paginate = $options;
    $this->set('questions', $this->paginate('Question'));
    $this->set('tags', $this->Tag->find('all'));
  }

  public function view($id = null) {
    $this->Question->id = $id;
    $q = $this->Question->read();
    $this->request->data['Answer']['question_id'] = $id;
    if($q == null) {
      $this->Session->setFlash('This question does not exist or has been deleted');
      $this->errorRedirect('/questions');
      return;
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

  public function report($id = null) {
    $this->Question->id = $id;
    $q = $this->Question->read();
    if($this->Session->read('User.id')) {
      $this->Session->setFlash("This quetsion has been reported.");
      $rc = array();
      $rc['ReportedQuestion']['question_id'] = $q['Question']['id'];
      $rc['ReportedQuestion']['user_id'] = $this->Session->read('User.id');
      $this->ReportedQuestion->save($rc);
      $this->errorRedirect(array('controller' => 'questions', 'action' => 'view', $q['Question']['id']), '475 Unnecessary');
      return;
    } else {
      $this->Session->setFlash("You need to be logged in to do that.");
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
  }

  public function edit($id = null) {
    $this->Question->id = $id;
    $q = $this->Question->read();
    if($q == null) {
      $this->Session->setFlash('This question does not exist or has been deleted');
      $this->errorRedirect('/questions');
      return;
    }

    $this->set('tags', $this->Question->Tag->find('list'));
    if($this->request->is('get')) {
      $this->request->data = $q;
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
        $this->errorRedirect('/login', '401 Unauthorized');
        return;
      }
    }
  }

  public function remove($id = null) {
    $this->Question->id = $id;
    $q = $this->Question->read();
    if($q) {
      if($this->Session->read('User.id') == $q['User']['id'] || $this->Session->read('User.permissions') & Configure::read('permissions.QAMod')) {
        if($this->Question->delete($id)) {
          $this->Session->setFlash('Post deleted');
          $this->redirect('/questions');
        } else {
          $this->Session->setFlash('There was a problem deleting this post');
          $this->errorRedirect(array('action' => 'view', $id), '500 Server Error');
          return;
        }
      } else {
        $this->Session->setFlash('This post does not belong to you');
        $this->errorRedirect('/login', '401 Unauthorized');
        return;
      }
    } else {
      $this->Session->setFlash('No such question exists');
      $this->errorRedirect('/questions');
      return;
    }
  }

  public function add() {
    if(!(CakeSession::read('User.username'))) {
      $this->Session->setFlash("You must be logged in to post a question");
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    } else {
      $this->set('tags', $this->Question->Tag->find('list'));
      if($this->request->is('post')) {
        $this->request->data['Question']['user_id'] = $this->Session->read('User.id');
        if($this->Question->save($this->request->data)) {
          $question = $this->Question->read();
          $this->Session->setFlash('Your question has been added');
          App::uses('CakeEmail', 'Network/Email');
          $email = new CakeEmail('monitor');
          $email->template('question-created');
          $email->to('ashroff6@gmail.com');
          $email->subject('[GMM] Question Created');
          $vars = array();
          $vars['fname'] = 'Abhishek';
          $vars['user'] = $question['User']['username'];
          $vars['title'] = $question['Question']['title'];
          $vars['body'] = $question['Question']['body'];
          $vars['url'] = 'http://' . $_SERVER['SERVER_NAME'] . '/questions/view/' . $question['Question']['id'];
          $email->viewVars($vars);
          $email->send();
          $this->errorRedirect(array('controller'=>'questions', 'action'=>'index'), '477 Questions');
          return;
        } else {
          $this->Session->setFlash('Could not add your question');
        }
      }
    }
  }

  public function faq() {
    $options = $this->filterTags('faqTag', '5');
    CakeSession::write('postTag', '0');
    CakeSession::write('questionTag', '0');
    $options['conditions']['Question.faq'] = '1';
    $this->set('faqs', $this->Question->find('all', $options));
    $this->set('tags', $this->Tag->find('all'));
  }

  public function addFaq($id) {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.FAQ')) ) {
      $this->Session->setFlash("You must be an admin to add to the FAQ");
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    } else {
      $this->Question->id = $id;
      $question = $this->Question->read();
      $question['Question']['faq'] = '1';
      $this->Question->save($question);
      $this->redirect('/questions/faq');
    }
  }

  public function removeFaq($id) {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.FAQ')) ) {
      $this->Session->setFlash("You must be an admin to add to the FAQ");
      $this->redirect('/login');
    } else {
      $this->Question->id = $id;
      $question = $this->Question->read();
      $question['Question']['faq'] = '0';
      $this->Question->save($question);
      $this->redirect('/questions/faq');
    }
  }
}
?>
