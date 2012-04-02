<h2>Users</h2>
<table id="question-list">
<tr>
<th>Username</th>
<th>Name</th>
<th>Email</th>
</tr>

<?php foreach ($users as $q): ?>
<tr>
<td><?php echo $q['User']['username']; ?></td>
<td><?php echo $q['User']['first_name'] . ' ' . $q['User']['last_name']; ?></td>
<td style="width: 180px"><?php echo $q['User']['email']; ?></td>
</tr>
<?php endforeach; ?>

</table>

<?php $this->end() ?>
