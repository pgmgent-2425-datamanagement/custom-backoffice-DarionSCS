<h1 class="text-2xl font-bold mb-4"><?php echo $title; ?></h1>

<!-- Chart for New Releases -->
<canvas id="newReleasesChart" width="400" height="200"></canvas>

<!-- Chart for New Authors -->
<canvas id="newAuthorsChart" width="400" height="200" class="mt-8"></canvas>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
<script>
    // Prepare data for New Releases Chart
    const newReleasesLabels = <?php echo json_encode(array_column($newReleasesData, 'date')); ?>;
    const newReleasesData = <?php echo json_encode(array_column($newReleasesData, 'count')); ?>;

    // Prepare data for New Authors Chart
    const newAuthorsLabels = <?php echo json_encode(array_column($newAuthorsData, 'date')); ?>;
    const newAuthorsData = <?php echo json_encode(array_column($newAuthorsData, 'count')); ?>;

    // New Releases Chart
    const releasesCtx = document.getElementById('newReleasesChart').getContext('2d');
    const newReleasesChart = new Chart(releasesCtx, {
        type: 'bar',
        data: {
            labels: newReleasesLabels,
            datasets: [{
                label: 'New Releases in the Last 30 Days',
                data: newReleasesData,
                backgroundColor: 'rgba(54, 162, 235, 0.5)',
                borderColor: 'rgba(54, 162, 235, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: { title: { display: true, text: 'Date' }},
                y: { beginAtZero: true, title: { display: true, text: 'Number of Releases' }}
            },
            plugins: {
                legend: { display: true, position: 'top' }
            }
        }
    });

    // New Authors Chart
    const authorsCtx = document.getElementById('newAuthorsChart').getContext('2d');
    const newAuthorsChart = new Chart(authorsCtx, {
        type: 'bar',
        data: {
            labels: newAuthorsLabels,
            datasets: [{
                label: 'New Authors in the Last 30 Days',
                data: newAuthorsData,
                backgroundColor: 'rgba(75, 192, 192, 0.5)',
                borderColor: 'rgba(75, 192, 192, 1)',
                borderWidth: 1
            }]
        },
        options: {
            scales: {
                x: { title: { display: true, text: 'Date' }},
                y: { beginAtZero: true, title: { display: true, text: 'Number of Authors' }}
            },
            plugins: {
                legend: { display: true, position: 'top' }
            }
        }
    });
</script>
