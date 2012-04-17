<h3>Tags</h3>
<p>
  <?php
    $selTag = CakeSession::read('tag');
    if(!$selTag) {
      $selTag = 0;
      CakeSession::write('tag', $selTag);
    }
    $text = '';
    if($selTag == 0) {
      $text = '<i class="icon-plus"></i> ';
    }
    $text .= 'All';
    echo $this->Html->link($text, array('controller' => 'tags', 'action' => 'flip', 0), array('escape' => false));
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
    echo $this->Html->link($text, array('controller' => 'tags', 'action' => 'flip', $tag['Tag']['id']), array('escape' => false));
  ?>
</p>
<?php endforeach; ?>
