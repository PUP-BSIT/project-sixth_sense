function fetch_users() {
    const month = document.getElementById('month_picker').value;

    let url = 'fetch_users.php';  
    if (month && month !== 'all') {
        url += `?month=${encodeURIComponent(month)}`;
    }

    fetch(url)
        .then(response => {
            if (!response.ok) {
                throw new Error('Network response was not ok');
            }
            return response.json();
        })
        .then(data => {
            console.log(data);  
            const user_list_div = document.getElementById('user_list');
            const chart_container = document.getElementById('chart_container');
            
            if (data.length === 0) {
                console.warn('No users found.');
                user_list_div.innerHTML = '<p>No users found.</p>';
                if (window.myChart) {
                    window.myChart.destroy();
                }
                return;
            }

            user_list_div.innerHTML = '';
            if (window.myChart) {
                window.myChart.destroy();
            }

            const monthNames = ["January", "February", "March", "April", "May", "June", 
                                "July", "August", "September", "October", "November", "December"];
            const userCounts = Array(12).fill(0);

            data.forEach(user => {
                const p = document.createElement('p');
                p.textContent = `User ID: ${user.user_id}, Registered on: ${user.date}`;
                user_list_div.appendChild(p);

                const userMonth = new Date(user.date).getMonth();
                userCounts[userMonth]++;
            });

            const xValues = monthNames;
            const yValues = userCounts;

            const ctx = document.getElementById('user_chart').getContext('2d');
            window.myChart = new Chart(ctx, {
                type: 'line',
                data: {
                    labels: xValues,
                    datasets: [{
                        backgroundColor: "rgba(0,0,255,0.1)",
                        borderColor: "rgba(0,0,255,1.0)",
                        data: yValues,
                        fill: true,
                        lineTension: 0,
                        pointBackgroundColor: "rgba(0,0,255,1.0)",
                        pointRadius: 5,
                    }]
                },
                options: {
                    scales: {
                        x: {
                            beginAtZero: true
                        },
                        y: {
                            beginAtZero: true
                        }
                    },
                    plugins: {
                        legend: {
                            display: false
                        }
                    },
                    responsive: true,
                    maintainAspectRatio: false,
                }
            });
        })
        .catch(error => console.error('Error fetching data:', error));
}

window.onload = fetch_users;
