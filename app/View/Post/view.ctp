<?php include("sidebar.ctp") ?>

<h2>
<?php
  echo $post['Post']['title'];
  if(CakeSession::read('User.permissions') & Configure::read('permissions.postBlog')) {
?>
    <a href="/posts/add" class="btn btn-info ask-a-question">Create a new blog post</a>
<?php
  }
?>
</h2>

<div class="top-content"></div>
<div class="main-content">
  <div class="content-partial">
    <div class="post">
      <h3><?php echo $post['Post']['title']; ?></h3>
      <div class="post-content">
        <p><?php echo $post['Post']['output']; ?></p>
        <?php if($this->Session->read('User.permissions') & Configure::read('permissions.postBlog')) { ?>
          <div class="actions">
          <?php echo $this->Html->link('Edit', array('action' => 'edit', $post['Post']['id'])); ?>
          |
          <?php echo $this->Html->link('Delete', array('action' => 'delete', $post['Post']['id'])); ?>
          </div>
        <?php } ?>
      </div>
      <div class="info">
        <p>by <strong><?php echo $post['PostUser']['username'] ?></strong></p>
        <p>Filed under:
          <?php
            $c = false;
            foreach($post['Category'] as $cat) {
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
              foreach($post['Tag'] as $tag) {
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
        <p class="clear"></p>
      </div>
      <div class="comments">
        <?php
          if($this->Session->read('User.id')) {
            echo "<h4>Add a comment</h4>";
            echo $this->Form->create('Comment', array('action' => 'post'));
            echo $this->Form->input('post_id', array('type' => 'hidden'));
            echo $this->Form->input('body',
                array('rows' => 4, 'class' => 'newcomment', 'label' => ''));
            echo $this->Form->submit('Add comment', array('class' => 'btn btn-primary'));
            echo $this->Form->end();
          }
        ?>

        <?php foreach ($post['PostComment'] as $com): ?>
          <?php $i=0;
                echo "<div class=\" comment";
                if ($i%2==0) {
                  echo " even";
                } else {
                  echo " odd";
                }
                echo "\">";
          ?>
            <p class="commenter"><strong>
            <?php
                echo $this->Html->link($com['username'], array('controller' => 'users', 'action' => 'view', $com['user_id']));
            ?>:</strong></p>
            <p><?php echo $com['body'] ?></p>
            <?php 
              if ($this->Session->read('User.id')) {
                echo "<div class=\"actions\">";
                if ($com['user_id'] == $this->Session->read('User.id') || $this->Session->read('User.permissions') & Configure::read('permissions.blogMod')) {
                  echo $this->Html->Link('Delete', array('controller' => 'comments', 'action' => 'remove', $com['id']));
                } else {
                  echo $this->Html->Link('Report', array('controller' => 'comments', 'action' => 'report', $com['id']));
                }
                echo "</div>";
              }
            ?>
          </div>
        <?php endforeach ?>
      </div>
    </div>
  </div>
  <?php echo $this->fetch('sidebar'); ?>
  <div class="clear"></div>
</div>
<div class="bottom-content"></div>
