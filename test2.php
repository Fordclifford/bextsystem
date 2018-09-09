<!DOCTYPE html>
<html>

<head>
    <script src="assets/zingchart/zingchart.min.js"></script>
  <script>
    zingchart.MODULESDIR = "assets/zingchart/modules/";
    ZC.LICENSE = ["569d52cefae586f634c54f86dc99e6a9", "ee6b7db5b51705a13dc2339db3edaf6d"];
  </script>
  <style>
    html,
    body,
    #myChart {
      width: 100%;
      height: 100%;
    }
  </style>
</head>

<body>
    <div class="glyphicon glyphicon-subtitles" id='myChart'></div>
  <script>
    var myConfig = {
      type: "line",
      plotarea: {
        adjustLayout: true
      },
      scaleX: {
        label: {
          text: "Here is a category scale"
        },
        labels: ["Jan", "Feb", "March", "April", "May", "June", "July", "Aug"]
      },
      series: [{
        values: [20, 40, 25, 50, 15, 45, 33, 34]
      }, {
        values: [5, 30, 21, 18, 59, 50, 28, 33]
      }]
    };

    zingchart.render({
      id: 'myChart',
      data: myConfig,
      height: "100%",
      width: "100%"
    });
  </script>
</body>

</html>