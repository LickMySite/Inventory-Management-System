<div class="row">
  <div class="col-lg">
    <section class="card form-wizard" id="w2">
      <div class="tabs">
        <ul class="nav nav-tabs nav-justify wizard-steps wizard-steps-style-2">
          <li class="nav-item active">
            <a href="#w2-account" data-bs-toggle="tab" class="nav-link text-center">
              <span class="badge badge-primary">1</span>
              Account
            </a>
          </li>
          <li class="nav-item">
            <a href="#w2-profile" data-bs-toggle="tab" class="nav-link text-center">
              <span class="badge badge-primary">2</span>
              Profile
            </a>
          </li>
          <li class="nav-item">
            <a href="#w2-confirm" data-bs-toggle="tab" class="nav-link text-center">
              <span class="badge badge-primary">3</span>
              Confirm
            </a>
          </li>
        </ul>
        <form class="form-horizontal" method="POST">

          <div class="tab-content">
            <div id="w2-account" class="tab-pane p-3 active">

              <div class="form-group row pb-3">
                <label class="col-sm-3 control-label text-sm-end pt-2">Choose User Role <span class="required">*</span></label>
                <div class="col-sm-9">
                  <div class="radio-custom radio-primary">
                    <input id="awesome" name="user_role" type="radio" value="1" required />
                    <label for="awesome">Manager</label>
                  </div>
                  <div class="radio-custom radio-primary">
                    <input id="very-awesome" name="user_role" type="radio" value="2" />
                    <label for="very-awesome">Employee</label>
                  </div>
                  <div class="radio-custom radio-primary">
                    <input id="ultra-awesome" name="user_role" type="radio" value="3" />
                    <label for="ultra-awesome">ADMIN</label>
                  </div>
                  <label class="error" for="user_role"></label>
                </div>
              </div>


              <div class="form-group row mb-3">
                <label class="col-lg-3 control-label text-lg-end pt-2">Company</label>
                <div class="col-lg-6">
                  <select name="company" data-plugin-selectTwo class="form-control populate" title="Please select at least one company" required>
                    <optgroup label="All companies">
                      <option value="">-Choose a Company-</option>
                        <?php foreach($company_list as $key => $value):?>
                          <option value="<?=$key;?>"><?=$value;?></option>";
                        <?php endforeach;?>
                    </optgroup>
                  </select>
                </div>
              </div>

            </div>
            <div id="w2-profile" class="tab-pane p-3">
              <div class="form-group mb-3">
                <label>Name</label>
                <input name="name" type="text" value="<?= isset($data['POST']['name']) ? show_input($data['POST']['name']) : '';?>" class="form-control form-control-lg" required/>
              </div>

              <div class="form-group mb-3">
                <label>User Name</label>
                  <input name="username" type="text" value="<?= isset($data['POST']['username']) ? show_input($data['POST']['username']) : '';?>" class="form-control form-control-lg" required/>
              </div>

              <div class="form-group mb-3">
                <label>E-mail Address</label>
                <input name="email" type="text" value="<?= isset($data['POST']['email']) ? show_input($data['POST']['email']) : '';?>" class="form-control form-control-lg" required/>
              </div>
            </div>
            <div id="w2-confirm" class="tab-pane p-3">
              <div class="form-group mb-3">
                <label>Password</label>
                <input name="password" type="text" value="" class="form-control form-control-lg" required/>
              </div>
              <div class="col-sm-4 text-right">
                <button type="submit" onclick="this.disabled=true;this.form.submit();" class="btn btn-success mt-2">Create User</button>
              </div>
            </div>
          </div>
          <input type="hidden" value="<?= $company_info->id;?>" name="company">
          <input type="hidden" value="<?= $_SESSION['token'] ?? '' ?>" name="token">
        </form>

      </div>
      <div class="card-footer">
        <ul class="pager">
          <li class="previous disabled">
            <a><i class="fas fa-angle-left"></i> Previous</a>
          </li>
          <li class="next">
            <a>Next <i class="fas fa-angle-right"></i></a>
          </li>
        </ul>
      </div>
    </section>
  </div>
</div>