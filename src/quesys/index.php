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
  <title>Dashboard - สถานะคิวผู้ป่วย</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0" />

  <script src="https://cdn.tailwindcss.com"></script>
  <script src="./config.js?v=9"></script>

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

<body class="bg-gray-100 min-h-screen">

<!-- HEADER -->
<header id="header" class="bg-green-50 shadow px-4 py-2 flex items-center justify-between">
  <div class="flex items-center gap-3">
    <div id="app"></div>
    <div>
      <h1 class="text-lg md:text-xl font-bold text-gray-800">
        ระบบแสดงสถานะคิวผู้ป่วย
      </h1>
      <p class="text-xs text-gray-500">
        <span class="me-3"><?= $_SESSION['us_dv'] ?></span>
      </p>
    </div>
  </div>

  <div class="text-right">
    <p class="text-xs text-gray-500">วันเวลาปัจจุบัน</p>
    <p id="datetime" class="text-sm md:text-lg font-semibold text-blue-600"></p>
  </div>
</header>

<button
onclick="toggleUpload()"
class="absolute top-2 ligth-2 text-gray-300 hover:text-gray-700 text-sm"
>
⚙
</button>

<div id="uploadPanel"
class="hidden absolute top-10 ligth-2 bg-white border p-3 rounded shadow text-xs grid grid-cols-2 gap-1">

  <button class="px-3 py-1 text-sm rounded bg-green-500 text-white block m-2"
    onclick="setc()">เลือกคลินิกแสดงผล</button>

    <div>
      <div class="bottom-4 right-4 flex gap-2 bg-white shadow-lg rounded-xl p-2 border">
  <button 
    onclick="zoomIn()" 
    class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 active:scale-95 transition"
  >
    +
  </button>

  <button 
    onclick="zoomOut()" 
    class="px-3 py-2 bg-blue-500 text-white rounded-lg hover:bg-blue-600 active:scale-95 transition"
  >
    -
  </button>

  <button 
    onclick="resetZoom()" 
    class="px-3 py-2 bg-gray-500 text-white rounded-lg hover:bg-gray-600 active:scale-95 transition"
  >
    Reset
  </button>
  
</div>

<script>
  let zoomLevel = 100;

  const MIN_ZOOM = 50;
  const MAX_ZOOM = 200;

  function applyZoom() {
  const scale = zoomLevel / 100;
  const app = document.getElementById("app1");

  app.style.zoom = zoomLevel + "%";
  // app.style.height = (100 / scale) + "vh";
  // app.style.width = (100 / scale) + "vh";
}

  function zoomIn() {
    if (zoomLevel < MAX_ZOOM) {
      zoomLevel += 10;
      applyZoom();
    }
  }

  function zoomOut() {
    if (zoomLevel > MIN_ZOOM) {
      zoomLevel -= 10;
      applyZoom();
    }
  }

  function resetZoom() {
    zoomLevel = 100;
    applyZoom();
  }

  // เรียกครั้งแรก
  applyZoom();
</script>

</div>

    </div>

</div>

<!-- SUMMARY -->



<section id="summary" class="bg-summary text-white px-3 py-2">
  <div class="grid grid-cols-4 gap-2 text-center text-xs md:text-sm">
    <div>
      <p id="sumWaiting" class="text-lg font-bold">0</p>
      <p>รอ</p>
    </div>
    <div>
      <p id="sumDone" class="text-lg font-bold text-green-400">0</p>
      <p>เสร็จ</p>
    </div>
    <div>
      <p id="sumTotal" class="text-lg font-bold text-blue-400">0</p>
      <p>ทั้งหมด</p>
    </div>
    <div>
      <p id="sumPercent" class="text-lg font-bold text-yellow-400">0%</p>
      <p>สําเร็จ</p>
    </div>
    <!-- <div>
      <p id="sumAvg" class="text-lg font-bold text-pink-400">0</p>
      <p>นาที</p>
    </div> -->
  </div>
</section>



<!-- CONTENT -->
<main id="main" class="p-2 overflow-hidden">

  <!-- VERTICAL ONLY -->
  <section id="verticalSection" class="h-full overflow-auto">
    <div id="app1">
    <div id="verticalList"
      class="grid gap-2"
      style="grid-template-columns: repeat(auto-fit, minmax(200px, 1fr));">
    </div>
    </div>
  </section>

