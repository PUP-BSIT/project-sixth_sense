document.addEventListener('DOMContentLoaded', function() {
    const moodButtons = document.querySelectorAll('.mood-button');
    moodButtons.forEach(button => {
        button.addEventListener('click', function() {
            fetch_data(this.dataset.mood);
        });
    });
});

function fetch_data(mood) {
    fetch(`fetch_age_emotion.php?mood=${encodeURIComponent(mood)}`)
        .then(response => response.json())
        .then(data => {
            const age_emotion_div = document.getElementById('age_emotion');
            if (data.length === 0) {
                age_emotion_div.innerHTML = '<p>No data available.</p>';
                return;
            }

            const ages = data.map(item => item.age);
            const counts = data.map(item => item.count);

            const ctx = document.getElementById('my_chart').getContext('2d');
            if (window.my_pie_chart) {
                window.my_pie_chart.destroy();
            }
            window.my_pie_chart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: ages,
                    datasets: [{
                        data: counts,
                        backgroundColor: ['#FF6384', '#36A2EB', '#FFCE56', '#4BC0C0', '#9966FF', '#FF9F40']
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: `Number of users for ${mood} mood`
                    }
                }
            });

            age_emotion_div.innerHTML = '';
            data.forEach(item => {
                const p = document.createElement('p');
                p.textContent = `Age ${item.age}: ${item.count} users`;
                age_emotion_div.appendChild(p);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}
