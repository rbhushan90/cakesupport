<?php include("qlist.ctp") ?>

<h2>Unanswered Questions</h2>
<!--
<?php #echo $this->Html->link('Post a new Question', array('action' => 'add')); ?>
<br />
<br />
-->

<?php echo $this->fetch('qlist'); ?>
