(function () {
  function initFloatingStickers(options) {
    const settings = options || {};
    const count = Number.isInteger(settings.count) ? settings.count : 15;
    const container = document.getElementById(settings.containerId || 'leafBg');

    if (!container) {
      return;
    }

    const stickers = Array.isArray(settings.stickers) && settings.stickers.length
      ? settings.stickers
      : ['stickers/ballon.png', 'stickers/objet.png', 'stickers/fossile.png', 'stickers/cloquettes.png'];

    for (let index = 0; index < count; index += 1) {
      const sticker = document.createElement('img');
      sticker.className = 'leaf-sticker';
      const stickerSrc = stickers[Math.floor(Math.random() * stickers.length)];
      sticker.src = stickerSrc;
      if (stickerSrc.includes('ballon.png')) {
        sticker.classList.add('no-rotate');
      }
      sticker.alt = '';
      sticker.setAttribute('aria-hidden', 'true');
      sticker.style.left = Math.random() * 100 + '%';
      sticker.style.animationDuration = (8 + Math.random() * 14) + 's';
      sticker.style.animationDelay = (Math.random() * 12) + 's';
      sticker.style.width = (20 + Math.random() * 24) + 'px';
      container.appendChild(sticker);
    }
  }

  window.initFloatingStickers = initFloatingStickers;
})();