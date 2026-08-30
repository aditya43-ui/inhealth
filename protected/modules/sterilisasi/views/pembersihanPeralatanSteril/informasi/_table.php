<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/datetime.js'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/fileinput.js'); ?>
<div class="panel panel-gradient">
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Pembersihan</b>
        </div>
    </div>
    <div class="panel-body">
        <!--<div class="white-container">-->
        <?php
        $this->breadcrumbs = array(
            'Informasi Pembersihan',
        );
        Yii::app()->clientScript->registerScript('search', "
$('#dekontaminasi-info-search').submit(function(){
	$('#informasipembersihan-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasipembersihan-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . 'informasi/_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Pembersihan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php
                $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasipembersihan-grid',
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'No.',
                            'headerHtmlOptions' => array('style' => 'text-align: center;vertical-align:middle;'),
                            'value' => '$row+1'
                        ),
                        array(
                            'header' => 'No. Penerimaan',
                            'type' => 'raw',
                            'value' => '$data->getNoPenerimaan($data->dekontaminasi_id)'
                        ),
                        array(
                            'header' => 'Tanggal Pembersihan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->tgl_pembersihan)'
                        ),
                        array(
                            'header' => 'No. Pembersihan',
                            'type' => 'raw',
                            'value' => '$data->no_pembersihan'
                        ),
                        array(
                            'header' => 'Nama Peralatan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $dekon = DekontaminasidetailT::model()->findAllByAttributes(array(
                                    'dekontaminasi_id' => $data->dekontaminasi_id,
                                ));
                                if (count((array)$dekon) == 0) {
                                    return "-";
                                }
                                $str = "<ul>";
                                foreach ($dekon as $item) {
                                    $det = PenerimaansterilisasidetT::model()->findByPk($item->penerimaansterilisasidet_id);
                                    if (empty($det)) continue;
                                    $peralatan = PeralatansterilisasiM::model()->findByPk($det->peralatansterilisasi_id);
                                    /*
                                    $mapBarang = MapbarangsterilisasiM::model()->findByAttributes(array('peralatansterilisasi_id'=>$det->peralatansterilisasi_id));
                                    $mapLinen = MaplinensterilisasiM::model()->findByAttributes(array('peralatansterilisasi_id'=>$det->peralatansterilisasi_id));
                                    $mapAlkes = MapalkessterilisasiM::model()->findByAttributes(array('peralatansterilisasi_id'=>$det->peralatansterilisasi_id));
                                    $nama = "";
                                    if(!empty($mapBarang)){
                                        $barang = BarangM::model()->findByPk($mapBarang->barang_id);
                                        $nama = $barang->barang_nama;
                                    } else if(!empty($mapLinen)){
                                        $barang = LinenM::model()->findByPk($mapLinen->linen_id);
                                        $nama = $barang->namalinen;
                                    } else if(!empty($mapAlkes)){
                                        $barang = ObatalkesM::model()->findByPk($mapAlkes->obatalkes_id);
                                        $nama = $barang->obatalkes_nama;
                                    } else continue;
                                    */
                                    $str .= "<li>" . $peralatan->peralatansterilisasi_nama . " (x" . $item->dekontaminasidetail_jml . ")</li>";
                                }
                                $str .= "</ul>";
                                return $str;
                            }
                        ),
                        array(
                            'header' => 'Status Proses',
                            'type' => 'raw',
                            'value' => '$data->statusproses'
                        ),
                        array(
                            'header' => 'Mesin',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $b = BarangM::model()->findByPk($data->namamesin_id);
                                if (empty($b)) {
                                    return "-";
                                }
                                return $b->barang_nama;
                            }
                        ),
                        array(
                            'header' => 'Mulai Pembersihan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForDb($data->mulaipembersiha)'
                        ),
                        array(
                            'header' => 'Selesai Pembersihan',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForDb($data->selesaipembersihan)'
                        ),
                        array(
                            'header' => 'Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-detail\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/PembersihanPeralatanSteril/detail",array("pembersihan_id"=>$data->pembersihan_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));', 'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->statuspembersihan == Params::STATUSPEMBERSIHAN_MULAI) {
                                    return '<button id="red" class="btn btn-gold nohover btn-status" name="yt1" onclick="setStatus(' . $data->pembersihan_id . '); ">' . $data->statuspembersihan . '</button>';
                                } else if ($data->statuspembersihan == Params::STATUSPEMBERSIHAN_SEDANGCUCI) {
                                    return '<button id="red" class="btn btn-gold nohover btn-status" name="yt1" onclick="setdialogIndikator(' . $data->pembersihan_id . '); $(\'#dialogIndikator\').dialog(\'open\');return false; ">' . $data->statuspembersihan . '</button>';
                                } else {
                                    return '<button id="red" class="btn btn-gold nohover btn-status" name="yt1">' . $data->statuspembersihan . '</button>';
                                }
                            }
                        ),
                        array(
                            'header' => 'Inspeksi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->statuspembersihan == Params::STATUSPEMBERSIHAN_SELESAI) {
                                    return CHtml::link("<i class='fa fa-check-square'></i>", Yii::app()->controller->createUrl("/sterilisasi/ProsesInspeksi/index", array("pembersihan_id" => $data->pembersihan_id)));
                                }
                            },
                            'htmlOptions' => array(
                                'style' => 'text-align: center',
                            ),
                        ),
                        array(
                            'header' => 'Sterilisasi',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $inspeksi = InspeksiinstrumenT::model()->findByAttributes(array(
                                    'pembersihan_id' => $data->pembersihan_id,
                                ));
                                if (empty($inspeksi)) {
                                    return 'BELUM DI INSPEKSI';
                                }
                                $det = DekontaminasidetailT::model()->findByAttributes(array(
                                    'dekontaminasi_id' => $data->dekontaminasi_id
                                ));
                                $modPenerimaanSterilisasiDetail = PenerimaansterilisasidetT::model()->findByAttributes(array('penerimaansterilisasi_id' => $det->penerimaansterilisasi_id));
                                $steril = SterilisasidetailT::model()->findByAttributes(array('penerimaansterilisasi_id' => $det->penerimaansterilisasi_id));
                                if (!empty($steril)) {
                                    return "SUDAH DI STERILISASI";
                                }
                                if (empty($modPenerimaanSterilisasiDetail)) {
                                    return "-";
                                }
                                if ($modPenerimaanSterilisasiDetail->keadaanperalatan == "BERSIH") {
                                    return CHtml::link("<i class='entypo-pencil'></i>", Yii::app()->controller->createUrl("/sterilisasi/SterilisasiT/index", array('pembersihan_id' => $data->pembersihan_id)), array("rel" => "tooltip", "title" => "Klik untuk Sterilisasi"));
                                } else {
                                    //return'';
                                    $modSterilisasiDetail = SterilisasidetailT::model()->findByAttributes(array('penerimaansterilisasi_id' => $data->penerimaansterilisasi_id));
                                    if ($modSterilisasiDetail != NULL) {
                                        $modSterilisasi = SterilisasiT::model()->findByAttributes(array('sterilisasi_id' => $modSterilisasiDetail->sterilisasi_id));
                                        if ($modSterilisasi != NULL) {
                                            $no = $modSterilisasi->sterilisasi_no;
                                            $tgl = MyFormatter::formatDateTimeforUser($modSterilisasi->sterilisasi_tgl);
                                            return CHtml::link($no . '/' . $tgl, Yii::app()->createUrl('sterilisasi/PenerimaanPeralatanSterilT/detailSterilisasi&id=' . $data->penerimaansterilisasi_id), array("rel" => "tooltip", "title" => "Klik untuk Rincian Sterilisasi", "target" => "frameDetailSterilisasi", "onclick" => "$(\"#dialogDetailsSterilisasi\").dialog(\"open\");",));
                                        } else {
                                            return '-';
                                        }
                                    }
                                }
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                ));
                ?>
            </div>
        </div>
    </div>
