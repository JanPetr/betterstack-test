// create user using AJAX

function createUser(e) {
	e.preventDefault();
	
	const form = $(this);
	const action = form.attr('action');
	const data = form.serialize();
	
	$.ajax({
		type: 'POST',
		url: action,
		data: data,
		dataType: 'json',
		success: function (res) {
			const success = $("<div class='alert alert-success' role='alert'>").text("New user added");
			$("#message").html(success);
			
			$("#users tbody").append(
				"<tr>" +
				"<td>" + $("#name", form).val() + "</td>" +
				"<td>" + $("#email", form).val() + "</td>" +
				"<td>" + $("#phone-number", form).val() + "</td>" +
				"<td>" + $("#city", form).val() + "</td>" +
				"</tr>"
			);
			
			$("input", form).val(''); // reset form fields
			$("#token", form).val(res.token); // set new CSRF token
		},
		error: function (res, status, error) {
			const jsonRes = res.responseJSON
			$("#token", form).val(jsonRes.token); // set new CSRF token
			
			$("#message").html(); // reset notice content
			jsonRes.errors.forEach(error => {
				const alert = $("<div class='alert alert-danger' role='alert'>").text(error);
				$("#notice").append(alert);
			})
		}
	});
}

$("#create-new-user").submit(createUser);
