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


  $(document).on('click', 'a', 
    function(e) {
      if($(this).is('.action')) {
          e.preventDefault();
          $.ajax($(this).attr('href'));
          if($(this).is('.logout')) {
            loadPage(window.location);
            $('#menu').load('/elements/navigation');
          }
          if($(this).is('.tags')) {
            loadPage(window.location);
          }
          if($(this).is('.categories')) {
            loadPage(window.location);
          }
      } else {
        if(this.href.indexOf(location.hostname) == -1) {
          $(this).attr('target', '_blank');
        } else {
          e.preventDefault();
          history.pushState({loc: encodeURIComponent($(this).attr('href'))}, '', $(this).attr('href'));
          loadPage($(this).attr('href'));
        }
      } 
    }
  )

  $(document).on('submit', 'form',
    function() {
      var fields = {};
      $("#theForm").find(":input").each(function() {
        fields[this.name] = $(this).val();
      });
      $.post({url: $(this).attr('action')}, data, function(data) {
          $('#content-main').html(data);
      });
      return false;
    }
  )

  $(window).bind("popstate", function (e) {
    if(e.originalEvent.state != null) {
      state = e.originalEvent.state;
      loadPage(decodeURIComponent(state.loc));
    }
  });

  $("#user-dropdown a").click(function(e) {
    e.preventDefault();

    if ($("#user-dropdown").hasClass('dropdown')) {
      $("#user-dropdown").removeClass('dropdown');
    } else {
      $("#user-dropdown").addClass('dropdown');
    }
  });
});

function loadPage(url) {
  $.get(url, function(data) {
    $('#content-main').html(data);
  });
}

