<h1>PHP Test Application</h1>

<?php if (sizeof($errors) > 0 ){?>
  <div class="errors">
    <h2>Errors</h2>
    <p>Please fix the following errors:</p>
    <ul>
      <?php foreach ($errors as $error) {?>
        <li><?=escape($error)?></li>
      <?php }?>
    </ul>
<?php }?>

<table>
	<thead>
		<tr>
			<th>Name</th>
      <th>E-mail</th>
      <th>Phone Number</th>
			<th>City</th>
		</tr>
	</thead>
	<tbody>
		<?php foreach($users as $user){?>
		<tr>
			<td><?=escape($user->getName())?></td>
      <td><?=escape($user->getEmail())?></td>
      <td><?=escape($user->getPhoneNumber())?></td>
			<td><?=escape($user->getCity())?></td>
		</tr>
		<?php }?>
	</tbody>
</table>				

<form method="post" action="create.php">
	<input type="hidden" name="token" value="<?=escape($_SESSION['token'])?>"/>

	<label for="name">Name:</label>
	<input name="name" type="text" id="name"/>

  <label for="email">E-mail:</label>
  <input name="email" type="email" id="email"/>

  <label for="phone-number">Phone number:</label>
  <input name="phone-number" type="text" id="phone-number"/>
	
	<label for="city">City:</label>
	<input name="city" type="text" id="city"/>
	
	<button>Create new row</button>
</form>
