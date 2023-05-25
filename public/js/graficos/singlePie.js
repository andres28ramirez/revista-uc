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
$(".piechart-spinner").fadeOut(1000, function(){
    $(".canvasPieid").each(function(indice, elemento){
        var id = $(this).val();
        var datos = new Array();
        var labels = new Array();
        var bgColor = new Array();
        var brColor;

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

        //Background del grafico
        $(".canvasBgColor"+unique).each(function(indice,elemento){
            bgColor.push($(this).val());
        });

        //Border de las lineas del grafico
        $(".canvasBrColor"+unique).each(function(indice,elemento){
            brColor = $(this).val();
        });

        //Imprimimos el grafico
        printPieChart(id, datos, labels, bgColor, brColor);
    });
});

// Función que imprime la grafica
var printPieChart = (id, datos, labels, bgColor, brColor) => {
    var ctx = document.getElementById(id);
    
    //Setteo de datos del gráfico
      var DataChart = new Array();
      var xAsysLabel = new Array();
      var bgColors = new Array();

      datos.forEach(function (elemento) {
          DataChart.push(elemento);
      });

      labels.forEach(function (elemento) {
          xAsysLabel.push(elemento);
      });
      
      bgColor.forEach(function (elemento) {
          bgColors.push(elemento);
      });

    //Configuración Datos del Gráfico y linea
      let Dato1 = {
          backgroundColor: bgColors,
          borderColor: brColor,
          hoverBackgroundColor: bgColors,
          hoverBorderColor: "rgba(234, 236, 244, 1)",
          borderWidth: 2,
          hoverBorderWidth: 3,
          borderAlign: 'inner',
          data: DataChart,
      };

    //Configuración Labels + Datos
      let chartData = {
          labels: xAsysLabel,
          datasets: [Dato1]
      };
      
    //Configuración Opciones
      let chartOption = {
        maintainAspectRatio: false,
        tooltips: {
          backgroundColor: "rgb(255,255,255)",
          bodyFontColor: "#858796",
          borderColor: '#dddfeb',
          borderWidth: 1,
          xPadding: 15,
          yPadding: 15,
          displayColors: false,
          caretPadding: 10,
        },
        legend: {
          display: true,
          position: "bottom",
          align: "center",
          rtl: false,
        },
        cutoutPercentage: 80,
        responsive: true,
      };
      
    //Generamos el grafico
    var pieChart = new Chart(ctx, {
      type: 'pie',
      data: chartData,
      options: chartOption
    });
}