setTimeout(() => {
  const notificationDiv = document.querySelector("#navNotification");
  const notificationHoverDiv = document.querySelector("#navNotificationHover");

  notificationDiv.addEventListener("mouseover", () => {
    notificationHoverDiv.classList.remove("hidden");
  });
  notificationDiv.addEventListener("mouseout", () => {
    notificationHoverDiv.classList.add("hidden");
  });
  notificationHoverDiv.addEventListener("mouseover", () => {
    notificationHoverDiv.classList.remove("hidden");
  });
  notificationHoverDiv.addEventListener("mouseout", () => {
    notificationHoverDiv.classList.add("hidden");
  });
}, "200");
