$(document).ready(function() {
	$("li.subnav a").hover(function() {
		$(this).parent().find("ul").slideDown('fast').show();
		$(this).parent().hover(function() {
		}, function() {
			$(this).parent().find("ul").slideUp('slow');
		});
	}, function() { });
  $("ul#nav>li>a").hover(function() {
    $(this).animate( { backgroundColor: '#227722'}, 200);
  }, function() {
    $(this).animate( { backgroundColor: '#116611'}, 200);
  });
});
