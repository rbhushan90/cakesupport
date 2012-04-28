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
          } else {
            loadError();
          }
          loadHeader();
        });
      }

      return false;
    }
  )
  // Prepare History.js
  var History = window.History;

  showHide();

});
function pop(e) {
  if(e.originalEvent && e.originalEvent.state != null && e.originalEvent.state != undefined) {
    state = History.getState();
    loadPage(decodeURIComponent(state.data.loc));
  } else {
    var State = History.getState();
    History.log(State.url, State.title, State.date);
    loadPage(State.url);
  }
};

function historyAdd(url) {
  $(window).unbind("popstate");
  $(window).bind("popstate", pop);
  History.pushState({loc: encodeURIComponent(url)}, '', url);
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
