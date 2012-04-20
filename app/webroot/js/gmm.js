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

          if($(this).is('.ref-head')) {
            $('#menu').load('/elements/navigation');
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
    function(e) {
      var fields = {};
      $(this).find(":input").each(function() {
        fields[this.name] = $(this).val();
      });

      $("#user-dropdown").removeClass('dropdown');
      if($(this).is('.noredirect')) {
        fields['noredirect'] = '1';
        $.post($(this).attr('action'), fields);
      } else {
        $.post($(this).attr('action'), fields, function(data) {
          $('#content-main').html(data);
        });
      }

      if($(this).is('.home')) {
        loadPage('/');
        history.pushState({loc: encodeURIComponent('/')}, '', '/');
      }

      if($(this).is('.ref-head')) {
        $('#menu').load('/elements/navigation');
      }
      if($(this).is('.ref')) {
        loadPage(window.location)
      }
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

