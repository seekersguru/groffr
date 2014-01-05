<?php include_once('header.php'); ?>

<div class="row">
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <div class="caption">
        <h3>Buyer</h3>
        <p>Select as a Buyer</p>
        <p><a href="<?php echo WEBSITE_URL."myaccount.php?type=Buyer"; ?>" class="btn btn-primary" role="button">Select</a> </p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <div class="caption">
        <h3>Seller</h3>
        <p>Select as a Seller</p>
        <p><a href="<?php echo WEBSITE_URL."myaccount.php?type=Seller"; ?>" class="btn btn-primary" role="button">Select</a> </p>
      </div>
    </div>
  </div>
  <div class="col-sm-6 col-md-4">
    <div class="thumbnail">
      <div class="caption">
        <h3>Agent</h3>
        <p>Select as a Agent</p>
        <p><a href="<?php echo WEBSITE_URL."myaccount.php?type=Agent"; ?>" class="btn btn-primary" role="button">Select</a> </p>
      </div>
    </div>
  </div>
</div>




</body>
</html>