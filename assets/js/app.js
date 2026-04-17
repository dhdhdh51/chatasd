document.querySelectorAll('[data-mobile-toggle]').forEach((btn) => {
  btn.addEventListener('click', () => {
    const target = document.querySelector(btn.dataset.mobileToggle);
    if (target) target.classList.toggle('open');
  });
});

setInterval(async () => {
  const holder = document.querySelector('[data-notification-feed]');
  if (!holder) return;
  const res = await fetch('/auth/notifications.php');
  const html = await res.text();
  holder.innerHTML = html;
}, 15000);
