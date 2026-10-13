document.addEventListener("DOMContentLoaded", () => {

  /* ============================================================
     HAMBURGER MENU
     ============================================================ */
  const Hamburger = document.querySelector('.Hamburger');
  const navLinks = document.querySelector('.navLinks');
  const mediaQuery = window.matchMedia("(max-width: 900px)");

  if (Hamburger && navLinks) {
    let state = 0; // 0 = closed, 1 = open

    function openHamburger() {
      if (state === 0) {
        Hamburger.classList.add('activated');
        navLinks.classList.remove('hideNav');
        navLinks.classList.add('showNav');
        state = 1;
      } else {
        Hamburger.classList.remove('activated');
        navLinks.classList.remove('showNav');
        navLinks.classList.add('hideNav');
        state = 0;
      }
    }

    function checkScreenSize() {
      if (mediaQuery.matches) {
        state = 0;
        Hamburger.classList.remove('activated');
        navLinks.classList.remove('showNav');
        navLinks.classList.add('hideNav');
      }
    }

    mediaQuery.addEventListener('change', checkScreenSize);
    Hamburger.addEventListener('click', openHamburger);

    // Set initial state on load
    checkScreenSize();
  }

  /* ============================================================
     ADD-ONS
     ============================================================ */
  const addonList = document.getElementById('addonList');
  const addAddonButton = document.getElementById('addAddon');

  if (addonList && addAddonButton) {
    function addAddon() {
      const addonRow = document.createElement('div');
      addonRow.classList.add('addon-row');

      const addonName = document.createElement('input');
      addonName.type = 'text';
      addonName.name = 'addon_name[]';
      addonName.placeholder = 'Add-on name';
      addonName.required = true;

      const addonPrice = document.createElement('input');
      addonPrice.type = 'number';
      addonPrice.name = 'addon_price[]';
      addonPrice.placeholder = 'Price';
      addonPrice.min = '0';
      addonPrice.step = '0.01';
      addonPrice.required = true;

      const removeButton = document.createElement('button');
      removeButton.type = 'button';
      removeButton.classList.add('remove-addon');
      removeButton.textContent = 'Remove';

      removeButton.addEventListener('click', function () {
        addonRow.remove();
      });

      addonRow.append(addonName, addonPrice, removeButton);
      addonList.appendChild(addonRow);
    }

    addAddonButton.addEventListener('click', addAddon);

    // Delegated remove handler (also catches pre-rendered rows)
    addonList.addEventListener('click', function (event) {
      if (event.target.classList.contains('remove-addon')) {
        event.target.closest('.addon-row').remove();
      }
    });
  }

  /* ============================================================
     PRODUCT VARIANTS
     ============================================================ */
  function createVariantRow() {
    const row = document.createElement("div");
    row.classList.add("admin-tr", "variant-row");

    const ozInput = document.createElement("input");
    ozInput.type = "text";
    ozInput.name = "variant_oz[]";
    ozInput.placeholder = "Size (oz)";
    ozInput.min = "0.1";
    ozInput.step = "0.1";
    ozInput.required = true;

    const priceInput = document.createElement("input");
    priceInput.type = "number";
    priceInput.name = "variant_price[]";
    priceInput.placeholder = "Price";
    priceInput.min = "0";
    priceInput.step = "0.01";
    priceInput.required = true;

    const stockInput = document.createElement("input");
    stockInput.type = "number";
    stockInput.name = "variant_stock[]";
    stockInput.placeholder = "Stock";
    stockInput.min = "0";
    stockInput.step = "1";
    stockInput.required = true;

    const removeButton = document.createElement("button");
    removeButton.type = "button";
    removeButton.classList.add("remove-variant");
    removeButton.textContent = "Remove";

    row.append(ozInput, priceInput, stockInput, removeButton);
    return row;
  }

  function initProductVariants() {
    const category = document.getElementById("category");
    const variantsSection = document.getElementById("variantsSection");
    const variantList = document.getElementById("variantList");
    const addVariantButton = document.getElementById("addVariant");

    // Bail out if this page doesn't contain the variants form.
    if (!category || !variantsSection || !variantList || !addVariantButton) {
      return;
    }

    const variantCategories = ["Coffee", "Tea", "Iced-Coffee"];

    function updateVariants() {
      const needsVariants = variantCategories.includes(category.value);
      variantsSection.hidden = !needsVariants;

      if (needsVariants && variantList.children.length === 0) {
        variantList.appendChild(createVariantRow());
      }

      if (!needsVariants) {
        variantList.replaceChildren();
      }
    }

    category.addEventListener("change", updateVariants);

    addVariantButton.addEventListener("click", () => {
      variantList.appendChild(createVariantRow());
    });

    variantList.addEventListener("click", (event) => {
      if (event.target.classList.contains("remove-variant")) {
        event.target.closest(".variant-row").remove();
      }
    });

    updateVariants();
  }

  initProductVariants();

  /* ============================================================
     OTHER FEATURES
     ============================================================ */
  // initAddons();
  // initImagePreview();
  // initProductForm();


  // ===========================================================
  // add to Cart
  // ===========================================================

  const productRadioVariant = document.getElementById('productRadioVariant');

  const radiobuttons = productRadioVariant.querySelectorAll('input[type="radio"]');

  if(productRadioVariant){
    function getButtonValue(){
      
      radiobuttons.forEach(element => {
        console.log(element.value)
      });

    }
  function getVariantData() {
    const el = document.getElementById("variantData");
    if (!el) return null;
    try {
      return JSON.parse(el.textContent);
    } catch (err) {
      console.error("Invalid variant JSON", err);
      return null;
    }
  }
  console.log(getVariantData())
    getButtonValue();
  }
});