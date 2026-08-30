<?php $linkHalaman = CustomFunction::getUrlByMenuID(3032); ?>
<?php
$this->breadcrumbs = array(
    'Informasi Sterilisasi',
);
$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Sterilisasi</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Transaksi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
$('#sterilisasi-info-search').submit(function(){
	$('#informasisterilisasi-grid').addClass('animation-loading');
	$.fn.yiiGridView.update('informasisterilisasi-grid', {
			data: $(this).serialize()
	});
	return false;
});
");
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash("success", "Data berhasil disimpan!");
        }
        ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial($this->path_view . '_search', array('model' => $model, 'format' => $format)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Sterilisasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'informasisterilisasi-grid',
                    'replaceUrl' => true,
                    'dataProvider' => $model->searchInformasi(),
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                    'replaceUrl' => true,
                    'columns' => array(
                        array(
                            'header' => 'Tanggal Sterilisasi',
                            'type' => 'raw',
                            'value' => 'MyFormatter::formatDateTimeForUser($data->sterilisasi_tgl)',
                        ),
                        array(
                            'header' => 'No. Sterilisasi',
                            'type' => 'raw',
                            'value' => '$data->sterilisasi_no',
                        ),
                        array(
                            'header' => 'Keterangan',
                            'type' => 'raw',
                            'value' => '$data->sterilisasi_ket',
                        ),
                        array(
                            'header' => 'Instalasi',
                            'type' => 'raw',
                            'value' => '$data->ruangan->instalasi->instalasi_nama',
                        ),
                        array(
                            'header' => 'Ruangan',
                            'type' => 'raw',
                            'value' => '$data->ruangan->ruangan_nama',
                        ),
                        array(
                            'header' => 'Petugas Sterilisasi',
                            'name' => 'pegsterilisasi_nama',
                            'type' => 'raw',
                            'value' => '$data->pegsterilisasi->NamaLengkap',
                        ), /*
                                array(
					'header'=>'Tanggal Mulai',
					'type'=>'raw',
					//'value'=>'$data->tglmulaisterilisasi',
                    'value'=>function($data){
                        return MyFormatter::formatDateTimeForUser($data->tglmulaisterilisasi);
                    },
				),
                                array(
					'header'=>'Tanggal Selesai',
					'type'=>'raw',
					//'value'=>'$data->tglselesaisterilisasi',
                    'value'=>function($data){
                        return MyFormatter::formatDateTimeForUser($data->tglselesaisterilisasi);
                    },
				),
                                array(
					'header'=>'Monitoring',
					'type'=>'raw',
					'value'=>function($data) {
                                          if($data->sterilisasi_status == 'SEDANG') {
                                             return '<button id="red" class="btn btn-gold nohover btn-status" name="yt1" onclick="setdialogMonitoring('.$data->sterilisasi_id.'); $(\'#dialogMonitoring\').dialog(\'open\');return false; generatePicker();">Monitoring</button>'; 
                                        }
                                        }
				),
                 * 
                 */
                        array(
                            'header' => 'Lihat Detail',
                            'type' => 'raw',
                            'value' => 'CHtml::link("<i class=\'icon-form-lihat\'></i> ",  Yii::app()->controller->createUrl("/sterilisasi/informasiSterilisasi/detail",array("id"=>$data->sterilisasi_id)),array("target"=>"frameDetail","rel"=>"tooltip","title"=>"Klik untuk Detail Sterilisasi Linen Linen", "onclick"=>"window.parent.$(\'#dialogDetail\').dialog(\'open\')"));',    'htmlOptions' => array('style' => 'text-align: center; width:40px')
                        ),
                        array(
                            'header' => 'Status',
                            'type' => 'raw',
                            'value' => function ($data) {
                                if ($data->sterilisasi_status == 'BELUM') {
                                    return '<button id="red" class="btn btn-gold nohover btn-status" name="yt1" onclick="setStatus(' . $data->sterilisasi_id . '); ">' . $data->sterilisasi_status . '</button>';
                                } else if ($data->sterilisasi_status == 'SEDANG') {
                                    return '<button id="red" class="btn btn-gold nohover btn-status" name="yt1" onclick="setdialogIndikator(' . $data->sterilisasi_id . '); $(\'#dialogIndikator\').dialog(\'open\');return false; ">' . $data->sterilisasi_status . '</button>';
                                } else {
                                    return '<button id="red" class="btn btn-gold nohover btn-status" name="yt1">' . $data->sterilisasi_status . '</button>';
                                }
                            }
                        ),
                        array(
                            'header' => 'Penyimpanan',
                            'type' => 'raw',
                            'value' => function ($data) {
                                $det = SterilisasidetailT::model()->findByAttributes(array(
                                    'sterilisasi_id' => $data->sterilisasi_id,
                                ), array(
                                    'join' => 'left join penyimpanansterildet_t d on d.sterilisasidetail_id = t.sterilisasidetail_id',
                                    'condition' => 'd.sterilisasidetail_id is null'
                                ));
                                if (empty($det)) {
                                    return "SUDAH DISIMPAN";
                                }
                                return CHtml::link('<i class="icon-pencil"></i> ',  Yii::app()->controller->createUrl("/sterilisasi/PenyimpananSterilisasiT/Index", array("sterilisasi_id" => $data->sterilisasi_id)));
                            },
                            'htmlOptions' => array('style' => 'text-align: center; width:40px')
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
                )); ?>
            </div>
        </div>
    </div>
</div>
<?php
//========= Dialog untuk Melihat detail Pemakaian Barang =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDetail',
    'options' => array(
        'title' => 'Detail Sterilisasi',
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
            'title' => 'Form Hasil Indikator',
            'autoOpen' => false,
            'minWidth' => 1000,
            'minheight' => 1000,
            'modal' => true,
        ),
    )
);
echo CHtml::hiddenField('temp_dialogIndikator', '', array('readonly' => true));
echo '<div class="divForFormdialogIndikator"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
// end
?>
<?php
//======================= form monitoring ======================= 
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogMonitoring',
        'options' => array(
            'title' => 'Form Monitoring Sterilisasi',
            'autoOpen' => false,
            'modal' => true,
            'width' => 900,
            'height' => 500,
            'resizable' => false,
        ),
    )
);
echo CHtml::hiddenField('temp_dialogMonitoring', '', array('readonly' => true));
echo '<div class="divForFormdialogMonitoring"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
// end
?>
<script type="text/javascript">
    function setStatus(id) {
        var sterilisasi_id = id;
        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('setStatusSterilisasi'); ?>',
            data: {
                sterilisasi_id: sterilisasi_id
            },
            dataType: "json",
            success: function(data) {
                if (data.status == true) {
                    $.fn.yiiGridView.update('informasisterilisasi-grid');
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
        $('#temp_dialogIndikator').val(id);
        jQuery.ajax({
            'url': '<?php echo $this->createUrl('insertHasilIndikator') ?>',
            'data': $(this).serialize(),
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.status == 'create_form') {
                    $('#dialogIndikator div.divForFormdialogIndikator').html(data.div);
                    $('#dialogIndikator div.divForFormdialogIndikator form').submit(setdialogIndikator);
                } else {
                    $('#dialogIndikator div.divForFormdialogIndikator').html(data.div);
                    $.fn.yiiGridView.update('informasisterilisasi-grid');
                }
            },
            'cache': false
        });
        return false;
    }

    function setdialogMonitoring(id) {
        $('#temp_dialogMonitoring').val(id);
        jQuery.ajax({
            'url': '<?php echo $this->createUrl('insertMonitoringSterilisasi') ?>',
            'data': $(this).serialize(),
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.status == 'create_form') {
                    $('#dialogMonitoring div.divForFormdialogMonitoring').html(data.div);
                    $('#dialogMonitoring div.divForFormdialogMonitoring form').submit(setdialogMonitoring);
                    //$.fn.yiiGridView.update('informasisterilisasi-grid');
                } else {
                    $('#dialogMonitoring div.divForFormdialogMonitoring').html(data.div);
                    myAlert("Data Monitoring Berhasil Disimpan");
                    $('#dialogMonitoring').dialog('close');
                    $.fn.yiiGridView.update('informasisterilisasi-grid');
                }
            },
            'cache': false
        });
        return false;
    }
</script>