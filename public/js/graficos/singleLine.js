// Set new default font family and font color to mimic Bootstrap's default styling
Chart.defaults.global.defaultFontFamily = 'Nunito', '-apple-system,system-ui,BlinkMacSystemFont,"Segoe UI",Roboto,"Helvetica Neue",Arial,sans-serif';
Chart.defaults.global.defaultFontColor = '#858796';

function number_format(number, decimals, dec_point, thousands_sep) {
  // *     example: number_format(1234.56, 2, ',', ' ');
  // *     return: '1 234,56'
  number = (number + '').replace(',', '').replace(' ', '');
  var n = !isFinite(+number) ? 0 : +number,
    prec = !isFinite(+decimals) ? 0 : Math.abs(decimals),
    sep = (typeof thousands_sep === 'undefined') ? ',' : thousands_sep,
    dec = (typeof dec_point === 'undefined') ? '.' : dec_point,
    s = '',
    toFixedFix = function(n, prec) {
      var k = Math.pow(10, prec);
      return '' + Math.round(n * k) / k;
    };
  // Fix for IE parseFloat(0.55).toFixed(0) = 0;
  s = (prec ? toFixedFix(n, prec) : '' + Math.round(n)).split('.');
  if (s[0].length > 3) {
    s[0] = s[0].replace(/\B(?=(?:\d{3})+(?!\d))/g, sep);
  }
  if ((s[1] || '').length < prec) {
    s[1] = s[1] || '';
    s[1] += new Array(prec - s[1].length + 1).join('0');
  }
  return s.join(dec);
}

//Recogemos la Información del grafico y eliminamos el spinner
$(".singleline-spinner").fadeOut(1000, function(){
    $(".canvasLineid").each(function(indice, elemento){
        var id = $(this).val();
        var datos = new Array();
        var labels = new Array();
        var type, bgColor, brColor;

        //Valor unico para generar canvas unicos
        var unique = $(this).attr("name");

        //Datos del grafico
        $(".canvasbdatos"+unique).each(function(indice,elemento){
            datos.push($(this).val());
        });

        //Labels del grafico
        $(".canvasblabels"+unique).each(function(indice,elemento){
            labels.push($(this).val());
        });

        //Tipo de grafico
        $(".canvasTipoB"+unique).each(function(indice,elemento){
            type = $(this).val();
        });

        //Background del grafico
        $(".canvasBgColor"+unique).each(function(indice,elemento){
            bgColor = $(this).val();
        });

        //Border de las lineas del grafico
        $(".canvasBrColor"+unique).each(function(indice,elemento){
            brColor = $(this).val();
        });

        //Tipo de grafico
        if(type == "top")
            $('#'+id).attr('height', 100);

        //Imprimimos el grafico
        printSingleLineChart(id, datos, labels, type, bgColor, brColor);
    });
});

// Función que imprime la grafica
var printSingleLineChart = (id, datos, labels, type, bgColor, brColor) => {
    var ctx = document.getElementById(id);

    //Setteo de datos del gráfico
      var DataChart = new Array();
      var xAsysLabel = new Array();
      var maxed, step, style;

      datos.forEach(function (elemento) {
          DataChart.push(elemento);
      });

      labels.forEach(function (elemento) {
          xAsysLabel.push(elemento);
      });

      if(type == "normal"){
          maxed = Math.ceil(Math.max(...DataChart));
          step = "";
          style = "";
      }
      else if(type == "porcentaje"){
          maxed = 1;
          step = 0.2;
          style = {style:'percent'};
      }

    //Configuración Datos del Gráfico y linea
      let Dato1 = {
          label: "Total",
          backgroundColor: bgColor,
          borderColor: brColor,
          pointBackgroundColor: bgColor,
          pointBorderColor: brColor,
          pointHoverBackgroundColor: bgColor,
          pointHoverBorderColor: brColor,
          borderWidth: 4,
          lineTension: 0.3,
          pointRadius: 3,
          pointHoverRadius: 3,
          pointHitRadius: 10,
          pointBorderWidth: 2,
          data: DataChart,
      }

    //Configuración Labels + Datos
      let chartData = {
          labels: xAsysLabel,
          datasets: [Dato1]
      }

    //Configuración Opciones
      let chartOption = {
          maintainAspectRatio: false,
          layout: {
            padding: {
              left: 10,
              right: 25,
              top: 25,
              bottom: 0
            }
          },
          scales: {
            xAxes: [{
              time: {
                unit: 'date'
              },
              gridLines: {
                display: false,
                drawBorder: false
              },
              ticks: {
                maxTicksLimit: 7
              }
            }],
            yAxes: [{
              ticks: {
                maxTicksLimit: 5,
                padding: 10,
                // Include a dollar sign in the ticks
                callback: function(value, index, values) {
                  return '' + number_format(value);
                }
              },
              gridLines: {
                color: "rgb(234, 236, 244)",
                zeroLineColor: "rgb(234, 236, 244)",
                drawBorder: false,
                borderDash: [2],
                zeroLineBorderDash: [2]
              }
            }],
          },
          legend: {
            display: false
          },
          tooltips: {
            backgroundColor: "rgb(255,255,255)",
            bodyFontColor: "#858796",
            titleMarginBottom: 10,
            titleFontColor: '#6e707e',
            titleFontSize: 14,
            borderColor: '#dddfeb',
            borderWidth: 1,
            xPadding: 15,
            yPadding: 15,
            displayColors: false,
            intersect: false,
            mode: 'index',
            caretPadding: 10,
            callbacks: {
              label: function(tooltipItem, chart) {
                var datasetLabel = chart.datasets[tooltipItem.datasetIndex].label || '';
                return datasetLabel + ': ' + number_format(tooltipItem.yLabel);
              }
            }
          }
      }

    //Generamos el grafico
    var lineChart = new Chart(ctx, {
      type: 'line',
      data: chartData,
      options: chartOption
    });
}