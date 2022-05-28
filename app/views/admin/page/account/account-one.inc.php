<?php if($master === true):?>
  <a class="btn btn-primary btn-md font-weight-semibold btn-py-2 px-4 m-4" href="<?=ADMIN;?>account/">View All Accounts</a>
<?php endif;?>

<div class="row">
  <div class="col">
    <section class="card card-modern card-big-info">
      <div class="card-body">
        <div class="tabs-modern row" style="min-height: 490px;">
          <div class="col-lg-2-5 col-xl-1-5">
            <div class="nav flex-column" id="tab" role="tablist" aria-orientation="vertical">
                <a class="nav-link active" id="general-tab" data-bs-toggle="pill" data-bs-target="#general" href="#general" role="tab" aria-controls="general" aria-selected="true"><i class="bx bx-cog me-2"></i> General</a>
                <a class="nav-link" id="users-tab" data-bs-toggle="pill" data-bs-target="#users" href="#users" role="tab" aria-controls="users" aria-selected="true"><i class="bx bx-cog me-2"></i> Users</a>
                <a class="nav-link" id="usage-restriction-tab" data-bs-toggle="pill" data-bs-target="#usage-restriction" href="#usage-restriction" role="tab" aria-controls="usage-restriction" aria-selected="false"><i class="bx bx-block me-2"></i> Usage Restriction</a>
                <a class="nav-link" id="usage-limits-tab" data-bs-toggle="pill" data-bs-target="#usage-limits" href="#usage-limits" role="tab" aria-controls="usage-limits" aria-selected="false"><i class="bx bx-timer me-2"></i> Usage Limits</a>
            </div>
          </div>
          <div class="col-lg-3-5 col-xl-4-5">
            <div class="tab-content" id="tabContent">
              <div class="tab-pane fade show active" id="general" role="tabpanel" aria-labelledby="general-tab">
                <form id="editClient" method="post" class="needs-validation">
                  <input type="hidden" name="id" value="<?=isset($company_info) ? $company_info->id : $user_info->client_id;?>">
                  <div class="form-group row align-items-center pb-3">
                    <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Company Short Name</label>
                    <div class="col-lg-7 col-xl-6">
                      <input type="text" class="form-control form-control-modern" name="companyName" value="<?=isset($company_info) ? $company_info->client_name : $user_info->client_name;?>" required />
                    </div>
                  </div>
                  <div class="form-group row align-items-center pb-3">
                    <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Company Full Name</label>
                    <div class="col-lg-7 col-xl-6">
                      <input type="text" class="form-control form-control-modern" name="companyFullName" value="<?=isset($company_info) ? $company_info->fullname : $user_info->fullname;?>" required />
                    </div>
                  </div>
                  <div class="form-group row">
                    <label class="col-lg-5 col-xl-3 control-label text-lg-end pt-2 mt-1 mb-0">Description</label>
                    <div class="col-lg-7 col-xl-6">
                      <textarea class="form-control form-control-modern" name="Description" rows="6"></textarea>
                    </div>
                  </div>
                  <div class="form-group row">
                      <div class="col-md-12 text-end">
                        <button class="btn btn-primary" type="submit" onclick="this.disabled=true;this.form.submit();">Submit</button>
                        <button class="btn btn-default modal-dismiss">Cancel</button>
                      </div>
                    </div>
                </form>
              </div>
              <div class="tab-pane fade show" id="users" role="tabpanel" aria-labelledby="users-tab">
                <div class="form-group row align-items-center pb-3">
                  <a class="btn btn-default w-25 m-2" href="<?=ROOT.ADMIN;?>/users/create/<?=$company_info->client_name;?>"> Create User</a>

                  <table class="table table-responsive-lg table-bordered table-striped table-sm mb-0">
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
                      <?php if(!empty($company_users)):?>
                        <?php foreach($company_users as $value):?>
                          <tr>
                            <td><?=$value->name;?></td>
                            <td><?=$value->email;?></td>
                            <td><?=$value->username;?></td>
                            <td><?=$value->user_role;?></td>
                            <td class="actions">
                              <a href="<?=ROOT.ADMIN.'/users/profile/'.$value->name;?>"><i class="fas fa-pencil-alt"></i></a>
                            </td>
                          </tr>
                        <?php endforeach;?>
                      <?php endif;?>
                    </tbody>
                  </table>
                </div>
              </div>

              <div class="tab-pane fade" id="usage-restriction" role="tabpanel" aria-labelledby="usage-restriction-tab">
                <div class="form-group row align-items-center pb-3">
                  <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Minimum Spend</label>
                  <div class="col-lg-7 col-xl-6">
                    <input type="text" class="form-control form-control-modern" name="couponMinimumSpend" value="" placeholder="No minimum" />
                  </div>
                </div>
                <div class="form-group row align-items-center pb-3">
                  <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Maximum Spend</label>
                  <div class="col-lg-7 col-xl-6">
                    <input type="text" class="form-control form-control-modern" name="couponMaximumSpend" value="" placeholder="No maximum" />
                  </div>
                </div>
                <div class="form-group row align-items-center pb-3">
                  <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Individual Use Only?</label>
                  <div class="col-lg-7 col-xl-6">
                    <div class="checkbox">
                      <label class="my-2">
                        <input type="checkbox" value="">
                        Check this box if the coupon cannot be used in conjunction with other coupons.
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center pb-3">
                  <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Exclude Sale Items?</label>
                  <div class="col-lg-7 col-xl-6">
                    <div class="checkbox">
                      <label class="my-2">
                        <input type="checkbox" value="">
                        Check this box if the coupon should not apply to items on sale. Per-item coupons will only work if the item is not on sale. Per-cart coupons will only work if there are items in the cart that are not on sale.
                      </label>
                    </div>
                  </div>
                </div>
                <div class="form-group row align-items-center pb-3">
                  <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Products</label>
                  <div class="col-lg-7 col-xl-6">
                    <select multiple data-plugin-selectTwo class="form-control form-control-modern" name="couponProducts" data-plugin-options='{ "placeholder": "Search for a product..." }'>
                      <option value=""></option>
                      <option value="product1">Porto Bag</option>
                      <option value="product2">Porto Shoes</option>
                      <option value="product3">Porto Jacket</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row align-items-center pb-3">
                  <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Exclude Products</label>
                  <div class="col-lg-7 col-xl-6">
                    <select multiple data-plugin-selectTwo class="form-control form-control-modern" name="couponExcludeProducts" data-plugin-options='{ "placeholder": "Search for a product..." }'>
                      <option value=""></option>
                      <option value="product1">Porto Bag</option>
                      <option value="product2">Porto Shoes</option>
                      <option value="product3">Porto Jacket</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row align-items-center pb-3">
                  <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Product Categories</label>
                  <div class="col-lg-7 col-xl-6">
                    <select multiple data-plugin-selectTwo class="form-control form-control-modern" name="couponProductCategories" data-plugin-options='{ "placeholder": "Search for a product category..." }'>
                      <option value="any">Any Category</option>
                      <option value="product1">Bags</option>
                      <option value="product2">Shoes</option>
                      <option value="product3">Jackets</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row align-items-center pb-3">
                  <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Exclude Categories</label>
                  <div class="col-lg-7 col-xl-6">
                    <select multiple data-plugin-selectTwo class="form-control form-control-modern" name="couponExcludeCategories" data-plugin-options='{ "placeholder": "Search for a product category..." }'>
                      <option value="none">None</option>
                      <option value="product1">Bags</option>
                      <option value="product2">Shoes</option>
                      <option value="product3">Jackets</option>
                    </select>
                  </div>
                </div>
                <div class="form-group row align-items-center pb-3">
                  <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Allowed E-mails</label>
                  <div class="col-lg-7 col-xl-6">
                    <input type="text" class="form-control form-control-modern" name="couponAllowedEmails" value="" />
                  </div>
                </div>
              </div>
              
              <div class="tab-pane fade" id="usage-limits" role="tabpanel" aria-labelledby="usage-limits-tab">
                <div class="form-group row align-items-center pb-3">
                  <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Usage Limit Per Coupon</label>
                  <div class="col-lg-7 col-xl-6">
                    <input type="text" class="form-control form-control-modern" name="couponUsageLimitPerCoupon" value="" placeholder="Unlimited Usage" />
                  </div>
                </div>
                <div class="form-group row align-items-center pb-3">
                  <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Limit Usage to X Items</label>
                  <div class="col-lg-7 col-xl-6">
                    <input type="text" class="form-control form-control-modern" name="couponLimitUsageXItems" value="" placeholder="Apply to all qualifying items in cart" />
                  </div>
                </div>
                <div class="form-group row align-items-center pb-3">
                  <label class="col-lg-5 col-xl-3 control-label text-lg-end mb-0">Usage Limit Per User</label>
                  <div class="col-lg-7 col-xl-6">
                    <input type="text" class="form-control form-control-modern" name="couponUsageLimitPerUser" value="" placeholder="Unlimited Usage" />
                  </div>
                </div>
              </div>
            </div>
          </div>
        </div>
      </div>
    </section>
  </div>
</div>
