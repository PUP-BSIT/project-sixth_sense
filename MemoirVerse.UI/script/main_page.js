document.addEventListener("DOMContentLoaded", () => {
    const entryForm = document.getElementById("entry_form");
    const entryInput = document.getElementById("entry_input");
    const entriesContainer = document.getElementById("entries_container");
    const sortNewest = document.getElementById("sort_newest");
    const sortOldest = document.getElementById("sort_oldest");

    entryForm.addEventListener("submit", async function(event) {
        event.preventDefault();
        const entry = entryInput.value;
        try {
            const response = await fetch(
                '/project-sixth_sense/MemoirVerse.UI/diary_entries.php', 
                {
                    method: 'POST',
                    headers: {
                        'Content-Type': 
                        'application/x-www-form-urlencoded'
                    },
                    body: `entry=${encodeURIComponent(entry)}`
                }
            );
            const responseText = await response.text();
            console.log("Raw Response Text:", responseText);
            try {
                const data = JSON.parse(responseText);
                if (data.status === 'success') {
                    loadEntries();
                    entryInput.value = '';
                } else {
                    alert(data.message);
                }
            } catch (e) {
                console.error("Error parsing JSON:", e);
            }
        } catch (error) {
            console.error("Error:", error);
        }
    });

    const loadEntries = async () => {
        try {
            const response = await fetch(
                '/project-sixth_sense/MemoirVerse.UI/diary_entries.php'
            );
            const responseText = await response.text();
            console.log("Raw Response Text:", responseText);
            try {
                const data = JSON.parse(responseText);
                displayEntries(data);
            } catch (e) {
                console.error("Error parsing JSON:", e);
            }
        } catch (error) {
            console.error("Error:", error);
        }
    };

    const editEntry = async (entryId) => {
        const newContent = prompt("Edit your entry:");
        if (newContent !== null) {
            try {
                const response = await fetch(
                    '/project-sixth_sense/MemoirVerse.UI/diary_entries.php', 
                    {
                        method: 'PUT',
                        headers: {
                            'Content-Type': 
                            'application/x-www-form-urlencoded'
                        },
                        body: `entry_id=${entryId}&entry=${encodeURIComponent(
                            newContent)}`
                    }
                );
                const responseText = await response.text();
                console.log("Raw Response Text:", responseText);
                try {
                    const data = JSON.parse(responseText);
                    if (data.status === 'success') {
                        loadEntries();
                    } else {
                        alert(data.message);
                    }
                } catch (e) {
                    console.error("Error parsing JSON:", e);
                }
            } catch (error) {
                console.error("Error:", error);
            }
        }
    };

    const deleteEntry = async (entryId) => {
        if (confirm("Are you sure you want to delete this entry?")) {
            try {
                const response = await fetch(
                    '/project-sixth_sense/MemoirVerse.UI/diary_entries.php', 
                    {
                        method: 'DELETE',
                        headers: {
                            'Content-Type': 
                            'application/x-www-form-urlencoded'
                        },
                        body: `entry_id=${entryId}`
                    }
                );
                const responseText = await response.text();
                console.log("Raw Response Text:", responseText);
                try {
                    const data = JSON.parse(responseText);
                    if (data.status === 'success') {
                        loadEntries();
                    } else {
                        alert(data.message);
                    }
                } catch (e) {
                    console.error("Error parsing JSON:", e);
                }
            } catch (error) {
                console.error("Error:", error);
            }
        }
    };

    sortNewest.addEventListener('click', () => {
        fetchEntries('newest');
    });

    sortOldest.addEventListener('click', () => {
        fetchEntries('oldest');
    });

    const fetchEntries = async (sortOrder) => {
        try {
            const response = await fetch(
                `/project-sixth_sense/MemoirVerse.UI/diary_entries.php?sort=${sortOrder}`
            );
            const responseText = await response.text();
            console.log("Raw Response Text:", responseText);
            try {
                const data = JSON.parse(responseText);
                displayEntries(data);
            } catch (e) {
                console.error("Error parsing JSON:", e);
            }
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
            button.addEventListener('click', () => 
                editEntry(button.getAttribute('data-id')));
        });

        document.querySelectorAll('.delete-button').forEach(button => {
            button.addEventListener('click', () => 
                deleteEntry(button.getAttribute('data-id')));
        });
    };

    loadEntries();
});
