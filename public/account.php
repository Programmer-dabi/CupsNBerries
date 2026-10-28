<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Cups &amp; Berries</title>
    <link href="./style/style.css" rel="stylesheet" />
  </head>
  <body>
    <?php include('../components/header.php');?>
    <section class="page-shell" id="account">
      <div class="account-head">
        <div class="big-avatar">SR</div>
        <div>
          <span class="kicker"> MY ACCOUNT </span>
          <h1>Sofia Reyes</h1>
          <p>sofia.reyes@email.com · 0917 555 0184</p>
        </div>
        <button class="outline">Edit profile</button>
      </div>
      <div class="account-tabs">
        <button class="active">Orders</button>
        <button>Wishlist</button>
        <button>Profile &amp; Security</button>
      </div>
      <div class="panel">
        <div class="panel-title">
          <h2>Order history</h2>
          <span> 6 orders </span>
        </div>
        <div class="table-row">
          <span> #KP-240818 </span>
          <span> Aug 18, 2026 </span>
          <span> 2 items </span>
          <span> ₱290 </span>
          <span class="status preparing"> Preparing </span>
          <a href="tracking.php"> View details </a>
        </div>
        <div class="table-row">
          <span> #KP-240731 </span>
          <span> Jul 31, 2026 </span>
          <span> 3 items </span>
          <span> ₱435 </span>
          <span class="status completed"> Completed </span>
          <a href="tracking.php"> View details </a>
        </div>
        <div class="table-row">
          <span> #KP-240712 </span>
          <span> Jul 12, 2026 </span>
          <span> 1 item </span>
          <span> ₱160 </span>
          <span class="status completed"> Completed </span>
          <a href="tracking.php"> View details </a>
        </div>
      </div>
    </section>
    <?php include('../components/footer.php') ?>
    <script type="module" src="../js/main.js"></script>
  </body>
</html>
