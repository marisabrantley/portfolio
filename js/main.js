const button = document.querySelector('.toggle-button');

const useDark = window.matchMedia('(prefers-color-scheme: dark)');
let darkModeState = useDark.matches;

function toggleDarkMode(state) {
  document.documentElement.classList.toggle('dark-mode', state);
}

toggleDarkMode(useDark.matches);

useDark.addListener((evt) => toggleDarkMode(evt.matches));

button.addEventListener('click', () => {
  document.documentElement.classList.toggle('dark-mode');
});