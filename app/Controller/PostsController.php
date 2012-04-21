<?php

class PostsController extends AppController {
  public $name = 'Post';
  public $helpers = array('Html', 'Form');
  public $uses = array('Post', 'User', 'Tag', 'Category');

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

  public function add() {
    $this->User;
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.postBlog'))) {
      $this->Session->setFlash('You do not have the permissions to post to the blog');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
    $this->set('tags', $this->Post->Tag->find('list'));
    $this->set('categories', $this->Post->Category->find('list'));
    if($this->request->is('post') && $this->request->data) {
      include '../webroot/markitup/markdown.php';
      $this->request->data['Post']['output'] = Markdown($this->request->data['Post']['body']);
      $this->request->data['Post']['user_id'] = $this->Session->read('User.id');
      if($this->Post->save($this->request->data)) {
        $this->Session->setFlash('The post has been added.');
        $this->redirect('/blog');
      } else {
        $this->Session->setFlash('There was an error adding your post. Please try again later..');
      }
    }
  }

  public function delete($id = null) {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.postBlog'))) {
      $this->Session->setFlash('You do not have permission to delete blog posts');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    } else {
      $this->Post->delete($id);
      $this->redirect('/blog');
    }
  }

  public function edit($id = null) {
    if(!($this->Session->read('User.permissions') & Configure::read('permissions.postBlog'))) {
      $this->Session->setFlash('You do not have permission to edit blog posts');
      $this->errorRedirect('/login', '401 Unauthorized');
      return;
    }
    $this->Post->id = $id;
    $post = $this->Post->read();
    if(!$post) {
      $this->Session->setFlash('This post does not exist');
      $this->redirect('/blog');
    }

    $this->set('tags', $this->Post->Tag->find('list'));
    $this->set('categories', $this->Post->Category->find('list'));
    if($this->request->is('get')) {
      $this->request->data = $post;
    } else {
      include '../webroot/markitup/markdown.php';
      $this->request->data['Post']['output'] = Markdown($this->request->data['Post']['body']);
      $this->request->data['Post']['user_id'] = $this->Session->read('User.id');
      if($this->Post->save($this->request->data)) {
        $this->Session->setFlash('The post was successfully edited.');
        $this->redirect(array('action' => 'view', $id));
      } else {
        $this->Session->setFlash('Could not save your edits. Please try again later.');
      }
    }


  }


  public function view($id = null) {
    $this->Post->id = $id;
    $p = $this->Post->read();
    $selCat = CakeSession::read('cat');
    if(!$selCat) {
      $selCat = 0;
      CakeSession::write('cat', $selCat);
    }

    if($p == null) {
      $this->Session->setFlash('This post does not exist or has been deleted');
      $this->redirect('/blog');
    }

    for ($i=count($p['PostComment'])-1; $i >= 0; $i--) {
      $this->User->id = $p['PostComment'][$i]['user_id'];
      $user = $this->User->read();
      $p['PostComment'][$i]['username'] = $user['User']['username'];
    }

    $this->request->data['Comment']['post_id'] = $id;
    $this->set('post', $p);
    $this->set('tags', $this->Tag->find('all'));
    $this->set('cats', $this->Category->find('all'));
  }
  public function index() {
    $this->set('title_for_layout', 'Blog');
    $selCat = CakeSession::read('cat');
    $selTag = CakeSession::read('tag');
    if($selCat && $selCat != 0) {
      $options['joins'][] = array(
          'table' => 'categories_posts',
          'alias' => 'PostCategory',
          'type' => 'inner',
          'conditions' => array('Post.id = PostCategory.post_id')
        );
      $options['joins'][] = array(
          'table' => 'categories',
          'alias' => 'Category',
          'type' => 'inner',
          'conditions' => array('PostCategory.category_id = Category.id')
        );

      $options['conditions']['Category.id'] = $selCat;
    }
    if($selTag && $selTag != 0) {
      $options['joins'][] = array(
          'table' => 'posts_tags',
          'alias' => 'PostTag',
          'type' => 'inner',
          'conditions' => array('Post.id = PostTag.post_id')
        );
      $options['joins'][] = array(
          'table' => 'tags',
          'alias' => 'Tag',
          'type' => 'inner',
          'conditions' => array('PostTag.tag_id = Tag.id')
        );

      $options['conditions']['Tag.id'] = $selTag;
    }
    $options['order'] = array('Post.id desc');

    $posts = $this->Post->find('all', $options);
    $this->set('posts', $posts);
    $this->set('tags', $this->Tag->find('all'));
    $this->set('cats', $this->Category->find('all'));
  }


}
?>
