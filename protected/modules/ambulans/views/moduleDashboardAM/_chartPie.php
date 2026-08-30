<div class="panel panel-default">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-ambulance"></i> Mobil Ambulans Bulan Ini
            <br>
            <small><i>Mobil ambulans yang sering dipakai</i></small>
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
        <div id="pie-chart-1" style="overflow: auto">
            <span class="chart"></span>
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
            foreach ($dataPieChart as $i => $pie) { ?> '<?php echo $i; ?>': '<?php echo $pie['nopolisi']; ?>',
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
            barColor: getRandomColor(),
            height: '265px',
            barWidth: 10,
            barSpacing: 2
        });
    });
</script>