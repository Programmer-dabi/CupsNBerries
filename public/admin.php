<!doctype html>
<html lang="en">
  <head>
    <meta charset="utf-8" />
    <meta content="width=device-width, initial-scale=1" name="viewport" />
    <title>Cups &amp; Berries</title>
    <link href="./style/style.css" rel="stylesheet" />
  </head>
  <body>
    <section class="admin-app" id="admin">
      <aside class="admin-sidebar">
        <a class="logo logo-light" href="home.php">
          <span class="logo-mark"> K </span>
          <span>
            Cups &amp; Berries
            <small> COFFEE &amp; BAKEHOUSE </small>
          </span>
        </a>
        <nav>
          <a class="active" href="#admin">
            <span> Dashboard </span>
          </a>
          <a href="#admin-products">
            <span> Products </span>
          </a>
          <a href="#admin-categories">
            <span> Categories </span>
          </a>
          <a href="#admin-inventory">
            <span> Inventory </span>
          </a>
          <a href="#admin-orders">
            <span> Orders </span>
            <em> 6 </em>
          </a>
          <a href="#admin-customers">
            <span> Customers </span>
          </a>
          <a href="#admin-promotions">
            <span> Promotions </span>
          </a>
          <a href="#admin-reports">
            <span> Reports </span>
          </a>
        </nav>
        <div class="admin-profile">
          <span> AM </span>
          <div>
            <b> Alex Mendoza </b>
            <small> Administrator </small>
          </div>
        </div>
      </aside>
      <main class="admin-main">
        <header>
          <div>
            <small> ADMIN PORTAL </small>
            <h1>Dashboard</h1>
          </div>
          <div class="admin-header-actions">
            <b> Monday, Aug 18 </b>
            <small> Store open · closes 9:00 PM </small>
          </div>
        </header>
        <div class="admin-welcome">
          <div>
            <h2>Good morning, Alex.</h2>
            <p>Here’s what’s happening at Cups &amp; Berries today.</p>
          </div>
          <a class="admin-primary" href="admin-modals.php#product-modal">
            ＋ Add product
          </a>
        </div>
        <div class="metric-grid">
          <article class="metric">
            <div class="metric-icon">▥</div>
            <span> Total sales </span>
            <b> ₱18,420 </b>
            <p>
              +12.4%
              <small> Today </small>
            </p>
          </article>
          <article class="metric">
            <div class="metric-icon">▤</div>
            <span> Orders </span>
            <b> 84 </b>
            <p>
              +8.2%
              <small> Today </small>
            </p>
          </article>
          <article class="metric">
            <div class="metric-icon">♙</div>
            <span> Customers </span>
            <b> 1,248 </b>
            <p>
              +24
              <small> All time </small>
            </p>
          </article>
          <article class="metric">
            <div class="metric-icon">▣</div>
            <span> Products </span>
            <b> 32 </b>
            <p class="warn">
              3 low stock
              <small> Active </small>
            </p>
          </article>
        </div>
        <div class="admin-grid">
          <section class="admin-panel">
            <div class="panel-title">
              <div>
                <h3>Sales overview</h3>
                <p>Revenue for the last 7 days</p>
              </div>
              <select>
                <option>This week</option>
                <option>This month</option>
              </select>
            </div>
            <div class="chart-wrap">
              <div class="bars">
                <div class="bar-col">
                  <i style="height: 54%"> </i>
                  <span> Mon </span>
                </div>
                <div class="bar-col">
                  <i style="height: 68%"> </i>
                  <span> Tue </span>
                </div>
                <div class="bar-col">
                  <i style="height: 47%"> </i>
                  <span> Wed </span>
                </div>
                <div class="bar-col">
                  <i style="height: 81%"> </i>
                  <span> Thu </span>
                </div>
                <div class="bar-col">
                  <i style="height: 61%"> </i>
                  <span> Fri </span>
                </div>
                <div class="bar-col">
                  <i class="hot" style="height: 92%"> </i>
                  <span> Sat </span>
                </div>
                <div class="bar-col">
                  <i style="height: 74%"> </i>
                  <span> Sun </span>
                </div>
              </div>
            </div>
          </section>
          <section class="admin-panel">
            <div class="panel-title">
              <div>
                <h3>Best sellers</h3>
                <p>This month</p>
              </div>
            </div>
            <div class="best-row">
              <span class="rank"> 1 </span>
              <img
                src="https://images.unsplash.com/photo-1749104028391-c1362c3b92d6?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
              />
              <div>
                <b> Spanish Latte </b>
                <small> 184 sold </small>
              </div>
              <strong> ₱26,680 </strong>
            </div>
            <div class="best-row">
              <span class="rank"> 2 </span>
              <img
                src="https://images.unsplash.com/photo-1753727470826-584b80850a3c?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
              />
              <div>
                <b> Caramel Macchiato </b>
                <small> 156 sold </small>
              </div>
              <strong> ₱24,180 </strong>
            </div>
            <div class="best-row">
              <span class="rank"> 3 </span>
              <img
                src="https://images.unsplash.com/photo-1587982704600-e5f79d652fe5?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
              />
              <div>
                <b> Classic Americano </b>
                <small> 132 sold </small>
              </div>
              <strong> ₱14,520 </strong>
            </div>
          </section>
        </div>
        <section class="admin-panel recent" id="admin-orders">
          <div class="panel-title">
            <div>
              <h3>Recent orders</h3>
              <p>Latest orders from your shop</p>
            </div>
          </div>
          <div class="admin-table">
            <div class="admin-tr head">
              <span> Order </span>
              <span> Customer </span>
              <span> Pickup </span>
              <span> Items </span>
              <span> Total </span>
              <span> Status </span>
              <span> </span>
            </div>
            <div class="admin-tr">
              <span> #KP-240818 </span>
              <span> Sofia Reyes </span>
              <span> 10:30 AM </span>
              <span> 2 items </span>
              <span> ₱290 </span>
              <span class="status preparing"> Preparing </span>
              <a href="admin-modals.php#order-modal"> View </a>
            </div>
            <div class="admin-tr">
              <span> #KP-240817 </span>
              <span> Miguel Santos </span>
              <span> 10:45 AM </span>
              <span> 3 items </span>
              <span> ₱515 </span>
              <span class="status confirmed"> Confirmed </span>
              <a href="admin-modals.php#order-modal"> View </a>
            </div>
            <div class="admin-tr">
              <span> #KP-240816 </span>
              <span> Anna Cruz </span>
              <span> 11:00 AM </span>
              <span> 1 item </span>
              <span> ₱160 </span>
              <span class="status pending"> Pending </span>
              <a href="admin-modals.php#order-modal"> View </a>
            </div>
            <div class="admin-tr">
              <span> #KP-240815 </span>
              <span> Luis Garcia </span>
              <span> 11:15 AM </span>
              <span> 4 items </span>
              <span> ₱620 </span>
              <span class="status ready"> Ready </span>
              <a href="admin-modals.php#order-modal"> View </a>
            </div>
          </div>
        </section>
        <div class="admin-grid lower">
          <section class="admin-panel" id="admin-inventory">
            <div class="panel-title">
              <div>
                <h3>Low stock alerts</h3>
                <p>Products needing attention</p>
              </div>
              <span> 3 items </span>
            </div>
            <div class="stock-row">
              <img
                src="https://images.unsplash.com/photo-1587982708730-ffc82d18e9fc?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
              />
              <div>
                <b> Butter Croissant </b>
                <small> SKU: KP-006 </small>
              </div>
              <span class="status low"> 9 left </span>
              <a href="admin-modals.php#stock-modal"> Update </a>
            </div>
            <div class="stock-row">
              <img
                src="https://images.unsplash.com/photo-1682052253414-ddbd9f2da806?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
              />
              <div>
                <b> Blueberry Cheesecake </b>
                <small> SKU: KP-007 </small>
              </div>
              <span class="status low"> 7 left </span>
              <a href="admin-modals.php#stock-modal"> Update </a>
            </div>
            <div class="stock-row">
              <img
                src="https://images.unsplash.com/photo-1651241268906-38bde7268415?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
              />
              <div>
                <b> Sea Salt Cocoa </b>
                <small> SKU: KP-008 </small>
              </div>
              <span class="status pending"> Out of stock </span>
              <a href="admin-modals.php#stock-modal"> Update </a>
            </div>
          </section>
          <section class="admin-panel">
            <div class="panel-title">
              <div>
                <h3>Order status</h3>
                <p>Today's 84 orders</p>
              </div>
            </div>
            <div class="summary-progress">
              <p>Pending — 6</p>
              <i style="display: block; height: 8px; background: #ddd">
                <b
                  style="
                    display: block;
                    width: 15%;
                    height: 100%;
                    background: #9b765d;
                  "
                >
                </b>
              </i>
            </div>
            <div class="summary-progress">
              <p>Confirmed — 12</p>
              <i style="display: block; height: 8px; background: #ddd">
                <b
                  style="
                    display: block;
                    width: 30%;
                    height: 100%;
                    background: #9b765d;
                  "
                >
                </b>
              </i>
            </div>
            <div class="summary-progress">
              <p>Preparing — 18</p>
              <i style="display: block; height: 8px; background: #ddd">
                <b
                  style="
                    display: block;
                    width: 45%;
                    height: 100%;
                    background: #9b765d;
                  "
                >
                </b>
              </i>
            </div>
            <div class="summary-progress">
              <p>Ready for pickup — 9</p>
              <i style="display: block; height: 8px; background: #ddd">
                <b
                  style="
                    display: block;
                    width: 25%;
                    height: 100%;
                    background: #9b765d;
                  "
                >
                </b>
              </i>
            </div>
            <div class="summary-progress">
              <p>Completed — 39</p>
              <i style="display: block; height: 8px; background: #ddd">
                <b
                  style="
                    display: block;
                    width: 70%;
                    height: 100%;
                    background: #9b765d;
                  "
                >
                </b>
              </i>
            </div>
          </section>
        </div>
        <section
          class="admin-panel"
          id="admin-products"
          style="margin-top: 15px"
        >
          <div class="admin-welcome">
            <div>
              <h2>Products management</h2>
              <p>Manage your menu and product availability.</p>
            </div>
            <a class="admin-primary" href="admin-modals.php#product-modal">
              ＋ Add product
            </a>
          </div>
          <div class="admin-table product-admin">
            <div class="admin-tr head">
              <span> Product </span>
              <span> Category </span>
              <span> Price </span>
              <span> Stock </span>
              <span> Status </span>
              <!-- <span> Rating </span> -->
              <span> </span>
            </div>
            <div class="admin-tr">
              <span class="admin-product">
                <img
                  src="https://images.unsplash.com/photo-1749104028391-c1362c3b92d6?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
                />
                <b> Spanish Latte </b>
              </span>
              <span> Coffee </span>
              <span> ₱145 </span>
              <span> 38 </span>
              <span class="status completed"> In stock </span>
              <!-- <span> ★ 4.9 </span> -->
              <span class="table-actions">
                <a href="admin-modals.php#product-modal"> Edit </a>
                <a class="delete-link" href="admin-modals.php#delete-modal">
                  Delete
                </a>
              </span>
            </div>
            <div class="admin-tr">
              <span class="admin-product">
                <img
                  src="https://images.unsplash.com/photo-1753727470826-584b80850a3c?crop=entropy&amp;cs=tinysrgb&amp;fit=crop&amp;fm=jpg&amp;q=85&amp;w=1200"
                />
                <b> Caramel Macchiato </b>
              </span>
              <span> Coffee </span>
              <span> ₱155 </span>
              <span> 24 </span>
              <span class="status completed"> In stock </span>
              <!-- <span> ★ 4.8 </span> -->
              <span class="table-actions">
                <a href="admin-modals.php#product-modal"> Edit </a>
                <a class="delete-link" href="admin-modals.php#delete-modal">
                  Delete
                </a>
              </span>
            </div>
          </div>
        </section>
        <section
          class="admin-panel"
          id="admin-categories"
          style="margin-top: 15px"
        >
          <div class="admin-welcome">
            <div>
              <h2>Categories management</h2>
              <p>Organize products into customer-friendly groups.</p>
            </div>
            <a class="admin-primary" href="admin-modals.php#category-modal">
              ＋ Add category
            </a>
          </div>
          <div class="admin-table category-table">
            <div class="admin-tr head">
              <span> Category </span>
              <span> Description </span>
              <span> Products </span>
              <span> Status </span>
              <span> </span>
            </div>
            <div class="admin-tr">
              <span>
                <b> Coffee </b>
              </span>
              <span> Espresso-based and brewed coffee </span>
              <span> 12 </span>
              <span class="status completed"> Active </span>
              <span>
                <a href="admin-modals.php#category-modal"> Edit </a>
                ·
                <a class="delete-link" href="admin-modals.php#delete-modal">
                  Delete
                </a>
              </span>
            </div>
            <div class="admin-tr">
              <span>
                <b> Non-Coffee </b>
              </span>
              <span> Chocolate and blended favorites </span>
              <span> 7 </span>
              <span class="status completed"> Active </span>
              <span>
                <a href="admin-modals.php#category-modal"> Edit </a>
                ·
                <a class="delete-link" href="admin-modals.php#delete-modal">
                  Delete
                </a>
              </span>
            </div>
            <div class="admin-tr">
              <span>
                <b> Tea </b>
              </span>
              <span> Matcha and tea-based drinks </span>
              <span> 5 </span>
              <span class="status completed"> Active </span>
              <span>
                <a href="admin-modals.php#category-modal"> Edit </a>
                ·
                <a class="delete-link" href="admin-modals.php#delete-modal">
                  Delete
                </a>
              </span>
            </div>
            <div class="admin-tr">
              <span>
                <b> Pastries </b>
              </span>
              <span> Freshly baked every morning </span>
              <span> 8 </span>
              <span class="status completed"> Active </span>
              <span>
                <a href="admin-modals.php#category-modal"> Edit </a>
                ·
                <a class="delete-link" href="admin-modals.php#delete-modal">
                  Delete
                </a>
              </span>
            </div>
          </div>
        </section>
        <section
          class="admin-panel"
          id="admin-customers"
          style="margin-top: 15px"
        >
          <div class="admin-welcome">
            <div>
              <h2>Customers management</h2>
              <p>View customer profiles and account activity.</p>
            </div>
          </div>
          <div class="admin-table customer-table">
            <div class="admin-tr head">
              <span> Customer </span>
              <span> Email </span>
              <span> Contact </span>
              <span> Joined </span>
              <span> Orders </span>
              <span> Status </span>
              <span> </span>
            </div>
            <div class="admin-tr">
              <span>
                <b> Sofia Reyes </b>
              </span>
              <span> sofia@email.com </span>
              <span> 0917 555 0184 </span>
              <span> May 12, 2025 </span>
              <span> 12 </span>
              <span class="status completed"> Active </span>
              <span>
                <a href="admin-modals.php#customer-modal"> View </a>
              </span>
            </div>
            <div class="admin-tr">
              <span>
                <b> Miguel Santos </b>
              </span>
              <span> miguel@email.com </span>
              <span> 0921 443 9082 </span>
              <span> Jun 03, 2025 </span>
              <span> 8 </span>
              <span class="status completed"> Active </span>
              <span>
                <a href="admin-modals.php#customer-modal"> View </a>
              </span>
            </div>
            <div class="admin-tr">
              <span>
                <b> Anna Cruz </b>
              </span>
              <span> anna@email.com </span>
              <span> 0918 203 7711 </span>
              <span> Jul 19, 2025 </span>
              <span> 6 </span>
              <span class="status completed"> Active </span>
              <span>
                <a href="admin-modals.php#customer-modal"> View </a>
              </span>
            </div>
          </div>
        </section>
        <!-- <section
          class="admin-panel"
          id="admin-promotions"
          style="margin-top: 15px"
        >
          <div class="admin-welcome">
            <div>
              <h2>Promotions management</h2>
              <p>Create and manage simple offers and promo codes.</p>
            </div>
            <a class="admin-primary" href="admin-modals.php#promotion-modal">
              ＋ Create promotion
            </a>
          </div>
          <div class="promo-grid">
            <article class="promo-card">
              <span class="status completed"> Active </span>
              <small> New Customer Welcome </small>
              <h3>WELCOME10</h3>
              <b> 10% OFF </b>
              <p>Min. order ₱300 · Aug 1 – Sep 30</p>
              <a href="admin-modals.php#promotion-modal"> Edit </a>
              ·
              <a class="delete-link" href="admin-modals.php#delete-modal">
                Delete
              </a>
            </article>
            <article class="promo-card">
              <span class="status completed"> Active </span>
              <small> Weekend Brew </small>
              <h3>BREW50</h3>
              <b> ₱50 OFF </b>
              <p>Min. order ₱500 · Aug 15 – Aug 31</p>
              <a href="admin-modals.php#promotion-modal"> Edit </a>
              ·
              <a class="delete-link" href="admin-modals.php#delete-modal">
                Delete
              </a>
            </article>
            <article class="promo-card">
              <span class="status pending"> Inactive </span>
              <small> Student Break </small>
              <h3>STUDENT</h3>
              <b> 15% OFF </b>
              <p>Valid school ID · Ongoing</p>
              <a href="admin-modals.php#promotion-modal"> Edit </a>
              ·
              <a class="delete-link" href="admin-modals.php#delete-modal">
                Delete
              </a>
            </article>
          </div>
        </section> -->
        <section
          class="admin-panel"
          id="admin-reports"
          style="margin-top: 15px"
        >
          <div class="admin-welcome">
            <div>
              <h2>Reports</h2>
              <p>Review revenue, order volume, and product performance.</p>
            </div>
          </div>
          <div class="report-metrics">
            <div>
              <span> Daily sales </span>
              <b> ₱18,420 </b>
              <small> ↑ 12.4% from last period </small>
            </div>
            <div>
              <span> Weekly sales </span>
              <b> ₱106,850 </b>
              <small> ↑ 12.4% from last period </small>
            </div>
            <div>
              <span> Monthly sales </span>
              <b> ₱438,200 </b>
              <small> ↑ 12.4% from last period </small>
            </div>
            <div>
              <span> Orders this month </span>
              <b> 2,184 </b>
              <small> ↑ 12.4% from last period </small>
            </div>
          </div>
          <div class="report-chart">
            <i style="height: 45%">
              <span> 1 </span>
            </i>
            <i style="height: 70%">
              <span> 2 </span>
            </i>
            <i style="height: 52%">
              <span> 3 </span>
            </i>
            <i style="height: 84%">
              <span> 4 </span>
            </i>
            <i style="height: 64%">
              <span> 5 </span>
            </i>
            <i style="height: 92%">
              <span> 6 </span>
            </i>
            <i style="height: 74%">
              <span> 7 </span>
            </i>
            <i style="height: 82%">
              <span> 8 </span>
            </i>
            <i style="height: 60%">
              <span> 9 </span>
            </i>
            <i style="height: 89%">
              <span> 10 </span>
            </i>
            <i style="height: 76%">
              <span> 11 </span>
            </i>
            <i style="height: 96%">
              <span> 12 </span>
            </i>
          </div>
        </section>
      </main>
    </section>
  </body>
</html>
