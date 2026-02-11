<?php
// --------------------
// Database config
// --------------------
$host = "119.110.207.26";
$dbname = "eis";
$user = "pn";
$pass = "4321";

try {
    $pdo = new PDO(
        "mysql:host=$host;dbname=$dbname;charset=utf8",
        $user,
        $pass,
        [
            PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
            PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC
        ]
    );

    // ดึงชื่อภาษาไทย + จำนวนคลิก
    $stmt = $pdo->query(
        "SELECT linkinfo, linkcount 
         FROM eis_stats 
         ORDER BY linkcount DESC"
    );
    $stats = $stmt->fetchAll();

} catch (PDOException $e) {
    die("Database error");
}

// เตรียมข้อมูลสำหรับกราฟ
$labels = [];
$data   = [];

foreach ($stats as $row) {
    $labels[] = $row['linkinfo'];
    $data[]   = $row['linkcount'];
}
?>
<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>EIS Statistics</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">

  <!-- Tailwind -->
  <script src="https://cdn.tailwindcss.com"></script>

  <!-- Chart.js -->
  <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>
</head>
<body class="bg-gray-100 text-gray-800">

<div class="min-h-screen p-6">

  <h1 class="text-3xl font-bold mb-6 text-center">
    สถิติการเข้าชม
  </h1>

  <!-- กราฟ -->
  <div class="max-w-4xl mx-auto bg-white rounded-lg shadow p-6 mb-8">
    <canvas id="clickChart" height="120"></canvas>
  </div>

  <!-- ตาราง -->
  <div class="max-w-3xl mx-auto bg-white rounded-lg shadow p-6">
    <table class="w-full border-collapse">
      <thead>
        <tr class="bg-gray-200">
          <th class="border px-4 py-2 text-left">#</th>
          <th class="border px-4 py-2 text-left">ชื่อระบบ</th>
          <th class="border px-4 py-2 text-right">จำนวนเข้าชม</th>
        </tr>
      </thead>
      <tbody>
        <?php if (count($stats) > 0): ?>
          <?php $i = 1; foreach ($stats as $row): ?>
            <tr class="hover:bg-gray-50">
              <td class="border px-4 py-2"><?= $i++ ?></td>
              <td class="border px-4 py-2 font-medium">
                <?= htmlspecialchars($row['linkinfo']) ?>
              </td>
              <td class="border px-4 py-2 text-right font-bold">
                <?= number_format($row['linkcount']) ?>
              </td>
            </tr>
          <?php endforeach; ?>
        <?php else: ?>
          <tr>
            <td colspan="3" class="text-center py-4 text-gray-500">
              ยังไม่มีข้อมูลการเข้าชม
            </td>
          </tr>
        <?php endif; ?>
      </tbody>
    </table>
  </div>

</div>

<script>
const ctx = document.getElementById('clickChart').getContext('2d');

new Chart(ctx, {
    type: 'bar',
    data: {
        labels: <?= json_encode($labels, JSON_UNESCAPED_UNICODE) ?>,
        datasets: [{
            label: 'จำนวนคลิก',
            data: <?= json_encode($data) ?>,
            backgroundColor: 'rgba(34, 197, 94, 0.7)',
            borderColor: 'rgba(34, 197, 94, 1)',
            borderWidth: 1
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: { display: false }
        },
        scales: {
            y: {
                beginAtZero: true,
                ticks: { precision: 0 }
            }
        }
    }
});
</script>

</body>
</html>
