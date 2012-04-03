<style type="text/css">
div.question{
  width: 700px;
  margin-left: auto;
  margin-right: auto;
  margin-bottom: 10px;
  border: 2px solid;
}
div.answer{
  width: 90%;
  margin: auto;
  background-color: #E3E3E3;
}
</style>

<?php include("qlist.ctp") ?>

<h2>Frequently Asked Questions</h2>
<!--
<?php #echo $this->Html->link('Post a new Question', array('action' => 'add')); ?>
<br />
<br />
-->

<?php echo $this->fetch('qlist'); ?>
