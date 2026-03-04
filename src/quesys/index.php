<?php
session_start();

if (!isset($_SESSION['us_id'])) {
    header("Location: login.php");
    exit();
}
?>

<!-- 
index.html                      → 🖥 PC แนวนอน (เหมือนเดิม)
index.html?mode=tv              → 📺 TV แนวนอน (เหมือนเดิม)
index.html?layout=vt            → 🖥 PC แนวตั้ง (ไม่ auto scroll)
index.html?mode=tv&layout=vt    → 📺 TV แนวตั้ง (scroll เฉพาะคลินิก) 
-->

<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8" />
  <title>Dashboard - สถานะคิวผู้ป่วย </title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="./config.js?v=2"></script>

  <script>
    tailwind.config = {
      theme: {
        extend: {
          colors: {
            waiting: '#f59e0b',
            done: '#22c55e',
            total: '#3b82f6',
            summary: '#0f172a'
          }
        }
      }
    }
  </script>
</head>

<body class="bg-gray-100 min-h-screen text-lg">

<!-- ================= HEADER ================= -->
<header class="bg-white shadow-md px-6 py-4 flex items-center justify-between">
  <div class="flex items-center gap-4">
    <div id="app">
    
  </div>
    <div>
      <h1 class="text-2xl font-bold text-gray-800">
        ระบบแสดงสถานะคิวผู้ป่วย <span class="me-3">
                 <?= $_SESSION['us_dv'] ?>
            </span>
      </h1>
      <p class="text-sm text-gray-500">Dashboard ภาพรวมการให้บริการ</p>
    </div>
  </div>

  <div class="text-right">
    <p class="text-sm text-gray-500">วันเวลาปัจจุบัน</p>
    <p id="datetime" class="text-xl font-semibold text-blue-600"></p>
  </div>
</header>

<!-- ================= SUMMARY ================= -->
<section class="bg-summary text-white px-6 py-4">
  <div id="summaryGrid"
    class="grid grid-cols-2 md:grid-cols-5 gap-4 text-center">
    <div>
      <p id="sumWaiting" class="text-3xl font-bold">0</p>
      <p class="opacity-80">รอทั้งหมด</p>
    </div>
    <div>
      <p id="sumDone" class="text-3xl font-bold text-green-400">0</p>
      <p class="opacity-80">เสร็จแล้ว</p>
    </div>
    <div>
      <p id="sumTotal" class="text-3xl font-bold text-blue-400">0</p>
      <p class="opacity-80">ทั้งหมด</p>
    </div>
    <div>
      <p id="sumPercent" class="text-3xl font-bold text-yellow-400">0%</p>
      <p class="opacity-80">ความคืบหน้า</p>
    </div>
    <div>
      <p id="sumAvg" class="text-3xl font-bold text-pink-400">0</p>
      <p class="opacity-80">เวลารอเฉลี่ย (นาที)</p>
    </div>
  </div>
</section>

<!-- ================= CONTENT ================= -->
<main class="p-6">

  <!-- ===== แนวนอน (PC + TV เดิม) ===== -->
  <section id="horizontalSection"
    class="bg-white rounded-xl shadow-lg p-4 overflow-hidden">
    <h2 class="text-xl font-bold mb-3 px-2">🏥 สถานะคิวรายคลินิก</h2>

    <!-- PC -->
    <div id="pcList"
      class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6"></div>

    <!-- TV -->
    <div id="tvWrapper" class="relative overflow-hidden hidden">
      <div id="clinicBanner" class="flex gap-6 py-4"></div>
    </div>
  </section>

  <!-- ===== แนวตั้ง (scroll เฉพาะคลินิก) ===== -->
  <section id="verticalSection" class="hidden">
    <div id="verticalList"
      class="grid grid-cols-1 gap-4 p-4 overflow-y-auto"
      style="height: calc(100vh - 230px);">
    </div>
  </section>

</main>

<!-- ================= SCRIPT ================= -->
<script src="./app.js?v=1>"></script>

</body>
</html>
