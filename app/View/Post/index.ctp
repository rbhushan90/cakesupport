<h2>
Blog
<?php if(CakeSession::read('User.permissions') & Configure::read('permissions.postBlog')) { ?>
  <a href="/posts/add" class="btn btn-info ask-a-question">Create a new blog post</a>
<?php } ?>
</h2>

<div class="top-content"></div>
<div class="main-content">
  <div class="content-partial">
    <?php if(count($posts) == 0) { ?>
        <div class="nothing">There are no blog posts with this criteria.</div>
    <?php } ?>
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
            $ct .= " [Add a comment]";
            echo $this->Html->link($ct,
              array('controller' => 'posts', 'action' => 'view',
              $p['Post']['id']
            ));
          ?>
        </p>
        <div class="info">
          <p>by <strong><?php echo $this->Html->link($p['User']['username'], array('controller' =>'users', 'action' =>'view', $p['User']['id'])); ?></strong></p>
          <p>Filed under:
            <?php
              $c = false;
              foreach($p['Category'] as $cat) {
                if($c) {
                  echo ", ";
                } else {
                  $c = true;
                }
                echo "<b>";
                echo $cat['name'];
                echo "</b>";
              }
              if(!$c) {
                echo "Uncategorized";
              }
            ?>
          </p>
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
    <?php echo $this->element('external'); ?>
    <?php echo $this->element('categories'); ?>
    <?php echo $this->element('tags'); ?>
  </div>
  <div class="clear"></div>
</div>
<div class="bottom-content">
