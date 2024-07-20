function fetch_data() {
    const gender = document.getElementById('gender_picker').value;

    let url = 'fetch_mood.php';
    if (gender) {
        url += `?gender=${encodeURIComponent(gender)}`;
    }

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            const mood_counts_div = document.getElementById('mood_counts');
            if (data.length === 0) {
                console.warn('No mood data available for the selected gender.');
                mood_counts_div.innerHTML = '<p>No mood data available for the selected gender.</p>';
                if (window.my_pie_chart) {
                    window.my_pie_chart.destroy();
                }
                return;
            }

            const labels = data.map(item => item.mood);
            const values = data.map(item => item.count);

            const colors = getComputedStyle(document.documentElement)
                .getPropertyValue('--chart-colors')
                .trim()
                .split(',');

            const ctx = document.getElementById('my_chart').getContext('2d');
            if (window.my_pie_chart) {
                window.my_pie_chart.destroy();
            }
            window.my_pie_chart = new Chart(ctx, {
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
                        text: `Mood Reactions ${gender ? 'for ' + gender : ''}`
                    }
                }
            });

            mood_counts_div.innerHTML = '';
            data.forEach(item => {
                const p = document.createElement('p');
                p.textContent = `There are ${item.count} people that are ${item.mood}${gender ? ' of gender ' + gender : ''}.`;
                mood_counts_div.appendChild(p);
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}