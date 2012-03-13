<?php include("qlist.ctp") ?>

<h2>Recently Asked</h2>
<!--
<?php #echo $this->Html->link('Post a new Question', array('action' => 'add')); ?>
<br />
<br />
-->

<?php echo $this->fetch('qlist'); ?>
