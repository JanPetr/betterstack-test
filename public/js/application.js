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
			
			$("#users tbody .add-new-user-row").before(
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
				$("#message").append(alert);
			})
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
		noResults.innerHTML = '<td colspan="4" class="text-center">No results found for query "' + filterValue + '".</td>';
		document.querySelector('#users tbody').appendChild(noResults);
	}
}

const input = document.querySelector('#city-filter');
input.addEventListener("input", filterByCity);