</div>
<div hidden>
    <?php
    $this->widget('MyDateTimePicker', array(
        'name' => 'placeholder_0',
        'mode' => 'datetime',
        'options' => array(
            'dateFormat' => Params::DATE_FORMAT,
            'maxDate' => 'd',
        ),
        'htmlOptions' => array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
    ));
    ?>
</div>
<?php
//========= Dialog untuk Melihat detail Pembersihan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => true,
    ),
));
echo '<iframe src="" name="frameDetail" style="overflow:auto; width: 100%; height: 98%;"></iframe>';
$this->endWidget();
?>
<?php
//======================= form indikator ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogIndikator',
        'options' => array(
            'title' => 'Hasil Indikator',
            'autoOpen' => false,
            'minWidth' => 1000,
            'height' => 1000,
            'modal' => true,
        ),
    )
);
echo CHtml::hiddenField('temp_dialogIndikator', '', array('readonly' => true));
echo '<div class="divForFormdialogIndikator"></div>';
$this->endWidget();
// end
?>
<script type="text/javascript">
    function setStatus(id) {
        var pembersihan_id = id;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setStatusPembersihan'); ?>',
            data: {
                pembersihan_id: pembersihan_id
            },
            dataType: "json",
            success: function(data) {
                if (data.status == true) {
                    $.fn.yiiGridView.update('informasipembersihan-grid');
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function setdialogIndikator(id) {
        //      myAlert(id);
        $('#temp_dialogIndikator').val(id);
        jQuery.ajax({
            'url': '<?php echo $this->createUrl('updatePembersihan') ?>',
            'data': {
                id: id
            },
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.status == 'create_form') {
                    $('#dialogIndikator div.divForFormdialogIndikator').html(data.div);
                    loadDataPendaftaran();
                    generatePicker();
                }
            },
            'cache': false
        });
        return false;
    }

    function loadDataPendaftaran() {
        var pembersihan_id = $('#temp_dialogIndikator').val();
        $('#PembersihanT_pembersihan_id').val(pembersihan_id);
    }

    function generatePicker() {
        jQuery('input[name$="[selesaipembersihan]"]').datetimepicker(
            jQuery.extend({
                    showMonthAfterYear: false
                },
                jQuery.datepicker.regional['id'], {
                    'dateFormat': 'dd M yy',
                    'minDate': 'd',
                    'timeText': 'Waktu',
                    'hourText': 'Jam',
                    'minuteText': 'Menit',
                    'secondText': 'Detik',
                    'showSecond': true,
                    'timeOnlyTitle': 'Pilih Waktu',
                    'timeFormat': 'hh:mm:ss',
                    'changeYear': true,
                    'changeMonth': true,
                    'showAnim': 'fold',
                    'yearRange': '-80y:+20y'
                }
            )
        ); //mask("99/99/9999 99:99:99")
        jQuery('#PembersihanT_selesaipembersihan_date').click(jQuery('#PembersihanT_selesaipembersihan').focus);
    }

    function cuciulang() {
        var pembersihan_id = $('#temp_dialogIndikator').val();
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setCuciUlang'); ?>',
            data: {
                pembersihan_id: pembersihan_id
            },
            dataType: "json",
            success: function(data) {
                if (data.status == true) {
                    $.fn.yiiGridView.update('informasipembersihan-grid');
                } else {
                    myAlert(data.pesan);
                }
            },
            error: function(jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function simpanSelesaiBersih() {
        $.post('<?php echo $this->createUrl('updatePembersihan'); ?>', $("#updatePembersihan-form").serialize(), function(data) {
            if (data.ok == 1) {
                myAlert(data.msg);
                $('#dialogIndikator').dialog('close');
                $('#dialogIndikator div.divForFormdialogIndikator').html("");
                $.fn.yiiGridView.update('informasipembersihan-grid');
            } else {
                myAlert(data.msg);
            }
        }, 'json');
    }
</script>