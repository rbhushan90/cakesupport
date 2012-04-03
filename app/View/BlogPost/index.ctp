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
<?php echo $this->Html->link($p['BlogPost']['title'],
    array('controller'  => 'blog_posts', 'action' => 'view',
      $p['BlogPost']['id'])); ?>
</td>
<td><?php echo $p['BlogPostUser']['username']; ?></td>
<td style="width: 180px"><?php echo $p['BlogPost']['created']; ?></td>
</tr>
<?php endforeach; ?>

</table>

