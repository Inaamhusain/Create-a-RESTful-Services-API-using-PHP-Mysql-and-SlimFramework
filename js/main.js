$(document).ready(function(){
	$('body').keypress(function (e) {
	 var key = e.which;
	 if(key == 13)  // the enter key code
		{
			$('#login-btn').click();
			return false;  
		}
	});
	$(document).on("click","#login-btn", function(){
		$("#email, #password").removeClass("error");
		$(".error-div ul").html("");
		var error = "";
		var email = $("#email").val();
		var password = $("#password").val();
		if(email == ""){
			$("#email").addClass("error");
			error += "<li>Please enter Email</li>";
		}
		if(password == ""){
			$("#password").addClass("error");
			error += "<li>Please enter Password</li>";
		}
		if(error != ""){
			$(".error-div ul").html(error);
			return;
		}else{
			API.call("/login", function(data){
				if(data.error == 0){
					error += "<li>"+data.message+"</li>";
					$(".error-div ul").html(error);
				}else{
					error += "<li>"+data.message+"</li>";
					$(".error-div ul").html(error);
				}
			},{email:email,password:password});
		}
	});
});
