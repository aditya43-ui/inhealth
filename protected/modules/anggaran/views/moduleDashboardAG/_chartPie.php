<div class="panel panel-default">
    <div class="panel-heading tall">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Unit Kerja yang Melakukan Realisasi Anggaran Pengeluaran
            <!--<small><i>Berdasarkan Jenis Penjamin Penjamin</i></small>-->
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
            foreach ($dataPieChart as $i => $pie) { ?> '<?php echo $i; ?>': '<?php echo $pie['namaunitkerja']; ?>',
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