$(document).ready(function(){makeAjaxRequest(1)});function makeAjaxRequest(a){if(a==1){$.ajax({url:"adminSignin_exe.php",type:"post",data:{x:a},success:function(b){$("div#codeDiv").html(b);if(erruser!=""){alert(erruser)}}})}};