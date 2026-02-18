const STORAGE_KEY = window.APP_CONFIG.STORAGE_KEY;
const params = new URLSearchParams(location.search);
const HOSPITAL = params.get("hospital");
const MODE = params.get("mode") === "tv" ? "tv" : "pc";
const LAYOUT = params.get("layout") === "vt" ? "vertical" : "horizontal";
const API_URL = window.APP_CONFIG.API_URL+HOSPITAL;

/* ---------- DOM ---------- */
const pcList = document.getElementById("pcList");
const clinicBanner = document.getElementById("clinicBanner");
const verticalList = document.getElementById("verticalList");
const horizontalSection = document.getElementById("horizontalSection");
const verticalSection = document.getElementById("verticalSection");
const tvWrapper = document.getElementById("tvWrapper");
const hosp = document.getElementById("hosp");

/* ---------- DATETIME (พ.ศ.) ---------- */
function updateDateTime() {
  const now = new Date();
  const yearBE = now.getFullYear() + 543;
  const date = now.toLocaleDateString("th-TH",
    { weekday: "long", day: "numeric", month: "long" });
  const time = now.toLocaleTimeString("th-TH");
  document.getElementById("datetime").innerText =
    `${date} พ.ศ. ${yearBE} ${time}`;
}
updateDateTime();
setInterval(updateDateTime, 1000);

/* ---------- FILTER ADMIN ---------- */
function filterByAdmin(data) {
  const selected = JSON.parse(localStorage.getItem(STORAGE_KEY) || "[]");
  return selected.length === 0
    ? data
    : data.filter(i => selected.includes(i.orders));
}

/* ---------- RENDER ---------- */
let scrollX = 0;
let scrollY = 0;
const speed = 2;

function render(data) {
  pcList.innerHTML = "";
  clinicBanner.innerHTML = "";
  verticalList.innerHTML = "";
  scrollX = scrollY = 0;

  let sw = 0, sd = 0, st = 0, wavg = 0;

  data.forEach(i => {
    sw += i.waiting;
    sd += i.done;
    st += i.total;
    wavg += i.avg_time_min * i.total;

    const cardHTML = `
      <h3 class="text-lg text-center font-semibold mb-2">${i.name} <br >(${i.lctaddr})</h3>
      <div class="grid grid-cols-3 text-center gap-2 mb-2">
        <div><p class="text-waiting text-2xl font-bold">${i.waiting}</p><p class="text-xs">รอ</p></div>
        <div><p class="text-done text-2xl font-bold">${i.done}</p><p class="text-xs">เสร็จ</p></div>
        <div><p class="text-total text-2xl font-bold">${i.total}</p><p class="text-xs">ทั้งหมด</p></div>
      </div>
      <div class="border-t pt-2 text-center text-sm text-gray-600">
        ⏱ ${i.avg_time_min} นาที / ราย
      </div>
    `;

    const card = document.createElement("div");
    card.className = "bg-gray-50 rounded-xl shadow p-4";
    card.innerHTML = cardHTML;

    if (LAYOUT === "vertical") {
      verticalList.appendChild(card);
    } else if (MODE === "pc") {
      pcList.appendChild(card);
    } else {
      card.classList.add("min-w-[360px]", "flex-shrink-0");
      clinicBanner.appendChild(card);
    }
  });

  
  

  document.getElementById("sumWaiting").innerText = sw;
  document.getElementById("sumDone").innerText = sd;
  document.getElementById("sumTotal").innerText = st;
  document.getElementById("sumPercent").innerText =
    st ? Math.round(sd / st * 100) + "%" : "0%";
  document.getElementById("sumAvg").innerText =
    st ? Math.round(wavg / st) : 0;

  if (MODE === "tv" && LAYOUT === "horizontal") {
    clinicBanner.innerHTML += clinicBanner.innerHTML;
  }
}

/* ---------- AUTO SCROLL ---------- */
function autoScroll() {
  if (MODE === "tv" && LAYOUT === "horizontal") {
    scrollX += speed;
    if (scrollX >= clinicBanner.scrollWidth / 2) scrollX = 0;
    clinicBanner.style.transform = `translateX(-${scrollX}px)`;
  }

  if (MODE === "tv" && LAYOUT === "vertical") {
    scrollY += speed;
    if (scrollY >= verticalList.scrollHeight - verticalList.clientHeight) {
      scrollY = 0;
    }
    verticalList.scrollTop = scrollY;
  }
}

const a = "./admin.html";



document.getElementById("app").innerHTML =
  `<a href="${a+"?"+"hospital"+"="+HOSPITAL}"><img src="logo.png" class="h-14 w-14 object-contain" /></a>`;


/* ---------- LOAD ---------- */
function load() {


  
  fetch(API_URL)
    .then(r => r.json())
    .then(d => render(filterByAdmin(d)))
    .catch(console.error);
    // console.log(HOSPITAL)
    
}

document.addEventListener("DOMContentLoaded", () => {
  if (LAYOUT === "vertical") {
    horizontalSection.classList.add("hidden");
    verticalSection.classList.remove("hidden");
  }

  if (MODE === "tv") {
    tvWrapper.classList.remove("hidden");
    setInterval(autoScroll, 16);
  }

  load();
  setInterval(load, 30000);
});