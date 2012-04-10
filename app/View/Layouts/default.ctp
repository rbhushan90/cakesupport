<?php
/**
 *
 * PHP 5
 *
 * CakePHP(tm) : Rapid Development Framework (http://cakephp.org)
 * Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 *
 * Licensed under The MIT License
 * Redistributions of files must retain the above copyright notice.
 *
 * @copyright     Copyright 2005-2011, Cake Software Foundation, Inc. (http://cakefoundation.org)
 * @link          http://cakephp.org CakePHP(tm) Project
 * @package       Cake.View.Layouts
 * @since         CakePHP(tm) v 0.10.0.1076
 * @license       MIT License (http://www.opensource.org/licenses/mit-license.php)
 */
?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
	<?php echo $this->Html->charset(); ?>
	<title>
		<?php echo $title_for_layout; ?>
	</title>
	<?php

    # The two I'm using
    echo $this->Html->css('bootstrap.min');                                             
    echo $this->Html->css('gmm');                                             

    echo $this->Html->script('jquery');
    echo $this->Html->script('jquery.animate-colors');
    echo $this->Html->script('menu');
                                                                                 
    echo $this->fetch('meta');                                                   
    echo $this->fetch('css');                                                    
    echo $this->fetch('script');                                                 
  ?>                                                                             
</head>
<body>
  <div id="header-container">
    <div id="header" class="content-width">
      <h1><a href="/"><img src="/img/gmm_logo.png"></a></h1>
      <div class="menu">
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
              <li><a href="/logout">Logout</a></li>
              <?php if(CakeSession::read('User.username')) { ?>
                <li><a href='/admin'>Admin</a></li>
              <?php } ?>
            </ul>
          </li>
        <?php } else { ?>
          <li><a href="/login">Login</a></li>
          <li><a href="/register">Sign Up</a></li>
        <?php } ?>

        </ul>
      </div>
    </div>
  </div>

  <div class="content-container content-width">
    <?php echo $this->Session->flash(); ?> 
    <?php echo $this->fetch('content'); ?>                                     
  </div>

  <div class="footer content-width">
    Footer Stuff Goes Here &copy; Since The Big Bang
  </div>
</body>                                                                          
</html>  
