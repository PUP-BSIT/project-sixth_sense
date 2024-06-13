document.addEventListener("DOMContentLoaded", function() {
    const form = document.getElementById("entryForm");
    const entryInput = document.getElementById("entryInput");
    const entriesContainer = document.getElementById("entriesContainer");
    const sortNewestButton = document.getElementById("sortNewest");
    const sortOldestButton = document.getElementById("sortOldest");

    const entries = [];

    form.addEventListener("submit", function(event) {
        event.preventDefault();

        const entryText = entryInput.value.trim();
        if (entryText === "") return;

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

    sortNewestButton.addEventListener("click", function() {
        sortEntries('newest');
    });

    sortOldestButton.addEventListener("click", function() {
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
