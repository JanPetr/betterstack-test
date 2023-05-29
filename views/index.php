<h1>PHP Test Application</h1>

<?php if (sizeof($errors) > 0) { ?>
  <div class="errors">
    <h2>Errors</h2>
    <p>Please fix the following errors:</p>
    <ul>
        <?php foreach ($errors as $error) { ?>
          <li><?= escape($error) ?></li>
        <?php } ?>
    </ul>
  </div>
<?php } ?>

<h2>Users</h2>
<table class="table table-striped" id="users">
  <thead>
  <tr>
    <th>Name</th>
    <th>E-mail</th>
    <th>Phone Number</th>
    <th>
      City
    </th>
  </tr>
  <tr>
    <th></th>
    <th></th>
    <th></th>
    <th><input type="text" id="city-filter" class="form-control" placeholder="Filter by city"/></th>
  </tr>
  </thead>
  <tbody>
  <?php foreach ($users as $user) { ?>
    <tr>
      <td><?= escape($user->getName()) ?></td>
      <td><?= escape($user->getEmail()) ?></td>
      <td><?= escape($user->getPhoneNumber()) ?></td>
      <td class="city"><?= escape($user->getCity()) ?></td>
    </tr>
  <?php } ?>
  </tbody>
</table>

<div class="row">
  <div id="message"></div>

  <form id="create-new-user" method="post" action="create.php" class="form-inline">
    <input type="hidden" name="token" id="token" value="<?= escape($token) ?>"/>

    <div class="form-group col-md-2">
      <label class="sr-only" for="name">Name</label>
      <input name="name" type="text" class="form-control" id="name" placeholder="John Doe" required maxlength="255">
    </div>

    <div class="form-group col-md-3">
      <label class="sr-only" for="email">E-mail</label>
      <input name="email" class="form-control" input="email" id="email" placeholder="your@email.com" required
             maxlength="255">
    </div>

    <div class="form-group col-md-2">
      <label class="sr-only" for="city">City</label>
      <input name="city" class="form-control" input="text" id="city" placeholder="Břeclav" required maxlength="255"/>
    </div>

    <div class="form-group col-md-2">
      <label class="sr-only" for="phone-number">Phone</label>
      <input name="phone-number" class="form-control" input="tel" id="phone-number" placeholder="+420123456789" required
             maxlength="50"/>
    </div>

    <div class="col-md-2">
      <button type="submit" class="btn btn-primary">Create new user</button>
    </div>
  </form>
</div>
