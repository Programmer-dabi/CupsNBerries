document.addEventListener("DOMContentLoaded", () => {

  /* ============================================================
     HAMBURGER MENU
     ============================================================ */
  const Hamburger = document.querySelector('.Hamburger');
  const navLinks = document.querySelector('.navLinks');
  const mediaQuery = window.matchMedia("(max-width: 900px)");

  if (Hamburger && navLinks) {
    function setMenuOpen(open) {
      Hamburger.classList.toggle('activated', open);
      Hamburger.setAttribute('aria-expanded', String(open));
      Hamburger.setAttribute('aria-label', open ? 'Close menu' : 'Open menu');
      navLinks.classList.toggle('showNav', open);
      navLinks.hidden = !open;
    }

    mediaQuery.addEventListener('change', () => setMenuOpen(false));
    Hamburger.addEventListener('click', () => {
      setMenuOpen(mediaQuery.matches && navLinks.hidden);
    });
    navLinks.addEventListener('click', (event) => {
      if (event.target.closest('a')) setMenuOpen(false);
    });
    document.addEventListener('keydown', (event) => {
      if (event.key === 'Escape' && !navLinks.hidden) {
        setMenuOpen(false);
        Hamburger.focus();
      }
    });

    // Set initial state on load
    setMenuOpen(false);
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
    ozInput.placeholder = "Variant Name eg. Size(oz)";
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

    const variantCategories = ["Coffee", "Tea", "Iced-Coffee", "Pastries", "Desserts"];

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

  document.querySelectorAll('.gallery').forEach((gallery) => {
    const mainPhoto = gallery.querySelector('.main-photo img');
    const thumbnails = gallery.querySelectorAll('.thumbs button');

    if (!mainPhoto) return;

    thumbnails.forEach((button) => {
      button.addEventListener('click', () => {
        const image = button.querySelector('img');
        if (!image) return;

        mainPhoto.src = image.src;
        mainPhoto.alt = image.alt;

        thumbnails.forEach((thumbnail) => {
          const selected = thumbnail === button;
          thumbnail.classList.toggle('selected', selected);
          thumbnail.setAttribute('aria-pressed', String(selected));
        });
      });
    });
  });

  /* ============================================================
     CHECKOUT PAYMENT
     ============================================================ */
  const checkoutForm = document.querySelector('.checkout-form');
  if (checkoutForm) {
    const paymentOptions = checkoutForm.querySelectorAll('[name="payment_method"]');
    const pickupFields = checkoutForm.querySelector('[data-pickup-fields]');
    const pickupInput = checkoutForm.querySelector('[name="pickup_at"]');
    const deliveryFields = checkoutForm.querySelector('[data-delivery-fields]');
    const addressInputs = deliveryFields ? deliveryFields.querySelectorAll('input') : [];

    if (pickupFields && pickupInput) {
      function updatePickupFields() {
        const selected = checkoutForm.querySelector('[name="payment_method"]:checked');
        const storePickup = selected?.value === 'store_pickup';
        pickupFields.hidden = !storePickup;
        pickupInput.disabled = !storePickup;
        pickupInput.required = storePickup;
        const needsDelivery = selected?.value === 'gcash' || selected?.value === 'cash_on_delivery';
        if (deliveryFields) deliveryFields.hidden = !needsDelivery;
        addressInputs.forEach((input) => {
          input.disabled = !needsDelivery;
          input.required = needsDelivery;
        });
      }

      paymentOptions.forEach((option) => option.addEventListener('change', updatePickupFields));
      window.addEventListener('pageshow', updatePickupFields);
      updatePickupFields();
    }
  }

  /* ============================================================
     ORDER TRACKING
     ============================================================ */
  const trackingPage = document.querySelector('[data-tracking-status-url]');
  if (trackingPage) {
    const heading = trackingPage.querySelector('[data-tracking-heading]');
    const badge = trackingPage.querySelector('[data-tracking-status]');
    const progress = trackingPage.querySelector('[data-tracking-progress]');
    const note = trackingPage.querySelector('[data-tracking-update-note]');
    const steps = trackingPage.querySelectorAll('[data-tracking-step]');
    let refreshing = false;
    let stopped = false;
    let timer;

    async function refreshTracking() {
      if (refreshing || stopped || document.hidden) return;
      refreshing = true;
      try {
        const response = await fetch(trackingPage.dataset.trackingStatusUrl, {
          headers: {'Accept': 'application/json'},
          cache: 'no-store',
          signal: AbortSignal.timeout(10000),
        });
        if (response.status === 401 || response.status === 403 || response.status === 404) {
          stopped = true;
          clearInterval(timer);
          note.textContent = 'This order is no longer available. Please sign in to view your orders.';
          return;
        }
        if (!response.ok) throw new Error('Could not refresh order status.');
        const state = await response.json();
        if (!state.success || !Number.isInteger(state.progress_step) || state.progress_step < 0 || state.progress_step > steps.length ||
            !Array.isArray(state.tracking_steps) || state.tracking_steps.length !== steps.length || state.tracking_steps.some((label) => typeof label !== 'string') ||
            typeof state.status !== 'string' || typeof state.status_class !== 'string' || typeof state.tracking_heading !== 'string') {
          throw new Error('Unexpected order status response.');
        }
        heading.textContent = state.tracking_heading;
        badge.textContent = state.status;
        badge.className = `status ${state.status_class}`;
        progress.hidden = state.progress_step === 0;
        steps.forEach((step) => {
          const number = Number(step.dataset.trackingStep);
          const current = number === state.progress_step;
          step.querySelector('[data-tracking-step-label]').textContent = state.tracking_steps[number - 1];
          step.classList.toggle('active', number <= state.progress_step);
          step.querySelector('[data-tracking-marker]').textContent = number <= state.progress_step ? '✓' : String(number);
          if (current) step.setAttribute('aria-current', 'step');
          else step.removeAttribute('aria-current');
          const stepNote = step.querySelector('[data-tracking-step-note]');
          stepNote.textContent = current ? 'Current status' : (number === state.progress_step + 1 ? 'Up next' : '');
          stepNote.hidden = stepNote.textContent === '';
        });
        note.textContent = '';
      } catch {
        note.textContent = 'Could not refresh your order status. Retrying…';
      } finally {
        refreshing = false;
      }
    }

    timer = setInterval(refreshTracking, 5000);
    document.addEventListener('visibilitychange', () => {
      if (!document.hidden) refreshTracking();
    });
    window.addEventListener('pagehide', () => {
      clearInterval(timer);
      stopped = true;
    });
    window.addEventListener('pageshow', (event) => {
      if (event.persisted) {
        stopped = false;
        timer = setInterval(refreshTracking, 5000);
        refreshTracking();
      }
    });
    refreshTracking();
  }

  /* ============================================================
     CART QUANTITY
     ============================================================ */
  const cartPage = document.getElementById('cart');
  if (cartPage) {
    const forms = cartPage.querySelectorAll('[data-cart-quantity-form]');
    const status = cartPage.querySelector('[data-cart-update-status]');
    const money = new Intl.NumberFormat('en-PH', {
      minimumFractionDigits: 2,
      maximumFractionDigits: 2,
    });
    let updating = false;

    function updateButtons() {
      forms.forEach((form) => {
        const quantity = Number(form.querySelector('[data-cart-quantity]').textContent);
        form.querySelectorAll('[data-quantity-step]').forEach((button) => {
          const nextQuantity = quantity + Number(button.dataset.quantityStep);
          button.value = String(nextQuantity);
          button.disabled = updating || nextQuantity < 1 || nextQuantity > 99;
        });
      });
    }

    forms.forEach((form) => {
      form.addEventListener('submit', async (event) => {
        event.preventDefault();
        if (updating || !event.submitter) return;

        const data = new FormData(form);
        data.set('quantity', event.submitter.value);
        updating = true;
        updateButtons();
        status.textContent = 'Updating cart…';

        try {
          const response = await fetch(form.action, {
            method: 'POST',
            headers: {'Accept': 'application/json'},
            body: data,
          });
          const result = await response.json();
          if (response.status === 401) {
            window.location.assign(result.redirect_url || '/login');
            return;
          }
          if (!response.ok || !result.success) {
            throw new Error(result.message || 'Could not update your cart.');
          }

          forms.forEach((quantityForm) => {
            const row = quantityForm.closest('[data-cart-item]');
            const item = result.items[row.dataset.cartItem];
            if (!item) return;
            quantityForm.querySelector('[data-cart-quantity]').textContent = String(item.quantity);
            row.querySelector('[data-cart-line-total]').textContent = `₱${money.format(item.line_total)}`;
          });
          cartPage.querySelector('[data-cart-subtotal]').textContent = `₱${money.format(result.subtotal)}`;
          cartPage.querySelector('[data-cart-total]').textContent = `₱${money.format(result.total)}`;
          cartPage.querySelector('[data-cart-summary-count]').textContent =
            `${result.cart_count} ${result.cart_count === 1 ? 'item' : 'items'} waiting for you`;
          document.querySelectorAll('[data-cart-count]').forEach((count) => {
            count.textContent = String(result.cart_count);
          });
          status.textContent = 'Cart updated.';
        } catch (error) {
          status.textContent = error instanceof SyntaxError
            ? 'The server returned an unexpected response. Please try again.'
            : error.message || 'Could not update your cart. Please try again.';
        } finally {
          updating = false;
          updateButtons();
        }
      });
    });
    updateButtons();
  }

  /* ============================================================
     ADD TO CART
     ============================================================ */
  document.querySelectorAll('[data-cart-form]').forEach((form) => {
    const submitButton = form.querySelector('[type="submit"]');
    const status = form.querySelector('[data-cart-status]');
    const minusButton = form.querySelector('#minusButton');
    const plusButton = form.querySelector('#addButton');
    const quantityDisplay = form.querySelector('[data-quantity]');
    const quantityInput = form.querySelector('[name="quantity"]');
    const totalInput = form.querySelector('[name="totalPrice"]');
    // const detailPrice = form.closest('.page-shell').querySelector('.detail-price');
    let quantity = 1;
    let submitting = false;

    // Calculate in centavos using only prices passed into the template.
    function toCentavos(price) {
      return Math.round(Number(price) * 100);
    }

    function updatePrice() {
      const variant = form.querySelector('[name="variant_id"]:checked:not(:disabled)');
      const milk = form.querySelector('[name="milk_preference"]:checked');
      let unitPrice = form.dataset.basePrice ? toCentavos(form.dataset.basePrice) : 0;

      if (variant) unitPrice += toCentavos(variant.dataset.price);
      if (milk) unitPrice += toCentavos(milk.dataset.price);

      form.querySelectorAll('[name="addon_ids[]"]:checked:not(:disabled)').forEach((addon) => {
        unitPrice += toCentavos(addon.dataset.price);
      });

      const total = (unitPrice * quantity / 100).toFixed(2);
      quantityDisplay.textContent = String(quantity);
      quantityInput.value = String(quantity);
      minusButton.disabled = quantity === 1;
      totalInput.value = total;
      if (submitButton) {
        submitButton.value = `Add to Cart ₱${total}`;
        submitButton.dataset.totalprice = total;
      }
      // if (detailPrice) detailPrice.textContent = `₱${total}`;
    }

    minusButton.addEventListener('click', () => {
      quantity = Math.max(1, quantity - 1);
      updatePrice();
    });

    plusButton.addEventListener('click', () => {
      quantity += 1;
      updatePrice();
    });

    form.addEventListener('change', (event) => {
      if (event.target.matches('[name="variant_id"], [name="milk_preference"], [name="addon_ids[]"]')) {
        updatePrice();
      }
    });
    updatePrice();

    form.addEventListener('submit', async (event) => {
      event.preventDefault();
      if (form.dataset.loginRequired === 'true') {
        window.location.assign('/login');
        return;
      }
      if (submitting || !form.reportValidity()) return;

      const data = new FormData(form);
      const variant = data.get('variant_id');
      const sugar = data.get('sugar_level');

      if (form.querySelector('[name="variant_id"]') && variant === null) {
        status.textContent = 'Please choose an in-stock variant.';
        return;
      }

      const payload = {
        variant_id: variant === null ? null : Number(variant),
        milk_preference: data.get('milk_preference'),
        sugar_level: sugar === null ? null : Number(sugar),
        addon_ids: data.getAll('addon_ids[]').map(Number),
        quantity: Number(data.get('quantity')),
      };

      submitting = true;
      submitButton.disabled = true;
      status.textContent = 'Sending product options…';

      try {
        const response = await fetch(form.action, {
          method: 'POST',
          headers: {
            'Content-Type': 'application/json',
            'Accept': 'application/json',
          },
          body: JSON.stringify(payload),
        });
        const result = await response.json();

        if (response.status === 401) {
          window.location.assign(result.redirect_url || '/login');
          return;
        }

        if (!response.ok || !result.success) {
          throw new Error(result.message || 'Could not send product options.');
        }

        status.textContent = result.message;
        window.location.assign(result.redirect_url || '/cart');
      } catch (error) {
        status.textContent = error instanceof SyntaxError
          ? 'The server returned an unexpected response. Please try again.'
          : error.message || 'Could not send product options. Please try again.';
      } finally {
        submitting = false;
        submitButton.disabled = false;
      }
    });
  });
});
