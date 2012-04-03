<?php $this->start('qlist') ?>
<?php for($i = count($faqs)-1; $i>=0; $i--){ ?>
<div class="question">
<h3>Question</h3>
<p>Title: <?php echo $this->Html->link($faqs[$i]['title'], array('controller'=>'questions', 'action'=>'view', $faqs[$i]['question_id'])); ?></p>
<p>Question: <?php echo $faqs[$i]['body']; ?></p>
<div class="answer">
  <h4>Answer</h3>
  <p>
  <?php if($faqs[$i]['answer']==null){
    echo $this->Html->link('View Thread',array('controller'=>'questions', 'action'=>'view', $faqs[$i]['question_id']));
  } else {
    echo $faqs[$i]['answer'];
  }?>
</p>
</div>
<?php if($this->Session->read('User.permissions') & 1){
  echo $this->Html->link('Remove', array('controller'=>'faq', 'action'=>'remove', $faqs[$i]['id']));
} ?>
</div>
<?php } ?>
<?php $this->end() ?>
