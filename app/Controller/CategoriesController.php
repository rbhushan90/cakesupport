<?php
class CategoriesController extends AppController {
  public $name = 'Categories';
  public $helpers = array('Form', 'Html');
  public $uses = array('Category');


  public function flip($id = null) {
    $this->Category->id = $id;
    $cat = $this->Category->read();
    $cats = CakeSession::read('cats');
    if($id == 0) {
      $cats = array();
    } else {
      if(array_key_exists($id, $cats)) {
        unset($cats[$id]);
      } else {
        $cats[$id] = 1;
      }
    }
    CakeSession::write('cats', $cats);

    $this->redirect(array('controller' => 'posts'));
  }

}
?>
