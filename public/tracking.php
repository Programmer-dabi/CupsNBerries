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
    <section class="page-shell" id="tracking">
      <a class="back-link" href="home.php"> ← Back to home </a>
      <div class="tracking-card">
        <span class="kicker"> ORDER #KP-240818 </span>
        <h1>Your coffee is being made.</h1>
        <p>
          Estimated pickup:
          <b> 10:30 AM today </b>
        </p>
        <div class="progress-list">
          <div class="progress active">
            <span> ✓ </span>
            <div>
              <b> Order confirmed </b>
              <small> 10:06 AM </small>
            </div>
          </div>
          <div class="progress active">
            <span> ✓ </span>
            <div>
              <b> Preparing your order </b>
              <small> Our baristas are working their magic </small>
            </div>
          </div>
          <div class="progress">
            <span> 3 </span>
            <div>
              <b> Ready for pickup </b>
              <small> Up next </small>
            </div>
          </div>
          <div class="progress">
            <span> 4 </span>
            <div>
              <b> Completed </b>
            </div>
          </div>
        </div>
        <div class="pickup-box">
          ▣
          <div>
            <small> PICKUP LOCATION </small>
            <b> Cups &amp; Berries Arellano Dagupan </b>
          </div>
        </div>
      </div>
    </section>
        <?php include('../components/footer.php') ?>
    <script type="module" src="../js/main.js"></script>
  </body>
</html>
