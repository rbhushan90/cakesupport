<div id="categories" class="links">
  <h3>Categories</h3>
  <p>
    <?php
      $selCat = CakeSession::read('cat');
      if(!$selCat) {
        $selCat = 0;
      }
      $text = '';
      if($selCat == 0) {
        $text = '<i class="icon-plus"></i> ';
      }
      $text .= 'All';
      echo $this->Html->link($text, array('controller' => 'categories', 'action' => 'select', '0'), array('escape' => false, 'class' =>'action ref'));
    ?>
  </p>
  <?php foreach($cats as $cat): ?>
  <p>
    <?php
      $text = '';
      if($selCat == $cat['Category']['id']) {
        $text = '<i class="icon-plus"></i> ';
      }
      $text .= $cat['Category']['name'];
      echo $this->Html->link($text, array('controller' => 'categories', 'action' => 'select', $cat['Category']['id']), array('escape' => false, 'class' =>'action ref'));
    ?>
  </p>
  <?php endforeach; ?>
</div>
