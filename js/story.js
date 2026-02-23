let background = ""; 
let font = "Clean";

$("#imageUpload").change(function () {

  if (this.files && this.files[0]) {

    $(".right-part").addClass("hidden");
    $(".p-rect-text").addClass("hidden");
    $(".story-preview-container").removeClass("hidden");
    $(".story-wrapper").removeClass("hidden");
    $(".story-body").addClass("hidden");

    let reader = new FileReader();

    reader.onload = function (e) {
      $(".p-rect").css('background-image', 'url(' + e.target.result + ')');
    }

    reader.readAsDataURL(this.files[0]);

  }

})

$(document).on("click", "#share-btn", function (event) {
  let storyData = document.querySelector("#imageUpload").files[0];
  let userid = $(".profile-user-id").data("userid");
  let text=$("#textInput").val().trim();
  if (storyData != "" && text =="") {
    let formData = new FormData();
    formData.append("userid", userid);
    formData.append("status", storyData);
    $.ajax({
      url: "http://localhost/instagram.yan-coder.com/core/ajax/status.php",
      type: "POST",
      cache: false,
      processData: false,
      data: formData,
      contentType: false,
      success: (data) => {
       const response=JSON.parse(data);
        window.location.href='http://localhost/instagram.yan-coder.com/stories/'+response.username+"/"+response.userid;
      },
    });
  }else{
    if(background !=""){
      $.post("http://localhost/instagram.yan-coder.com/core/ajax/textStory.php",{
        userid:userid,
        storyText:text,
        background:background,
        font:font
      },function(data){
        const response=JSON.parse(data);
        window.location.href='http://localhost/instagram.yan-coder.com/stories/'+response.username+"/"+response.userid;
      })
    }
  }
});

$(document).on("click", ".text-container", function () {
  $(".right-part").addClass("hidden");
  $(".story-preview-container").removeClass("hidden");
  $(".story-wrapper").removeClass("hidden");
  $(".story-body").removeClass("hidden");
})

$(document).on("click", ".pick_font_btnn", function () {
  $(".font_list").toggle();
})

$("#textInput").keyup(function (event) {
  let textValue = $(event.target).val().trim();
  let textElement = document.querySelector(".p-rect-text");
  if (textValue != "") {
    $(".p-rect-text").css({
      'color': '#fff'
    });
    textElement.innerText = textValue;
  } else {
    $(".p-rect-text").css({
      'color': 'rgba(255,255,255,0.5)'
    });
    textElement.innerText = 'START TYPING';
  }
})

$(document).on("click", ".bg_story_select", function () {
  $(".bg_story_select").removeClass("bg_active");
  var backgroundImage = $(this).addClass("bg_active").find('img').attr('src');
  background = backgroundImage;
  $(".p-rect").css('background-image', 'url(' + backgroundImage + ')');
})

$(document).on('click', "#clean_font", function () {
  $(".p-rect-text").css('font-family', 'kanit');
  font = "Clean";
  $(".font_name").html(font);
  $(".font_list").hide();
})

$(document).on('click', "#bold_font", function () {
  $(".p-rect-text").css('font-family', 'Bebas Neue');
  font = "Bold";
  $(".font_name").html(font);
  $(".font_list").hide();
})

$(document).on('click', "#simple_font", function () {
  $(".p-rect-text").css('font-family', 'Segoe UI');
  font = "Simple";
  $(".font_name").html(font);
  $(".font_list").hide();
})

$(document).on('click', "#neon_font", function () {
  $(".p-rect-text").css('font-family', 'Indie Flower');
  font = "Neon";
  $(".font_name").html(font);
  $(".font_list").hide();
})

$(document).on('click', "#italic_font", function () {
  $(".p-rect-text").css('font-family', 'Roboto');
  font = "Italic";
  $(".font_name").html(font);
  $(".font_list").hide();
})