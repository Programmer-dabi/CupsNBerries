<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Kapétolyo Coffee &amp; Bakehouse</title>
    <link href="../style/style.css" rel="stylesheet" />
  </head>
  <body>
    <?php include('../components/header.php') ?>
    <section class="page-shell" id="checkout">
      <a class="back-link" href="cart.php"> ← Back to cart </a>
      <div class="page-title compact left">
        <span class="kicker"> ALMOST THERE </span>
        <h1>Pickup details</h1>
        <p>Tell us when to have your order ready.</p>
      </div>
      <div class="checkout-layout">
        <form class="checkout-form">
          <section>
            <div class="form-number">1</div>
            <div class="form-content">
              <h2>Contact information</h2>
              <div class="field-grid">
                <label>
                  Full name
                  <input required="" value="Sofia Reyes" />
                </label>
                <label>
                  Contact number
                  <input required="" value="0917 555 0184" />
                </label>
                <label class="full">
                  Email address
                  <input type="email" value="sofia.reyes@email.com" />
                </label>
              </div>
            </div>
          </section>
          <section>
            <div class="form-number">2</div>
            <div class="form-content">
              <h2>Pickup schedule</h2>
              <div class="pickup-choice">
                ▣
                <span>
                  <b> Store pickup </b>
                  <small> 18 Mabini Street, Quezon City </small>
                </span>
                ✓
              </div>
              <div class="field-grid">
                <label>
                  Pickup date
                  <input type="datetime-local" value="2026-08-18T10:30" />
                </label>
              </div>
            </div>
          </section>
          <section>
            <div class="form-number">3</div>
            <div class="form-content">
              <h2>Payment &amp; notes</h2>
              <div class="payment-choice">
                <b> ₱ </b>
                <span>
                  <b> Cash / Pay at counter </b>
                  <small>
                    Please prepare the exact amount when possible.
                  </small>
                </span>
                ✓
              </div>
              <label class="notes">
                Order notes
                <textarea
                  placeholder="Any pickup instructions or special requests?"
                ></textarea>
              </label>
            </div>
          </section>
          <a
            class="primary place-order"
            href="order-success.php"
            style="text-align: center"
          >
            Place order · ₱240 →
          </a>
        </form>
        <aside class="summary-card checkout-summary">
          <h2>Your order</h2>
          <div class="summary-item">
            <img
              src="https://images.unsplash.com/photo-1749104028391-c1362c3b92d6?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
            />
            <span>
              <b> 1× Spanish Latte </b>
              <small> Medium · Regular milk </small>
            </span>
            <strong> ₱145 </strong>
          </div>
          <div class="summary-item">
            <img
              src="https://images.unsplash.com/photo-1587982708730-ffc82d18e9fc?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
            />
            <span>
              <b> 1× Butter Croissant </b>
              <small> Regular </small>
            </span>
            <strong> ₱95 </strong>
          </div>
          <hr />
          <div>
            <span> Subtotal </span>
            <b> ₱240 </b>
          </div>
          <div>
            <span> Pickup fee </span>
            <b class="green"> Free </b>
          </div>
          <div class="total">
            <span> Total </span>
            <b> ₱240 </b>
          </div>
        </aside>
      </div>
    </section>
       <?php include('../components/footer.php') ?>
    <script type="module" src="../js/main.js"></script>
  </body>
</html>
