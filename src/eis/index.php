<!DOCTYPE html>
<html lang="th">
<head>
  <meta charset="UTF-8">
  <title>EIS MSD</title>
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <link rel="icon" type="image/x-icon" href="favicon.ico">

  <!-- Bootstrap 5 -->
  <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css" rel="stylesheet">

  <style>
    body {
      background: #f5f6fa;
    }

    .main-wrapper {
      max-width: 1300px;
      width: 100%;
    }

    .menu-card {
      background: #ffffff;
      border-radius: 16px;
      padding: 25px 15px;
      transition: all 0.25s ease;
      box-shadow: 0 4px 12px rgba(0,0,0,0.06);
      height: 100%;
    }

    .menu-card:hover {
      transform: translateY(-6px);
      box-shadow: 0 8px 20px rgba(0,0,0,0.12);
    }

    .menu-img {
      width: 110px;
      height: 110px;
      object-fit: contain;
    }

    .menu-title {
      font-weight: 600;
      margin-top: 15px;
      font-size: 16px;
    }
  </style>
</head>

<body>

<div class="min-vh-100 d-flex flex-column align-items-center">

  <!-- Title -->
  <div class="text-center mt-5 mb-4">
    <h1 class="fw-bold display-5">EIS MSD</h1>
  </div>

  <!-- Menu Section -->
  <div class="container main-wrapper">

    <div class="row row-cols-2 row-cols-md-3 row-cols-xl-4 g-4 justify-content-center text-center">

      <!-- ตรวจสุขภาพ -->
      <div class="col">
        <a href="click.php?id=health" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/health.png" class="menu-img">
            <div class="menu-title">ตรวจสุขภาพ</div>
          </div>
        </a>
      </div>

      <!-- วิ่งล้อมเมือง -->
      <div class="col">
        <a href="click.php?id=run" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/run.png" class="menu-img">
            <div class="menu-title">วิ่งล้อมเมือง</div>
          </div>
        </a>
      </div>

      <!-- Health Map -->
      <div class="col">
        <a href="click.php?id=map" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/map.png" class="menu-img">
            <div class="menu-title">Health Map</div>
          </div>
        </a>
      </div>

      <!-- Policy Tracking -->
      <div class="col">
        <a href="click.php?id=policy" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/policy.png" class="menu-img">
            <div class="menu-title">Policy Tracking</div>
          </div>
        </a>
      </div>

      <!-- ความพึงพอใจ -->
      <div class="col">
        <a href="click.php?id=good" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/good.png" class="menu-img">
            <div class="menu-title">ความพึงพอใจ</div>
          </div>
        </a>
      </div>

      <!-- Smart IPD -->
      <div class="col">
        <a href="click.php?id=smart" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/smart.png" class="menu-img">
            <div class="menu-title">Smart IPD</div>
          </div>
        </a>
      </div>

      <!-- Data Center -->
      <div class="col">
        <a href="click.php?id=datac" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/data.png" class="menu-img">
            <div class="menu-title">Data Center</div>
          </div>
        </a>
      </div>

      <!-- งบประมาณ -->
      <div class="col">
        <a href="click.php?id=budget" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/budget.png" class="menu-img">
            <div class="menu-title">งบประมาณ</div>
          </div>
        </a>
      </div>

      <!-- BHZ -->
      <div class="col">
        <a href="click.php?id=bhz" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/bhz.png" class="menu-img">
            <div class="menu-title">BHZ</div>
          </div>
        </a>
      </div>

      <!-- Telemedicine -->
      <div class="col">
        <a href="click.php?id=tele" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/tele.png" class="menu-img">
            <div class="menu-title">Telemedicine</div>
          </div>
        </a>
      </div>

      <!-- รถรับส่ง -->
      <div class="col">
        <a href="click.php?id=cars" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/cars.png" class="menu-img">
            <div class="menu-title">รถรับส่ง<br>คนพิการ-ผู้สูงอายุ</div>
          </div>
        </a>
      </div>

      <!-- ระบบคิว -->
      <div class="col">
        <a href="click.php?id=queue" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/queue1.png" class="menu-img">
            <div class="menu-title">ระบบติดตามจำนวน <br> คิวผู้ป่วยของโรงพยาบาล</div>
          </div>
        </a>
      </div>

      <!-- พลังงาน -->
      <div class="col">
        <a href="click.php?id=energy" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/energy.png" class="menu-img">
            <div class="menu-title">รายงานพลังงาน</div>
          </div>
        </a>
      </div>

      <div class="col">
        <a href="click.php?id=policy27" target="_blank" class="text-decoration-none text-dark">
          <div class="menu-card">
            <img src="images/244.png" class="menu-img">
            <div class="menu-title">ผลดำเนินงาน 24+3 <br> นโยบาย</div>
          </div>
        </a>
      </div>

    </div>
  </div>

  <!-- ปุ่มสถิติ -->
  <div class="text-center mt-5 mb-5">
    <a href="stats.php"
       target="_blank"
       class="btn btn-success btn-lg px-5 py-3 fw-semibold text-warning shadow">
      📊 สถิติการเข้าชม
    </a>
  </div>

</div>

<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html>
