<h2>Recently Blog Entries</h2>

<table id="question-list">
<tr>
<th>Title</th>
<th>by</th>
<th>on</th>
</tr>

<?php foreach ($entries as $q): ?>
<tr>
<td>
<?php echo $q['title']; ?>
</td>
<td><?php echo $q['dc:creator']; ?></td>
<td style="width: 180px"><?php echo $q['pubDate']; ?></td>
</tr>
<?php echo $q['content:encoded']; ?>
<?php endforeach; ?>
</table>

