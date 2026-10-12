const Hamburger = document.querySelector('.Hamburger');
const navLinks = document.querySelector('.navLinks');
const mediaQuery = window.matchMedia("(max-width: 900px)");

// Get the add-on container and buttons
const addonList = document.getElementById('addonList');
const addAddonButton = document.getElementById('addAddon');

// Create a new add-on row
function addAddon() {
    // Create the row container
    const addonRow = document.createElement('div');
    addonRow.classList.add('addon-row');

    // Create the add-on name input
    const addonName = document.createElement('input');
    addonName.type = 'text';
    addonName.name = 'addon_name[]';
    addonName.placeholder = 'Add-on name';
    addonName.required = true;

    // Create the add-on price input
    const addonPrice = document.createElement('input');
    addonPrice.type = 'number';
    addonPrice.name = 'addon_price[]';
    addonPrice.placeholder = 'Price';
    addonPrice.min = '0';
    addonPrice.step = '0.01';
    addonPrice.required = true;

    // Create the remove button
    const removeButton = document.createElement('button');
    removeButton.type = 'button';
    removeButton.classList.add('remove-addon');
    removeButton.textContent = 'Remove';

    // Remove this add-on row when clicked
    removeButton.addEventListener('click', function () {
        addonRow.remove();
    });

    // Put the inputs and button inside the row
    addonRow.append(addonName, addonPrice, removeButton);

    // Add the new row to the page
    addonList.appendChild(addonRow);
}

// Add an add-on when the button is clicked
addAddonButton.addEventListener('click', addAddon);

// Handle remove buttons on the two existing rows
addonList.addEventListener('click', function (event) {
    if (event.target.classList.contains('remove-addon')) {
        event.target.closest('.addon-row').remove();
    }
});

let state = 0;
function openHamburger(){
    if(state == 0){
        Hamburger.classList.toggle('activated');
        navLinks.classList.toggle('hideNav');
        navLinks.classList.remove('showNav');

        navLinks.classList.toggle('showNav');
        state == 1
    }else if(state == 1){
        Hamburger.classList.toggle('activated');
        navLinks.classList.remove('showNav');
        state == 0
    }
}

function checkScreenSize() {

    if (mediaQuery.matches) {
        state = 0;

        Hamburger.classList.remove("activated");
        navLinks.classList.remove("showNav");
        navLinks.classList.add("hideNav");
    }
}

function createVariantRow() {
  // Create a row using your existing admin-table styling.
  const row = document.createElement("div");
  row.classList.add("admin-tr", "variant-row");

  // Size in ounces.
  const ozInput = document.createElement("input");
  ozInput.type = "text";
  ozInput.name = "variant_oz[]";
  ozInput.placeholder = "Size (oz)";
  ozInput.min = "0.1";
  ozInput.step = "0.1";
  ozInput.required = true;

  // Custom price.
  const priceInput = document.createElement("input");
  priceInput.type = "number";
  priceInput.name = "variant_price[]";
  priceInput.placeholder = "Price";
  priceInput.min = "0";
  priceInput.step = "0.01";
  priceInput.required = true;

  // Stock quantity.
  const stockInput = document.createElement("input");
  stockInput.type = "number";
  stockInput.name = "variant_stock[]";
  stockInput.placeholder = "Stock";
  stockInput.min = "0";
  stockInput.step = "1";
  stockInput.required = true;

  // Remove button.
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

  // Do nothing if this page doesn't contain the variants form.
  if (!category || !variantsSection || !variantList || !addVariantButton) {
    return;
  }

  const variantCategories = ["Coffee", "Tea", "Iced-Coffee"];

  // Show or hide variants based on the selected category.
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

  // Listen for category changes.
  category.addEventListener("change", updateVariants);

  // Add another variant row.
  addVariantButton.addEventListener("click", () => {
    variantList.appendChild(createVariantRow());
  });

  // Remove a variant row.
  variantList.addEventListener("click", (event) => {
    if (event.target.classList.contains("remove-variant")) {
      event.target.closest(".variant-row").remove();
    }
  });

  // Set the initial state for this feature.
  updateVariants();
}

// Keep your other JS features separate.
document.addEventListener("DOMContentLoaded", () => {
  initProductVariants();

  // Example:
  // initAddons();
  // initImagePreview();
  // initProductForm();
});


mediaQuery.addEventListener("change", checkScreenSize);
Hamburger.addEventListener('click', openHamburger)