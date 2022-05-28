<table class="table table-bordered table-striped mb-0" id="datatable-default">
  <thead>
    <tr>
      <th>Name</th>
      <th>Email</th>
      <th>Username</th>
      <th>Role</th>
      <th>Actions</th>
    </tr>
  </thead>
  <tbody>
    <?php if(isset($table)):?>
      <?php foreach($table as $data):?>
        <tr data-item-id="<?=$data->id;?>">
          <td><?=$data->name;?></td>
          <td><?=$data->email;?></td>
          <td><?=$data->username;?></td>
          <td><?=$data->user_role;?></td>
          <td data-title="User" class="actions">
            <a class="modal-with-form" href="#editUser_<?=$data->id;?>"><i class="fas fa-pencil-alt"></i></a>
          </td>
        </tr>

        <!-- Edit User Form -->
        <div id="editUser_<?=$data->id;?>" class="modal-block modal-block-primary mfp-hide">
          <section class="card">
            <header class="card-header">
              <h2 class="card-title">Edit: <?=$data->name;?></h2>
              <a class="modal-with-form btn btn-rounded btn-danger float-end" href="#deleteUser_<?=$data->id;?>">
                <i class="fas fa-trash"></i>DELETE
              </a>
            </header>
            <form id="editUser" method="post" class="needs-validation">
              <input type="hidden" name="type" value="editUser">
              <input type="hidden" name="user_id" value="<?=$data->id;?>">
              <div class="card-body">
                <div class="form-group">
                  <label for="user">Name</label>
                  <input type="text" class="form-control" name="user" id="user" maxlength="40" placeholder="<?=$data->name;?>" value="<?=$data->name;?>">
                </div>
              </div>
              <footer class="card-footer">
                <div class="row">
                  <div class="col-md-12 text-end">
                    <button class="btn btn-primary" type="submit" onclick="this.disabled=true;this.form.submit();">Submit</button>
                    <button class="btn btn-default modal-dismiss">Cancel</button>
                  </div>
                </div>
              </footer>
            </form>

          </section>
        </div>

        <!-- Delete User Form -->
        <div id="deleteUser_<?=$data->id;?>" class="modal-block modal-block-primary mfp-hide">
          <form id="deleteUser" method="post" class="needs-validation">
            <input type="hidden" name="type" value="deleteUser">
            <input type="hidden" name="user_id" value="<?=$data->id;?>">

            <section class="card">
              <header class="card-header">
                <h2 class="card-title">Delete: <?=$data->name;?></h2>
                <a class="modal-with-form btn btn-rounded btn-info float-end" href="#editUser_<?=$data->id;?>">
                  <i class="fas fa-edit"></i>Go Back to Edit
                </a>
              </header>
              <div class="card-body">
              <h2 class="card-title">Are you sure you want to delete <?=$data->name;?> ?</h2>
              <p>This action cant be undone!</p>
              </div>
              <footer class="card-footer">
                <div class="row">
                  <div class="col-md-12 text-end">
                    <button class="btn btn-danger" type="submit" onclick="this.disabled=true;this.form.submit();">Confirm</button>
                    <button class="btn btn-default modal-dismiss">Cancel</button>
                  </div>
                </div>
              </footer>
            </section>
          </form>
        </div>

      <?php endforeach;?>
    <?php endif;?>
  </tbody>
</table>
<a class="btn btn-dark btn-md font-weight-semibold btn-py-2 px-4 mb-4" href="<?=ROOT.ADMIN.'/'.$page;?>/create">Create User</a>
