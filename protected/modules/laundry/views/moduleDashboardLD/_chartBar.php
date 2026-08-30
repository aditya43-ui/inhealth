<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Jumlah Perawatan
        </div>
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
            if (count((array)$dataBarChart) > 0) {
                foreach ($dataBarChart as $i => $bar) { ?> {
                        x: '<?php echo $bar['minatpekerjaan']; ?>',
                        y: <?php echo $bar['jumlah']; ?>
                    },
            <?php }
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
</script>