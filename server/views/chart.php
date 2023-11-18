<?php
    include("../views/base.php");

    $sql = "SELECT p.tenphim, SL_Dat
                FROM Phim p
                ORDER BY SL_Dat DESC
                LIMIT 5";
    $result = queryDB($sql);
    // Khởi tạo mảng để lưu trữ dữ liệu từ truy vấn SQL
    $labels = [];
    $data = [];

    // Lấy dữ liệu từ kết quả truy vấn và đưa vào mảng
    while ($row = mysqli_fetch_assoc($result)) {
        $labels[] = $row['tenphim'];
        $data[] = $row['SL_Dat'];
    }
?>

<div>
    <canvas id="myChart"></canvas>
</div>

<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<script>
const ctx = document.getElementById('myChart');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?php echo json_encode($labels); ?>,
        datasets: [{
            label: '# of Votes',
            data: <?php echo json_encode($data); ?>,
            borderWidth: 1
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
</script>