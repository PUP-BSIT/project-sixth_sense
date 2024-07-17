document.addEventListener("DOMContentLoaded", function () {
  const form = document.querySelector("form");
  const password = document.getElementById("password");
  const confirmPassword = document.getElementById("confirm-password");
  const errorMessage = document.getElementById("error-message");

  form.addEventListener("submit", function (event) {
    if (!validateForm()) {
      event.preventDefault();
    }
  });

  window.validateForm = function () {
    errorMessage.textContent = ""; 

    if (!validatePassword(password.value)) {
      errorMessage.textContent =
        "Password must be at least 8 characters long and include numbers and special characters.";
      return false;
    }

    if (password.value !== confirmPassword.value) {
      errorMessage.textContent = "Passwords do not match.";
      return false;
    }

    return true;
  };

  function validatePassword(password) {
    const re = /^(?=.*[0-9])(?=.*[!@#$%^&*])[a-zA-Z0-9!@#$%^&*]{8,}$/;
    const isValid = re.test(password);
    console.log(`Password: ${password}, Valid: ${isValid}`); // Debugging line
    return isValid;
  }
});
