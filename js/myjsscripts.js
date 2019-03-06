$(document).ready(function() {
	$("#passwordmismatchalert").hide();
	$("#viewerjs").hide();

	function matchingPasswords() {
		var password1 = $("#password1").val();
		var password2 = $("#password2").val();

		if(password1 != password2 && password2 != null) {
			$("#passwordmismatchalert").show();
			disableSubmitButton($('#signup_submit'));
		} else {
			$("#passwordmismatchalert").hide();
			enableSubmitButton($('#signup_submit'));
			return true;
		}
	}

	$('.pull-down').each(function() {
	  var $this = $(this);
	  $this.css('margin-top', $this.parent().height() - $this.height())
	});
	
	function readURL(input) {
		if (!input.files[0].name.match(/\.(jpg|jpeg|png|gif)$/gi)) { 	
	    	$("#viewerjs").show();
	    	$("#image_preview").hide();
	    	$("note_file_input").show();
	    	$("note_file_container").show();
	    } else {
	    	if (input.files && input.files[0]) {
		        var reader = new FileReader();

		        reader.onload = function (e) {
		            $('#image_preview').attr('src', e.target.result);
		        }

		        reader.readAsDataURL(input.files[0]);
		    }
	    } 
	}

	var courseid=2;

	$("#courses_button").click(function() {
		var buttonID = $(this).attr('id');
		var newElement = $("<div class=\"form-group\"><div class=\"col-sm-2\"></div><div class=\"col-sm-3\"><input class=\"form-control course-field\" type=\"text\" name=\"course\" id=\"course-" + courseid + "\"></input></div>");
		courseid++;

		var position = $(buttonID).last();
		$(this).parent().parent().after(newElement);
	});

	$("#courses").change(function() {
				
	});	

	$("#courses").change(function() {
		$("#fields").val("");
		//$("#fields").prop("disabled",true);
	});

	$("#fields").change(function() {
		$("#courses").val("");
	});

	$("#topic").keyup(function () {
		var characters = countChar(this);
		//alert(characters);
		var remainder = 700-characters;
		$(".textcounter").val(characters);
	});

	$('#deleteDiscussionModal').on('shown.bs.modal', function () {
		$('#myInput').focus();
	});

	$('#deleteCommentModal').on('shown.bs.modal', function () {
		$('#myInput').focus();
	});


	function countChar(val) {
    	var len = val.value.length;
    	if (len >= 701) {
    		val.value = val.value.substring(0, 700);
		} else {
			$('#textcounter').text(700 - len);
		}
    		if ($("#textcounter").text() == 0) {
    			document.getElementById("textcounter-container").style.color = 'red';
    		} else {
    			document.getElementById("textcounter-container").style.color = 'black';

    		}
	};

   
    function submitform(){
        var courses = document.getElementById("courses");
        var coursevalue = courses.options[courses.selectedIndex].value;
        $("#hidden_course").val(coursevalue);
		document.forms[2].submit();
    }

    function resetInputValues(field,course) {
    	$("#fields").val(field);
    	$("#courses").val(course);

    }

	function disableSubmitButton() {
		arguments[0].prop('disabled',true);
	}

	function enableSubmitButton() {
		arguments[0].prop('disabled',false);
	}
	
	$("#profile_image_input").change(function(){
	    readURL(this);
	});

	$("#note_file_input").change(function() {
		readURL(this);
	});


	$("#password1").keyup(function() {
		matchingPasswords();
	});

	$("#password2").keyup(function() {
		matchingPasswords();
	});


	$.get('localhost:99/NoteShare/courses/courses.json', function(data){
    	$(".course-field").typeahead({ source:data });
	},'json');
});