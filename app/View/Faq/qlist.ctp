<?php $this->start('qlist') ?>

<table id="question-list">
<tr>
<th>Question</th>
<th>Answer</th>
</tr>

<?php foreach ($questions as $q): ?>
<tr>
<td style="width: 80px"><?php echo $q['Question']['title'] ?></td>
<td style="width: 180px"><?php echo $q['Question']['body']; ?></td>
</tr>
<?php endforeach; ?>

</table>

<?php $this->end() ?>
