<div class="panel panel-primary">
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-users"></i>
                Kunjungan Pasien Bulan Ini
                <br>
                <small><i>Berdasarkan Kelompok Penjamin</i></small>
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
            <div id="pie-chart-1" style="padding: 15px; text-align: center;">
                <span class="chart"></span>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function($) {
        var values = [
            <?php
            foreach ($dataPieChart as $i => $pie) { ?>
                <?php echo $pie['jumlah']; ?>,
            <?php
            }
            ?>
        ];
        var tooltips = {
            <?php
            foreach ($dataPieChart as $i => $pie) { ?> '<?php echo $i; ?>': '<?php echo $pie['penjamin_nama']; ?>',
            <?php
            }
            ?>
        };
        $("#pie-chart-1").sparkline(values, {
            type: 'pie',
            tooltipFormat: '{{offset:offset}} ({{percent.0}}%)',
            tooltipValueLookups: {
                'offset': tooltips,
            },
            sliceColors: getRandomColorSpark(),
            height: '265px',
            barWidth: 10,
            barSpacing: 2
        });
    });

    function getRandomColorSpark() {
        var flat_colors = [
            '#8788fd', '#55ce63',
            '#f7e05a', '#f62d51',
            '#997ad3', '#55ce63',
            '#f7e05a', '#f62d51',
            '#bdc3c7', '#ebebfd',
            '#1abc9c', '#2ecc71',
            '#3498db', '#9b59b6',
            '#34495e', '#f1c40f',
            '#e67e22', '#e74c3c',
        ];
        return flat_colors;
    }
</script>