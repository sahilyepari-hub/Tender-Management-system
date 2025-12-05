<?php require 'auth.php'; include 'header.php'; ?>

<style>
/* Page background - update path if needed */
body {
  background: url('images/background2.jpg') no-repeat center center fixed;
  background-size: cover;
  -webkit-font-smoothing: antialiased;
  -moz-osx-font-smoothing: grayscale;
}

/* Container that holds the form */
.form-container {
  max-width: 980px;
  margin: 0 auto;
  padding: 26px;
  border-radius: 12px;
  /* translucent so page background shows through */
  background: rgba(255,255,255,0.06);
  backdrop-filter: blur(6px); /* glass effect on supported browsers */
  -webkit-backdrop-filter: blur(6px);
  box-shadow: 0 8px 30px rgba(0,0,0,0.08);
  position: relative;
}

/* Form heading */
.form-container h3 {
  font-size: 1.5rem;
  font-weight: 600;
  text-align: center;
  margin-bottom: 1rem;
}

/* Make form controls readable while retaining glass look */
.form-container .form-control,
.form-container textarea,
.form-container select {
  background: rgba(255,255,255,0.92);
  border: 1px solid rgba(0,0,0,0.08);
  border-radius: 6px;
  padding: .5rem .625rem;
}

/* File inputs - keep consistent spacing on small screens */
.form-container .form-label {
  font-size: 0.95rem;
}

/* Mobile-first: stack everything, bigger tappable areas */
@media (max-width: 575.98px) {
  .form-container {
    padding: 18px;
    border-radius: 10px;
  }

  .form-container h3 { font-size: 1.25rem; }

  /* full width submit on phones */
  .btn-submit {
    width: 100%;
    padding: 12px 16px;
    font-size: 1rem;
  }

  /* Slightly larger inputs for tapping */
  .form-control { font-size: 1rem; }
}

/* Tablet adjustments */
@media (min-width: 576px) and (max-width: 991.98px) {
  .form-container { padding: 22px; }
}

/* Desktop: limit width and center */
@media (min-width: 992px) {
  .form-container { margin-top: 40px; margin-bottom: 40px; }
}
</style>

<div class="container mt-4">
  <div class="form-container">
    <h3 class="mb-4">Tender Filling Form</h3>

    <form action="tender_save.php" method="post" enctype="multipart/form-data" class="row g-3">

      <!-- Type -->
      <div class="col-12 col-md-4">
        <label for="type" class="form-label">Type *</label>
        <input type="text" name="type" id="type" class="form-control" required placeholder="Enter type">
      </div>

      <!-- Full Name -->
      <div class="col-12 col-md-8">
        <label for="full_name" class="form-label">Full Name *</label>
        <input type="text" name="full_name" id="full_name" class="form-control" required>
      </div>

      <!-- Address -->
      <div class="col-12">
        <label for="address" class="form-label">Address</label>
        <textarea name="address" id="address" class="form-control" rows="2"></textarea>
      </div>

      <!-- Location -->
      <div class="col-12 col-md-4">
        <label for="state" class="form-label">State *</label>
        <select id="state" name="state_id" class="form-control" required>
          <option value="">Loading States...</option>
        </select>
      </div>

      <div class="col-12 col-md-4">
        <label for="district" class="form-label">District *</label>
        <select id="district" name="district_id" class="form-control" required>
          <option value="">Select District</option>
        </select>
      </div>

      <div class="col-12 col-md-4">
        <label for="taluka" class="form-label">Taluka / Sub-district</label>
        <select id="taluka" name="taluka_name" class="form-control">
          <option value="">Select Taluka</option>
        </select>
      </div>

      <!-- Pincode -->
      <div class="col-12 col-md-4">
        <label for="pincode" class="form-label">Pincode *</label>
        <input
          type="tel"
          name="pincode"
          id="pincode"
          class="form-control"
          maxlength="6"
          required
          placeholder="6 digits"
          pattern="[0-9]{6}"
          title="Pincode must be exactly 6 digits"
          oninput="this.value = this.value.replace(/[^0-9]/g,'');"
        />
      </div>

      <!-- Mobile -->
      <div class="col-12 col-md-4">
        <label for="mobile" class="form-label">Mobile *</label>
        <input
          type="tel"
          name="mobile"
          id="mobile"
          class="form-control"
          maxlength="10"
          required
          placeholder="Must start with 6,7,8 or 9"
          pattern="^[6-9][0-9]{9}$"
          title="Mobile must start with 6,7,8 or 9 and be 10 digits"
          oninput="this.value = this.value.replace(/[^0-9]/g,'');"
        />
        <div class="invalid-feedback" id="mobileFeedback">
          Mobile must start with 6, 7, 8 or 9 and be exactly 10 digits.
        </div>
      </div>

      <!-- Email -->
      <div class="col-12 col-md-4">
        <label for="email" class="form-label">Email *</label>
        <input type="email" name="email" id="email" class="form-control" required>
      </div>

      <!-- License & GST -->
      <div class="col-12 col-md-3">
        <label class="form-label d-block">License Number *</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="license_number" value="YES" required id="lic_yes">
          <label class="form-check-label" for="lic_yes">YES</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="license_number" value="NO" required id="lic_no">
          <label class="form-check-label" for="lic_no">NO</label>
        </div>
      </div>

      <div class="col-12 col-md-3">
        <label class="form-label d-block">GST Number *</label>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gst_number" value="YES" required id="gst_yes">
          <label class="form-check-label" for="gst_yes">YES</label>
        </div>
        <div class="form-check">
          <input class="form-check-input" type="radio" name="gst_number" value="NO" required id="gst_no">
          <label class="form-check-label" for="gst_no">NO</label>
        </div>
      </div>

      <!-- Goods -->
      <div class="col-12 col-md-6">
        <label for="goods_type" class="form-label">Goods Type *</label>
        <input type="text" name="goods_type" id="goods_type" class="form-control" required placeholder="Enter goods type">
      </div>
      <div class="col-12 col-md-6">
        <label for="goods_demand" class="form-label">Goods Demand *</label>
        <input type="text" name="goods_demand" id="goods_demand" class="form-control" required placeholder="e.g., 1000 Ton">
      </div>

      <div class="col-12 col-md-6">
        <label for="sale_rate" class="form-label">Sale Rate *</label>
        <input type="text" name="sale_rate" id="sale_rate" class="form-control" required placeholder="e.g., 3800 Per Ton">
      </div>

      <!-- File uploads grouped responsively -->
      <div class="col-12">
        <div class="row g-3">
          <div class="col-12 col-md-6">
            <label class="form-label">Passport Photo *</label>
            <input type="file" name="photo" accept=".jpg,.jpeg,.png" class="form-control" required>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">Aadhar Copy *</label>
            <input type="file" name="aadhar_copy" accept=".jpg,.jpeg,.png" class="form-control" required>
          </div>

          <div class="col-12 col-md-6">
            <label class="form-label">PAN Copy *</label>
            <input type="file" name="pan_copy" accept=".jpg,.jpeg,.png" class="form-control" required>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">GST Certificate *</label>
            <input type="file" name="gst_certificate" accept=".jpg,.jpeg,.png" class="form-control" required>
          </div>
          <div class="col-12 col-md-6">
            <label class="form-label">License Certificate *</label>
            <input type="file" name="license_certificate" accept=".jpg,.jpeg,.png" class="form-control" required>
          </div>
        </div>
      </div>

      <!-- Remarks -->
      <div class="col-12">
        <label for="remarks" class="form-label">Remarks</label>
        <textarea name="remarks" id="remarks" class="form-control" rows="3"></textarea>
      </div>

      <!-- Submit -->
      <div class="col-12 text-center mt-3">
        <button type="submit" class="btn btn-primary btn-submit px-4">Submit</button>
      </div>
    </form>
  </div>
