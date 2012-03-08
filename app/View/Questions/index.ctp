<h2>Recently Asked</h2>
<!--
<?php #echo $this->Html->link('Post a new Question', array('action' => 'add')); ?>
<br />
<br />
-->


<table id="question-list">
<tr>
<th>Title</th>
<th>by</th>
<th>on</th>
</tr>

<?php foreach ($questions as $q): ?>
<tr>
<td>
<?php echo $this->Html->link($q['Question']['title'],
    array('controller'  => 'questions', 'action' => 'view',
      $q['Question']['id'])); ?>
</td>
<td><?php echo $q['User']['username']; ?></td>
<td style="width: 180px"><?php echo $q['Question']['created']; ?></td>
</tr>
<?php endforeach; ?>
</table>

