<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/html2canvas/html2canvas.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/html2canvas/html2canvas.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jsPDF/jspdf.min.js', CClientScript::POS_END);
?>
<style>
    #inichart {
        background: white;
    }
    #area-chart {
        background: white;
        margin-right: 15px;
    }
    #pie-chart {
        background: white;
        margin-right: 15px;
    }
    #line-chart {
        background: white;
        margin-right: 15px;
    }
    html{
        background: #fff !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">Laporan <strong>Insiden</strong></div>
    </div>
    <?php
    $url = Yii::app()->createUrl('yankesMasyarakat/laporaninsidenV/frameGrafikInsiden&id=1');
    Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('.search-form form').submit(function(){
            $('#Grafik').attr('src','').css('height','480px');
            $('#tableLaporan').addClass('animation-loading');
            $.fn.yiiGridView.update('tableLaporan', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
            </div>
            <div class="panel-body search-form">
                <?php $this->renderPartial('_search', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel <strong>Insiden</strong></div>
            </div>
            <div class="panel-body overflow-x" >
                <div class="block-tabel"> 
                    <?php $this->renderPartial('_table', array('model' => $model)); ?>
                </div>
            </div>
        </div>		
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">Grafik</div>

                <div class="panel-options">
                    <ul class="nav nav-tabs">
                        <li class="active"><a href="#area-chart" data-toggle="tab">Batang</a></li>
                        <li class=""><a href="#pie-chart" data-toggle="tab">Pie</a></li>
                        <li class=""><a href="#line-chart" data-toggle="tab">Garis</a></li>
                    </ul>
                </div>
            </div>
            <div class="panel-body">
                <!--                <div class="block-tabel">
                <?php // $this->renderPartial('_tab'); ?>
                                    <iframe class="biru" src="" id="Grafik" width="100%" height='0'></iframe>        
                                </div>-->
                <div class="tab-content">
                    <div class="tab-pane active up" id="area-chart">                                          
                        <canvas id="grafik-batang" ></canvas>
                    </div>
                    <div class="tab-pane up" id="pie-chart">
                        <canvas id="grafik-pie" ></canvas>
                    </div>
                    <div class="tab-pane up" id="line-chart">
                        <canvas id="grafik-garis" ></canvas>
                    </div>            
                </div>
                <table id="table-grafikTAT" class="table table-striped table-bordered table-condensed hide">
                    <thead>
                        <tr>
                            <th>Pilihan</th>
                            <th>Kuning</th>
                            <th>Hijau</th>
                            <th>Biru</th>
                            <th>Merah</th>
                            <th>Low</th>
                            <th>Moderate</th>
                            <th>High</th>
                            <th>Extreem</th>
                        </tr>
                    </thead>
                    <tbody>

                    </tbody>
                </table>
            </div>
        </div>	
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanInsiden');
        $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url));
        ?>
    </div>
</div>
<script>
    function downloadPDF() {
        const batang = document.querySelector("#area-chart");
        const pie = document.querySelector("#pie-chart");
        const garis = document.querySelector("#line-chart");
        
        if(batang.classList.contains("active") == true){
            var canvas = document.querySelector('#grafik-batang');
            //creates image
            var canvasImg = canvas.toDataURL("image/png", 1.0);
            var doc = new jsPDF('potrait');
            doc.setFontSize(20);
            doc.addImage(canvasImg, 'PNG', 10, 10, 180, 100);
            doc.save('Grafik Laporan Insiden.pdf');
        }else if(pie.classList.contains("active") == true){
            var canvas = document.querySelector('#grafik-pie');
            //creates image
            var canvasImg = canvas.toDataURL("image/png", 1.0);
            var doc = new jsPDF('potrait');
            doc.setFontSize(20);
            doc.addImage(canvasImg, 'PNG', 10, 10, 200, 100);
            doc.save('Grafik Laporan Insiden.pdf');
        }else if(garis.classList.contains("active") == true){
            var canvas = document.querySelector('#grafik-garis');
            //creates image
            var canvasImg = canvas.toDataURL("image/png", 1.0);
            var doc = new jsPDF('potrait');
            doc.setFontSize(20);
            doc.addImage(canvasImg, 'PNG', 10, 10, 180, 100);
            doc.save('Grafik Laporan Insiden.pdf');
        }
        
    }

    function caridata() {
        
        var pilihan = '';
        var ada1 = $('#YKMLaporaninsidenV_pilihan_0');
        if (ada1.is(" :checked")) {
            pilihan = 'a';
        }
        var ada2 = $('#YKMLaporaninsidenV_pilihan_1');
        if (ada2.is(" :checked")) {
            pilihan = 'b';
        }
        var ada3 = $('#YKMLaporaninsidenV_pilihan_2');
        if (ada3.is(" :checked")) {
            pilihan = 'c';
        }
        
        var tgl_awal = $('#YKMLaporaninsidenV_tgl_awal').val();
        var tgl_akhir = $('#YKMLaporaninsidenV_tgl_akhir').val();
        var ruangan_id = $('#YKMLaporaninsidenV_ruangan_id').val();
        var instalasi_id = $('#YKMLaporaninsidenV_instalasi_id').val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setDataGrafik'); ?>',
            data: {tgl_awal: tgl_awal, tgl_akhir: tgl_akhir, instalasi_id: instalasi_id, ruangan_id: ruangan_id, pilihan: pilihan},
            dataType: "json",
            success: function (data) {
                $('#searchLaporan').submit();
                $('#table-grafikTAT > tbody').html(data);
                $('#table-grafikTAT').removeClass("animation-loading");
                $('#grafik-batang').remove(); // this is my <canvas> element
                $('#grafik-pie').remove(); // this is my <canvas> element
                $('#grafik-garis').remove(); // this is my <canvas> element
                $('#area-chart').append('<canvas id="grafik-batang"><canvas>');
                $('#pie-chart').append('<canvas id="grafik-pie"><canvas>');
                $('#line-chart').append('<canvas id="grafik-garis"><canvas>');
                if(pilihan == 'a'){
                    generateGrafik1();
                } else if(pilihan == 'b'){
                    generateGrafik2();
                } else if(pilihan == 'c'){
                    generateGrafik3();
                }
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }

        });
    }


    function generateGrafik1() {
        var batang = $("#grafik-batang");
        var pie = $("#grafik-pie");
        var line = $("#grafik-garis");

        var o = 0;
        var p = 0;
        var q = 0;
        var r = 0;

        var arrKuning = [];
        var arrHijau = [];
        var arrBiru = [];
        var arrMerah = [];
        var arrPilihan = [];

        var piekuning = 0;
        var piehijau = 0;
        var piemerah = 0;
        var piebiru = 0;

        var a = 0;

        $("#table-grafikTAT > tbody > tr").each(function () {
            console.log($(this).find(".pilihan").val());
            //1
            if ($(this).find(".pilihan").val() != '' && $(this).find(".grade_kuning").val() != '') {
                piekuning = $(this).find(".grade_kuning").val();
                arrKuning[o] = {
                    x: $(this).find(".pilihan").val(),
                    y: $(this).find(".grade_kuning").val(),
                };
                o++;
            }

            //2
            if ($(this).find(".pilihan").val() != '' && $(this).find(".grade_hijau").val() != '') {
                piehijau = $(this).find(".grade_hijau").val();
                arrHijau[q] = {
                    x: $(this).find(".pilihan").val(),
                    y: $(this).find(".grade_hijau").val(),
                };
                q++;
            }

            //3
            if ($(this).find(".pilihan").val() != '' && $(this).find(".grade_biru").val() != '') {
                piebiru = $(this).find(".grade_biru").val();
                arrBiru[p] = {
                    x: $(this).find(".pilihan").val(),
                    y: $(this).find(".grade_biru").val(),
                };
                p++;
            }

            //4
            if ($(this).find(".pilihan").val() != '' && $(this).find(".grade_merah").val() != '') {
                piemerah = $(this).find(".grade_merah").val();
                arrMerah[r] = {
                    x: $(this).find(".pilihan").val(),
                    y: $(this).find(".grade_merah").val(),
                };
                r++;
            }

            //pilihan
            if ($(this).find(".pilihan").val() != '') {
                arrPilihan[a] = $(this).find(".pilihan").val();
            }
            a++;
        });
        console.log(arrPilihan);
        var grafikbatang = new Chart(batang, {
            type: 'bar',
            data: {
                labels: arrPilihan,
                datasets: [{
                        label: 'Biru',
                        data: arrBiru,
                        backgroundColor: '#00a3e8',
                        borderColor: '#00a3e8',
                    }, {
                        label: 'Hijau',
                        data: arrHijau,
                        backgroundColor: '#b5e51d',
                        borderColor: '#b5e51d',
                    }, {
                        label: 'Kuning',
                        data: arrKuning,
                        backgroundColor: '#ffc90d',
                        borderColor: '#ffc90d',
                    }, {
                        label: 'Merah',
                        data: arrMerah,
                        backgroundColor: '#e81600',
                        borderColor: '#e81600',
                    }],
            },
            backgroundColor: '#FFFFFF',
            options: {
                layout: {
                    padding: {
                        left: 50,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                },
                legend: {
                    labels: {
//                        usePointStyle: true
                    },
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Grading Risiko Insiden'
                },
                scales: {
                    xAxes: [{
                            scaleLabel: {
                                display: false,
                                labelString: 'Grading Risiko Insiden'
                            },
                            ticks: {
                                fontSize: 11
                            },
                            categoryPercentage: 0.5,
                            barPercentage: 1.0,
                            gridLines: {
                                offsetGridLines: true,
                            }
                        }],
                    yAxes: [{
                            scaleLabel: {
                                display: false,
                                labelString: '',
                            },
                            id: 'A',
                            type: 'linear',
                            position: 'left',
                        }],
                },
            },

        });

        var grafikpie = new Chart(pie, {
            type: 'pie',
            data: {
                labels: ['Biru', 'Hijau', 'Kuning', 'Merah'],
                datasets: [{
                        label: 'Tingkat Risiko Insiden',
                        data: [piebiru, piehijau, piekuning, piemerah],
                        backgroundColor: ['#00a3e8', '#b5e51d', '#ffc90d', '#e81600'],
                    }],
            },
            backgroundColor: '#FFFFFF',
            options: {
                showAllTooltips: true,
                responsive: true,
                title: {
                    display: true,
                    text: 'Tingkat Risiko Insiden'
                },
                legend: {
                    display: true,
                    position: 'right'
                },
                plugins: {
                    labels: {
                        render: function (args) {
                            return args.label + '\n' + args.percentage + '%';
                        },
                        fontColor: '#fff',
                        fontStyle: 'bold',
                    }
                }
            },
        });

        var grafikgaris = new Chart(line, {
            type: 'line',
            data: {
                labels: ['Biru', 'Hijau', 'Kuning', 'Merah'],
                datasets: [{
                        label: 'Jumlah',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        data: [piebiru, piehijau, piekuning, piemerah],
                        backgroundColor: ['#000'],
                        pointStyle: 'circle',
                        pointRadius: 7,
                    }],
            },
            backgroundColor: '#FFFFFF',
            options: {
                layout: {
                    padding: {
                        left: 50,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                },
                legend: {
                    labels: {
//                        usePointStyle: true
                    },
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Grading Risiko Insiden'
                },
                scales: {
                    xAxes: [{
                            scaleLabel: {
                                display: false,
                                labelString: 'Jumlah'
                            },
                            ticks: {
                                fontSize: 11
                            },
                            categoryPercentage: 0.5,
                            barPercentage: 1.0,
                            gridLines: {
                                offsetGridLines: true,
                            }
                        }],
                    yAxes: [{
                            scaleLabel: {
                                display: false,
                                labelString: '',
                            },
                            id: 'A',
                            type: 'linear',
                            position: 'left',
                        }],
                },
            },

        });
    }


    function generateGrafik2() {
        var batang = $("#grafik-batang");
        var pie = $("#grafik-pie");
        var line = $("#grafik-garis");

        var o = 0;
        var p = 0;
        var q = 0;
        var r = 0;

        var arrhigh = [];
        var arrmoderate = [];
        var arrlow = [];
        var arrextrem = [];
        var arrPilihan = [];

        var piehigh = 0;
        var piemoderate = 0;
        var pieextrem = 0;
        var pielow = 0;

        var a = 0;

        $("#table-grafikTAT > tbody > tr").each(function () {
            console.log($(this).find(".pilihan").val());
            //1
            if ($(this).find(".pilihan").val() != '' && $(this).find(".grade_high").val() != '') {
                piehigh = $(this).find(".grade_high").val();
                arrhigh[o] = {
                    x: $(this).find(".pilihan").val(),
                    y: $(this).find(".grade_high").val(),
                };
                o++;
            }

            //2
            if ($(this).find(".pilihan").val() != '' && $(this).find(".grade_moderate").val() != '') {
                piemoderate = $(this).find(".grade_moderate").val();
                arrmoderate[q] = {
                    x: $(this).find(".pilihan").val(),
                    y: $(this).find(".grade_moderate").val(),
                };
                q++;
            }

            //3
            if ($(this).find(".pilihan").val() != '' && $(this).find(".grade_low").val() != '') {
                pielow = $(this).find(".grade_low").val();
                arrlow[p] = {
                    x: $(this).find(".pilihan").val(),
                    y: $(this).find(".grade_low").val(),
                };
                p++;
            }

            //4
            if ($(this).find(".pilihan").val() != '' && $(this).find(".grade_extrem").val() != '') {
                pieextrem = $(this).find(".grade_extrem").val();
                arrextrem[r] = {
                    x: $(this).find(".pilihan").val(),
                    y: $(this).find(".grade_extrem").val(),
                };
                r++;
            }

            //pilihan
            if ($(this).find(".pilihan").val() != '') {
                arrPilihan[a] = $(this).find(".pilihan").val();
            }
            a++;
        });
        console.log(arrPilihan);
        var grafikbatang = new Chart(batang, {
            type: 'bar',
            data: {
                labels: arrPilihan,
                datasets: [{
                        label: 'Low',
                        data: arrlow,
                        backgroundColor: '#00a3e8',
                        borderColor: '#00a3e8',
                    }, {
                        label: 'Moderate',
                        data: arrmoderate,
                        backgroundColor: '#b5e51d',
                        borderColor: '#b5e51d',
                    }, {
                        label: 'High',
                        data: arrhigh,
                        backgroundColor: '#ffc90d',
                        borderColor: '#ffc90d',
                    }, {
                        label: 'Extrem',
                        data: arrextrem,
                        backgroundColor: '#e81600',
                        borderColor: '#e81600',
                    }],
            },
            backgroundColor: '#FFFFFF',
            options: {
                layout: {
                    padding: {
                        left: 50,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                },
                legend: {
                    labels: {
//                        usePointStyle: true
                    },
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Tingkat Risiko Insiden'
                },
                scales: {
                    xAxes: [{
                            scaleLabel: {
                                display: false,
                                labelString: 'Tingkat Risiko Insiden'
                            },
                            ticks: {
                                fontSize: 11
                            },
                            categoryPercentage: 0.5,
                            barPercentage: 1.0,
                            gridLines: {
                                offsetGridLines: true,
                            }
                        }],
                    yAxes: [{
                            scaleLabel: {
                                display: false,
                                labelString: '',
                            },
                            id: 'A',
                            type: 'linear',
                            position: 'left',
                        }],
                },
            },

        });

        var grafikpie = new Chart(pie, {
            type: 'pie',
            data: {
                labels: ['Low', 'Moderate', 'High', 'Extrem'],
                datasets: [{
                        label: 'Tingkat Risiko Insiden',
                        data: [pielow, piemoderate, piehigh, pieextrem],
                        backgroundColor: ['#00a3e8', '#b5e51d', '#ffc90d', '#e81600'],
                    }],
            },
            backgroundColor: '#FFFFFF',
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Tingkat Risiko Insiden'
                },
                legend: {
                    display: true,
                    position: 'right'
                },
                plugins: {
                    labels: {
                        render: function (args) {
                            return args.label + '\n' + args.percentage + '%';
                        },
                        fontColor: '#fff',
                        fontStyle: 'bold',
                    }
                }
            },
        });

        var grafikgaris = new Chart(line, {
            type: 'line',
            data: {
                labels: ['Low', 'Moderate', 'High', 'Extrem'],
                datasets: [{
                        label: 'Jumlah',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        data: [pielow, piemoderate, piehigh, pieextrem],
                        backgroundColor: ['#000'],
                        pointStyle: 'circle',
                        pointRadius: 7,
                    }],
            },
            backgroundColor: '#FFFFFF',
            options: {
                layout: {
                    padding: {
                        left: 50,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                },
                legend: {
                    labels: {
//                        usePointStyle: true
                    },
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Tingkat Risiko Insiden'
                },
                scales: {
                    xAxes: [{
                            scaleLabel: {
                                display: false,
                                labelString: 'Jumlah'
                            },
                            ticks: {
                                fontSize: 11
                            },
                            categoryPercentage: 0.5,
                            barPercentage: 1.0,
                            gridLines: {
                                offsetGridLines: true,
                            }
                        }],
                    yAxes: [{
                            scaleLabel: {
                                display: false,
                                labelString: '',
                            },
                            id: 'A',
                            type: 'linear',
                            position: 'left',
                        }],
                },
            },

        });
    }
    
    
    function generateGrafik3() {
        var batang = $("#grafik-batang");
        var pie = $("#grafik-pie");
        var line = $("#grafik-garis");

        var q = 0;
        var r = 0;

        var arrHijau = [];
        var arrMerah = [];
        var arrPilihan = [];

        var piehijau = 0;
        var piemerah = 0;

        var a = 0;

        $("#table-grafikTAT > tbody > tr").each(function () {
            console.log($(this).find(".pilihan").val());

            //2
            if ($(this).find(".pilihan").val() != '' && $(this).find(".grade_hijau").val() != '') {
                piehijau = $(this).find(".grade_hijau").val();
                arrHijau[q] = {
                    x: $(this).find(".pilihan").val(),
                    y: $(this).find(".grade_hijau").val(),
                };
                q++;
            }

            //4
            if ($(this).find(".pilihan").val() != '' && $(this).find(".grade_merah").val() != '') {
                piemerah = $(this).find(".grade_merah").val();
                arrMerah[r] = {
                    x: $(this).find(".pilihan").val(),
                    y: $(this).find(".grade_merah").val(),
                };
                r++;
            }

            //pilihan
            if ($(this).find(".pilihan").val() != '') {
                arrPilihan[a] = $(this).find(".pilihan").val();
            }
            a++;
        });
        console.log(arrPilihan);
        var grafikbatang = new Chart(batang, {
            type: 'bar',
            data: {
                labels: arrPilihan,
                datasets: [{
                        label: '<= 2x24 jam',
                        data: arrHijau,
                        backgroundColor: '#00a3e8',
                        borderColor: '#00a3e8',
                    }, {
                        label: '> 2x24 jam',
                        data: arrMerah,
                        backgroundColor: '#e81600',
                        borderColor: '#e81600',
                    }],
            },
            backgroundColor: '#FFFFFF',
            options: {
                layout: {
                    padding: {
                        left: 50,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                },
                legend: {
                    labels: {
//                        usePointStyle: true
                    },
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Waktu Pelaporan Insiden'
                },
                scales: {
                    xAxes: [{
                            scaleLabel: {
                                display: false,
                                labelString: 'Waktu Pelaporan Insiden'
                            },
                            ticks: {
                                fontSize: 11
                            },
                            categoryPercentage: 0.5,
                            barPercentage: 1.0,
                            gridLines: {
                                offsetGridLines: true,
                            }
                        }],
                    yAxes: [{
                            scaleLabel: {
                                display: false,
                                labelString: '',
                            },
                            id: 'A',
                            type: 'linear',
                            position: 'left',
                        }],
                },
            },

        });

        var grafikpie = new Chart(pie, {
            type: 'pie',
            data: {
                labels: ['<= 2x24 jam', '> 2x24 jam'],
                datasets: [{
                        label: 'Waktu Pelaporan Insiden',
                        data: [piehijau, piemerah],
                        backgroundColor: ['#00a3e8', '#e81600'],
                    }],
            },
            backgroundColor: '#FFFFFF',
            options: {
                responsive: true,
                title: {
                    display: true,
                    text: 'Waktu Pelaporan Insiden'
                },
                legend: {
                    display: true,
                    position: 'right'
                },
                plugins: {
                    labels: {
                        render: function (args) {
                            return args.label + '\n' + args.percentage + '%';
                        },
                        fontColor: '#fff',
                        fontStyle: 'bold',
                    }
                }
            },
        });

        var grafikgaris = new Chart(line, {
            type: 'line',
            data: {
                labels: ['<= 2x24 jam', '> 2x24 jam'],
                datasets: [{
                        label: 'Jumlah',
                        yAxisID: 'A',
                        display: false,
                        fill: false,
                        data: [piehijau, piemerah],
                        backgroundColor: ['#000'],
                        pointStyle: 'circle',
                        pointRadius: 7,
                    }],
            },
            backgroundColor: '#FFFFFF',
            options: {
                layout: {
                    padding: {
                        left: 50,
                        right: 0,
                        top: 0,
                        bottom: 0
                    }
                },
                tooltips: {
                    mode: 'nearest',
                    intersect: false,
                },
                legend: {
                    labels: {
//                        usePointStyle: true
                    },
                },
                responsive: true,
                title: {
                    display: true,
                    text: 'Waktu Pelaporan Insiden'
                },
                scales: {
                    xAxes: [{
                            scaleLabel: {
                                display: false,
                                labelString: 'Jumlah'
                            },
                            ticks: {
                                fontSize: 11
                            },
                            categoryPercentage: 0.5,
                            barPercentage: 1.0,
                            gridLines: {
                                offsetGridLines: true,
                            }
                        }],
                    yAxes: [{
                            scaleLabel: {
                                display: false,
                                labelString: '',
                            },
                            id: 'A',
                            type: 'linear',
                            position: 'left',
                        }],
                },
            },

        });
    }
    
    $(document).ready(function () {
        var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
        var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');
        var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
        var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');
        var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
        var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');
        var pelayanan = jQuery('#<?php echo CHtml::activeId($model, 'kelaspelayanan_id') ?>');
        var tujuan = jQuery('#<?php echo CHtml::activeId($model, 'ruangantujuan_id') ?>');
        var penunjang = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpenunj_id') ?>');
        var obat = jQuery('#<?php echo CHtml::activeId($model, 'jenisobatalkes_id') ?>');
        var cara_keluar = jQuery('#<?php echo CHtml::activeId($model, 'carakeluar') ?>');
        var tindakan = jQuery('#<?php echo CHtml::activeId($model, 'tindakansudahbayar_id') ?>');
        var jenispenjualan = jQuery('#<?php echo CHtml::activeId($model, 'jenispenjualan') ?>');
        var statusbayar = jQuery('#<?php echo CHtml::activeId($model, 'statusbayar') ?>');
        var instalasipemesan_nama = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>');
        var ruanganpemesan_nama = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_nama') ?>');
        var obatalkes_kategori = jQuery('#<?php echo CHtml::activeId($model, 'obatalkes_kategori') ?>');
        var pegawai = jQuery('#<?php echo CHtml::activeId($model, 'pegawai_id') ?>');
        var kunjungan = jQuery('#<?php echo CHtml::activeId($model, 'kunjungan') ?>');
        var instalasipemesan_id = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>');
        var ruanganpemesan_id = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_id') ?>');
        var asalrujukan_id = jQuery('#<?php echo CHtml::activeId($model, 'asalrujukan_id') ?>');
        var namaperujuk = jQuery('#<?php echo CHtml::activeId($model, 'namaperujuk') ?>');
        var nama_pegawai = jQuery('#<?php echo CHtml::activeId($model, 'nama_pegawai') ?>');


        jQuery(instalasipemesan_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_id') ?>');
                var brands = ins_all;
                var selected = [];
                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });
                ru.addClass('animation-loading');
                //alert(selected);
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_id: selected},
                    success: function (data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onSelectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_id') ?>');
                var brands = ins_all;
                var selected = [];
                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });
                ru.addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_id: selected},
                    success: function (data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            },
            onDeselectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_id') ?>');
                var brands = ins_all;
                var selected = '';
                ru.addClass('animation-loading');
                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_id: selected},
                    success: function (data) {
                        if (data.sukses != '1') {
                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);
                    }
                });
            }
        }).hide();

        jQuery(instalasipemesan_nama).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_nama') ?>');

                var brands = ins_all;
                var selected = [];


                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganpemesanByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasipemesan_nama: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan_nama);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_nama') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganpemesanByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasipemesan_nama: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan_nama);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasipemesan_nama') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruanganpemesan_nama') ?>');

                var brands = ins_all;
                var selected = '';



                ru.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganpemesanByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasipemesan_nama: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan_nama);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];


                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_id: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                ru.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_id: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = '';



                ru.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {instalasi_id: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            ru.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            ru.html(data.ruangan);
                            ru.multiselect('rebuild');
                            ru.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(ru).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        /**
         * multi select cara bayar dan penjamin
         */


        jQuery(cara).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = cara_all;
                var selected = [];


                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                penj.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetPenjaminByMultiSelect') ?>',
                    dataType: "json",
                    data: {carabayar_id: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjamin);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function () {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                penj.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {carabayar_id: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjaminan);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function () {
                var cara = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>');
                var cara_all = jQuery('#<?php echo CHtml::activeId($model, 'carabayar_id') ?>   option:selected');
                var penj = jQuery('#<?php echo CHtml::activeId($model, 'penjamin_id') ?>');

                var brands = ins_all;
                var selected = '';



                penj.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetRuanganByMultiSelect') ?>',
                    dataType: "json",
                    data: {carabayar_id: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            penj.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            penj.html(data.penjamin);
                            penj.multiselect('rebuild');
                            penj.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(penj).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();


        /**
         * multi select propinsi dan kabupaten
         */

        jQuery(prop).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
                var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
                var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');

                var brands = prop_all;
                var selected = [];


                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                kab.addClass('animation-loading');
                //alert(selected);

                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',
                    dataType: "json",
                    data: {propinsi_id: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            kab.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            kab.html(data.kabupaten);
                            kab.multiselect('rebuild');
                            kab.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onSelectAll: function () {
                var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
                var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
                var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');

                var brands = prop_all;
                var selected = [];

                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                kab.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',
                    dataType: "json",
                    data: {propinsi_id: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            kab.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            kab.html(data.kabupaten);
                            kab.multiselect('rebuild');
                            kab.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            },
            onDeselectAll: function () {
                var prop = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>');
                var prop_all = jQuery('#<?php echo CHtml::activeId($model, 'propinsi_id') ?>   option:selected');
                var kab = jQuery('#<?php echo CHtml::activeId($model, 'kabupaten_id') ?>');

                var brands = prop_all;
                var selected = '';



                kab.addClass('animation-loading');


                jQuery.ajax({
                    type: 'POST',
                    url: '<?php echo $this->createUrl('/ActionDynamic/GetKabupatenByMultiSelect') ?>',
                    dataType: "json",
                    data: {propinsi_id: selected},
                    success: function (data) {

                        if (data.sukses != '1') {

                            //toastr.error(data.pesan);
                            kab.addClass('animation-loading');
                        } else {
                            //alert(data.ruangan);
                            kab.html(data.kabupaten);
                            kab.multiselect('rebuild');
                            kab.removeClass('animation-loading');
                        }
                    },
                    error: function (jqXHR, textStatus, errorThrown) {
                        console.log(errorThrown);

                    }
                });

            }
        }).hide();

        jQuery(kab).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(pelayanan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(tujuan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(penunjang).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(obat).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(cara_keluar).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(tindakan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(jenispenjualan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(statusbayar).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(instalasipemesan_nama).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(ruanganpemesan_nama).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(obatalkes_kategori).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(pegawai).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(kunjungan).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(ruanganpemesan_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(asalrujukan_id).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(namaperujuk).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

        jQuery(nama_pegawai).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();

    });
</script>