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


const constraints = {
  name: {
      presence: {allowEmpty: false}
  },
  email: {
      presence: {allowEmpty: false},
      email: true
  },
  message: {
      presence: {allowEmpty: false}
  }
};

const form = document.getElementById('contact-form');

form.addEventListener('submit', function (event) {
  const formValues = {
      name: form.elements.name.value,
      email: form.elements.email.value,
      message: form.elements.message.value
  };

  const errors = validate(formValues, constraints);

  if (errors) {
      event.preventDefault();
      const errorMessage = Object
          .values(errors)
          .map(function (fieldValues) {
              return fieldValues.join(', ')
          })
          .join("\n");

      alert(errorMessage);
  }
}, false);

function onRecaptchaSuccess () {
  document.getElementById('contact-form').submit()
}