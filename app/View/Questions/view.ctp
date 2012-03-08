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
<div id="question-info">
<h2><?php echo $question['Question']['title']; ?></h2>

<b>Asked by:</b> <?php echo $question['User']['username']; ?> <br />
<b>on:</b> <?php echo $question['Question']['created']; ?> <br />
</div>

<div class="qa question">
<div class="user">
<h4>
<?php echo $question['User']['username'] ?>
</h4>
</div>
<div class="body">
<?php echo $question['Question']['body']; ?>
</div>

<div class="mod">
<?php 
  if($this->Session->read('User.id') == $question['User']['id']) {
    echo $this->Html->Link('Edit',
        array('action' => 'edit', $question['Question']['id']));
    echo " | ";
    echo $this->Html->Link('Delete',
        array('action' => 'remove', $question['Question']['id']));
  } else {
    echo $this->Html->Link('Report', array('action' => 'report', $question['Question']['id']));
  }
?>
</div>
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

<?php
  foreach ($question['QuestionAnswer'] as $ans):
    echo "<div class=\"qa answer";
    if($ans['accepted']) {
      echo " accepted";
    }
    if($ans['endorsed']) {
      echo " endorsed";
    }
    echo "\">";
?>
<div class="user">
<h4>
<?php echo $ans['username'] ?>
</h4>
</div>
<div class="body">
<?php echo $ans['body'] ?> 
</div>

<div class="mod">
<a href="#top">Top</a>
<?php 
  if($this->Session->read('User.permissions') & 1) {
    echo " | ";
    echo $this->Html->Link('Endorse',
        array('controller' => 'answers', 'action' => 'endorse', $ans['id']));
  }

  if ($question['Question']['user_id'] == $this->Session->read('User.id')) {
    echo " | ";
    echo $this->Html->Link('Approve', array('controller' => 'answers', 'action' => 'approve', $ans['id']));
  }

  if ($ans['user_id'] == $this->Session->read('User.id') || $this->Session->read('User.permissions') & 2) {
    echo " | ";
    echo $this->Html->Link('Delete', array('controller' => 'answers', 'action' => 'remove', $ans['id']));
  } else {
    echo " | ";
    echo $this->Html->Link('Report', array('controller' => 'answers', 'action' => 'report', $ans['id']));
  }
?>
</div>

</div>
<?php endforeach; ?>

</div>
