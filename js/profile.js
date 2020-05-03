$(function () {
  //resizing add button
  let el = document.getElementById('addFavButton').parentElement;
  var width = getCookie('tabWidth');
  var height = width * (3 / 4);
  el.style.width = `${width}px`;
  el.style.height = `${height}px`;

  //displaying bookmarks
  let favs = [];
  $.ajax({
    type: 'GET',
    url: 'api/display.php',
    success: (response) => {
      if (response !== 'false') {
        favs = JSON.parse(response);
        const addFavDiv = $('#addFavButton').parent();

        for (var i = 0; i < favs.length; i += 3) {
          let src = getUrlSrc(favs[i + 2]) + 'favicon.ico';
          addFavDiv.before(`
          <div
            class='favDiv'
            fav_id='${favs[i]}'
            style="width: ${width}px; height: ${height}px"
          >
            <button class='favTrash'></button>
            <button class='favButton' url='${favs[i + 2]}'>
              <img src='${src}' onerror='favDivImgError(this)'>
              <span>${favs[i + 1]}</span>
            </button>
          </div>
        `);
        }

        $('#fav-container').hide().slideDown('medium');
      } else showError('SQL error fetching bookmarks !');
    },
    error: () => showError(),
  });

  //bookmark buttons events
  $('#fav-container')
    .on('click', '.favButton', function () {
      //simulating middle mouse click
      //target="_blank" doesn't work in steam browser
      $('body').append(
        '<a id="toOpen" href="' + $(this).attr('url') + '"></a>'
      );
      jQuery('#toOpen')[0].dispatchEvent(
        new MouseEvent('click', { button: 1, which: 1 })
      );
      $('#toOpen').remove();
    }) //deleting bookmark
    .on('click', '.favTrash', function () {
      //hiding the div
      $(this).parent().hide('medium');
      //removing from database with ajax
      $.ajax({
        type: 'GET',
        url: 'api/remove.php',
        data: {
          target: $(this).parent().attr('fav_id'),
        },
        success: (response) => {
          if (response === 'false') showError('SQL error in delete function !');
        },
        error: () => showError(),
      });
    });

  //modal events
  $('#addFavButton').click(function () {
    $('#modal').slideDown('medium');
  });
  $('body').on('click', '#modal', function (e) {
    if (e.target == modal) $('#modal').slideUp('medium');
  });

  //adding favs events
  $('#addFavSubmit').click(function () {
    var siteName = $('#site_nameInput').val();
    var siteUrl = $('#site_urlInput').val();

    //highlights if input is empty
    if (siteName === '') $('#site_nameInput').addClass('highlighted_red');
    else if (siteUrl === '') $('#site_urlInput').addClass('highlighted_red');
    else {
      //sliding up the modal
      $('#modal').slideUp('medium');
      //if the site doesn't have https or http at the beginning http is added
      if (!(siteUrl.match('^https://') || siteUrl.match('^http://')))
        siteUrl = 'http://' + siteUrl;
      //adding to the database with ajax
      $.ajax({
        type: 'GET',
        url: 'api/add.php',
        data: { site_name: siteName, site_url: siteUrl },
        success: function (response) {
          if (response !== 'false') {
            let src = getUrlSrc(siteUrl) + 'favicon.ico';
            let width = getCookie('tabWidth');
            let height = width * (3 / 4);
            $('#addFavButton').parent().before(`
              <div style='width: ${width}px; height: ${height}px; display: none'
							  id='newFavDiv'
							  class='favDiv'
							  fav_id='${response}'
								>
                <button class='favTrash'></button>
                <button class='favButton' url='${siteUrl}'>
                  <img src='${src}' onerror='favDivImgError(this);'>
                  <span>${siteName}</span>
                </button>
              </div>
            `);

            $('#newFavDiv').slideDown('slow');
            $('#newFavDiv').removeAttr('id');

            //emptying modal inputs
            $('#site_nameInput').val('');
            $('#site_urlInput').val('');
          } else
            showError('An error occurred, this bookmark did not get saved !');
        },
        error: () => showError(),
      });
    }
  });
  //when a red highlighted input gets focus we remove the highlight
  $('#mContentContainer').on('focus', '.highlighted_red', function () {
    $(this).removeClass('highlighted_red');
  });

  //drag events
  var dragOn = false;
  var addIn = false;
  var movingDiv;
  $('#fav-container')
    .on('click', '.favDiv', function (e) {
      if (
        !dragOn &&
        $(this).attr('fav_id') != 'last' &&
        !$(e.target).hasClass('favButton')
      ) {
        dragOn = true;
        movingDiv = $(this);

        movingDiv.addClass('moving');
        movingDiv.children('.favTrash').hide();
        $('.favTrash').css('opacity', '0');
        $('.favDiv').addClass('noBg');

        //making the div slightly under to the mouse pointer
        movingDiv.css({
          left: e.pageX - 25 + 'px',
          top: e.pageY + 25 + 'px',
        });

        addIn = true;
        let width = getCookie('tabWidth');
        let height = width * (3 / 4);

        movingDiv.before(`
          <div
            id="addDiv"
            fav_id= "${$(this).attr('fav_id')}"
            style="height: ${height}px; width: ${width}px"
            >
          </div>
        `);

        //binding the events
        //div follows cursor
        $(document).bind('mousemove', function (e) {
          movingDiv.css({
            left: e.pageX - 25 + 'px',
            top: e.pageY + 25 + 'px',
          });
        });

        //cancel when clicked on anything other than favDiv
        $(window).bind('click', function (e) {
          if (!$(e.target).hasClass('favDiv')) {
            dragOn = false;
            movingDiv.removeClass('moving');
            $('.favTrash').css('opacity', '1');
            movingDiv.children('.favTrash').show('fast');
            $('#fav-container').children('#addDiv').remove();
            $('.favDiv').removeClass('noBg');
            $('#addFavButton').parent().addClass('noBg');
            //unbinding the events
            $(document).unbind('mousemove');
            $(window).unbind('click');
          }
        });
      }
      //prevent bugs
      else $('#fav-container').children('#addDiv').remove();
    }) //showing the add div when entering a div
    .on('mouseenter', '.favDiv', function () {
      if (dragOn && !addIn) {
        addIn = true;

        let width = getCookie('tabWidth');
        let height = width * (3 / 4);

        $(this).before(`
          <div
            id="addDiv"
            fav_id= "${$(this).attr('fav_id')}"
            style="height: ${height}px; width: ${width}px"
            >
          </div>
        `);
      } else if (addIn) {
        $('#fav-container').children('#addDiv').remove();
        addIn = false;
      }
    }) //hiding the add div when mouse leaves
    .on('mouseleave', '#addDiv', function () {
      $(this).remove();
      addIn = false;
    }) //swapping when clicking on a addDiv
    .on('click', '#addDiv', function (e) {
      // swapping
      $(e.target).addClass('favDiv');
      $(e.target).attr('id', '');

      $(e.target).html(movingDiv.html());
      $(e.target).children('.favTrash').show();
      $('.favTrash').css('opacity', '1');
      $('.favDiv').removeClass('noBg');
      $('#addFavButton').parent().addClass('noBg');

      //swapping in the database
      $.ajax({
        type: 'GET',
        url: 'api/swap.php',
        data: {
          fav1Id: movingDiv.attr('fav_id'),
          fav2Id: $(e.target).attr('fav_id'),
        },
        success: (response) => {
          if (response === 'false') showError('SQL error in swap function !');
        },
        error: () => showError(),
      });

      $(e.target).attr('fav_id', movingDiv.attr('fav_id'));
      movingDiv.remove();

      dragOn = false;
      addIn = false;
      //unbinding
      $(document).unbind('mousemove');
      $(window).unbind('click');
    });
});

