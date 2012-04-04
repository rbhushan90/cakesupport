<a name="top"></a>
<div id="blog">
<h2><?php echo $post['Post']['title']; ?></h2>

<b>Posted on:</b> <?php echo $post['Post']['created']; ?> <br />
</div>
<br />

<div class="blog-post">
<?php echo $post['Post']['output']; ?>
</div>

<br />
<?php if($this->Session->read('User.permissions') & Configure::read('permissions.postBlog')) { ?>
  <div class="actions">
  <?php echo $this->Html->link('Edit', array('action' => 'edit', $post['Post']['id'])); ?>
  |
  <?php echo $this->Html->link('Delete', array('action' => 'delete', $post['Post']['id'])); ?>
  </div>
<?php } ?>

<br />
<br />
<h3>Comments</h3>
<br />
  <?php
    if($this->Session->read('User.id')) {
      echo $this->Form->create('Comment', array('action' => 'post'));
      echo $this->Form->input('post_id', array('type' => 'hidden'));
      echo $this->Form->input('body',
          array('rows' => 4, 'class' => 'newcomment', 'label' => ''));
      echo $this->Form->end('Comment');
    }
  ?>

</div>
