document.addEventListener("DOMContentLoaded", () => {
  const dateInput = document.querySelector("#reservation_date_reservation");
  const startInput = document.querySelector("#reservation_start");
  const endInput = document.querySelector("#reservation_end_reservation");
  const urlParams = new URLSearchParams(window.location.search);
  const dateParams = urlParams.get("date");
  
  dateInput.setAttribute("min", new Date().toISOString().split("T")[0]);
  startInput.disabled = true; // Active le champ
  endInput.disabled = true;

  if (dateParams) {
    const dateChosen = dateParams;
    dateInput.value = dateChosen;
    console.log(dateInput.value);

    startInput.disabled = false; // Active le champ
    endInput.disabled = false; // Active le champ
  }

  // Active le champ optionnel si le champ requis est rempli
  dateInput.addEventListener("change", () => {
    // Obtenir l'URL actuelle
    const currentUrl = new URL(window.location.href);

    // Ajouter ou mettre à jour le paramètre
    currentUrl.searchParams.set("date", dateInput.value);

    // Rafraîchir la page avec la nouvelle URL
    window.location.href = currentUrl.toString();
  });
});
