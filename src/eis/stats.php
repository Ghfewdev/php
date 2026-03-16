<?php

$host = "119.110.207.26";
$dbname = "eis";
$user = "pn";
$pass = "4321";

$month = $_GET['month'] ?? date('m');
$year  = $_GET['year'] ?? date('Y');

$start = "$year-$month-01";
$end   = date("Y-m-t", strtotime($start));

try {

$pdo = new PDO(
"mysql:host=$host;dbname=$dbname;charset=utf8mb4",
$user,
$pass,
[
PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION,
PDO::ATTR_DEFAULT_FETCH_MODE => PDO::FETCH_ASSOC,
PDO::ATTR_EMULATE_PREPARES => false
]);

// ---------------- QUERY หลัก ----------------

$stmt = $pdo->prepare("
SELECT 
    d.stat_date,
    d.linkname,
    s.linkinfo,
    SUM(d.click_count) AS clicks
FROM eis_stats_daily d
JOIN eis_stats s ON s.linkname = d.linkname
WHERE d.stat_date BETWEEN :start AND :end
GROUP BY d.stat_date, d.linkname, s.linkinfo
ORDER BY d.stat_date
");

$stmt->execute([
'start'=>$start,
'end'=>$end
]);

$rows = $stmt->fetchAll();


// ---------------- TOP SYSTEM ----------------

$topStmt = $pdo->prepare("
SELECT 
    d.linkname,
    s.linkinfo,
    SUM(d.click_count) total
FROM eis_stats_daily d
JOIN eis_stats s ON s.linkname = d.linkname
WHERE d.stat_date BETWEEN :start AND :end
GROUP BY d.linkname, s.linkinfo
ORDER BY total DESC
LIMIT 10
");

$topStmt->execute([
'start'=>$start,
'end'=>$end
]);

$topLinks = $topStmt->fetchAll();

}
catch (PDOException $e) {

die("Database error: ".$e->getMessage());

}


// ---------------- PREPARE DATA ----------------

$dates=[];
$systems=[];
$data=[];
$dailyTotal=[];

foreach($rows as $r){

$dates[$r['stat_date']] = true;
$systems[$r['linkname']] = $r['linkinfo'];

$dailyTotal[$r['stat_date']] = ($dailyTotal[$r['stat_date']] ?? 0) + $r['clicks'];

}

$dates = array_keys($dates);
sort($dates);


// init dataset

foreach($systems as $sys=>$label){

foreach($dates as $d){

$data[$sys][$d] = 0;

}

}


// fill real values

foreach($rows as $r){

$data[$r['linkname']][$r['stat_date']] = (int)$r['clicks'];

}


// ---------------- PASTEL COLORS ----------------

$colors = [

"cars"   => "#A8D8EA",
"datac"  => "#AA96DA",
"energy" => "#FFD3B6",
"good"   => "#FFAAA5",
"health" => "#A0E7E5",
"map"    => "#B4F8C8",
"policy" => "#FBE7C6",
"queue"  => "#D5AAFF",
"run"    => "#C7CEEA",
"smart"  => "#FFDAC1",
"tele"   => "#E2F0CB"

];


// ---------------- DATASET FOR CHART ----------------

$datasets=[];

foreach($data as $sys=>$values){

$datasets[]=[

"label"=>$systems[$sys],
"data"=>array_values($values),

"borderColor"=>$colors[$sys] ?? "#999",
"backgroundColor"=>$colors[$sys] ?? "#999",

"borderWidth"=>3,
"fill"=>false,
"tension"=>0.35

];

}


// ---------------- TOTAL MONTH ----------------

$totalClicks = array_sum($dailyTotal);

?>

<!DOCTYPE html>
<html lang="th">
<head>

<meta charset="UTF-8">
<title>EIS Statistics</title>

<script src="https://cdn.tailwindcss.com"></script>
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

</head>

<body class="bg-gray-100 text-gray-800">

<div class="min-h-screen p-6">

<h1 class="text-3xl font-bold text-center mb-6">
สถิติการเข้าชม EIS
</h1>


<!-- FILTER -->

<div class="max-w-xl mx-auto bg-white p-4 rounded shadow mb-6">

<form method="get" class="flex gap-3">

<select name="month" class="border p-2 rounded w-full">

<?php
for($m=1;$m<=12;$m++){
$mm=str_pad($m,2,'0',STR_PAD_LEFT);
$sel=($month==$mm)?'selected':'';
echo "<option value='$mm' $sel>$mm</option>";
}
?>

</select>

<select name="year" class="border p-2 rounded w-full">

<?php
$currentYear=date('Y');
for($y=$currentYear;$y>=2024;$y--){
$sel=($year==$y)?'selected':'';
echo "<option value='$y' $sel>$y</option>";
}
?>

</select>

<button class="bg-blue-500 text-white px-4 rounded">
ดูข้อมูล
</button>

</form>

</div>


<!-- DAILY SUMMARY -->

<div class="max-w-6xl mx-auto bg-white p-6 rounded shadow">

<h2 class="text-xl font-bold mb-4">
สรุปรายวัน
</h2>

<table class="w-full border">

<thead class="bg-gray-200">

<tr>

<th class="border px-3 py-2">วันที่</th>
<th class="border px-3 py-2 text-right">จำนวนการเข้าชม</th>

</tr>

</thead>

<tbody>

<?php foreach($dailyTotal as $day=>$count): ?>

<tr>

<td class="border px-3 py-2"><?=$day?></td>

<td class="border px-3 py-2 text-right font-bold">
<?=number_format($count)?>
</td>

</tr>

<?php endforeach ?>

</tbody>

</table>

</div>

<!-- GRAPH -->

<div class="max-w-6xl mx-auto bg-white p-6 rounded shadow mb-8 mt-8">

<canvas id="chart" height="120"></canvas>

</div>



<!-- SUMMARY -->

<div class="max-w-4xl mx-auto grid grid-cols-2 gap-4 mb-6 mt-8">

<div class="bg-white p-4 rounded shadow text-center">

<div class="text-gray-500">
ยอดการเข้าชมเดือนนี้
</div>

<div class="text-3xl font-bold text-green-600">
<?=number_format($totalClicks)?>
</div>

</div>

<div class="bg-white p-4 rounded shadow">

<div class="font-bold mb-2">
Top ระบบ
</div>

<?php foreach($topLinks as $t): ?>

<div class="flex justify-between text-sm">

<span><?=htmlspecialchars($t['linkinfo'])?></span>

<span class="font-bold">
<?=number_format($t['total'])?>
</span>

</div>

<?php endforeach ?>

</div>

</div>

</div>

<script>

const ctx=document.getElementById('chart');

new Chart(ctx,{

type:'line',

data:{

labels:<?=json_encode($dates)?>,

datasets:<?=json_encode($datasets,JSON_UNESCAPED_UNICODE)?>

},

options:{

responsive:true,

interaction:{mode:'index',intersect:false},

plugins:{
legend:{position:'top'}
},

scales:{
y:{beginAtZero:true}
}

}

});

</script>

</body>
</html>