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
      <li><a class="action logout" href="/logout">Logout</a></li>
      <?php if(CakeSession::read('User.username')) { ?>
        <li><a href='/admin'>Admin</a></li>
      <?php } ?>
    </ul>
  </li>
<?php } else { ?>
  <li><a href="/login">Login</a></li>
  <li><a class="action" href="/register">Sign Up</a></li>
<?php } ?>
</ul>
