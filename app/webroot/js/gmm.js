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
          loadPage($(this).attr('href'), true);
          $("#user-dropdown").removeClass('dropdown');
        }
      } 
    }
  )

  $(document).on('submit', 'form',
    function(e) {
      var fields = {};
      $(this).find(":input").each(function() {
        if(this.type != 'checkbox') {
          fields[this.name] = $(this).val();
        } else if($(this).is(':checked')) {
          fields[this.name] |= $(this).val();
        }
      });

      $("#user-dropdown").removeClass('dropdown');
      if($(this).is('.login')) {
        fields['noredirect'] = '1';
        $.post($(this).attr('action'), fields, function(data) {
          loadHeader();
          loadPage(window.location);
        });
      } else if($(this).is('register')) {
        $.post($(this).attr('action'), fields, function(data) {
          loadHeader();
          loadError();
        });
      } else {
        $.post($(this).attr('action'), fields, function(data) {
          $('#content-main').html(data);
          FB.XFBML.parse()
          $.ajax({ url: 'http://platform.twitter.com/widgets.js', dataType: 'script', cache:true});
          gapi.plusone.go();
        });
        loadError();
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

  showHide();

});

function loadError() {
  $.get('/elements/error', function(data) {
    $('#err').html(data);
    $("#err").fadeIn(400).delay(4000).slideUp(300);
  });
}

function loadHeader() {
  $.get('/elements/navigation', function(data) {
    $('#menu').html(data);
  });
}

function loadPage(url, push) {
  if(!push) {
    var push = false;
  }
  $.get(url, function(data) {
      $('#content-main').html(data);
      showHide();
      if(push) {
        history.pushState({loc: encodeURIComponent(url)}, '', url);
      }
      loadError();
      FB.XFBML.parse()
      $.ajax({ url: 'http://platform.twitter.com/widgets.js', dataType: 'script', cache:true});
      gapi.plusone.go();
    }).error(function(data, stat) {
    loadError();
  });
}

function showHide() {
  $('.displayed').show();
  $('.hidden').hide();
}

function flip(cls) {
  $(cls).toggle();
}
