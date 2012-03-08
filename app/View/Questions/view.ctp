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
<h2><?php echo $question['Question']['title']; ?></h2>
<a name="top"></a>

Created: <?php echo $question['Question']['created']; ?> <br />
by: <?php echo $question['User']['username']; ?> <br />
<br />
<?php echo $question['Question']['body']; ?>

<div style="text-align: right">
<?php 
  if($this->Session->read('User.id') == $question['User']['id']) {
    echo "<br />";
    echo $this->Html->Link('Edit Post',
        array('action' => 'edit', $question['Question']['id']));
    echo " | ";
    echo $this->Html->Link('Delete Post',
        array('action' => 'remove', $question['Question']['id']));
  }
?>
</div>
<br />
<br />
<?php
  if($this->Session->read('User.id')) {
    echo $this->Form->create('Answer', array('action' => 'post'));
    echo $this->Form->input('question_id', array('type' => 'hidden'));
    echo $this->Form->input('body',
        array('rows' => 4, 'class' => 'newanswer', 'label' => ''));
    echo $this->Form->end('Answer');
  }
?>
<br />
<h3>Answers</h3>
<br />

<?php foreach ($question['QuestionAnswer'] as $ans): ?>
<div class="answer">
<div class="user">
<h4>
<?php echo $ans['username'] ?>
</h4>
</div>
<div class="body">
<?php echo $ans['body'] ?> 
</div>

<?php if ($ans['user_id'] == $this->Session->read('User.id')) { ?>
<div class="mod">
<a href="#top">Top</a> | 
<?php echo $this->Html->Link('Delete', array('controller' => 'answer', 'action' => 'remove')); ?>
</div>
<?php } ?>

</div>
<?php endforeach; ?>

</div>
