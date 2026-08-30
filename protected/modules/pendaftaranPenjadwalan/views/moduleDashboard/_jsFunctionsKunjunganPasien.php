<script type="text/javascript">
    jQuery(document).ready(function($) {
        // Sample Toastr Notification
        setTimeout(function() {
            var opts = {
                "closeButton": true,
                "debug": false,
                "positionClass": "toast-top-right",
                "toastClass": "black",
                "onclick": null,
                "showDuration": "300",
                "hideDuration": "1000",
                "timeOut": "5000",
                "extendedTimeOut": "1000",
                "showEasing": "swing",
                "hideEasing": "linear",
                "showMethod": "fadeIn",
                "hideMethod": "fadeOut"
            };

        }, 3000);

        var bulans = ["Januari", "Februari", "Maret", "April", "Mei", "Juni", "Juli", "Agustus", "September", "Oktober", "November", "Desember"];

        // Sparkline Charts
        $('.inlinebar').sparkline('html', {
            type: 'bar',
            barColor: '#ff6264'
        });
        $('.inlinebar-2').sparkline('html', {
            type: 'bar',
            barColor: '#445982'
        });
        $('.inlinebar-3').sparkline('html', {
            type: 'bar',
            barColor: '#00b19d'
        });
        $('.bar').sparkline([
            [1, 4],
            [2, 3],
            [3, 2],
            [4, 1]
        ], {
            type: 'bar'
        });
        $('.pie').sparkline('html', {
            type: 'pie',
            borderWidth: 0,
            sliceColors: ['#3d4554', '#ee4749', '#00b19d']
        });
        $('.linechart').sparkline();
        $('.pageviews').sparkline('html', {
            type: 'bar',
            height: '30px',
            barColor: '#ff6264'
        });
        $('.uniquevisitors').sparkline('html', {
            type: 'bar',
            height: '30px',
            barColor: '#00b19d'
        });


        $(".monthly-sales").sparkline([
            <?php foreach ($modPasienbulan as $i => $pasienBulan) { ?>
                <?php echo $pasienBulan->jumlah ?>,
            <?php }  ?>
        ], {
            type: 'bar',
            barColor: getRandomColor(),
            height: '80px',
            barWidth: 6,
            barSpacing: 2
        });


        // JVector Maps
        var map = $("#map");

        map.vectorMap({
            map: 'europe_merc_en',
            zoomMin: '3',
            backgroundColor: '#383f47',
            focusOn: {
                x: 0.5,
                y: 0.8,
                scale: 3
            }
        });



        // Line Chart
        var line_chart_demo = $("#line-chart-demo");

        var line_chart = Morris.Line({
            element: 'line-chart-demo',
            data: [
                <?php foreach ($modChart as $i => $chart) { ?> {
                        y: '<?php echo ($chart->tahun . "-" . $chart->bulan) ?>',
                        a: <?php echo ($chart->jumlah) ?>
                    },
                <?php } ?>

            ],
            xkey: 'y',
            ykeys: ['a'],
            labels: ['Jumlah Pasien'],
            xLabels: 'month',
            redraw: true,
            dateFormat: function(x) {
                var date = new Date(x);
                return bulans[date.getMonth()];
            },
            xLabelFormat: function(x) {
                var date = new Date(x);
                return bulans[date.getMonth()];
            },
            lineColors: [getRandomColor()]
        });

        line_chart_demo.parent().attr('style', '');


        // Donut Chart
        var donut_chart_demo = $("#donut-chart-demo");

        donut_chart_demo.parent().show();

        var donut_chart = Morris.Donut({
            element: 'donut-chart-demo',
            data: [
                <?php foreach ($modChart as $i => $chart) { ?> {
                        label: bulans[<?php echo $chart->bulan; ?> - 1],
                        value: <?php echo $chart->jumlah; ?>
                    },
                <?php } ?>
            ],
            colors: [
                <?php foreach ($modChart as $i => $chart) { ?>
                    getRandomColor(),
                <?php } ?>
            ]
        });

        donut_chart_demo.parent().attr('style', '');


        // Area Chart
        var area_chart_demo = $("#area-chart-demo");

        area_chart_demo.parent().show();

        var area_chart = Morris.Area({
            element: 'area-chart-demo',
            data: [
                <?php foreach ($modChart as $i => $chart) { ?> {
                        x: '<?php echo ($chart->tahun . "-" . $chart->bulan) ?>',
                        y: <?php echo ($chart->jumlah) ?>
                    },
                <?php } ?>
            ],
            xkey: 'x',
            ykeys: ['y'],
            labels: ['Jumlah Pasien'],
            xLabels: 'month',
            dateFormat: function(x) {
                var date = new Date(x);
                return bulans[date.getMonth()];
            },
            xLabelFormat: function(x) {
                var date = new Date(x);
                return bulans[date.getMonth()];
            },

            lineColors: [getRandomColor()]
        });

        area_chart_demo.parent().attr('style', '');




        // Rickshaw
        var seriesData = [
            [],
            []
        ];

        var random = new Rickshaw.Fixtures.RandomData(50);

        for (var i = 0; i < 50; i++) {
            random.addData(seriesData);
        }

        var graph = new Rickshaw.Graph({
            element: document.getElementById("rickshaw-chart-demo"),
            height: 193,
            renderer: 'area',
            stroke: false,
            preserve: true,
            series: [{
                color: '#73c8ff',
                data: seriesData[0],
                name: 'Upload'
            }, {
                color: '#e0f2ff',
                data: seriesData[1],
                name: 'Download'
            }]
        });

        graph.render();

        var hoverDetail = new Rickshaw.Graph.HoverDetail({
            graph: graph,
            xFormatter: function(x) {
                return new Date(x * 1000).toString();
            }
        });

        var legend = new Rickshaw.Graph.Legend({
            graph: graph,
            element: document.getElementById('rickshaw-legend')
        });

        var highlighter = new Rickshaw.Graph.Behavior.Series.Highlight({
            graph: graph,
            legend: legend
        });

        setInterval(function() {
            random.removeData(seriesData);
            random.addData(seriesData);
            graph.update();

        }, 500);
    });

    function getRandomColor() {
        var flat_colors = [
            '#16a085', '#27ae60',
            '#2980b9', '#8e44ad',
            '#2c3e50', '#f39c12',
            '#d35400', '#c0392b',
            '#bdc3c7', '#7f8c8d',
            '#1abc9c', '#2ecc71',
            '#3498db', '#9b59b6',
            '#34495e', '#f1c40f',
            '#e67e22', '#e74c3c',
        ];
        var index = Math.floor((Math.random() * 10));
        var color = flat_colors[index];
        return color;
    }

    function getRandomInt(min, max) {
        return Math.floor(Math.random() * (max - min + 1)) + min;
    }
</script>