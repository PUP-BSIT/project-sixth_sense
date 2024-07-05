document.addEventListener("DOMContentLoaded", function() {
    const entryForm = document.getElementById("entry_form");
    const entryInput = document.getElementById("entry_input");
    const entriesContainer = document.getElementById("entries_container");

    entryForm.addEventListener("submit", async (e) => {
        e.preventDefault();
        const entry = entryInput.value.trim();
        const entryId = entryInput.dataset.id;  // Retrieve the entry ID from the dataset

        if (!entry) {
            alert("Entry cannot be empty");
            return;
        }

        const payload = {
            entry: entry
        };

        let method = 'POST';
        let url = 'diary_entries.php';

        if (entryId) {
            method = 'PUT';
            payload.entry_id = entryId;  // Add entry_id to the payload
        }

        try {
            const response = await fetch(url, {
                method: method,
                headers: {
                    'Content-Type': 'application/json'
                },
                body: JSON.stringify(payload)
            });
            const data = await response.json();
            if (data.status === 'success') {
                loadEntries();
                entryInput.value = '';
                delete entryInput.dataset.id;  // Clear the dataset
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });

    const loadEntries = async () => {
        try {
            const response = await fetch('diary_entries.php');
            const data = await response.json();
            displayEntries(data);
        } catch (error) {
            console.error("Error:", error);
        }
    };

    const displayEntries = (entries) => {
        entriesContainer.innerHTML = '';
        entries.forEach(entry => {
            const entryDiv = document.createElement('div');
            entryDiv.classList.add('entry');
            entryDiv.innerHTML = `
                <p>${entry.entry}</p>
                <span class="timestamp">${entry.entry_date}</span>
                <button class="edit-button" data-id="${entry.entry_id}">Edit</button>
                <button class="delete-button" data-id="${entry.entry_id}">Delete</button>
            `;
            entriesContainer.appendChild(entryDiv);
        });

        document.querySelectorAll('.edit-button').forEach(button => {
            button.addEventListener('click', () => editEntry(button.getAttribute('data-id')));
        });

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', () => deleteEntry(button.getAttribute('data-id')));
        });
    };

    const editEntry = (id) => {
        const entryToEdit = document.querySelector(`.edit-button[data-id="${id}"]`).closest('.entry');
        const entryText = entryToEdit.querySelector('p').textContent;
        entryInput.value = entryText;
        entryInput.dataset.id = id;  // Set the entry ID in the dataset
    };

    const deleteEntry = async (id) => {
        try {
            const response = await fetch('diary_entries.php', {
                method: 'DELETE',
                body: JSON.stringify({ entry_id: id }),
                headers: {
                    'Content-Type': 'application/json'
                }
            });
            const data = await response.json();
            if (data.status === 'success') {
                loadEntries();
            } else {
                alert(data.message);
            }
        } catch (error) {
            console.error("Error:", error);
        }
    };

    loadEntries();
});
