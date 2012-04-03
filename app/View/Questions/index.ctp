<?php include("qlist.ctp") ?>

<h2>
  Questions
  <a href="/questions/add" class="btn btn-info ask-a-question">Ask a question!</a>
</h2>
<!--
<?php #echo $this->Html->link('Post a new Question', array('action' => 'add')); ?>
<br />
<br />
-->

<?php echo $this->fetch('qlist'); ?>
