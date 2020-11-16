  <div class="row">
      <div class="col-md-12" >
        <canvas id="DOPHU_KHAC_<?=$ten_khu?>" ></canvas>
      </div>
  </div>
  <div class="row">
      <div class="col-md-12" >
        <div id="chart_legends_filter_<?=$ten_khu?>" ></div>
      </div>
  </div>


<script>

  $('form#occupied-tables').on('submit', function (event){
    event.preventDefault();

    var maKhu = "<?=$ma_khu?>";
    var formValues= $(this).serialize();
    var fileNameAjax = "<?=$file_name_ajax?>";
    $.ajax({
    url: fileNameAjax,
    method:"POST",
    //data:{'tu-ngay' : tuNgay, 'den-ngay' : denNgay},
    data:formValues + "&ma_khu="  + maKhu,
    dataType:"json",
    success:function(response)
      { 
        
          console.log(response);
          const DOPHU_KHAC_<?=$ten_khu?> = document.getElementById('DOPHU_KHAC_<?=$ten_khu?>');

          var banTrong = response[0].ban_trong;
          var coNguoi = response[0].co_nguoi; 

          var data = {
            labels: ["Bàn trống",  "Có người"],
            datasets: [
              {
                label: "Tỉ lệ bàn có người",
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
              text: "<?=$ten_khu_raw?>",
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
                    formatter: (value, DOPHU_KHAC_<?=$ten_khu?> ) => {
                        let sum = 0;
                        let dataArr = DOPHU_KHAC_<?=$ten_khu?>.chart.data.datasets[0].data;
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

        var myPieChart  = new Chart(DOPHU_KHAC_<?=$ten_khu?> , {
            type: 'doughnut',
            data: data,
            options: options
        });
        //document.getElementById('chart-legends').innerHTML = myPieChart.generateLegend();
        $("#chart_legends_filter_<?=$ten_khu?>").html(myPieChart.generateLegend());
    }

  })
});
</script>