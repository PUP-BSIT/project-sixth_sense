function fetchData() {
    const date = document.getElementById('datepicker').value;
    if (!date) return;

    fetch(`fetch_mood.php?date=${date}`)
        .then(response => response.json())
        .then(data => {
            if (data.length === 0) {
                console.warn(
                    'No mood data available for the selected date.'
                    );
                const moodCountsDiv = document.getElementById(
                    'mood_counts');
                moodCountsDiv.innerHTML =
                    '<p>No mood data available for the selected date.</p>';
                if (window.myPieChart) {
                    window.myPieChart.destroy();
                }
                return;
            }

            const labels = data.map(item => item.mood);
            const values = data.map(item => item.count);

            const colors = getComputedStyle(document
                    .documentElement)
                .getPropertyValue('--chart-colors')
                .trim()
                .split(',');

            const ctx = document.getElementById('myChart')
                .getContext('2d');
            if (window.myPieChart) {
                window.myPieChart.destroy();
            }
            window.myPieChart = new Chart(ctx, {
                type: 'pie',
                data: {
                    labels: labels,
                    datasets: [{
                        data: values,
                        backgroundColor: colors
                    }]
                },
                options: {
                    title: {
                        display: true,
                        text: `Mood Reactions on ${date}`
                    }
                }
            });

            const moodCountsDiv = document.getElementById(
                'mood_counts');
            moodCountsDiv.innerHTML = '';
            data.forEach(item => {
                const p = document.createElement('p');
                p.textContent =
                    `During this day, there are ${item.count} people that are ${item.mood}`;
                moodCountsDiv.appendChild(p);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}