const ctx = document.getElementById('myChart');

fetch("script.php")
  .then((response) => response.json())
  .then((data) => {
    createChart(data, 'bar');
  });

function createChart(chartData, type){
  new Chart(ctx, {
    type,
    data: {
      labels: chartData.map(rev => rev.dateAdded),
      datasets: [{
        label: '# of Reviews',
        data: chartData.map(rev => rev.count),
        borderWidth: 1,
        backgroundColor: 'rgba(75, 192, 192, 0.5)',
        borderColor: 'rgba(75, 192, 192, 1)'
      }]
    },
    options: {
      scales: {
        y: {
          beginAtZero: true
        }
      }
    }
  }); 
}
