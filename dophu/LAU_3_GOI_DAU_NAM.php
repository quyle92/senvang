<?php
$tong_so_ban = $senvang->countTotalTables( $ma_khu );
$co_nguoi = $senvang->countOccupiedTables( $today, $ma_khu );
$ban_trong = $tong_so_ban - $co_nguoi;

?>

<div class="row">
    <div class="col-md-12" >
      <canvas id="dophu_baygio_<?=$ma_khu?>" ></canvas>
    </div>
</div>
<div class="row">
    <div class="col-md-12" >
      <div id="chart_legends_<?=$ma_khu?>" ></div>
    </div>
</div>

<script>
//var ctx = document.getElementById('myChart').getContext('2d');

  const DOPHU_<?=$ten_khu?> = document.getElementById('dophu_baygio_<?=$ma_khu?>');

  var tenKhu = '<?=$ten_khu_raw?>'; 
  var coNguoi = <?=$co_nguoi?> ; //console.log(coNguoi);
  var banTrong = <?=$ban_trong?> ; //console.log(banTrong);
  var data = {
    labels: ["Bàn trống",  "Có người"],
    datasets: [
      {
        label: "Độ phủ theo thời gian thực",
        data: [banTrong, coNguoi],
        backgroundColor: [
          "#DC143C",
          "#2E8B57"
        ],
        borderColor: [
      "#CB252B",
          "#1D7A46"
        ],
        borderWidth: [1, 1]
      }
    ]
  };

  var options = {
    responsive: true,
    title: {
      display: true,
      position: "top",
      text: tenKhu,
      fontSize: 18,
      fontColor: "#111"
    },
    legend: {
      display: false,
      position: "bottom",
      labels: {
        fontColor: "#333",
        fontSize: 16
      }
    },
      plugins: {
        datalabels: {
            formatter: (value, DOPHU_<?=$ten_khu?>) => {
                let sum = 0;
                let dataArr = DOPHU_<?=$ten_khu?>.chart.data.datasets[0].data;
                dataArr.map(data => {
                    sum += data;
                });
                let percentage = (value*100 / sum).toFixed(2)+"%";
                return percentage;
            },
            color: '#fff',
            
        }
    },
    legendCallback: function(chart) {
     var ul = document.createElement('ul');
     var backgroundColor = chart.data.datasets[0].backgroundColor;
     var value = chart.data.datasets[0].data;
     chart.data.labels.forEach(function(label, index) {
        ul.innerHTML += `
          <li>
              <span style="background-color: ${backgroundColor[index]}"></span>
              ${label}:  ${value[index]}
           </li>
        `; // ^ ES6 Template String
     });
     return ul.outerHTML;
  }
  };

var myPieChart  = new Chart(DOPHU_<?=$ten_khu?>, {
    type: 'doughnut',
    data: data,
    options: options
});
//document.getElementById('chart-legends').innerHTML = myPieChart.generateLegend();
$("#chart_legends_<?=$r['MaKhu']?>").html(myPieChart.generateLegend());
//console.log(Chart.defaults.global);
//console.log(myPieChart);



</script>
