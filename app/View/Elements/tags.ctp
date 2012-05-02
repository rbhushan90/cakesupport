<div id="tags" class="links">
  <h3>Tags</h3>
  <p>
    <?php
      $text = '';
      if($selTag == 0) {
        $text = '<i class="icon-plus"></i> ';
      }
      $text .= 'All';
      echo $this->Html->link($text, array('controller' => 'tags', 'action' =>
        'select', $tagfn, 0), array('escape' => false, 'class' =>'action ref'));
    ?>
  </p>
  <?php foreach($tags as $tag): ?>
  <p>
    <?php
      $text = '';
      if($selTag == $tag['Tag']['id']) {
        $text = '<i class="icon-plus"></i> ';
      }
      $text .= $tag['Tag']['name'];
      echo $this->Html->link($text, array('controller' => 'tags', 'action' =>
        'select', $tagfn, $tag['Tag']['id']), array('escape' => false, 'class' =>'action ref'));
    ?>
  </p>
  <?php endforeach; ?>
</div>
