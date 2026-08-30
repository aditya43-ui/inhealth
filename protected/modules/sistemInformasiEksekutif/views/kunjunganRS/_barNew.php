<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/labels/chartjs-plugin-labels.js', CClientScript::POS_END);
?>
<div class="panel panel-success" style="margin-top: 17px;">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-chart-pie"></i> Grafik Berdasarkan Pelayan
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?= Chtml::label('Pelayanan', '', ['class' => 'control-label span2']) ?>
            <?= CHtml::dropDownList('pelayanan', 'pelayanan', ['1' => 'Rawat Inap', '2' => 'Rawat Jalan', '3' => 'Rawat Darurat'], [
                'prompt' => 'Pilih',
                /*
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('SetDropdownInstalasi', array('encode' => false, 'model_nama' => get_class('pelayanan'))),
                    //'update' => "#" . CHtml::activeId($model, 'kabupaten_id'),
                ),
                 */
                'onChange' => 'cariIns(this)'
            ]); ?>
        </div>
        <div class="control-group">
            <?= Chtml::label('Instalasi', '', ['class' => 'control-label span2']) ?>
            <?= CHtml::dropDownList('instalasi_id', 'instalasi_id', [], ['prompt' => 'Pilih', 'onChange' => 'caridata(this)']) ?>
        </div>
    </div>
    <div class="panel-body" id="grafik-bar">
        <canvas id="bar"></canvas>
    </div>
</div>
<script>
    $(document).ready(function() {
        var pieChart = <?= json_encode($dataBar) ?>;
        generateGrafik2($("#bar"), 'bar', pieChart.bar, '');
    });

    function generateGrafik2(id, tipe, getdata, jenis, legend) {
        var dtset = getdata;
        var display_tick_xaxes = true;
        var display_tick_yaxes = true;
        var stacked_yaxes = false;
        var legend_display = true;
        var posisi = 'border';
        var padding = 4;
        var margin = 4;
        var tampil = true;
        if (tipe == 'pie') {
            display_tick_xaxes = false;
            display_tick_yaxes = false;
            posisi = 'border';
            padding = 45;
            margin = 45;
            tampil = false;
        }
        if (jenis == 'stacked') {
            stacked_yaxes = true;
        }
        if (legend == 'off') {
            legend_display = false;
        }
        setTimeout(function() {
            var grafikTiga = new Chart(id, {
                type: tipe,
                data: dtset,
                options: {
                    responsive: true,
                    title: {
                        display: true,
                        text: ''
                    },
                    legend: {
                        display: legend_display,
                        position: 'bottom'
                    },
                    tooltips: {
                        mode: 'index',
                        intersect: false,
                    },
                    plugins: {
                        labels: {
                            render: function(args) {
                                if (tipe == 'pie') {
                                    return args.percentage + '%';
                                } else {
                                    return args.value;
                                }
                            },
                            fontColor: '#333',
                            fontStyle: 'bold',
                            position: posisi,
                            outsidePadding: padding,
                            textMargin: margin,
                            arc: false,
                            overlap: false,
                        }
                    },
                    scales: {
                        xAxes: [{
                            ticks: {
                                display: display_tick_xaxes
                            },
                            stacked: stacked_yaxes,
                            gridLines: {
                                display: tampil
                            }
                        }],
                        yAxes: [{
                            display: display_tick_yaxes,
                            stacked: stacked_yaxes,
                            gridLines: {
                                display: tampil
                            },
                            ticks: {
                                min: 0,
                            }
                        }]
                    },
                }
            });
        }, 300);
    }

    function cariIns(obj) {
        var jenis = $(obj).val();
        $('#SEKunjunganrsR_instalasi_id').val('');
        $.ajax({
            url: "<?= $this->createUrl('SetDropdownInstalasi'); ?>",
            type: 'post',
            data: {
                jenis: jenis,
            },
            success: function(data) {
                $("#instalasi_id").html(data);
            }
        })
    }

    function caridata(obj) {
        var isi = $(obj).val();
        $('#SEKunjunganrsR_instalasi_id').val(isi);
        $("#grafik-bar").html("<canvas id='bar'></canvas>");
        var jns_periode = $("#SEKunjunganrsR_jns_periode").val();
        var tgl_awal = $("#SEKunjunganrsR_tgl_awal").val();
        var tgl_akhir = $("#SEKunjunganrsR_tgl_akhir").val();
        var bln_awal = $("#SEKunjunganrsR_bln_awal").val();
        var bln_akhir = $("#SEKunjunganrsR_bln_akhir").val();
        var thn_awal = $("#SEKunjunganrsR_thn_awal").val();
        var thn_akhir = $("#SEKunjunganrsR_thn_akhir").val();
        var instalasi_id = $("#SEKunjunganrsR_instalasi_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('SetIFrameDashboard'); ?>',
            data: {
                jns_periode: jns_periode,
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir,
                bln_awal: bln_awal,
                bln_akhir: bln_akhir,
                thn_awal: thn_awal,
                thn_akhir: thn_akhir,
                instalasi_id: instalasi_id,
            },
            dataType: "json",
            success: function(data) {
                generateGrafik2($("#bar"), 'bar', data.bar, '');
            }
        });
    }
</script>