$("#imageUpload").change(function() {

    if (this.files && this.files[0]) {

        $(".right-part").addClass("hidden");
        $(".p-rect-text").addClass("hidden");
        $(".story-preview-container").removeClass("hidden");
        $(".story-body").addClass("hidden");

        let reader = new FileReader();
        
        reader.onload = function(e) {
            $(".p-rect").css('background-image', 'url('+e.target.result+')');
        }

        reader.readAsDataURL(this.files[0]);

    }

})

$(document).on("click", "#share-btn", function(event) {

    let storyData = document.querySelector("#imageUpload").files[0];
    let userid = $(".profile-user-id").data("follow");

    if (storyData != "") {

        let formData = new FormData();

        formData.append("userid", userid);
        formData.append('status', storyData);

        $.ajax({
            url:"http://localhost/instagram.yan-coder.com/core/ajax/status.png",
            type:"POST",
            cache:false,
            processData:false,
            data:formData,
            contentType:false,
            success:(data) => {
                
            }
        })

    }

})