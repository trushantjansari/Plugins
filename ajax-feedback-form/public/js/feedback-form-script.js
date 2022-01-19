(function( $ ) {
    'use strict'; 

    $("#feedbackForm").validator().on("submit", function (event) {
        //alert("Clicked")
        if (event.isDefaultPrevented()) {
            // handle the invalid form...
            formError();
            submitMSG(false, "Did you fill in the form properly?");
        } else {
            // everything looks good!
            event.preventDefault();
            submitForm();
        }
    });


    function submitForm(){
        // Initiate Variables With Form Content
        var fname = $("#fname").val();
        var lname = $("#lname").val();
        var email = $("#email").val();
        var msg_subject = $("#msg_subject").val();
        var message = $("#message").val();


        $.ajax({
            type: "POST",
            url: ajff.ajaxurl, 
            data:  {
                action: 'ajff_sentemail',
                fname: fname,
                lname:lname,
                email: email, 
                msg_subject: msg_subject, 
                message: message 
            }, 
            success : function(data){
                if (data == "success"){
                    formSuccess();
                } else {
                    formError();
                    submitMSG(false,data);
                }
            }
            
        });
    }

    function formSuccess(){
       $("#feedbackForm")[0].reset();
       showSucccess(true, "Thank you for sending us your feedback.")
    }

    function formError(){
        $("#feedbackForm").removeClass().addClass('shake animated').one('webkitAnimationEnd mozAnimationEnd MSAnimationEnd oanimationend animationend', function(){
            $(this).removeClass();
        });
    }

    function submitMSG(valid, msg){
        if(valid){
            var msgClasses = "h3 text-center tada animated text-success";
        } else {
            var msgClasses = "h3 text-center text-danger";
        }
        $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
    }

    function showSucccess(valid, msg){
        if(valid){
            $("#ajffcontent form").remove();
            var msgClasses = "h3 text-center tada animated text-success";
            $("#msgSubmit").removeClass().addClass(msgClasses).text(msg);
        }

    }

})( jQuery );
