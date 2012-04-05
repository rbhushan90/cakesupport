<h2><?php echo $user['User']['username']; ?>'s Profile</h2>

<div class="top-content"></div>
<div class="main-content">
    <p>Name: <?php echo $user['User']['first_name'] . ' ' . $user['User']['last_name']; ?></p>
    <p>Email: <?php echo $user['User']['email']; ?></p>
    <p><?php echo $this->Html->link(
	'Questions asked: ' . $user['User']['question_count'],
	 array('controller'=>'users',
		'action'=>'view',
		$user['User']['id'],
		'questions'));?></p>
    <p><?php echo $this->Html->link(
	'Questions answered: ' . $user['User']['answer_count'],
	 array('controller'=>'users',
		'action'=>'view',
		$user['User']['id'],
		'answers'));?></p>

    <?php 
    switch ($contentType){
	case 'questions':
		foreach($user['UserQuestion'] as $r){
			echo '<p>';
			echo $this->Html->link(
				$r['title'],
				array('controller'=>'questions',
					'action'=>'view',
					$r['id']
				));
		}
		break;

	case 'answers':
		foreach($user['UserAnswer'] as $r){
			//debug($r,1);
			echo '<p>';
			echo $this->Html->link(
				$r['body'],
				array('controller'=>'questions',
					'action'=>'view',
					$r['question_id']
				));
			//echo $r['body'];
		}
		break;
    } ?>
</div>
<div class="bottom-content"></div>
