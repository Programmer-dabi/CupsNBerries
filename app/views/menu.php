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

    <section class="page-shell" id="menu">
      <div class="page-title">
        <span class="kicker"> HANDCRAFTED FOR YOU </span>
        <h1>Explore our menu</h1>
        <p>
          From bold espresso classics to fresh bakes, there is something for
          every kind of day.
        </p>
      </div>
      <div class="menu-tools">
        <label class="search">
          ⌕
          <input placeholder="Search drinks or treats..." />
        </label>
        <select>
          <option>Popular</option>
          <option>Price: Low</option>
          <option>Rating</option>
        </select>
      </div>
      <div class="filter-tabs">
        <button class="active">All</button>
        <button>Coffee</button>
        <button>Non-Coffee</button>
        <button>Tea</button>
        <button>Pastries</button>
        <button>Desserts</button>
      </div>
      <div class="results-row">
        <span> Showing 8 items </span>
        <button>
          Filters
          <span class="filter-dot"> 2 </span>
        </button>
      </div>
      <div class="product-grid">
        <!-- All eight products -->
        <article class="product-card">
          <a class="product-photo" href="product.php">
            <img
              alt="Spanish Latte"
              src="https://images.unsplash.com/photo-1749104028391-c1362c3b92d6?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
            />
            <span class="photo-badge"> Bestseller </span>
          </a>
          <div class="product-info">
            <div class="eyebrow-row">
              <span> Coffee </span>
              <!-- <span class="rating"> ★ 4.9 </span> -->
            </div>
            <h3>Spanish Latte</h3>
            <p>Velvety espresso, fresh milk, and our signature sweet cream.</p>
            <div class="product-bottom">
              <strong> ₱145 </strong>
              <a class="add-circle" href="cart.php"> + </a>
            </div>
          </div>
        </article>
        <article class="product-card">
          <a class="product-photo" href="product.php">
            <img
              alt="Caramel Macchiato"
              src="https://images.unsplash.com/photo-1753727470826-584b80850a3c?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
            />
            <span class="photo-badge"> Popular </span>
          </a>
          <div class="product-info">
            <div class="eyebrow-row">
              <span> Coffee </span>
              <!-- <span class="rating"> ★ 4.8 </span> -->
            </div>
            <h3>Caramel Macchiato</h3>
            <p>Espresso and steamed milk finished with caramel drizzle.</p>
            <div class="product-bottom">
              <strong> ₱155 </strong>
              <a class="add-circle" href="cart.php"> + </a>
            </div>
          </div>
        </article>
        <article class="product-card">
          <a class="product-photo" href="product.php">
            <img
              alt="Classic Americano"
              src="https://images.unsplash.com/photo-1587982704600-e5f79d652fe5?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
            />
          </a>
          <div class="product-info">
            <div class="eyebrow-row">
              <span> Coffee </span>
              <!-- <span class="rating"> ★ 4.7 </span> -->
            </div>
            <h3>Classic Americano</h3>
            <p>Double-shot espresso mellowed with hot filtered water.</p>
            <div class="product-bottom">
              <strong> ₱110 </strong>
              <a class="add-circle" href="cart.php"> + </a>
            </div>
          </div>
        </article>
        <article class="product-card">
          <a class="product-photo" href="product.php">
            <img
              alt="Matcha Cloud"
              src="https://images.unsplash.com/photo-1551539441-309773d8580b?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
            />
            <span class="photo-badge"> New </span>
          </a>
          <div class="product-info">
            <div class="eyebrow-row">
              <span> Tea </span>
              <!-- <span class="rating"> ★ 4.9 </span> -->
            </div>
            <h3>Matcha Cloud</h3>
            <p>Ceremonial matcha layered with silky milk and cream foam.</p>
            <div class="product-bottom">
              <strong> ₱160 </strong>
              <a class="add-circle" href="cart.php"> + </a>
            </div>
          </div>
        </article>
        <article class="product-card">
          <a class="product-photo" href="product.php">
            <img
              alt="Chocolate Frappe"
              src="https://images.unsplash.com/photo-1504194472231-5a5294eddc43?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
            />
          </a>
          <div class="product-info">
            <div class="eyebrow-row">
              <span> Non-Coffee </span>
              <!-- <span class="rating"> ★ 4.6 </span> -->
            </div>
            <h3>Chocolate Frappe</h3>
            <p>Rich chocolate blended with milk, ice, and whipped cream.</p>
            <div class="product-bottom">
              <strong> ₱175 </strong>
              <a class="add-circle" href="cart.php"> + </a>
            </div>
          </div>
        </article>
        <article class="product-card">
          <a class="product-photo" href="product.php">
            <img
              alt="Butter Croissant"
              src="https://images.unsplash.com/photo-1587982708730-ffc82d18e9fc?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
            />
          </a>
          <div class="product-info">
            <div class="eyebrow-row">
              <span> Pastries </span>
              <!-- <span class="rating"> ★ 4.8 </span> -->
            </div>
            <h3>Butter Croissant</h3>
            <p>Flaky, golden layers baked fresh every morning.</p>
            <div class="product-bottom">
              <strong> ₱95 </strong>
              <a class="add-circle" href="cart.php"> + </a>
            </div>
          </div>
        </article>
        <article class="product-card">
          <a class="product-photo" href="product.php">
            <img
              alt="Blueberry Cheesecake"
              src="https://images.unsplash.com/photo-1682052253414-ddbd9f2da806?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
            />
            <span class="photo-badge"> Bestseller </span>
          </a>
          <div class="product-info">
            <div class="eyebrow-row">
              <span> Desserts </span>
              <!-- <span class="rating"> ★ 4.9 </span> -->
            </div>
            <h3>Blueberry Cheesecake</h3>
            <p>Creamy cheesecake with a bright blueberry compote.</p>
            <div class="product-bottom">
              <strong> ₱185 </strong>
              <a class="add-circle" href="cart.php"> + </a>
            </div>
          </div>
        </article>
        <article class="product-card">
          <a class="product-photo" href="product.php">
            <img
              alt="Sea Salt Cocoa"
              src="https://images.unsplash.com/photo-1651241268906-38bde7268415?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
            />
          </a>
          <div class="product-info">
            <div class="eyebrow-row">
              <span> Non-Coffee </span>
              <!-- <span class="rating"> ★ 4.7 </span> -->
            </div>
            <h3>Sea Salt Cocoa</h3>
            <p>Dark cocoa with sea-salt cream and toasted cacao.</p>
            <div class="product-bottom">
              <strong> ₱150 </strong>
              <span class="status pending"> Out of stock </span>
            </div>
          </div>
        </article>
      </div>
    </section>
    <?php include('../components/footer.php') ?>
    <script type="module" src="../js/main.js"></script>
   
  </body>
</html>
