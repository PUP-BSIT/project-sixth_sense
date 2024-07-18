document.addEventListener("DOMContentLoaded", function () {
  const entryForm = document.getElementById("entry_form");
  const entryInput = document.getElementById("entry_input");
  const entryImage = document.getElementById("entry_image");
  const entryImageName = document.getElementById("entry_image_name");
  const entriesContainer = document.getElementById("entries_container");
  const sortNewest = document.getElementById("sort_newest");
  const sortOldest = document.getElementById("sort_oldest");
  const submitCombinedButton = document.getElementById("submitCombinedButton");

  entryImage.addEventListener("change", function () {
    const file = this.files[0];
    entryImageName.textContent = file ? file.name : "";
  });

  submitCombinedButton.addEventListener("click", async function (event) {
    event.preventDefault();
    const entries = entryInput.value;
    const mood = document.getElementById("entry_mood").value;
    const file = entryImage.files[0];
    const formData = new FormData();
    formData.append("entry", entries);
    formData.append("mood", mood);
    if (file) {
      formData.append("entry_image", file);
    }

    try {
      const response = await fetch("entry_handler.php", {
        method: "POST",
        body: formData,
      });
      const data = await response.json();
      if (data.status === "success") {
        loadEntries();
        entryInput.value = "";
        entryImage.value = "";
        entryImageName.textContent = "";
        alert(data.message);
      } else {
        console.error(data.message);
        alert(data.message);
      }
    } catch (error) {
      console.error("Error:", error);
    }
  });

  const loadEntries = async (sortOrder = "DESC") => {
    try {
      const response = await fetch(`entry_handler.php?sort=${sortOrder}`);
      const data = await response.json();
      displayEntries(data);
    } catch (error) {
      console.error("Error:", error);
    }
  };

  const displayEntries = (entries) => {
    entriesContainer.innerHTML = "";
    entries.forEach((entry) => {
      const entryDiv = document.createElement("div");
      entryDiv.classList.add("entry");
      entryDiv.innerHTML = `
                <p>${entry.entries}</p>
                ${
                  entry.entry_image
                    ? `<img src="${entry.entry_image}" alt="Entry Image">`
                    : ""
                }
                ${entry.mood ? `<p class="mood">Mood: ${entry.mood}</p>` : ""}
                <span class="timestamp">${entry.entry_date}</span>
                <button class="edit-button" data-id="${entry.id}">Edit</button>
                <button class="delete-button" data-id="${
                  entry.id
                }">Delete</button>
            `;
      entriesContainer.appendChild(entryDiv);

      if (entry.entry_image) {
        entryDiv.querySelector("img").addEventListener("click", function () {
          showModal(entry.entry_image);
        });
      }
    });

    document.querySelectorAll(".edit-button").forEach((button) => {
      button.addEventListener("click", () =>
        editEntry(button.getAttribute("data-id"))
      );
    });

    document.querySelectorAll(".delete-button").forEach((button) => {
      button.addEventListener("click", () =>
        deleteEntry(button.getAttribute("data-id"))
      );
    });
  };

  const showModal = (imageSrc) => {
    const modal = document.getElementById("myModal");
    const modalImg = document.getElementById("img01");
    const captionText = document.getElementById("caption");

    modal.style.display = "block";
    modalImg.src = imageSrc;
    captionText.innerHTML = "";

    const span = document.getElementsByClassName("close")[0];
    span.onclick = function () {
      modal.style.display = "none";
    };
  };

  const editEntry = async (entryId) => {
    const newContent = prompt("Edit your entry:");
    if (newContent !== null) {
      try {
        const response = await fetch("entry_handler.php", {
          method: "PUT",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `entry_id=${entryId}&entry=${encodeURIComponent(newContent)}`,
        });
        const data = await response.json();
        if (data.status === "success") {
          loadEntries();
        } else {
          console.error(data.message);
          alert(data.message);
        }
      } catch (error) {
        console.error("Error:", error);
      }
    }
  };

  const deleteEntry = async (entryId) => {
    if (confirm("Are you sure you want to delete this entry?")) {
      try {
        const response = await fetch("entry_handler.php", {
          method: "DELETE",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `entry_id=${entryId}`,
        });
        const data = await response.json();
        if (data.status === "success") {
          loadEntries();
        } else {
          console.error(data.message);
          alert(data.message);
        }
      } catch (error) {
        console.error("Error:", error);
      }
    }
  };

  sortNewest.addEventListener("click", () => loadEntries("DESC"));
  sortOldest.addEventListener("click", () => loadEntries("ASC"));

  loadEntries();
});
