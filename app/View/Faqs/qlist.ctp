<?php $this->start('qlist') ?>
<table id="question-list">
<tr>
<th>Title</th>
<th>Question</th>
<th>Answer</th>
<?php if($this->Session->read('User.permissions') & 1){?>
<th>Delete<th>
<?php } ?>
</tr>
<?php for($i = count($faqs)-1; $i>=0; $i--){ ?>
<tr>
<td style="width: 120px"><?php echo $faqs[$i]['title']; ?></td>
<td style="width: 180px"><?php echo $this->Html->link($faqs[$i]['body'], array('controller'=>'questions', 'action'=>'view', $faqs[$i]['question_id'])); ?></td>
<td style="width: 180px">
  <?php if($faqs[$i]['answer']==null){
    echo $this->Html->link('View Thread',array('controller'=>'questions', 'action'=>'view', $faqs[$i]['question_id']));
  } else {
    echo $faqs[$i]['answer'];
  }?>
</td>
<?php if($this->Session->read('User.permissions') & 1){ ?>
<td style="width: 40px"><?php echo $this->Html->link('Remove', array('controller'=>'faq', 'action'=>'remove', $faqs[$i]['id']))?></td>
<?php } ?>
</tr>
<?php } ?>

</table>

<?php $this->end() ?>
