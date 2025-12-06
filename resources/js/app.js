import './bootstrap';
import Alpine from 'alpinejs';

window.Alpine = Alpine;
Alpine.start();

// small helper for flash messages
window.showFlash = (msg, type = 'info') => {
  const el = document.createElement('div');
  el.className = `fixed top-6 right-6 z-50 p-3 rounded shadow ${type === 'success' ? 'bg-green-500 text-white' : 'bg-gray-800 text-white'}`;
  el.innerText = msg;
  document.body.appendChild(el);
  setTimeout(() => el.remove(), 3500);
};
