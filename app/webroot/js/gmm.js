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


  $("a").click(
    function(e) {
      if($(this).is('.action')) {
          e.preventDefault();
          performAction($(this).attr('href'));
          if($(this).is('.logout')) {
            loadPage(window.location);
          }
      } else {
        if(this.href.indexOf(location.hostname) == -1) {
          $(this).attr('target', '_blank');
        } else {
          e.preventDefault();
          history.pushState($(this).attr('href'), '', $(this).attr('href'));
          loadPage($(this).attr('href'));
        }
      } 
    }
  )

  $('form').submit(
    function() {
      var fields = {};
      $("#theForm").find(":input").each(function() {
        fields[this.name] = $(this).val();
      });
      $.post($(this).attr('action'), data, function(data) {
          $('#content-main').html(data);
      });
      return false;
    }
  )

  window.onpopstate = function (e) {
    if(event.state != null) {
      loadPage(JSON.stringify(event.state));
    }
  }
});

function performAction(url) {
  $.ajax(url)
  $('#menu').load('/elements/navigation');
}

function loadPage(url) {
  $.get(url, function(data) {
    $('#content-main').html(data);
  });
}

