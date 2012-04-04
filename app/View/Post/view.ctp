<style type="text/css">
form div.required label {
  display: none;
}
form div.required {
  display: inline-block;
  padding: 10px 50px;
}
form div.required textarea {
  width: 600px;
}
form div.submit {
  display: inline-block;
}
</style>
<a name="top"></a>
<div id="blog">
<h2><?php echo $post['Post']['title']; ?></h2>

<b>Asked by:</b> <?php echo $post['PostUser']['username']; ?> <br />
<b>on:</b> <?php echo $post['Post']['created']; ?> <br />
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

</div>
