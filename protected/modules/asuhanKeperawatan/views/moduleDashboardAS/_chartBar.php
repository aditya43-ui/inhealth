<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">10 Diagnosa yang paling banyak ditentukan</div>
        <div class="panel-options">
            <a data-rel="collapse" href="#">
                <i class="entypo-down-open"></i>
            </a>
            <a data-rel="reload" href="#">
                <i class="entypo-arrows-ccw"></i>
            </a>
        </div>
    </div>

    <div class="panel-body">
        <div id="bar-chart-1" style="height: 280px"></div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function() {
        var data = [
            <?php
            if (count($dataBarChart) > 0) {
                foreach ($dataBarChart as $i => $bar) {
            ?> {
                        x: '<?php echo $bar['diagnosakep_nama']; ?>',
                        y: <?php echo $bar['jumlah']; ?>
                    },
            <?php
                }
            }
            ?>
        ];

        // Bar Charts
        Morris.Bar({
            element: 'bar-chart-1',
            axes: true,
            data: data,
            xkey: 'x',
            ykeys: ['y'],
            labels: ['Jumlah'],
            barColors: [getRandomColor()],
        });
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
</script>