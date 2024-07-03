async function fetchData() {
    const response = await fetch('fetch_data.php');
    const data = await response.json();
    return data;
}

async function createChart() {
    const data = await fetchData();

    const xValues = data.map(item => item.mood);
    const yValues = data.map(item => item.count);
    const barColors = [
        "#b91d47", "#00aba9", "#2b5797", "#e8c3b9", "#1e7145",
        "#ff9900", "#9900ff", "#ff0099", "#3399ff", "#66ff66",
        "#ff6666", "#99ff99", "#ffcc00", "#ff6699", "#66ccff",
        "#cc66ff", "#66ff99", "#ff9966", "#99ccff", "#cc99ff",
        "#66ffcc", "#ff6699", "#ccff66", "#6699ff", "#ff66cc",
        "#99ffcc", "#ccff99", "#ff99cc", "#669999", "#ff9999"
    ];

    new Chart("myChart", {
        type: "pie",
        data: {
            labels: xValues,
            datasets: [{
                backgroundColor: barColors,
                data: yValues
            }]
        },
        options: {
            title: {
                display: true,
                text: "overall mood"
            }
        }
    });
}

createChart();
