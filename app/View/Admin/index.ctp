<?php foreach(array('ReportedAnswer', 'ReportedQuestion') as $reportType): ?>
<h2>Recently Reported <?php echo substr($reportType, 8) ?>s</h2>
<table id="question-list">
<tr>
<th>Title</th>
<th>reported by</th>
<th>on</th>
</tr>

<?php foreach (${$reportType . 's'} as $q): ?>
<tr>
<td>
<?php echo $this->Html->link($q['$reportType']['title'],
    array('controller'  => 'questions', 'action' => 'view',
      $q[$reportType . 'Content']['id'])); ?>
</td>
<td><?php echo $q[$reportType . 'User']['username']; ?></td>
<td style="width: 180px"><?php echo $q['Report']['created']; ?></td>
</tr>
<?php endforeach; ?>
</table>
<?php endforeach; ?>

<?php $this->end() ?>
