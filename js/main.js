// Dark Mode


const button = document.getElementById('checkbox');

// Create MediaQueryList object
const useDark = window.matchMedia('(prefers-color-scheme: dark)');
let darkModeState = useDark.matches;

function toggleDarkMode(state) {
  document.documentElement.classList.toggle('dark-mode', state);
}
// Dark Mode Applied If User Has Dark Mode Enabled
toggleDarkMode(useDark.matches);

//Listen for Changes in the OS Settings and Users Toggle Choice
useDark.addEventListener('change', (evt) => toggleDarkMode(evt.matches));

button.addEventListener('change', () => {
  document.documentElement.classList.toggle('dark-mode');
});