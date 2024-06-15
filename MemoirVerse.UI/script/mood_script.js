document.addEventListener('DOMContentLoaded', function () {
    const moodIcons = document.querySelectorAll('.mood-icon');
    const motivationalQuote = document.querySelector('.motivational-quote');

    const quotes = {
        happy: "Keep smiling, life is beautiful!",
        content: "Stay content, happiness is within.",
        neutral: "Every day is a new opportunity.",
        sad: "It's okay to feel sad, better days are coming.",
        angry: "Take a deep breath, calmness will prevail."
    };

    moodIcons.forEach(icon => {
        icon.addEventListener('click', function () {
            const mood = this.dataset.mood;
            motivationalQuote.textContent = quotes[mood];

            const xhr = new XMLHttpRequest();
            xhr.open('POST', 'mood.php', true);
            xhr.setRequestHeader('Content-Type', 'application/x-www-form-urlencoded');
            xhr.onreadystatechange = function () {
                if (xhr.readyState === XMLHttpRequest.DONE) {
                    if (xhr.status === 200) {
                        console.log(xhr.responseText);
                    } else {
                        console.error('Error occurred:', xhr.statusText);
                    }
                }
            };
            xhr.send('mood=' + mood);
        });
    });
});