</div>

<?php include 'footer.php'; ?>

<script>
window.addEventListener('DOMContentLoaded', function() {
  fetch('get_states.php')
    .then(response => response.text())
    .then(html => document.getElementById('state').innerHTML = html);

  const stateEl = document.getElementById('state');
  const districtEl = document.getElementById('district');
  const talukaEl = document.getElementById('taluka');

  stateEl.addEventListener('change', function() {
    const state_id = this.value;
    districtEl.innerHTML = "<option value=''>Select District</option>";
    talukaEl.innerHTML = "<option value=''>Select Taluka</option>";
    if (!state_id) return;
    fetch('get_districts.php?state_id=' + encodeURIComponent(state_id))
      .then(r => r.text()).then(html => districtEl.innerHTML = html);
  });

  districtEl.addEventListener('change', function() {
    const district_id = this.value;
    talukaEl.innerHTML = "<option value=''>Select Taluka</option>";
    if (!district_id) return;
    fetch('get_talukas.php?district_id=' + encodeURIComponent(district_id))
      .then(r => r.text()).then(html => talukaEl.innerHTML = html);
  });
});
</script>

<script>
// live validation + prevent submit if invalid
document.addEventListener('DOMContentLoaded', function() {
  const form = document.querySelector('form');
  const mobile = document.getElementById('mobile');
  const mobileFeedback = document.getElementById('mobileFeedback');
  const mobileRegex = /^[6-9][0-9]{9}$/;

  // live input: toggle valid/invalid classes
  if (mobile) {
    mobile.addEventListener('input', () => {
      const val = mobile.value.trim();
      if (val === '') {
        mobile.classList.remove('is-valid','is-invalid');
        mobileFeedback.style.display = 'none';
        return;
      }
      if (mobileRegex.test(val)) {
        mobile.classList.add('is-valid');
        mobile.classList.remove('is-invalid');
        mobileFeedback.style.display = 'none';
      } else {
        mobile.classList.add('is-invalid');
        mobile.classList.remove('is-valid');
        mobileFeedback.style.display = 'block';
      }
    });
  }

  // prevent form submit if invalid fields (incl mobile)
  form.addEventListener('submit', (e) => {
    // let browser perform HTML validation first
    if (!form.checkValidity()) {
      e.preventDefault();
      e.stopPropagation();
      // show validation feedback for mobile specifically
      if (mobile) {
        const val = mobile.value.trim();
        if (!mobileRegex.test(val)) {
          mobile.classList.add('is-invalid');
          mobileFeedback.style.display = 'block';
        }
      }
      // add bootstrap validation class to form to show built-in messages
      form.classList.add('was-validated');
      return false;
    }
    // additionally enforce mobile server-side on submit (see tender_save.php)
  });
});
</script>
