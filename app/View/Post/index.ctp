<h2>Recent Blog Entries</h2>

<table id="question-list">
<tr>
<th>Title</th>
<th>by</th>
<th>on</th>
</tr>

<?php foreach ($posts as $p): ?>
<tr>
<td>
<?php echo $this->Html->link($p['Post']['title'],
    array('controller'  => 'posts', 'action' => 'view',
      $p['Post']['id'])); ?>
</td>
<td><?php echo $p['PostUser']['username']; ?></td>
<td style="width: 180px"><?php echo $p['Post']['created']; ?></td>
</tr>
<?php endforeach; ?>

</table>

