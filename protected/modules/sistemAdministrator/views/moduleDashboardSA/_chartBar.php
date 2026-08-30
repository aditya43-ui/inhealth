<div class="panel panel-primary">
    <div class="panel-heading">
        <div class="panel-title">Total Data Baru Hari Ini</div>
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
                        x: '<?php echo date("d", strtotime($bar['create_time'])); ?>',
                        y_1: <?php echo (!empty($bar['jumlah_1']) ? $bar['jumlah_1'] : 0); ?>,
                        y_2: <?php echo (!empty($bar['jumlah_2']) ? $bar['jumlah_2'] : 0); ?>,
                        y_3: <?php echo (!empty($bar['jumlah_3']) ? $bar['jumlah_3'] : 0); ?>,
                        y_4: <?php echo (!empty($bar['jumlah_4']) ? $bar['jumlah_4'] : 0); ?>,
                        y_5: <?php echo (!empty($bar['jumlah_5']) ? $bar['jumlah_5'] : 0); ?>,
                        y_6: <?php echo (!empty($bar['jumlah_6']) ? $bar['jumlah_6'] : 0); ?>
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
            ykeys: ['y_1', 'y_2', 'y_3', 'y_4', 'y_5', 'y_6'],
            labels: ['Pendaftaran', 'Pasien', 'Tindakan Pelayanan', 'Obat Alkes Pasien', 'Pasien Batal Periksa', 'Pembayaran Pelayanan'],
            barColors: [getRandomColor(), getRandomColor(), getRandomColor(), getRandomColor(), getRandomColor(), getRandomColor()],
        });
    });
</script>