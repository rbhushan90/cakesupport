<?php $this->start('qlist') ?>

<table id="question-list">
<tr>
<th>Answers</th>
<th>Title</th>
<th>by</th>
<th>on</th>
</tr>

<?php foreach ($questions as $q): ?>
<tr>
<td style="width: 80px"><?php echo $q['Question']['answer_count'] ?></td>
<td>
<?php echo $this->Html->link(htmlspecialchars($q['Question']['title']),
    array('controller'  => 'questions', 'action' => 'view',
      $q['Question']['id'])); ?>
</td>
<td><?php echo $q['User']['username']; ?></td>
<td style="width: 180px"><?php echo $q['Question']['created']; ?></td>
</tr>
<?php endforeach; ?>

</table>

<?php $this->end() ?>
