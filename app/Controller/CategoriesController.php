<?php
class CategoriesController extends AppController {
  public $name = 'Categories';
  public $helpers = array('Form', 'Html');
  public $uses = array('Category');


  public function select($id = null) {
    $this->Category->id = $id;
    $cat = $this->Category->read();
    if($cat || $id == 0 ) {
      CakeSession::write('cat', $id);
    } else {
      $this->Session->setFlash('This category does not exist');
    }

    $this->redirect(array('controller' => 'posts'));
  }

}
?>
