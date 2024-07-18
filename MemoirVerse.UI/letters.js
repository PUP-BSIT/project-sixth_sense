document.addEventListener("DOMContentLoaded", function () {
  const letterForm = document.getElementById("letterForm");
  const messageDiv = document.getElementById("message");
  const lettersDiv = document.getElementById("letters");

  letterForm.addEventListener("submit", function (event) {
    event.preventDefault();
    const formData = new FormData(letterForm);

    fetch("submit_letter.php", {
      method: "POST",
      body: formData,
    })
      .then((response) => response.json())
      .then((data) => {
        if (data.success) {
          messageDiv.textContent = "Letter submitted successfully!";
          fetchLetters();
        } else {
          messageDiv.textContent = data.error;
        }
      })
      .catch((error) => {
        messageDiv.textContent = "An error occurred. Please try again.";
        console.error("Error:", error);
      });
  });

  function fetchLetters() {
    fetch("get_letters.php")
      .then((response) => response.json())
      .then((data) => {
        lettersDiv.innerHTML = "";
        data.letters.forEach((letter) => {
          const letterDiv = document.createElement("div");
          letterDiv.className = "letter";
          letterDiv.innerHTML = `
            <div class="closed-envelope" style="display: block;">
              <h2 class="title">${letter.title}</h2>
            </div>
            <div class="open-letter" style="display: none;">
              <h2>${letter.title}</h2>
              <p>${letter.content}</p>
              <div class="timestamp">${letter.created_at}</div>
            </div>`;
          letterDiv.addEventListener("click", function () {
            toggleLetter(letterDiv);
          });
          lettersDiv.appendChild(letterDiv);
        });
      });
  }

  function toggleLetter(element) {
    const closedEnvelope = element.querySelector(".closed-envelope");
    const openLetter = element.querySelector(".open-letter");

    if (closedEnvelope.style.display === "none") {
      closedEnvelope.style.display = "block";
      openLetter.style.display = "none";
    } else {
      closedEnvelope.style.display = "none";
      openLetter.style.display = "block";
    }
  }

  fetchLetters();
});
