<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
  <link rel="apple-touch-icon" sizes="76x76" href="images/logo2.png">
  <link rel="icon" type="image/png" href="images/logo2.png">
  <title> Banjir Alert Warning System </title>
  <!--     Fonts and icons     -->
  <link href="https://fonts.googleapis.com/css?family=Open+Sans:300,400,600,700" rel="stylesheet" />
  <!-- Nucleo Icons -->
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-icons.css" rel="stylesheet" />
  <link href="https://demos.creative-tim.com/argon-dashboard-pro/assets/css/nucleo-svg.css" rel="stylesheet" />
  <!-- Font Awesome Icons -->
  <!-- <script src="https://kit.fontawesome.com/42d5adcbca.js" crossorigin="anonymous"></script> -->
  <!-- CSS Files -->
  <link id="pagestyle" href="style.css" rel="stylesheet" />

</head>

<body class="bg-gray-100">
  <main class="main-content position-relative border-radius-lg ">
    <header style="background-color: #344767; padding: 10px 20px; display: flex; align-items: center;">
      <img src="images/logo3.png" alt="Logo" style="height: 40px; border-radius: 10%;">
      <h1 style="color: white; margin-left: 10px; font-size: 24px;">Banjir Alert Warning System</h1>
    </header> 
       
    <div class="min-height-300 bg-dark position-absolute w-100">
    </div>
    <div class="container-fluid py-4">
      <div class="row">
        <!-- <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
        </div>
        <div class="col-xl-3 col-sm-6 mb-xl-0 mb-4">
          
        </div>
        <div class="col-xl-3 col-sm-6">
        </div>
      </div> -->

      <div class="row mt-4">
        <div class="col-lg-7 mb-lg-0 mb-4">
          <div class="card z-index-2 h-100">
            <div class="card-header pb-0 pt-3 bg-transparent">
              <h6 class="text-capitalize">Suhu dan Kelembapan</h6>
              <!-- animasi chart suhu dan kelembapan -->
            </div>
            <!-- card awal -->
            <div class="card-body p-3">
              <div class="chart">
                <canvas id="chart-line" class="chart-canvas">
                  <!-- Tambahkan Chart.js -->
                   <script src="https://cdn.jsdelivr.net/npm/chart.js"></script>


<!-- Script grafik -->
 <!-- Script grafik -->
<script>
const ctx = document.getElementById('chart-line').getContext('2d');
let chart = new Chart(ctx, {
  type: 'line',
  data: {
    labels: [],
    datasets: [
      {
        label: 'Suhu (°C)',
        data: [],
        borderColor: 'rgba(255, 99, 132, 1)',
        backgroundColor: 'rgba(255, 99, 132, 0.2)',
        fill: true,
        tension: 0.4
      },
      {
        label: 'Kelembapan (%)',
        data: [],
        borderColor: 'rgba(54, 162, 235, 1)',
        backgroundColor: 'rgba(54, 162, 235, 0.2)',
        fill: true,
        tension: 0.4
      }
    ]
  },
  options: {
    responsive: true,
    animation: {
      duration: 1000,
      easing: 'easeOutQuart'
    },
    scales: {
      y: {
        beginAtZero: true
      }
    }
  }
});



// Fungsi untuk ambil data dari PHP
function updateChart() {
  fetch('chart.php')
    .then(res => res.json())
    .then(data => {
      const labels = data.map(item => item.tanggal).reverse();
      const suhu = data.map(item => item.suhu).reverse();
      const kelembapan = data.map(item => item.kelembapan).reverse();

      chart.data.labels = labels;
      chart.data.datasets[0].data = suhu;
      chart.data.datasets[1].data = kelembapan;
      chart.update();
    });
}

// Load awal
updateChart();

// Auto update setiap 10 detik
setInterval(updateChart, 10000);
// ambil data
fetch('data.php')
  .then(res => res.json())
  .then(data => {
    console.log(data); // tampilkan ke UI
  });

</script>



                </canvas>
              </div>
            </div>
          </div>
        </div>
        
        <!-- card waspada -->
        <div class="col-lg-5">
          <div class="card h-100 d-flex justify-content-center align-items-center text-center p-4">
            <p class="ketinggian">Ketinggian Air</p>
            <p id="nilai-ketinggian" class="meter" style="font-size: 4rem; font-weight: bold; margin: 0;">
  <sup style="font-size: 2rem;">M</sup> </p>

            <p id="status-air" class="status"> WASPADA </p>
          </div>
        </div>        
      </div>
      
      
      <!-- card history -->
      <div class="row mt-4">
  <div class="col-lg-7 mb-lg-0 mb-4">
    <div class="card">
      <div class="card-header pb-0 p-3">
        <div class="d-flex justify-content-between">
        <h6 class="mb-0">History</h6>
        </div>
      </div>
      <div class="table-responsive">
        <table class="table align-items-center mb-0">
          <thead>
            <tr>
              <th class="text-uppercase text-secondary text-center text-xs font-weight-bold">Tanggal</th>
              <th class="text-uppercase text-secondary text-center text-xs font-weight-bold">Ketinggian</th>
              <th class="text-uppercase text-secondary text-center text-xs font-weight-bold">Suhu</th>
              <th class="text-uppercase text-secondary text-center text-xs font-weight-bold">Kelembapan</th>
            </tr>
          </thead>
          <tbody id="history-table">
            <!-- Diisi oleh JavaScript -->
          </tbody>
        </table>
      </div>
    </div>
  </div>
</div>


<style>
@keyframes blink {
  0%   { opacity: 1; }
  50%  { opacity: 0.2; }
  100% { opacity: 1; }
}
.blink-danger {
  animation: blink 1s infinite;
  color: red;
  font-weight: bold;
  font-size: 2.5rem;
}
</style>

<script>
function loadKetinggianAir() {
  fetch('data.php')
    .then(res => res.json())
    .then(data => {
      document.getElementById("nilai-ketinggian").innerHTML = data.ketinggian + "<sup>M</sup>";
      const status = document.getElementById("status-air");
      if (parseFloat(data.ketinggian) >= 5) {
        status.textContent = "⚠️ WASPADA!";
        status.className = "status blink-danger";
      } else {
        status.textContent = "AMAN";
        status.className = "status text-success fw-bold";
      }
    });
}

loadKetinggianAir();
setInterval(loadKetinggianAir, 10000);
</script>

<!-- menghitung rata rata  -->

<script>
function loadHistory() {
  fetch('history.php')
    .then(res => res.json())
    .then(data => {
      const tbody = document.getElementById("history-table");
      tbody.innerHTML = "";
      data.forEach(item => {
        const row = `<tr>
          <td class="text-center font-weight-bold">${item.tanggal}</td>
          <td class="text-center font-weight-bold">${item.ketinggian} M</td>
          <td class="text-center font-weight-bold">${item.suhu} °C</td>
          <td class="text-center font-weight-bold">${item.kelembapan} %</td>
        </tr>`;
        tbody.innerHTML += row;
      });
    });
}
loadHistory();
setInterval(loadHistory, 10000);
</script>


</body>      