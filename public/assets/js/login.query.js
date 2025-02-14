

$(document).ready(function() {

    $('#form_login').submit(function(e) {

        e.preventDefault();
        var formData = new FormData(this);

        $.ajax({
            url: base_url + '/thisLogin',
            type: 'POST',
            data: formData,
            contentType: false,
            processData: false,
            dataType: 'json',
            beforeSend: function(xhr) {

                $("#overlay").show();

            },
            success: function(response) {
                try {
                    if (!response.success) {
                        $('.has-error').removeClass('has-error');
                        $('.has-success').removeClass('has-success');
                        $('.help-block').empty();
                        
                        if(response.formnotvalid){
                            handleValidationErrors(response.data);
                        }else{
                            $(".error-box").show();
                            $(".error-message").html(response.message);

                            setTimeout(function() {
                                $(".error-box").hide();
                                $(".error-message").html("");
                            }, 3000);
                        }
                    }else{
                        window.location.href = response.redirect_to;
                    }
                } catch (error) {
                    console.error("Error processing response:", error);
                }
            },
            error: function(xhr, errorType, thrownError) {
                if (xhr.status === 403 || xhr.status === 405) {
                    alert(xhr.responseText);
                    console.log("Server error: " + xhr.responseText);
                } else {
                    var errorMessage = xhr.responseJSON && xhr.responseJSON.error ? xhr.responseJSON.error : xhr.statusText;
                    //alert("Server error: " + errorMessage);
                    console.log("Server error: " + xhr.responseText);
                }
                
            },
            complete: function() {
            
                $("#overlay").hide();
            }
        });

        
    });

});