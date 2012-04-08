<h2><?php echo $user['User']['username']; ?>'s Questions</h2>

<div class="top-content"></div>
<div class="main-content">
  <?php
		foreach($user['UserQuestion'] as $q) {
			echo '<p>';
			echo $this->Html->link($q['title'], array('controller'=>'questions', 'action'=>'view', $q['id']));
      echo '</p>';
		}
    echo '<br />';
    echo '<br />';
    echo $this->Html->link('Back', array('controller'=>'users', 'action'=>'view', $user['User']['id']));
    ?>
</div>
<div class="bottom-content"></div>
