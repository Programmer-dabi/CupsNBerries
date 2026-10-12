<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Kapétolyo Coffee &amp; Bakehouse</title>
    <link href="../style/style.css" rel="stylesheet" />
  </head>
  <body>
    <?php include('../components/header.php');?>
    <section class="success-page" id="success">
      <div class="success-check">✓</div>
      <span class="kicker"> ORDER CONFIRMED </span>
      <h1>We’ve got your order!</h1>
      <p>
        Thanks, Sofia. We’ll start preparing it soon and let you know when it’s
        ready for pickup.
      </p>
      <div class="order-number">
        <small> ORDER NUMBER </small>
        <b> #KP-240818 </b>
      </div>
      <div class="success-card">
        <div class="success-meta">
          <div>
            <small> PICKUP TIME </small>
            <b> Today, 10:30 AM </b>
          </div>
          <div>
            <small> PAYMENT </small>
            <b> Cash at counter </b>
          </div>
          <div>
            <small> STATUS </small>
            <span class="status preparing"> Confirmed </span>
          </div>
        </div>
        <hr />
        <div class="success-item">
          <span> 1× </span>
          <img
            src="https://images.unsplash.com/photo-1749104028391-c1362c3b92d6?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
          />
          <div>
            <b> Spanish Latte </b>
            <small> Medium · Regular milk </small>
          </div>
          <strong> ₱145 </strong>
        </div>
        <div class="success-item">
          <span> 1× </span>
          <img
            src="https://images.unsplash.com/photo-1587982708730-ffc82d18e9fc?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
          />
          <div>
            <b> Butter Croissant </b>
            <small> Regular </small>
          </div>
          <strong> ₱95 </strong>
        </div>
        <hr />
        <div class="success-total">
          <span> Total amount </span>
          <b> ₱240 </b>
        </div>
      </div>
      <div class="success-actions">
        <a class="primary" href="tracking.php"> Track order </a>
        <a class="outline" href="home.php"> Back to home </a>
      </div>
      <small class="confirmation-note">
        A confirmation has been sent to sofia.reyes@email.com
      </small>
    </section>
        <?php include('../components/footer.php') ?>
    <script type="module" src="../js/main.js"></script>
  </body>
</html>
