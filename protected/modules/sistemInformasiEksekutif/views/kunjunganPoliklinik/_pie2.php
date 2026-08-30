<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/labels/chartjs-plugin-labels.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/html2canvas/html2canvas.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/html2canvas/html2canvas.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jsPDF/jspdf.min.js', CClientScript::POS_END);
?>
<script>
    $(document).ready(function() {
        var tensi = $("#chart_pie");
        var arrSatu = [];
        var arrDua = [];
        var jenis = '';
        var jml = 0;
        var a = 0;
        $("#table-grafik-pie > tbody > tr").each(function() {
            console.log($(this).find(".periode").val());
            //1
            if ($(this).find(".jenis").val() != '') {
                jenis = $(this).find(".jenis").val();
                arrSatu.push(jenis);
            }
            //2
            if ($(this).find(".jumlah").val() != '') {
                jml = parseInt($(this).find(".jumlah").val());
                arrDua.push(jml);
            }
            a++;
        });
        var pieTensi = new Chart(tensi, {
            type: 'pie',
            data: {
                labels: arrSatu,
                datasets: [{
                    label: 'Kunjungan Poli Klinik',
                    data: arrDua,
                    backgroundColor: [
                        '#16a085', '#27ae60', '#2980b9', '#8e44ad', '#2c3e50', '#f39c12', '#d35400', '#c0392b', '#bdc3c7',
                        '#c20e77', '#a67977', '#d8db47', '#abe9b1', '#a0990d', '#27bfa7', '#43a9fb', '#7a58ba', '#230191',
                        '#7a8cc4', '#dcc05f'
                    ]
                }],
            },
            backgroundColor: '#FFFFFF',
            options: {
                showAllTooltips: true,
                responsive: true,
                legend: {
                    display: true,
                    position: 'right'
                },
                maintainAspectRatio: true,
                title: {
                    display: true,
                    text: ''
                },
                legendCallback: function(chart) {
                    var ul = document.createElement('ul');
                    if (typeof chart.data.datasets[0] !== 'undefined') {
                        var backgroundColor = chart.data.datasets[0].backgroundColor;
                        var dataChart = chart.data.datasets[0].data;
                    }
                    return ul.outerHTML;
                },
                plugins: {
                    labels: {
                        render: function(args) {
                            return args.percentage + '%';
                        },
                        fontColor: '#fff',
                        fontStyle: 'bold',
                    }
                }
            },
        });
    });
</script>
<div class="panel panel-success" style="margin-top: 17px">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Prosentase Kunjungan Poli Klinik
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <table id="table-grafik-pie" class="table table-striped table-bordered table-condensed hide">
            <thead>
                <tr>
                    <th>Jenis</th>
                    <th>Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php $i = 0; ?>
                <?php foreach ($dataPieChart as $value) : ?>
                    <tr>
                        <td><?php echo CHtml::hiddenField('jenis', $value['jenis'], array('readonly' => true, 'class' => 'jenis')); ?></td>
                        <td><?php echo CHtml::hiddenField('jumlah', $value['jumlah'], array('readonly' => true, 'class' => 'jumlah')); ?></td>
                    </tr>
                    <?php $i++; ?>
                <?php endforeach; ?>
            </tbody>
        </table>
        <div id="inichart">
            <canvas id="chart_pie" width="1200" height="600"> </canvas>
        </div>
    </div>
</div>