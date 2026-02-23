const getId = (id) => document.getElementById(id);
const getSl = (selector) => document.querySelector(selector);
const BASE_URL = "http://localhost/instagram.yan-coder.com/core/ajax/";
let user_id=$(".profile-user-id").data("userid");

const globalHeader = getSl(".global-header");
const modal = getSl(".menu-container");
const profileButton = getSl(".profile--container");
const image=getId("imgPreview");
   

const password = getId("password");
const show_hide_password = getId("show_hide_password");
const imageElement = getSl(".heroImg");
let slideIndex = 0;
const IMAGE_DATA = [
  "http://localhost/instagram.yan-coder.com/images/1.png",
  "http://localhost/instagram.yan-coder.com/images/2.png",
  "http://localhost/instagram.yan-coder.com/images/3.png",
  "http://localhost/instagram.yan-coder.com/images/4.png",
];

if (password) {
  show_hide_password.addEventListener("click", function () {
    if (password.type === "password") {
      password.type = "text";
      show_hide_password.innerText = "Hide";
    } else {
      password.type = "password";
      show_hide_password.innerText = "Show";
    }
  });

  function showSlides() {
    const slider = () => {
      slideIndex++;

      imageElement.style.backgroundImage = `url(${IMAGE_DATA[slideIndex]})`;
      if (slideIndex == 3) slideIndex = -1;
    };
    let timer = setInterval(slider, 3000);
  }
  showSlides();
}

if (globalHeader) {
  profileButton.addEventListener("click", function () {
    modal.style.display === "none"
      ? (modal.style.display = "block")
      : (modal.style.display = "none");
  });

  $(function () {
    $("#main-search").keyup(function (event) {
      const searchValue = $(this).val().trim();
      const resultContainer = $(".search-result");
      $.post(
        BASE_URL + "search.php",
        {
          search: searchValue,
        },
        function (data) {
          resultContainer.html(data);
          if (searchValue === "") {
            resultContainer.html("");
          }
        }
      );
    });
  });

  $(document).on("click","#postModal",function(){
    $("#post_box").toggle();
    $(".p-container-add").removeClass("display_none");
    $("#imgPreview").addClass("display_none");
    if($("#post_box").is(":visible")){
     document.title="Create New Post • Instagram";
    }else{
      document.title="Instagram";
      image.src="";
    }
  })

  $(document).on("click","#close_post",function(){
    let postContainer=getId("post_box");
    postContainer.style.display="none";
    $(".p-container-add").removeClass("display_none");
    $("#imgPreview").addClass("display_none");
    image.src="";
    document.title="Instagram";
  })
}

$("#post_photo").change(function(){
  if(this.files && this.files[0]){
    $(".p-container-add").addClass("display_none");
    $("#imgPreview").removeClass("display_none");
    let reader=new FileReader();
    reader.onload=(e)=>{
      image.src=e.target.result;
    }
    reader.readAsDataURL(this.files[0]);
  }

})

$(document).on("click","#post_button",function(event){
  event.preventDefault();
  let postImage=getId("post_photo").files[0];
  let text=$("#postTextarea").val().trim();
  if((postImage !="" && text =="") || (postImage !="" && text !="")){
    let formData=new FormData();
    formData.append("user_id",user_id);
    formData.append("post",text);
    formData.append("postImage",postImage);
    $.ajax({
      url:BASE_URL+"post.php",
      type:"POST",
      cache:false,
      processData:false,
      data:formData,
      contentType:false,
      success:(data)=>{
        $(".posts").html(data);
        $("#post_photo").val("");
        $("#post_box").hide();
      }
    })
  }
})

$(document).on("click",".comment-btn",function(){
    let commentArea=$(this).parents(".post__buttons").siblings(".postForm").find(".comment");
    commentArea.focus();
})

$(document).on("click",".comment-save",function(e){
   e.preventDefault();
   let postId=$(this).data('postid');
   let userid=$(this).data('userid');
   let commentArea=$(this).parents(".postForm").find('.comment');
   let commentValue=commentArea.val().trim();
   let commentList=$(this).parents(".postForm").siblings(".post__infos").find(".comment-lists");

   if(commentValue !=""){
    $.post(
      BASE_URL + "comment.php",
      {
        comment:commentValue,
        commentBy:userid,
        commentOn:postId
      },
      function (data) {
        commentList.html(data);
        commentArea.val("");
        commentArea.focus();
      }
    );
   }
})



$(document).on("click",".deleteContainer",function(){
  let postId=$(this).data('postid');
  let userid=$(this).data('userid');

   $.post(
     BASE_URL + "delete_request.php",
     {
        postedBy:userid,
        deletePost:postId
     },
     function (data) {
        $(".posts").html(data);

     }
   );

})