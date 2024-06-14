document.addEventListener("DOMContentLoaded", () => {
    const form = document.getElementById("entry_form");
    const entryInput = document.getElementById("entry_input");
    const entriesContainer = document.getElementById("entries_container");
    const sortNewestButton = document.getElementById("sort_newest");
    const sortOldestButton = document.getElementById("sort_oldest");

    const entries = []; 

    form.addEventListener("submit", (event) => {
        event.preventDefault(); 

        const entryText = entryInput.value.trim();
        if (!entryText) return;

        const timestamp = new Date().toLocaleString();
        const entry = {
            text: entryText,
            timestamp: timestamp,
            element: createEntryElement(entryText, timestamp)
        };

        entries.push(entry);
        entriesContainer.prepend(entry.element); 
        entryInput.value = ""; 
    });

    sortNewestButton.addEventListener("click", () => {
        sortEntries('newest');
    });

    sortOldestButton.addEventListener("click", () => {
        sortEntries('oldest');
    });

    function createEntryElement(text, timestamp) {
        const entryElement = document.createElement("div");
        entryElement.className = "entry";
        entryElement.innerHTML = `<p>${text}</p><span class="timestamp">${timestamp}</span>`;
        return entryElement;
    }

    function sortEntries(order) {
        entriesContainer.innerHTML = '';

        const sortedEntries = entries.slice().sort((a, b) => {
            const dateA = new Date(a.timestamp);
            const dateB = new Date(b.timestamp);

            return order === 'newest' ? dateB - dateA : dateA - dateB;
        });

        sortedEntries.forEach(entry => {
            entriesContainer.appendChild(entry.element);
        });
    }
});