</main>

</div>

<script>
function toggleUpload(){
  const panel = document.getElementById("uploadPanel");
  panel.classList.toggle("hidden");
}

function setc(){
  window.location.href = 'admin.php' + "?" + "hospital" + "=" + HOSPITAL;
}

/* ================= CONFIG ================= */
const STORAGE_KEY = window.APP_CONFIG.STORAGE_KEY;
const params = new URLSearchParams(location.search);
const HOSPITAL = params.get("hospital");
const API_URL = window.APP_CONFIG.API_URL + HOSPITAL;

/* ================= DOM ================= */
const verticalList = document.getElementById("verticalList");

/* ================= DATETIME ================= */
function updateDateTime() {
  const now = new Date();
  const yearBE = now.getFullYear() + 543;
  const date = now.toLocaleDateString("th-TH", {
    weekday: "short",
    day: "numeric",
    month: "short"
  });
  const time = now.toLocaleTimeString("th-TH");

  document.getElementById("datetime").innerText =
    `${date} ${yearBE} ${time}`;
}
setInterval(updateDateTime, 1000);
updateDateTime();

/* ================= FILTER ================= */
function filterByAdmin(data) {
  const selected = JSON.parse(localStorage.getItem(STORAGE_KEY) || "[]");
  return selected.length === 0
    ? data
    : data.filter(i => String(selected).includes(i.orders));
}

/* ================= LAYOUT HEIGHT FIX ================= */
function adjustLayout() {
  const header = document.getElementById("header");
  const summary = document.getElementById("summary");
  const main = document.getElementById("main");

  const h = header.offsetHeight + summary.offsetHeight;
  main.style.height = `calc(100vh - ${h}px)`;
}

/* ================= RENDER ================= */
let scrollY = 0;
const speed = 1.2;

function createCard(i) {
  const card = document.createElement("div");
  card.className = "bg-gray-50 rounded-lg shadow p-2";

  card.innerHTML = `
    <h3 class="text-sm text-center font-semibold mb-1">${i.name}</h3>
    <div class="grid grid-cols-3 text-center gap-1 mb-1">
      <div>
        <p class="text-waiting text-lg font-bold">${i.waiting}</p>
        <p class="text-[10px]">รอ</p>
      </div>
      <div>
        <p class="text-done text-lg font-bold">${i.done}</p>
        <p class="text-[10px]">เสร็จ</p>
      </div>
      <div>
        <p class="text-total text-lg font-bold">${i.total}</p>
        <p class="text-[10px]">ทั้งหมด</p>
      </div>
    </div>
    <div class="border-t pt-1 text-center text-xs text-gray-600">
      ⏱ ${i.avg_time_min} นาที
    </div>
  `;

  return card;
}

function render(data) {
  verticalList.innerHTML = "";

  let sw = 0, sd = 0, st = 0, wavg = 0;

  data.forEach(i => {
    sw += +i.waiting;
    sd += +i.done;
    st += +i.total;
    wavg += i.avg_time_min * i.total;

    const card = createCard(i);
    verticalList.appendChild(card);
  });

  document.getElementById("sumWaiting").innerText = sw;
  document.getElementById("sumDone").innerText = sd;
  document.getElementById("sumTotal").innerText = st;
  document.getElementById("sumPercent").innerText =
    st ? Math.round(sd / st * 100) + "%" : "0%";
  document.getElementById("sumAvg").innerText =
    st ? Math.round(wavg / st) : 0;
}

/* ================= SCROLL ================= */
function autoScroll() {
  scrollY += speed;
  if (scrollY >= verticalList.scrollHeight - verticalList.clientHeight) {
    scrollY = 0;
  }
  verticalList.scrollTop = scrollY;
}

/* ================= LOAD ================= */
function load() {
  fetch(API_URL)
    .then(r => r.json())
    .then(d => render(filterByAdmin(d.results[0].items)))
    .catch(console.error);
}

/* ================= INIT ================= */
document.addEventListener("DOMContentLoaded", () => {

  adjustLayout();
  window.addEventListener("resize", adjustLayout);

  document.body.style.overflow = "hidden";
  setInterval(autoScroll, 16);

  document.getElementById("app").innerHTML =
    `<img src="logo.png" class="h-10 w-10">`;

  load();
  setInterval(load, 6000);
});
</script>

</body>
</html>