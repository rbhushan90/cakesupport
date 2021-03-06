$(document).ready(function() {
  var ieVersion = -1; // Return value assumes failure.
  if (navigator.appName == 'Microsoft Internet Explorer')
  {
    var re  = new RegExp("MSIE ([0-9]{1,}[\.0-9]{0,})");
    if (re.exec(navigator.userAgent) != null)
      ieVersion = parseFloat( RegExp.$1 );
  }
  if(ieVersion < 0 || ieVersion > 9) {
    $(document).on('click', 'a', 
      function(e) {
        if($(this).is('.nojs')) {
          return;
        }
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
          }).error(function() {
            loadError();
          });
        } else {
          $.post($(this).attr('action'), fields, function(data) {
            $('#content-main').html(data);
            FB.XFBML.parse()
            $.ajax({ url: 'http://platform.twitter.com/widgets.js', dataType: 'script', cache:true});
            gapi.plusone.go();
            loadError();
          }).error(function(data, stat, err) {
            if(err.toLowerCase().indexOf('redirect') != -1) {
              loadPage('/', true);
            } else if(err.toLowerCase().indexOf('questions') != -1) {
              loadPage('/questions', true);
            } else {
              loadError();
            }
            loadHeader();
          });
        }

        return false;
      }
    )
  }

  showHide();

});

function pop(e) {
  if(e.originalEvent.state != null) {
    state = e.originalEvent.state;
    loadPage(decodeURIComponent(state.loc));
  } else {
    loadPage(window.location);
  }
}

function historyAdd(url) {
  $(window).unbind("popstate");
  $(window).bind("popstate", pop);
  history.pushState({loc: encodeURIComponent(url)}, '', url);
}

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
        historyAdd(url);
      }
      loadError();
      FB.XFBML.parse()
      $.ajax({ url: 'http://platform.twitter.com/widgets.js', dataType: 'script', cache:true});
      gapi.plusone.go();
    }).error(function(data, stat, err) {
      if(err.toLowerCase().indexOf('redirect') != -1) {
        loadPage('/', true);
      } else {
        loadError();
      }
    }
  );
}

function showHide() {
  $('.displayed').show();
  $('.hidden').hide();
}

function flip(cls) {
  $(cls).toggle();
}
