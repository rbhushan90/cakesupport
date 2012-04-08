<h2><?php echo $user['User']['username']; ?>'s Questions</h2>

<div class="top-content"></div>
<div class="main-content">
  <?php
		foreach($user['UserAnswer'] as $ans) {
			echo '<p>';
      echo $ans['body'];
			echo $this->Html->link('[View Question]', array('controller'=>'questions', 'action'=>'view', $ans['id']));
      echo '</p>';
		}

    echo $this->Html->link('Back', array('controller'=>'users', 'action'=>'view', $user['User']['id']));
    ?>
</div>
<div class="bottom-content"></div>
