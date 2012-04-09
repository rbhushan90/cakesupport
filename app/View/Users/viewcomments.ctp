<h2><?php echo $user['User']['username']; ?>'s Comments</h2>

<div class="top-content"></div>
<div class="main-content">
  <?php
		foreach($user['UserComment'] as $com) {
			echo '<p>';
      echo $com['body'];
			echo $this->Html->link('[View Post]', array('controller'=>'posts', 'action'=>'view', $com['post_id']));
      echo '</p>';
		}

    echo $this->Html->link('Back', array('controller'=>'users', 'action'=>'view', $user['User']['id']));
    ?>
</div>
<div class="bottom-content"></div>
