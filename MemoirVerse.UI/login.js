document.querySelector("form").addEventListener("submit", function (event) {
  event.preventDefault();

  var emailInput = document.querySelector('input[type="email"]');
  var passwordInput = document.querySelector('input[type="password"]');

  if (emailInput.value === "") {
    alert("Please enter your email.");
    return;
  }
  if (passwordInput.value === "") {
    alert("Please enter your password.");
    return;
  }

  this.submit();
});
