document.addEventListener("DOMContentLoaded", () => {
    const entryForm = document.getElementById("entry_form");
    const entryInput = document.getElementById("entry_input");
    const entryImage = document.getElementById("entry_image");
    const entriesContainer = document.getElementById("entries_container");

    entryForm.addEventListener("submit", (event) => {
        event.preventDefault();

        const entryText = entryInput.value.trim();
        if (!entryText) return;

        const file = entryImage.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = (e) => {
                const imageUrl = e.target.result;
                displayEntry(entryText, imageUrl);
            };
            reader.readAsDataURL(file);
        } else {
            displayEntry(entryText, null);
        }

        entryInput.value = '';
        entryImage.value = '';
    });

    const displayEntry = (text, imageUrl) => {
        const entryDiv = document.createElement('div');
        entryDiv.className = 'entry';
        entryDiv.innerHTML = `
            <p>${text}</p>
            ${imageUrl ? `<img src="${imageUrl}" alt="Entry Image">` : ''}
            <span class="timestamp">${new Date().toLocaleString()}</span>
            <button class="edit-button">Edit</button>
            <button class="delete-button">Delete</button>
        `;
        entriesContainer.appendChild(entryDiv);

        entryDiv.querySelector('.edit-button').addEventListener('click', () => editEntry(entryDiv));
        entryDiv.querySelector('.delete-button').addEventListener('click', () => deleteEntry(entryDiv));
    };

    const editEntry = (entryDiv) => {
        const newContent = prompt("Edit your entry:", entryDiv.querySelector('p').textContent);
        if (newContent !== null) {
            entryDiv.querySelector('p').textContent = newContent;
        }
    };

    const deleteEntry = (entryDiv) => {
        if (confirm("Are you sure you want to delete this entry?")) {
            entriesContainer.removeChild(entryDiv);
        }
    };
});
