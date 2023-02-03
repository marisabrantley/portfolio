// Dark Mode
const button = document.getElementById('checkbox');

const useDark = window.matchMedia('(prefers-color-scheme: dark)');
let darkModeState = useDark.matches;

function toggleDarkMode(state) {
  document.documentElement.classList.toggle('dark-mode', state);
}

toggleDarkMode(useDark.matches);

useDark.addEventListener('change', (e) => toggleDarkMode(e.matches));

button.addEventListener('change', () => {
  document.body.classList.toggle('dark-mode');
});