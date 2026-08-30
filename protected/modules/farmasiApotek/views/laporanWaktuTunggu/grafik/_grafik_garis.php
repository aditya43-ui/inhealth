<style type="text/css">
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 360px;
        max-width: 800px;
        margin: 1em auto;
    }

    .highcharts-data-table table {
        font-family: Verdana, sans-serif;
        border-collapse: collapse;
        border: 1px solid #ebebeb;
        margin: 10px auto;
        text-align: center;
        width: 100%;
        max-width: 500px;
    }

    .highcharts-data-table caption {
        padding: 1em 0;
        font-size: 1.2em;
        color: #555;
    }

    .highcharts-data-table th {
        font-weight: 600;
        padding: 0.5em;
    }

    .highcharts-data-table td,
    .highcharts-data-table th,
    .highcharts-data-table caption {
        padding: 0.5em;
    }

    .highcharts-data-table thead tr,
    .highcharts-data-table tr:nth-child(even) {
        background: #f8f8f8;
    }

    .highcharts-data-table tr:hover {
        background: #f1f7ff;
    }
</style>

<figure class="highcharts-figure">
    <div id="containerGaris"></div>
</figure>
<script type="text/javascript">
    Highcharts.chart('containerGaris', {

        title: {
            text: '<?php echo $judul_laporan; ?>'
        },

        // subtitle: {
        //     text: 'Source: thesolarfoundation.com'
        // },

        yAxis: {
            title: {
                text: 'Number of Employees'
            }
        },

        xAxis: {
            type: 'category',
            crosshair: true
        },

        legend: {
            layout: 'vertical',
            align: 'right',
            verticalAlign: 'middle'
        },

        series: [{
            name: 'Total per tahun',
            data: [
                <?php
                foreach ($lookup_m as $key => $value) {
                    $criteria = new CDbCriteria();
                    $criteria->select = "sum($key) as $key";
                    $criteria->addCondition("EXTRACT(YEAR from tglpenjualan) = " . $tahun);

                    $sum = LaporanjumlahresepV::model()->find($criteria);
                    echo "['" . $value . "'," . $sum->$key . "],";
                }
                ?>
            ],
        }],

        responsive: {
            rules: [{
                condition: {
                    maxWidth: 500
                },
                chartOptions: {
                    legend: {
                        layout: 'horizontal',
                        align: 'center',
                        verticalAlign: 'bottom'
                    }
                }
            }]
        }

    });
</script>