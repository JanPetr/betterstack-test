// create user using AJAX
function escapeHtml(unsafe)
{
	return unsafe
		.replace(/&/g, "&amp;")
		.replace(/</g, "&lt;")
		.replace(/>/g, "&gt;")
		.replace(/"/g, "&quot;")
		.replace(/'/g, "&#039;");
}

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
			
			const pn = $("#phone-number", form).val();
			let pnStr = "<i>No phone number :(</i>";
			if (pn.length > 0) {
				pnStr = escapeHtml(pn);
			}
			
			$("#users tbody .add-new-user-row").before(
				"<tr>" +
				"<td>" + escapeHtml($("#name", form).val()) + "</td>" +
				"<td><a href=\"mailto:" + escapeHtml($("#email", form).val()) + "\">" + escapeHtml($("#email", form).val()) + "</a></td>" +
				"<td>" + pnStr + "</td>" +
				"<td class=\"city\">" + escapeHtml($("#city", form).val()) + "</td>" +
				"</tr>"
			);
			
			$("input", form).val(''); // reset form fields
			$("#token", form).val(res.token); // set new CSRF token
		},
		error: function (res, status, error) {
			const msg = $("#message");
			
			const jsonRes = res.responseJSON
			$("#token", form).val(jsonRes.token); // set new CSRF token
			
			msg.html(); // reset notice content
			let errs = ""
			jsonRes.errors.forEach(error => {
				errs += "<li>" + error + "</li>";
			})
			
			const alert = $("<div class='alert alert-danger' role='alert'>").innerHTML("<ul>" + errs + "</ul>");
			msg.append(alert);
		}
	});
}

$("#create-new-user").submit(createUser);

// Filter table by City
function filterByCity(e) {
	const input = e.target;
	const rows = document.querySelectorAll('#users tbody tr');
	
	const filterValue = input.value.toLowerCase()
	
	// reset no results
	const noResults = document.querySelector('#no-results');
	if (noResults) {
		noResults.remove();
	}
	
	// Loop through each row of the table
	let areThereVisibleRows = false;
	rows.forEach(row => {
		let cell = row.querySelector('td.city');
		if (cell == null) {
			return;
		}
		
		let city = cell.textContent.toLowerCase()
		
		if (city.startsWith(filterValue)) {
			row.style.display = '';
			areThereVisibleRows = true;
		} else {
			row.style.display = 'none';
		}
	});
	
	if (!areThereVisibleRows) {
		const noResults = document.createElement('tr');
		noResults.setAttribute('id', 'no-results');
		noResults.innerHTML = '<td colspan="4" class="text-center">No results found for query "' + escapeHtml(filterValue) + '".</td>';
		document.querySelector('#users tbody').appendChild(noResults);
	}
}

const input = document.querySelector('#city-filter');
input.addEventListener("input", filterByCity);
