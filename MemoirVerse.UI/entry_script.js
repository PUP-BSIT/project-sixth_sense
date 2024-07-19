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
      const response = await fetch("./entry_handler.php", {
        method: "POST",
        body: formData,
      });
      const text = await response.text();
      const data = JSON.parse(text);

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
      const response = await fetch(`./entry_handler.php?sort=${sortOrder}`);
      const text = await response.text();
      const data = JSON.parse(text);

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
        <button class="delete-button" data-id="${entry.id}">Delete</button>
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

  // Edit modal handling
  const editModal = document.getElementById("editModal");
  const editEntryInput = document.getElementById("editEntryInput");
  const saveEditButton = document.getElementById("saveEditButton");
  let currentEditEntryId = null;

  document.querySelector(".edit-close").onclick = function () {
    editModal.style.display = "none";
  };

  window.onclick = function (event) {
    if (event.target == editModal) {
      editModal.style.display = "none";
    }
  };

  const editEntry = async (entryId) => {
    currentEditEntryId = entryId;
    const entryText = document
      .querySelector(`[data-id='${entryId}']`)
      .parentElement.querySelector("p").innerText;
    editEntryInput.value = entryText;
    editModal.style.display = "block";
  };

  saveEditButton.addEventListener("click", async function () {
    const newContent = editEntryInput.value;
    if (newContent !== "") {
      try {
        const response = await fetch("./entry_handler.php", {
          method: "PUT",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `entry_id=${currentEditEntryId}&entry=${encodeURIComponent(
            newContent
          )}`,
        });
        const text = await response.text();
        const data = JSON.parse(text);

        if (data.status === "success") {
          loadEntries();
          editModal.style.display = "none";
        } else {
          console.error(data.message);
          alert(data.message);
        }
      } catch (error) {
        console.error("Error:", error);
      }
    }
  });

  const deleteModal = document.getElementById("deleteModal");
  const confirmDeleteButton = document.getElementById("confirmDeleteButton");
  const cancelDeleteButton = document.getElementById("cancelDeleteButton");
  let currentDeleteEntryId = null;

  document.getElementById("deleteClose").onclick = function () {
    deleteModal.style.display = "none";
  };

  cancelDeleteButton.addEventListener("click", () => {
    deleteModal.style.display = "none";
  });

  confirmDeleteButton.addEventListener("click", async function () {
    if (currentDeleteEntryId) {
      try {
        const response = await fetch("./entry_handler.php", {
          method: "DELETE",
          headers: {
            "Content-Type": "application/x-www-form-urlencoded",
          },
          body: `entry_id=${currentDeleteEntryId}`,
        });
        const text = await response.text();
        const data = JSON.parse(text);

        if (data.status === "success") {
          loadEntries();
          deleteModal.style.display = "none";
        } else {
          console.error(data.message);
          alert(data.message);
        }
      } catch (error) {
        console.error("Error:", error);
      }
    }
  });

  const deleteEntry = (entryId) => {
    currentDeleteEntryId = entryId;
    deleteModal.style.display = "block";
  };

  sortNewest.addEventListener("click", () => loadEntries("DESC"));
  sortOldest.addEventListener("click", () => loadEntries("ASC"));

  loadEntries();
});
