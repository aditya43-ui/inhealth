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
        var arrSatu = 0;
        var arrDua = 0;
        var arrTiga = 0;
        var arrEmpat = 0;
        var a = 0;
        $("#table-grafikTAT > tbody > tr").each(function() {
            console.log($(this).find(".periode").val());
            //1
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_rs").val() != '') {
                arrSatu += parseInt($(this).find(".jumlah_rs").val());
            }
            //2
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_klinik").val() != '') {
                arrDua += parseInt($(this).find(".jumlah_klinik").val());
            }
            //3
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_dokter").val() != '') {
                arrTiga += parseInt($(this).find(".jumlah_dokter").val());
            }
            //4
            if ($(this).find(".periode").val() != '' && $(this).find(".jumlah_puskesmas").val() != '') {
                arrEmpat += parseInt($(this).find(".jumlah_puskesmas").val());
            }
            a++;
        });
        var pieTensi = new Chart(tensi, {
            type: 'pie',
            data: {
                labels: ['Rumah Sakit', 'Klinik', 'Dokter', 'Puskesmas'],
                datasets: [{
                    label: 'Rujukan Pasien',
                    data: [arrSatu, arrDua, arrTiga, arrEmpat],
                    backgroundColor: ['#f56954', '#00a65a', '#ffa812', '#00c0ef'],
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
            <i class="fas fa-chart-pie"></i> Grafik Prosentase Rujukan Pasien
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div id="inichart">
            <canvas id="chart_pie" width="1200" height="600"> </canvas>
        </div>
    </div>
</div>