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
    <section class="page-shell" id="cart">
      <div class="page-title compact">
        <span class="kicker"> YOUR ORDER </span>
        <h1>Shopping cart</h1>
        <p>2 items waiting for you</p>
      </div>
      <div class="cart-layout">
        <div class="cart-list">
          <article class="cart-item">
            <img
              alt="Spanish Latte"
              src="https://images.unsplash.com/photo-1749104028391-c1362c3b92d6?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
            />
            <div class="cart-item-info">
              <span> Coffee </span>
              <h3>Spanish Latte</h3>
              <p>Medium · Regular milk · Regular ice</p>
              <button>Remove</button>
            </div>
            <div class="cart-item-end">
              <strong> ₱145 </strong>
              <div class="quantity">
                <button>−</button>
                <b> 1 </b>
                <button>+</button>
              </div>
            </div>
          </article>
          <article class="cart-item">
            <img
              alt="Butter Croissant"
              src="https://images.unsplash.com/photo-1587982708730-ffc82d18e9fc?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
            />
            <div class="cart-item-info">
              <span> Pastries </span>
              <h3>Butter Croissant</h3>
              <p>Regular · Regular milk · Regular ice</p>
              <button>Remove</button>
            </div>
            <div class="cart-item-end">
              <strong> ₱95 </strong>
              <div class="quantity">
                <button>−</button>
                <b> 1 </b>
                <button>+</button>
              </div>
            </div>
          </article>
          <a class="back-link" href="menu.php"> ← Continue shopping </a>
        </div>
        <aside class="summary-card">
          <h2>Order summary</h2>
          <div>
            <span> Subtotal </span>
            <b> ₱240 </b>
          </div>
          <div>
            <span> Pickup fee </span>
            <b class="green"> Free </b>
          </div>
          <hr />
          <div class="total">
            <span> Total </span>
            <b> ₱240 </b>
          </div>
          <small> Taxes are included in listed prices. </small>
          <a
            class="primary"
            href="checkout.php"
            style="display: block; text-align: center; margin-top: 15px">
            Proceed to checkout →
          </a>
          <p class="safe-note">✓ Pay with cash at the counter</p>
        </aside>
      </div>
    </section>
       <?php include('../components/footer.php') ?>
    <script type="module" src="../js/main.js"></script>
  </body>
</html>
