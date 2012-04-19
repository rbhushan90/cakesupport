<h2><?php echo $user['User']['username']; ?>'s Comments</h2>

<div class="top-content"></div>
<div class="main-content">
  <div class="user user-content">
    <ul>
    <?php
      $count = 0;
      foreach($user['UserComment'] as $com) {
        $klass = ($count % 2 == 0) ? 'even' : 'odd';
        echo "<li class='{$klass}'>";
        echo $com['body'];
        echo $this->Html->link('[View Post]', array('controller'=>'posts', 'action'=>'view', $com['post_id']));
        echo '</li>';
        $count++;
      }
    ?>
    </ul>
    <?php
      echo $this->Html->link('Back', array('controller'=>'users', 'action'=>'view', $user['User']['id']), array('class' => 'user-back'));
    ?>
  </div>
</div>
<div class="bottom-content"></div>
