<?php include("qlist.ctp") ?>

<h2>
Questions with no accepted answers
<a href="/questions/add" class="btn btn-info ask-a-question">Ask a question!</a>
</h2>
<!--
<?php #echo $this->Html->link('Post a new Question', array('action' => 'add')); ?>
<br />
<br />
-->

<?php
  if(count($questions) < 1) {
    echo "<h4>There are no questions with unaccepted answers</h4>";
  } else {
    echo $this->fetch('qlist');
  }
?>

