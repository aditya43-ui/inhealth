<style type="text/css">
    .highcharts-figure,
    .highcharts-data-table table {
        min-width: 310px;
        max-width: 800px;
        margin: 1em auto;
    }

    #container {
        height: 400px;
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
    <div id="containerBatang"></div>
</figure>
<script type="text/javascript">
    Highcharts.chart('containerBatang', {
        chart: {
            type: 'column'
        },
        title: {
            text: '<?php echo $judul_laporan; ?>'
        },
        xAxis: {
            categories: [
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec'
            ],
            crosshair: true
        },
        yAxis: {
            min: 0,
            title: {
                text: 'Total'
            }
        },
        tooltip: {
            headerFormat: '<span style="font-size:10px">{point.key}</span><table>',
            pointFormat: '<tr><td style="color:{series.color};padding:0">{series.name}: </td>' +
                '<td style="padding:0"><b>{point.y:.1f}</b></td></tr>',
            footerFormat: '</table>',
            shared: true,
            useHTML: true
        },
        plotOptions: {
            column: {
                pointPadding: 0.2,
                borderWidth: 0
            }
        },
        series: [
            <?php
            foreach ($lookup_m as $key => $value) {
            ?> {
                    name: '<?php echo $value; ?>',
                    data: [
                        <?php
                        for ($bln = 1; $bln <= 12; $bln++) {
                            $criteria = new CDbCriteria();
                            $criteria->select = "sum($key) as $key";
                            $criteria->addCondition("EXTRACT(MONTH from tglpenjualan) = " . $bln);
                            $criteria->addCondition("EXTRACT(YEAR from tglpenjualan) = " . $tahun);
                            $sum = LaporanjumlahresepV::model()->find($criteria);
                            $nilai = 0;
                            if(!empty($sum)){
                                $nilai = (int)$sum->$key;
                            }
                            echo $nilai.',';
                        }
                        ?>
                    ]
                },
            <?php
            }
            ?>
        ]
    });
</script>