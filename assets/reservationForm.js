document.addEventListener("DOMContentLoaded", function () {
  const requiredInput = document.getElementById("date_reservation");
  const optionalInput = document.getElementById("start");
  const optionalInput2 = document.getElementById("end_reservation");

  // Par défaut, désactive le champ optionnel
  optionalInput.disabled = true;

  // Active le champ optionnel si le champ requis est rempli
  requiredInput.addEventListener("input", function () {
    if (requiredInput.value.trim() !== "") {
      optionalInput.disabled = false; // Active le champ
      optionalInput2.disabled = false; // Active le champ
    } else {
      optionalInput.disabled = true; // Désactive le champ
      optionalInput2.disabled = true; // Désactive le champ
    }
  });
});
