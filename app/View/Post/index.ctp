<h2>
B/log
<?php if(CakeSession::read('User.permissions') & Configure::read('permissions.postBlog')) { ?>
  <a href="/posts/add" class="btn btn-info ask-a-question">Create a new blog post</a>
<?php } ?>
</h2>

<div class="top-content"></div>
<div class="main-content">
  <div class="content-partial">
    <?php foreach ($posts as $p): ?>
      <div class="post index">
        <h3><?php echo $this->Html->link($p['Post']['title'],
                array('controller' => 'posts', 'action' => 'view',
                $p['Post']['id']
              ));
            ?>
        </h3>
       <div class="post-content">
          <?php echo $p['Post']['output'] ?>
          <br />
        </div>
        <p class="leave-comment">
          <?php 
            $ct = $p['Post']['comment_count'];
            if($ct == 1) {
              $ct .= ' comment';
            } else {
              $ct .= ' comments';
            }
            echo $this->Html->link($ct,
              array('controller' => 'posts', 'action' => 'view',
              $p['Post']['id']
            ));
          ?>
        </p>
        <div class="info">
          <p>by <strong><?php echo $p['PostUser']['username'] ?></strong></p>
          <p>Filed under: categories</p>
          <p>Tags:
            <?php
              $c = false;
              foreach($p['Tag'] as $tag) {
                if($c) {
                  echo ", ";
                } else {
                  $c = true;
                }
                echo "<b>";
                echo $tag['name'];
                echo "</b>";
              }
              if(!$c) {
                echo "none";
              }
            ?>
          </p>
          <p>Date: <?php echo $p['Post']['created'] ?>
          <p class="clear"></p>
        </div>
      </div>
    <?php endforeach; ?>
  </div>
  <div class="sidebar">
    <div class="links">
      <h3>Links</h3>
      <p><a href="#" target="_blank">@GoodMeasureMeals on Twitter</a></p>
      <p><a href="#" target="_blank">GMM Facebook Page</a></p>
      <p><a href="#" target="_blank">GMM Website</a></p>
      <p><a href="#" target="_blank">Open Hand Atlanta</a></p>
    </div>
    <div class="links">
      <h3>Categories</h3>
      <p><a href="#" target="_blank">Corporate Wellness</a></p>
      <p><a href="#" target="_blank">Wellness</a></p>
      <p><a href="#" target="_blank">In The Community</a></p>
      <p><a href="#" target="_blank">In The Kitchen</a></p>
      <p><a href="#" target="_blank">Nutrition</a></p>
      <p><a href="#" target="_blank">Uncategorized</a></p>
    </div>
  </div>
  <div class="clear"></div>
</div>
<div class="bottom-content">
