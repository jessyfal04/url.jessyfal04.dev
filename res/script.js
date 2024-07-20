
function verifCode() {
	var code = document.getElementById("code").value;

	$.ajax({
		url: "../api/verify.php",
		type: "GET",
		data: {
			code: code
		},
		success: function(data) {
			if (data.status == "success") {
				hideShow(data.data.exists);
				$("#nbVisites").text(data.data.visits);
				$("#redirectionUrl").text(data.data.url);
				$("#verify-button").prop('disabled', true);
			} 
			else if (data.status == "error") {
				hideShow(-1);
				setMessages("danger", data.message);
			}
		},
		error: function(data) {
			setMessages("danger", "Unxpected error.");
		}
	});

}

function createRedirection() {
	var url = document.getElementById("url").value;
	var code = document.getElementById("code").value;
	var passphrase = document.getElementById("passphrase").value;

	$.ajax({
		url: "../api/create.php",
		type: "GET",
		data: {
			url: url,
			code: code,
			passphrase: passphrase
		},
		success: function(data) {
			if (data.status == "success") {
				setMessages("success", data.message);
				verifCode();
			} 
			else if (data.status == "error") {
				setMessages("danger", data.message);
			}
		},
		error: function(data) {
			setMessages("danger", "Unxpected error.");
		}
	});
}

function deleteRedirection() {
	var code = document.getElementById("code").value;
	var passphrase = document.getElementById("passphrase").value;

	$.ajax({
		url: "../api/delete.php",
		type: "GET",
		data: {
			code: code,
			passphrase: passphrase
		},
		success: function(data) {
			if (data.status == "success") {
				setMessages("success", data.message);
				document.getElementById("code").value = "";
				document.getElementById("passphrase").value = "";
				hideShow(-1);
			} 
			else if (data.status == "error") {
				setMessages("danger", data.message);
			}
		},
		error: function(data) {
			setMessages("danger", "Unxpected error.");
		}
	});
}

function codeChanged() {
	$("#verify-button").prop('disabled', false);
	hideShow(-1);
}

// on load, check in ?error, if so, display error message
$(document).ready(function() {
	var urlParams = new URLSearchParams(window.location.search);
	var error = urlParams.get("error");
	if (error) {
		setMessages("danger", error);
		// remove error from url
		window.history.replaceState({}, document.title, "/");
	}
});

function setMessages(type, text) {
	$("#messages").html("");
	// in click one 
	if (text != null) {
        var notification = $(`
            <div class="notification is-${type} mx-6" style="display: none;">
				<button class="delete" onclick="$(this).parent().remove();"></button>
				${text}
            </div>
        `);
        
        // Append notification to messages container
        $("#messages").append(notification);

        // Fade in the notification
        notification.fadeIn();

        // Set timeout to fade out and remove the notification after 5 seconds
        setTimeout(function() {
            notification.fadeOut(function() {
                $(this).remove();
            });
        }, 5000);
    }
}

function hideShow(n) {
	if (n == -1) {
		$(".if-exists").hide();
		$(".if-no-exists").hide();
	} else if (n == 0) {
		$(".if-exists").hide();
		$(".if-no-exists").show();
	} else if (n == 1) {
		$(".if-no-exists").hide();
		$(".if-exists").show();
	}
}