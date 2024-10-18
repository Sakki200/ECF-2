setTimeout(() => {
  const uploadBtn = document.getElementById("upload-btn");
  const fileInput = document.getElementById("file");
  const form = document.getElementById("profile-img-form");

  uploadBtn.addEventListener("click", (e) => {
    fileInput.click();
  });
  
  fileInput.addEventListener("change", () => {
    if (fileInput.files.length > 0 && fileInput.files.length < 2) {
      form.removeAttribute("onsubmit"); // Autorise la soumission
      form.submit(); // Soumet le formulaire uniquement si un fichier est sélectionné
    }
  });
}, "200");