/* Functions */

//called when slider changes, resizes the tabs
function scaleTabs(width) {
  const height = width * (3 / 4);

  document.querySelectorAll('.favDiv').forEach((el) => {
    el.style.width = `${width}px`;
    el.style.height = `${height}px`;
  });

  //setting cookie for the size
  let year = new Date().getFullYear() + 1;

  document.cookie =
    'tabWidth=' +
    width +
    '; expires=Thu, 18 Dec ' +
    year +
    ' 12:00:00 UTC; path=/';
}

//this function returns the root url of any given url
function getUrlSrc(url) {
  //inilazing the counters
  var slashCount = 0;
  var c = 0;
  //if the url dosent have / at the end
  if (!url.match('/$')) url += '/';
  //this loop gets where the 3rd slash is
  while (slashCount != 3 && c < url.length) {
    if (url[c] == '/') slashCount++;
    c++;
  }
  //returning the substring
  return url.substring(0, c);
}

//this function handles image loading error
//using google api checking for the icon
//if not found using the default image
function favDivImgError(image) {
  var url = getUrlSrc(image.src);
  image.src = 'img/star.png';
  image.onerror = '';
  $.ajax({
    url: 'api/validateimage',
    data: { domain: url },
    async: true,
    success: (response) => {
      if (response === 'true')
        image.src = 'https://www.google.com/s2/favicons?domain=' + url;
      else image.src = 'img/star.png';
    },
    error: () => {
      image.src = 'img/star.png';
    },
  });
}

//simple function that shows an error
function showError(message = 'HTTP request error') {
  $('body').prepend("<div id='errorDiv'>" + message + '</div>');
}

//cookies function
function getCookie(cname) {
  var name = cname + '=';
  var decodedCookie = decodeURIComponent(document.cookie);
  var ca = decodedCookie.split(';');
  for (var i = 0; i < ca.length; i++) {
    var c = ca[i];
    while (c.charAt(0) == ' ') {
      c = c.substring(1);
    }
    if (c.indexOf(name) == 0) {
      return c.substring(name.length, c.length);
    }
  }
  return '';
}
