<?php $this->start('qlist') ?>

<table id="question-list">
<tr>
<th>Title</th>
<th>reported by</th>
<th>on</th>
</tr>

<?php foreach ($questions as $q): ?>
<tr>
<td>
<?php echo $this->Html->link($q['ReportQuestion']['title'],
    array('controller'  => 'questions', 'action' => 'view',
      $q['ReportQuestion']['id'])); ?>
</td>
<td><?php echo $q['ReportUser']['username']; ?></td>
<td style="width: 180px"><?php echo $q['Report']['created']; ?></td>
</tr>
<?php endforeach; ?>

</table>

<?php $this->end() ?>
