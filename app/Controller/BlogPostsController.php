<?php

class BlogPostsController extends AppController {
  public $name = 'BlogPost';
  public $helpers = array('Html', 'Form');
  public $uses = array('BlogPost', 'User');

  public function add() {
    $this->User;
    if(!($this->Session->read('User.permissions') & User::$permissionMasks['postBlog'])) {
      $this->Session->setFlash('You do not have the permissions to post to the blog');
      $this->redirect('/blog');
    }
    if($this->request->data) {
      $this->Session->setFlash('The post has been added.');
      include '../webroot/markitup/markdown.php';
      $this->request->data['BlogPost']['output'] = Markdown($this->request->data['BlogPost']['body']);
      $this->request->data['BlogPost']['user_id'] = $this->Session->read('User.id');
      $this->BlogPost->save($this->request->data);
      $this->redirect('/blog');
    }
  }

  public function delete($id = null) {
    $this->User
    if(!($this->Session->read('User.permissions') & User::$permissionMasks['postBlog'])) {
      $this->Session->setFlash('You do not have the permissions to delete blog entries');
      $this->redirect('/blog');
    } else {
      $this->BlogPost->delete($id);
      $this->redirect('/blog');
    }
  }

  public function view($id = null) {
    $this->BlogPost->id = $id;
    $p = $this->BlogPost->read();

    if($p == null) {
      $this->Session->setFlash('This post does not exist or has been deleted');
      $this->redirect('/blog');
    }

    $this->set('post', $p);
  }

  public function index() {
    $this->set('posts', $this->BlogPost->find('all',
      array('order' => 'BlogPost.id desc')));
  }


}
?>
