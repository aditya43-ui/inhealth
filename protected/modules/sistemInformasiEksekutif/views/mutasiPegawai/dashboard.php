<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/labels/chartjs-plugin-labels.js', CClientScript::POS_END);
?>
<?php $this->renderPartial('_search', array('model' => $model, 'unit' => $unit)); ?>
<?php $this->renderPartial('_tile', array('count' => $count)); ?>
<?php $this->renderPartial('_bar', ['unit' => $unit]); ?>
<?php $this->renderPartial('_grid', ['model' => $model]); ?>
<?php //$this->renderPartial('_stacked', array('model' => $model,'dataBarLineChart' => $dataBarLineChart)); 
?>
<?php //$this->renderPartial('_table', array('model' => $model, 'dataTable' => $dataTable)); 
?>
<script>
    $(document).ready(function() {
        var ru = jQuery('#<?php echo CHtml::activeId($model, 'unitkerja_id') ?>');
        jQuery(ru).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function(element, checked) {
                var check = jQuery('#<?php echo CHtml::activeId($model, 'unitkerja_id') ?>   option:selected').length;
                if (check > 5) {
                    toastr.warning("maksimum 5 Unit yang dipilih", "Perhatian");
                    $("#<?php echo CHtml::activeId($model, 'unitkerja_id') ?> option[value='" + element[0].value + "']").removeAttr("selected");
                }
                jQuery('#<?php echo CHtml::activeId($model, 'unitkerja_id') ?>').multiselect("refresh");
            },
        }).hide();
        ubahJnsPeriode();
        bersih();
        cari();
        //$("#search-laporan").find("input[type=\'checkbox\']").attr("checked", "checked");
    });

    function refreshForm() {
        window.location.href = "<?= Yii::app()->createUrl($this->route); ?>";
    }

    function ubahJnsPeriode() {
        var obj = $("#<?= CHtml::activeId($model, 'jns_periode') ?>");
        if (obj.val() == 'hari') {
            $('.hari').show();
            $('.bulan').hide();
            $('.tahun').hide();
        } else if (obj.val() == 'bulan') {
            $('.hari').hide();
            $('.bulan').show();
            $('.tahun').hide();
        } else if (obj.val() == 'tahun') {
            $('.hari').hide();
            $('.bulan').hide();
            $('.tahun').show();
        }
    }

    function getData() {
        cari();
        grid();
    }

    function grid() {
        var tgl_awal = $("#<?php echo CHtml::activeId($model, 'tgl_awal') ?>").val();
        var tgl_akhir = $("#<?php echo CHtml::activeId($model, 'tgl_akhir') ?>").val();
        var unitkerja_id = $("#<?php echo CHtml::activeId($model, 'unitkerja_id') ?>").val();
        setTimeout(function() {
            $.fn.yiiGridView.update('mutasi-r-grid', {
                data: {
                    "SEPegawaimutasiR[tgl_awal]": tgl_awal,
                    "SEPegawaimutasiR[tgl_akhir]": tgl_akhir,
                    "SEPegawaimutasiR[unitkerja_id]": unitkerja_id,
                }
            });
        }, 100);
    }

    function renameInput(obj_table) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find("#no_urut").val(row + 1);
            $(this).find('span').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("name", "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");
                if (old_name_arr.length == 3) {
                    $(this).attr("id", old_name_arr[0] + "_" + row + "_" + old_name_arr[2]);
                    $(this).attr("name", old_name_arr[0] + "[" + row + "][" + old_name_arr[2] + "]");
                }
            });
            row++;
        });
    }

    function cari(obj = "", unit_kerja = "", cart = "") {
        bersih();
        var cek = $(obj).attr("id");
        var unit_kerja = $("#unit_kerja").val();
        if (obj == "") {
            activaTab('batang-chart');
            $("#unit_kerja").val('');
            panel = "cari_batang";
        } else {
            if (cart != "") {
                panel = cart;
            } else {
                panel = cek;
            }
        }
        var tgl_awal = $("#SEPegawaimutasiR_tgl_awal").val();
        var tgl_akhir = $("#SEPegawaimutasiR_tgl_akhir").val();
        var unit_id = $("#SEPegawaimutasiR_unitkerja_id").val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getData') ?>',
            dataType: "json",
            data: {
                tgl_awal: tgl_awal,
                tgl_akhir: tgl_akhir,
                unit_id: unit_id,
                panel: panel,
                unit_kerja: unit_kerja,
            },
            success: function(data) {
                //console.log(data.bar);
                $("#tile1").html(data.count.tile_perempuan);
                $("#tile2").html(data.count.tile_laki);
                $("#tile3").html(data.count.tile_pns);
                $("#tile4").html(data.count.tile_blud);
                if (panel == 'cari_batang') {
                    generateGrafik($("#batang"), 'bar', data.bar);
                } else if (panel == 'cari_pie') {
                    generateGrafik($("#pie"), 'pie', data.bar, '');
                } else {
                    generateGrafik($("#garis"), 'line', data.bar, '');
                }
            }
        });
    }
    $("#unit_kerja").change(function() {
        var unit_kerja = $("#unit_kerja").val();
        var cart = 'cari_pie';
        cari(cart, unit_kerja, cart);
    });

    function generateGrafik(id, tipe, getdata, jenis, legend) {
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
            posisi = 'outside';
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
                                    return args.label + '\n' + args.percentage + '%';
                                } else {
                                    return args.value;
                                }
                            },
                            fontColor: '#333',
                            fontStyle: 'bold',
                            position: posisi,
                            outsidePadding: padding,
                            textMargin: margin,
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

    function bersih() {
        $("#batang").parents('.up').html("<canvas id='batang'></canvas>");
        $("#pie").parents('.up').html("<canvas id='pie'></canvas>");
        $("#garis").parents('.up').html("<canvas id='garis'></canvas>");
    }

    function activaTab(tab) {
        $('.nav-tabs a[href="#' + tab + '"]').tab('show');
    };
</script>