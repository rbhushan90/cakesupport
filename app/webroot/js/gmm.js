$(document).ready(function() {
  $(document).on('click', 'a', 
    function(e) {
      if($(this).is('.action')) {
          e.preventDefault();

          if($(this).is('.login')) {
            if ($("#user-dropdown").hasClass('dropdown')) {
              $("#user-dropdown").removeClass('dropdown');
            } else {
              $("#user-dropdown").addClass('dropdown');
            }
          } else {
            $.ajax($(this).attr('href'));
            $("#user-dropdown").removeClass('dropdown');
          }
          
          if($(this).is('.ref')) {
            loadPage(window.location);
          }

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
          $("#user-dropdown").removeClass('dropdown');
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
    } else {
      loadPage(window.location);
    }
  });

});

function loadPage(url) {
  $.get(url, function(data) {
    $('#content-main').html(data);
  });
}

