<?=show($POST);?>
<section class="card">
  <div class="card-body">
    <div class="invoice">
      <header class="clearfix">
        <div class="row">
          <div class="col-sm-6 mt-3">
            <h2 class="h2 mt-0 mb-1 text-dark font-weight-bold">Purchase Order</h2>
            <h4 class="h4 m-0 text-dark font-weight-bold"><?=isset($POST['po']) ? show_input($POST['po']) : '';?></h4>
          </div>
          <div class="col-sm-6 text-end mt-3 mb-3">
            <address class="ib me-5">
              <?=Settings::website_title();?>
              <br/>
              <?=Settings::address();?>
              <br/>
              <?=Settings::phone();?>
              <br/>
              <?=Settings::email();?>
            </address>
            <div class="ib">
              <img src="<?=ROOT?>uploads/logo.png" width="60" height="60" alt="MW" />
            </div>
          </div>
        </div>
      </header>
      <div class="bill-info">
        <div class="row">
          <div class="col-md-6">
            <div class="bill-to">
              <p class="h5 mb-1 text-dark font-weight-semibold">To:</p>
              <address>
                Envato
                <br/>
                121 King Street, Melbourne, Australia
                <br/>
                Phone: +61 3 8376 6284
                <br/>
                info@envato.com
              </address>
            </div>
          </div>
          <div class="col-md-6">
            <div class="bill-data text-end">
              <p class="mb-0">
                <span class="text-dark">Date&colon;</span>
                <span class="value"><?=isset($POST['date']) ? show_input($POST['date']) : '';?></span>
              </p>
              <p class="mb-0">
                <span class="text-dark">PO&num;</span>
                <span class="value"><?=isset($POST['po']) ? show_input($POST['po']) : '';?></span>
              </p>
              <p class="mb-0">
                <span class="text-dark">Container&num;</span>
                <span class="value"><?=isset($POST['container']) ? show_input($POST['container']) : '';?></span>
              </p>

            </div>
          </div>
        </div>
      </div>

      <table class="table table-responsive-md invoice-items">
        <thead>
          <tr class="text-dark">
            <th id="cell-id"     class="font-weight-semibold">&num;</th>
            <th id="cell-item"   class="font-weight-semibold">Item</th>
            <th id="cell-desc"   class="font-weight-semibold">Description</th>
            <th id="cell-price"  class="text-center font-weight-semibold">Price</th>
            <th id="cell-qty"    class="text-center font-weight-semibold">Quantity</th>
            <th id="cell-total"  class="text-center font-weight-semibold">Total</th>
          </tr>
        </thead>
        <tbody>

        <?php
          $cost = 5.25;
          $x = 0;
          foreach($POST['item_id'] as $value){
            if($POST['quantity'][$x] > 0 ){

              echo '
              <tr>
              <td>123456</td>
              <td class="font-weight-semibold text-dark">'.$POST['item_id'][$x].'</td>
              <td>'.$POST['item_id'][$x].'</td>
              <td class="text-center">$'.$cost.'</td>
              <td class="text-center">'.$POST['quantity'][$x].'</td>
              <td class="text-center">$'.$POST['quantity'][$x] * $cost.'</td>
            </tr>
               
              ';
            }
            $x++;
          }


        ?>
        </tbody>
      </table>

      <div class="invoice-summary">
        <div class="row justify-content-end">
          <div class="col-sm-4">
            <table class="table h6 text-dark">
              <tbody>
                <tr class="b-top-0">
                  <td colspan="2">Storage</td>
                  <td class="text-left">$<?=array_sum($POST['quantity']) * $cost;?></td>
                </tr>
                <tr>
                  <td colspan="2">Shipping</td>
                  <td class="text-left">$0.00</td>
                </tr>
                <tr class="h4">
                  <td colspan="2">Grand Total</td>
                  <td class="text-left">$73.00</td>
                </tr>
              </tbody>
            </table>
          </div>
        </div>
      </div>
    </div>
    <div class="d-grid gap-3 d-md-flex justify-content-md-end me-4">
      <a href="#" class="btn btn-default">Submit Invoice</a>
      <a href="invoiceprint" target="_blank" class="btn btn-primary ms-3"><i class="fas fa-print"></i> Print</a>
    </div>
  </div>
</section>
