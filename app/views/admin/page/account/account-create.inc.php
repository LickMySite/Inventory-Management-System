<a class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4 m-4" href="<?=ADMIN;?>account/">View All Accounts</a>

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
                <label class="col-lg-3 control-label text-lg-end pt-2" for="textareaDefault">URL Friendly Name<span class="required">*</span></label>
                <div class="col-lg-6">
                  <input class="form-control form-control-lg" name="company" type="text" value="<?=isset($data['POST']['company']) ? show_input($data['POST']['company']) : '';?>" data-plugin-maxlength maxlength="20" required/>
                  <p>
                    <code>max-length</code> set to 20.
                  </p>
                </div>
              </div>
              <div class="form-group row pb-3">
                <label class="col-lg-3 control-label text-lg-end pt-2" for="companyfull">Company Full Name<span class="required">*</span></label>
                <div class="col-lg-6">
                  <input class="form-control form-control-lg" name="companyfull" type="text" value="<?=isset($data['POST']['companyfull']) ? show_input($data['POST']['companyfull']) : '';?>" data-plugin-maxlength maxlength="40" required/>
                  <p>
                    <code>max-length</code> set to 40.
                  </p>
                </div>
              </div>

              <div class="form-group row mb-3">
                <label class="col-lg-3 control-label text-lg-end pt-3">E-mail Address</label>
                <div class="col-lg-6">
                  <input name="email" type="text" value="<?= isset($data['POST']['email']) ? show_input($data['POST']['email']) : '';?>" class="form-control form-control-lg" required/>
                </div>
              </div>
            </div>
            <div id="w2-profile" class="tab-pane p-3">

              <div class="form-group row pb-2">
                <label class="col-sm-3 control-label text-sm-end pt-2">Custom Fields</label>
                <div class="col-sm-9">

                  <div class="checkbox-custom chekbox-primary">
                    <input id="for-project" value="project" type="checkbox" name="for[]" required />
                    <label for="for-project">Hazmat</label>
                  </div>
                  <div class="checkbox-custom chekbox-primary">
                    <input id="for-website" value="website" type="checkbox" name="for[]" />
                    <label for="for-website">Item Code</label>
                  </div>
                  <div class="checkbox-custom chekbox-primary">
                    <input id="for-all" value="all" type="checkbox" name="for[]" />
                    <label for="for-all">Piece Count</label>
                  </div>
                  <div class="checkbox-custom chekbox-primary">
                    <input id="for-all" value="all" type="checkbox" name="for[]" />
                    <label for="for-all">PO Number</label>
                  </div>
                  <div class="checkbox-custom chekbox-primary">
                    <input id="for-all" value="all" type="checkbox" name="for[]" />
                    <label for="for-all">LOT Number</label>
                  </div>
                  
                </div>
              </div>

            </div>
            <div id="w2-confirm" class="tab-pane p-3">
              <div class="form-group row pb-3">
                <label class="col-lg-3 control-label text-lg-end pt-2" for="textareaDefault">Notes</label>
                <div class="col-lg-6">
                  <textarea class="form-control" rows="4" data-plugin-maxlength maxlength="140"></textarea>
                  <p>
                    <code>max-length</code> set to 140.
                  </p>
                </div>
              </div>
              <div class="col-lg text-lg-end">
                <button type="submit" onclick="this.disabled=true;this.form.submit();" class="btn btn-rounded btn-dark  mt-2">Create Client</button>
              </div>
            </div>
          </div>
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
