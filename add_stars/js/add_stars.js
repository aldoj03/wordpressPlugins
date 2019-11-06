jQuery(document).ready(function($) {
  var starsLoaded_db = 0;
  var post_id = $('div[id^="post-"]').attr("id");
  var id = post_id.substring(post_id.indexOf("-") + 1);
  var point;

  renderContainer($, $(".food-info"));
  var stars = $(".fa.fa-star");

  stars.hover(
    function() {
      paintStars(stars, $(this).attr("id"));
    },
    function() {
      unpaintStars(stars, ((starsLoaded_db > 0 ) ? starsLoaded_db : (point > 0 ) ? point : 0 ));
    }
  );

  //* PIDE LA CANTIDAD DE ESTRELLAS AL CARGAR SINGLE
  jQuery.ajax({
    type: "get",
    url: ajax_var2.url,
    data: "action=initialize_stars" + "&nonce=" + ajax_var2.nonce + "&id=" + id,
    success: function(result) {
      starsLoaded_db = result;
      paintStars(stars, starsLoaded_db);
    }
  });

  //* GUARDA LA CANTIDAD DE ESTRELLAS

  stars.click(function() {
    starsLoaded_db = 0;
    point = $(this).attr("id");
    jQuery.ajax({
      type: "post",
      url: ajax_var2.url,
      data:
        "action=save_points" +
        "&nonce=" +
        ajax_var2.nonce +
        "&id=" +
        id +
        "&point=" +
        point,
      success: function(result) {
      
      unpaintStars(stars, 0);
      paintStars(stars,  point  );
        console.log(result);
      }
    });
  });
});

//*CREA LOS ELEMENTOS

function renderContainer($, element) {
  $("head").append(
    '<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/4.7.0/css/font-awesome.min.css">'
  );

  element.append(
    '<ul id="stars-container"><li><span id="1" class="fa fa-star"></span></li><li><span id="2" class="fa fa-star"></span></li><li><span id="3" class="fa fa-star"></span></li><li><span id="4" class="fa fa-star"></span></li></ul> '
  );
}

function paintStars(stars, limit) {
  for (let index = 0; index < limit; index++) {
    stars[index].classList.add("checked");
  }
}
function unpaintStars(stars, limit) {
  for (let index = 3; index >= limit; index--) {
    stars[index].classList.remove("checked");
  }
}
