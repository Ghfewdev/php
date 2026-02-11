<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <title>EIS MSD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <!-- Tailwind CDN -->
  <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100 text-gray-800">

  <div class="min-h-screen flex flex-col items-center justify-center">

    <div class="p-3 mt-10">
      <p class="text-5xl font-bold">EIS MSD</p>
    </div>

    <br><br>

    <div class="grid grid-cols-2 lg:grid-cols-3">

      <!-- ตรวจสุขภาพ -->
      <a href="click.php?id=health" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
          <img src="images/health.png" alt="health" width="120" height="120">
          <h1 class="text-lg font-bold mt-2">ตรวจสุขภาพ</h1>
        </div>
      </a>

      <!-- วิ่งล้อมเมือง -->
      <a href="click.php?id=run" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
          <img src="images/run.png" alt="run" width="120" height="120">
          <h1 class="text-lg font-bold mt-2">วิ่งล้อมเมือง</h1>
        </div>
      </a>

      <!-- Health Map -->
      <a href="click.php?id=map" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
          <img src="images/map.png" alt="map" width="120" height="120">
          <h1 class="text-lg font-bold mt-2">Health Map</h1>
        </div>
      </a>

      <!-- Policy Tracking -->
      <a href="click.php?id=policy" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
          <img src="images/policy.png" alt="policy" width="120" height="120">
          <h1 class="text-lg font-bold mt-2">Policy Tracking</h1>
        </div>
      </a>

      <!-- ความพึงพอใจ -->
      <a href="click.php?id=good" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
          <img src="images/good.png" alt="good" width="120" height="120">
          <h1 class="text-lg font-bold mt-2">ความพึงพอใจ</h1>
        </div>
      </a>

      <!-- Smart IPD -->
      <a href="click.php?id=smart" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
          <img src="images/smart.png" alt="smart" width="120" height="120">
          <h1 class="text-lg font-bold mt-2">Smart IPD</h1>
        </div>
      </a>

      <!-- Data Center -->
      <a href="click.php?id=datac" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
          <img src="images/data.png" alt="data" width="120" height="120">
          <h1 class="text-lg font-bold mt-2">Data Center</h1>
        </div>
      </a>

      <!-- งบประมาณ -->
      <a href="click.php?id=budget" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
          <img src="images/budget.png" alt="budget" width="120" height="120">
          <h1 class="text-lg font-bold mt-2">งบประมาณ</h1>
        </div>
      </a>

      <!-- BHZ -->
      <a href="click.php?id=bhz" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
          <img src="images/bhz.png" alt="bhz" width="120" height="120">
          <h1 class="text-lg font-bold mt-2">BHZ</h1>
        </div>
      </a>

      <!-- Telemedicine -->
      <a href="click.php?id=tele" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
          <img src="images/tele.png" alt="tele" width="120" height="120">
          <h1 class="text-lg font-bold mt-2">Telemedicine</h1>
        </div>
      </a>

      <!-- รถรับส่ง -->
      <a href="click.php?id=cars" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
          <img src="images/cars.png" alt="cars" width="120" height="120">
          <h1 class="text-lg font-bold text-center">
            รถรับส่ง<br>คนพิการ-ผู้สูงอายุ
          </h1>
        </div>
      </a>

     <!-- ระบบคิว -->
<!-- Icon: Hospital Queue System -->
      <a href="click.php?id=queue" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
        <img src="images/queue1.png" alt="cars" width="120" height="120">
          <h1 class="text-lg font-bold text-center">
            ระบบคิวโรงพยาบาล
          </h1>
        </div>
      </a>

     <!-- พลังงาน -->
<a href="click.php?id=energy" target="_blank" class="px-6 py-2">
        <div class="flex flex-col items-center justify-center pb-4">
        <img src="images/energy.png" alt="cars" width="120" height="120">
          <h1 class="text-lg font-bold text-center">
            รายงานพลังงาน
          </h1>
        </div>
      </a>

    </div>

    <br><br>

  </div>
<center style="margin: 10px;">
<div class="flex justify-center mt-12">
  <a href="stats.php"
     target="_blank"
     class="inline-flex items-center gap-2
            bg-green-600 hover:bg-green-700
            text-yellow-300 font-semibold
            px-8 py-4 rounded-xl
            shadow-lg hover:shadow-xl
            transition duration-200">

    <!-- Icon -->
    <svg class="w-6 h-6" fill="currentColor" viewBox="0 0 24 24">
      <path d="M3 3h2v18H3V3zm16 8h2v10h-2V11zM11 13h2v8h-2v-8zM7 9h2v12H7V9zm8-6h2v18h-2V3z"/>
    </svg>

    สถิติการเข้าชม
  </a>
</div></center>
<br><br><br><br><br>
</body>
</html>