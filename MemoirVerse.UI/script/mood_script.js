document.addEventListener('DOMContentLoaded', function () {
    const moodIcons = document.querySelectorAll('.mood-icon');
    const motivationalQuote = document.querySelector('.motivational-quote');
    const submitMoodButton = document.getElementById('submitMoodButton');
    const moodEntriesContainer = document.getElementById('mood_entries');
    let selectedMood = null;

    const quotes = {
        happy: "Keep smiling, life is beautiful!",
        content: "Stay content, happiness is within.",
        neutral: "Every day is a new opportunity.",
        sad: "It's okay to feel sad, better days are coming.",
        angry: "Take a deep breath, calmness will prevail."
    };

    moodIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            selectedMood = this.dataset.mood;
            motivationalQuote.textContent = quotes[selectedMood];
        });
    });

    submitMoodButton.addEventListener('click', function () {
        if (!selectedMood) {
            alert("Please select a mood before submitting.");
            return;
        }

        const formData = new URLSearchParams();
        formData.append('mood', selectedMood);

        fetch('mood.php', {
            method: 'POST',
            headers: {
                'Content-Type': 'application/x-www-form-urlencoded'
            },
            body: formData.toString()
        })
        .then(response => {
            if (!response.ok) {
                return response.text().then(text => { throw new Error(text) });
            }
            return response.text();
        })
        .then(text => {
            console.log('Raw response text:', text);
            text = text.trim();
            try {
                const data = JSON.parse(text);
                if (data.status === 'success') {
                    alert(data.message);
                    loadMoodEntries();
                } else {
                    alert('Error: ' + data.message);
                }
            } catch (error) {
                console.error('Error parsing JSON:', error, text);
                alert('An error occurred while processing your request.');
            }
        })
        .catch(error => {
            console.error('Fetch error:', error);
            alert('An error occurred while submitting your mood.');
        });
    });

    const loadMoodEntries = async () => {
        try {
            const response = await fetch('mood_entries.php');
            const data = await response.json();
            displayMoodEntries(data);
        } catch (error) {
            console.error('Error:', error);
        }
    };

    const displayMoodEntries = (entries) => {
        moodEntriesContainer.innerHTML = '<h2>Mood Entries</h2>';
        entries.forEach(entry => {
            const entryDiv = document.createElement('div');
            entryDiv.classList.add('entry');
            entryDiv.innerHTML = `
                <p>Mood: ${entry.mood}</p>
                <span class="timestamp">${entry.entry_date}</span>
            `;
            moodEntriesContainer.appendChild(entryDiv);
        });
    };

    loadMoodEntries();
});
