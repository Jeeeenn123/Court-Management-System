
function filterTimeSlots() {
  var duration = document.getElementById("duration").value;
  var timeSlot = document.getElementById("timeSlot");
  var options = timeSlot.options;

  // Reset selection
  timeSlot.selectedIndex = 0;

  // Loop through options
  for (var i = 0; i < options.length; i++) {
    var option = options[i];
    var dataDuration = option.getAttribute("data-duration");

    if (!dataDuration || duration === "") {
      option.style.display = i === 0 ? "" : "none"; // Show default only
    } else {
      option.style.display = (dataDuration === duration) ? "" : "none";
    }
  }
}
