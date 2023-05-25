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
$(".doublebar-spinner").fadeOut(1000, function(){
    $(".canvasDoubleBarid").each(function(indice, elemento){
        var id = $(this).val();
        var labels = new Array();

        //Bar 1 declaracion de variables
            var bar_1 = new Array();
            var data_1 = new Array();
            var label_1, bgColor1, brColor1;

        //Bar 2 declaracion de variables
            var bar_2 = new Array();
            var data_2 = new Array();
            var label_2, bgColor2, brColor2;

        //Valor unico para generar canvas unicos
        var unique = $(this).attr("name");
        
        //Labels del grafico
        $(".canvasblabels"+unique).each(function(indice,elemento){
            labels.push($(this).val());
        });

        //Bar 1 Toma de Datos
            //Datos de la barra
            $(".canvasDb1datos"+unique).each(function(indice,elemento){
                data_1.push($(this).val());
            });

            //Nombre de la barra
            $(".canvasDb1label"+unique).each(function(indice,elemento){
                label_1 = $(this).val();
            });

            //Background de la barra
            $(".canvasBg1Color"+unique).each(function(indice,elemento){
                bgColor1 = $(this).val();
            });

            //Border de las lineas de la barra
            $(".canvasBr1Color"+unique).each(function(indice,elemento){
                brColor1 = $(this).val();
            });

            bar_1.push(data_1, label_1, bgColor1, brColor1);

        //Bar 2 Toma de Datos
            //Datos de la barra
            $(".canvasDb2datos"+unique).each(function(indice,elemento){
                data_2.push($(this).val());
            });

            //Nombre de la barra
            $(".canvasDb2label"+unique).each(function(indice,elemento){
                label_2 = $(this).val();
            });

            //Background de la barra
            $(".canvasBg2Color"+unique).each(function(indice,elemento){
                bgColor2 = $(this).val();
            });

            //Border de las lineas de la barra
            $(".canvasBr2Color"+unique).each(function(indice,elemento){
                brColor2 = $(this).val();
            });

            bar_2.push(data_2, label_2, bgColor2, brColor2);

        //Imprimimos el grafico
        printDoubleBarChart(id, labels, bar_1, bar_2);
    });
});

// Función que imprime la grafica
var printDoubleBarChart = (id, labels, bar_1, bar_2) => {
    var ctx = document.getElementById(id);

    //Setteo de datos del gráfico
      let xAsysLabel = new Array();
      labels.forEach(function (elemento) {
          xAsysLabel.push(elemento);
      });

      /* DATOS DEL BAR 1 ESTAN EN POSICION 0 */
      var DataBar_1 = new Array();
      bar_1[0].forEach(function(elemento){
        DataBar_1.push(elemento);
      });

      /* DATOS DEL BAR 2 ESTAN EN POSICION 0 */
      var DataBar_2 = new Array();
      bar_2[0].forEach(function(elemento){
        DataBar_2.push(elemento);
      });

    //Configuración Datos del Gráfico y linea
      let Dato1 = {
          label: bar_1[1],
          data: DataBar_1,
          backgroundColor: bar_1[2],
          borderColor: bar_1[3],
          borderWidth: 2,
          borderSkipped: "left",
          hoverBorderWidth: 3,
      }

      let Dato2 = {
          label: bar_2[1],
          data: DataBar_2,
          backgroundColor: bar_2[2],
          borderColor: bar_2[3],
          borderWidth: 2,
          borderSkipped: "left",
          hoverBorderWidth: 3,
    }

    //Configuración Labels + Datos
      let chartData = {
          labels: xAsysLabel,
          datasets: [Dato1, Dato2]
      }

    //Configuración Opciones
      let chartOption = {
        scales: {
            xAxes: [{
                barPercentage: 1,
                categoryPercentage: 0.7,
                gridLines: {
                    display: true,
                    drawTicks: true,
                    drawOnChartArea: false,
                    backdropColor: "rgba(255,255,255,1)",
                    backdropPaddingX: 2,
                    backdropPaddingY: 2,
                }
            }],
        },
        legend: {
            display: true,
            labels:{
                fontColor: "#333333",
                fontStyle: "normal"
            },
            position: "bottom",
            align: "center",
        },
        animation: {
            animateRotate: true,
            animateScale: true
        },
        responsive: true,
        layout: {
            padding: {
                left: 0,
                right: 0,
                top: 0,
                bottom: 0
            }
        }
      }

    //Generamos el grafico
    var barChart = new Chart(ctx, {
      type: 'bar',
      data: chartData,
      options: chartOption
    });
}