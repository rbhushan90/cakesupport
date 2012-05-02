<?php
class CategoriesController extends AppController {
  public $name = 'Categories';
  public $helpers = array('Form', 'Html');


  public function select($id = null) {
    $this->Category->id = $id;
    $cat = $this->Category->read();
    if($cat || $id == 0 ) {
      CakeSession::write('cat', $id);
    } else {
      $this->Session->setFlash('This category does not exist');
    }

    if(!$this->request->is('ajax')) {
      if(isset($_SERVER['HTTP_REFERER'])) {
        $this->redirect($_SERVER['HTTP_REFERER']);
      } else {
        $this->redirect('/posts');
      }
    }
  }

}
?>
