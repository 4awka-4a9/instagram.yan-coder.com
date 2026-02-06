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