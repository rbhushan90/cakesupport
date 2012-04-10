<h3>Tags</h3>
<p>
  <?php
    $selTags = CakeSession::read('tags');
    if(!($selTags)) {
      $selTags = array();
      CakeSession::write('tags', $selTags);
    }
    echo $this->Html->link('All', array('controller' => 'tags', 'action' => 'flip', '0'));
  ?>
</p>
<?php foreach($tags as $tag): ?>
<p>
  <?php
    if(array_key_exists($tag['Tag']['id'], $selTags)) {
      $text = '<i class="icon-minus"></i> ';
    } else {
      $text = '<i class="icon-plus"></i> ';
    }
    $text .= $tag['Tag']['name'];
    echo $this->Html->link($text, array('controller' => 'tags', 'action' => 'flip', $tag['Tag']['id']), array('escape' => false));
  ?>
</p>
<?php endforeach; ?>
