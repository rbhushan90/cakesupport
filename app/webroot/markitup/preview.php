<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
  <head>
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <title>markItUp! preview template</title>
    <link rel="stylesheet" type="text/css" href="/css/bootstrap.min.css" />
    <link rel="stylesheet" type="text/css" href="/css/gmm.css" />
  </head>
  <body style="background-color: white">
    <div class="post">
      <div class="post-content">
        <?php
          include 'markdown.php';
          echo Markdown($_POST['data']);
        ?>
      </div>
    </div>
    <br />
    <br />
  </body>
</html>
