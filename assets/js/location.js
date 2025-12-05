// Load states on page load
window.addEventListener('DOMContentLoaded', function() {
  fetch('get_states.php')
    .then(response => response.text())
    .then(html => document.getElementById('state').innerHTML = html)
    .catch(() => document.getElementById('state').innerHTML = "<option value=''>Error loading states</option>");
});

// Load districts when state changes
document.getElementById('state').addEventListener('change', function() {
  const state_id = this.value;
  fetch('get_districts.php?state_id=' + encodeURIComponent(state_id))
    .then(response => response.text())
    .then(html => document.getElementById('district').innerHTML = html)
    .catch(() => document.getElementById('district').innerHTML = "<option value=''>Error loading districts</option>");

  // Reset city dropdown
  document.getElementById('city').innerHTML = "<option value=''>Select City</option>";
});

// Load cities when district changes
document.getElementById('district').addEventListener('change', function() {
  const district_id = this.value;
  fetch('get_cities.php?district_id=' + encodeURIComponent(district_id))
    .then(response => response.text())
    .then(html => document.getElementById('city').innerHTML = html)
    .catch(() => document.getElementById('city').innerHTML = "<option value=''>Error loading cities</option>");
});