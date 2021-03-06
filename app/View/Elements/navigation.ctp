<ul>
  <li><a href="/blog">Blog</a></li>
  <li class="nested-menu"><a href="/questions">Questions <i class="icon-chevron-down"></i></a>
    <ul id="questions_submenu">
      <li><a href="/recent">All</a></li>
      <li><a href="/unanswered">Unanswered</a></li>
      <li><a href="/unaccepted">No accepted answers</a></li>
    </ul>
  </li>
  <!--
  <li><a href="/testimonials">Testimonials</a></li>
  -->
  <li><a href="/faq">FAQ</a></li>
<?php if(CakeSession::read('User.username')) { ?>
  <li class="nested-menu"><a href="/users/view/<?php echo CakeSession::read('User.id') ?>">Welcome, <?php echo CakeSession::read('User.username') ?> <i class="icon-chevron-down"></i></a>
    <ul id="users_submenu">
      <li><a href="/users/view/<?php echo CakeSession::read('User.id') ?>">Your profile</a></li>
      <li><a class="action ref ref-head" href="/logout">Logout</a></li>
      <?php if(CakeSession::read('User.permissions') & Configure::read('permissions.admin')) { ?>
        <li><a href='/admin'>Admin</a></li>
      <?php } ?>
    </ul>
  </li>
<?php } else { ?>
  <li id="user-dropdown" class="nested-menu">
    <a href="/login" class="action login">Login</a>
    <div id="nav-login">
    <?php
      echo $this->Form->create('User', array('action' => 'login', 'class' => 'login'));
      echo $this->Form->input('username');
      echo $this->Form->input('password');
      echo $this->Form->submit('Login', array('class' => 'btn btn-primary', 'div' => false));
      echo $this->Form->end();
      echo "<br />";
      echo $this->Html->link('Forgot Username/Password?', '/users/forgot');
    ?>
    </div>
  </li>
  <li><a class="" href="/register">Sign Up</a></li>
<?php } ?>
</ul>
