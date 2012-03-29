<?php $this->start('qlist') ?>

<table id="question-list">
<tr>
<th>Question</th>
<th>Answer</th>
</tr>
<?php for($i = count($faqs)-1; $i>=0; $i--){ ?>
<tr>
<td style="width: 80px"><?php echo $this->Html->link($faqs[$i]['body'], array('controller'=>'questions', 'action'=>'view', $faqs[$i]['question_id'])); ?></td>
<td style="width: 180px">
  <?php if($faqs[$i]['answer']==null){
    echo $this->Html->link('View Thread',array('controller'=>'questions', 'action'=>'view', $faqs[$i]['question_id']));
  } else {
    echo $faqs[$i]['answer'];
  }?>
</td>
</tr>
<?php } ?>

</table>

<?php $this->end() ?>
