setTimeout(() => {
  const dateInput = document.querySelector("#planning-date");
  const urlParams = new URLSearchParams(window.location.search);
  const dateParams = urlParams.get("date");

  dateInput.setAttribute("min", new Date().toISOString().split("T")[0]);

  if (dateParams) {
    dateInput.value = dateParams;
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
}, "200");
