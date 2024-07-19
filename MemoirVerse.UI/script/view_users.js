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
            
            const monthNames = ["January", "February", "March", "April", "May", "June", 
                                "July", "August", "September", "October", "November", "December"];

            const title = month === 'all' ? 'Registered Users for All Months' : `Registered Users by ${monthNames[parseInt(month) - 1]}`;
            
            if (data.length === 0) {
                console.warn('No users found.');
                user_list_div.innerHTML = `<h2>${title}</h2><hr class="black-line"><p>No users found.</p>`;
                if (window.myChart) {
                    window.myChart.destroy();
                }
                return;
            }

            user_list_div.innerHTML = `<h2>${title}</h2><hr class="black-line">`;
            if (window.myChart) {
                window.myChart.destroy();
            }

            const userCounts = Array(12).fill(0);

            const table = document.createElement('table');
            const thead = document.createElement('thead');
            const tbody = document.createElement('tbody');
            table.appendChild(thead);
            table.appendChild(tbody);

            const headerRow = document.createElement('tr');
            const thUserId = document.createElement('th');
            thUserId.textContent = 'User ID';
            const thDate = document.createElement('th');
            thDate.textContent = 'Date';
            headerRow.appendChild(thUserId);
            headerRow.appendChild(thDate);
            thead.appendChild(headerRow);

            data.forEach(user => {
                const row = document.createElement('tr');
                const tdUserId = document.createElement('td');
                tdUserId.textContent = user.user_id;
                const tdDate = document.createElement('td');
                tdDate.textContent = user.date;
                row.appendChild(tdUserId);
                row.appendChild(tdDate);
                tbody.appendChild(row);

                const userMonth = new Date(user.date).getMonth();
                userCounts[userMonth]++;
            });

            user_list_div.appendChild(table);

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