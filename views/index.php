<h1>Manage your users like a Pro!</h1>

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
    <th class="col-md-3">Name</th>
    <th class="col-md-3">E-mail</th>
    <th class="col-md-3">Phone Number</th>
    <th class="col-md-3">City</th>
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
      <td><a href="mailto:<?= escape($user->getEmail()) ?>"><?= escape($user->getEmail()) ?></a></td>
      <td><?php if (empty($user->getPhoneNumber())) { ?>
          <i>No phone number :(</i>
          <?php } else { ?>
              <?= escape($user->getPhoneNumber()) ?>
          <?php } ?>
      </td>
      <td class="city"><?= escape($user->getCity()) ?></td>
    </tr>
  <?php } ?>
  </tbody>
  <tfoot>
  <tr class="add-new-user-row">
    <td colspan="4">
      <div id="message"></div>
      <form id="create-new-user" method="post" action="create.php" class="form-inline">
        <input type="hidden" name="token" id="token" value="<?= escape($token) ?>"/>
        <div class="row">
          <div class="col-md-3">
            <label class="sr-only" for="name">Name</label>
            <input name="name" type="text" class="form-control" id="name" placeholder="John Doe" required
                   maxlength="255">
          </div>

          <div class="col-md-3">
            <label class="sr-only" for="email">E-mail</label>
            <input name="email" class="form-control" type="email" id="email" placeholder="your@email.com" required
                   maxlength="255">
          </div>

          <div class="col-md-3">
            <label class="sr-only" for="phone-number">Phone</label>
            <input name="phone-number" class="form-control" input="tel" id="phone-number" placeholder="+420123456789"
                   maxlength="50"/>
          </div>

          <div class="col-md-3">
            <label class="sr-only" for="city">City</label>
            <input name="city" class="form-control" input="text" id="city" placeholder="Břeclav" required
                   maxlength="255"/>
          </div>
        </div>

        <div class="row button-row">
          <div class="col-md-12 text-center">
            <button type="submit" class="btn btn-primary">Create new user</button>
          </div>
        </div>
      </form>
    </td>
  </tr>
  </tfoot>
</table>
