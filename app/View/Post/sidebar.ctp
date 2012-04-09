<?php $this->start('sidebar') ?>
  <div class="sidebar">
    <div class="links">
      <h3>Links</h3>
      <p><a href="http://twitter.com/goodmeasuremeal" target="_blank">@GoodMeasureMeals on Twitter</a></p>
      <p><a href="http://www.facebook.com/GoodMeasureMeals" target="_blank">GMM Facebook Page</a></p>
      <p><a href="http://www.youtube.com/user/GoodMeasureMeals" target="_blank">GMM YouTube Channel</a></p>
      <p><a href="http://www.goodmeasuremeals.com" target="_blank">GMM Website</a></p>
      <p><a href="http://www.projectopenhand.com" GMM target="_blank">Open Hand Atlanta</a></p>
    </div>
    <div class="links">
      <h3>Categories</h3>
      <p>
        <?php
          $selCat = CakeSession::read('cat');
          $text = '';
          if($selCat == 0) {
            $text = '<i class="icon-plus"></i> ';
          }
          $text .= 'All';
          echo $this->Html->link($text, array('controller' => 'categories', 'action' => 'select', '0'), array('escape' => false));
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
          echo $this->Html->link($text, array('controller' => 'categories', 'action' => 'select', $cat['Category']['id']), array('escape' => false));
        ?>
      </p>
      <?php endforeach; ?>
    </div>
    <div class="links">
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
    </div>
  </div>
<?php $this->end() ?>
