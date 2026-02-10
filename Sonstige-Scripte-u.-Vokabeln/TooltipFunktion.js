function showInfoBox(text, duration = 4000) {
  let infoBox = document.getElementById('infoBox');

  if (!infoBox) {
    infoBox = document.createElement('div');
    infoBox.id = 'infoBox';
    infoBox.className = 'info-box';
    document.body.appendChild(infoBox);

    infoBox.addEventListener('click', () => {
      infoBox.classList.remove('show');
    });
  }

  infoBox.textContent = text;
  infoBox.classList.add('show');

  setTimeout(() => {
    infoBox.classList.remove('show');
  }, duration);
}
