<?php
$this->breadcrumbs = array(
    'Informasi Dokumen Rekam Medis',
);
?>
<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('#rmdokrekammedisrm-t-search').submit(function(){
	$.fn.yiiGridView.update('informasidokrekammedis-m-grid', {
		data: $(this).serialize()
	});
	return false;
});
");
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-info-circled"></i> Informasi <b>Dokumen Rekam Medis</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_searchinformasi', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Dokumen Rekam Medis</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class='hide'>
                    <?php
                    $warnadokrm_id = 1;
                    $this->widget(
                        'ext.colorpicker.ColorPicker',
                        array(
                            'name' => 'Dokumen[warnadokrm_id][]',
                            'value' => WarnadokrmM::model()->getKodeWarnaId($warnadokrm_id), // string hexa decimal contoh 000000 atau 0000ff
                            'height' => '30px', // tinggi
                            'width' => '83px',
                            //'swatch'=>true, // default false jika ingin swatch
                            'colors' =>  WarnadokrmM::model()->getKodeWarna(), //warna dalam bentuk array contoh array('0000ff','00ff00')
                            'colorOptions' => array(
                                'transparency' => true,
                            ),
                        )
                    );
                    ?>
                </div>
                <div class="block-tabel">
                    <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                        'id' => 'informasidokrekammedis-m-grid',
                        'dataProvider' => $model->searchinformasi(),
                        'filter' => $model,
                        'template' => "{summary}\n{items}\n{pager}",
                        'itemsCssClass' => 'table table-bordered table-striped table-condensed',
                        'replaceUrl' => true,
                        'columns' => array(
                            array(
                                'header' => 'Lokasi Rak',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return CHtml::link("<i class='" . MyIcon::getIcons('ubah') . "'></i> " . (isset($data->lokasirak) ? $data->lokasirak->lokasirak_nama : ""), " ", array("onclick" => "ubahLokasirak('" . $data->dokrekammedis_id . "');$ ('#editLokasiRak').dialog('open');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Lokasi Rak"));
                                },
                            ),
                            array(
                                'header' => 'Sub Rak',
                                // 'value'=>'$data->subrak->subrak_nama',
                                'type' => 'raw',
                                'value' => function ($data) {
                                    return CHtml::link("<i class='" . MyIcon::getIcons('ubah') . "'></i> " . (isset($data->subrak) ? $data->subrak->subrak_nama : ""), " ", array("onclick" => "ubahSubrak('" . $data->dokrekammedis_id . "');$ ('#editSubRak').dialog('open');return false;", "rel" => "tooltip", "rel" => "tooltip", "title" => "Klik untuk Mengubah Sub Rak"));
                                },
                            ),
                            array(
                                'header' => 'Warna Dokumen RK',
                                'type' => 'raw',
                                'value' => '$this->grid->getOwner()->renderPartial(\'_warnaDokumen2\', array(\'warnadokrm_id\'=>$data->warnadokrm_id, \'dokrekammedis_id\'=>$data->dokrekammedis_id), true)',
                                // 'htmlOptions'=>'CHtml::link(array("onclick"=>"ubahWarna(\'$data->dokrekammedis_id\'))'
                            ),
                            array(
                                'header' => 'Tanggal Rekam Medis',
                                'value' => 'isset($data->tglrekammedis) ? MyFormatter::formatDateTimeForUser($data->tglrekammedis) : ""',
                            ),
                            array(
                                'header' => 'No. Dokumen<br>Rekam Medis',
                                'value' => 'isset($data->nodokumenrm) ? $data->nodokumenrm : ""',
                            ),
                            array(
                                'header' => 'Nama Pasien',
                                'value' => '(isset($data->pasien->namadepan) ? $data->pasien->namadepan : ""." ".isset($data->pasien->nama_pasien)) ? $data->pasien->nama_pasien : ""',
                                'type' => 'raw',
                            ),
                            array(
                                'header' => 'No. Tersier',
                                'value' => '$data->nomortertier'
                            ),
                            array(
                                'header' => 'No. Sekunder',
                                'value' => '$data->nomorsekunder',
                            ),
                            array(
                                'header' => 'No. Primer',
                                'value' => '$data->nomorprimer'
                            ),
                            array(
                                'header' => 'Tanggal Lahir',
                                'value' => 'MyFormatter::formatDateTimeForUser($data->pasien->tanggal_lahir)',
                            ),
                            array(
                                'header' => 'Jenis Kelamin',
                                'value' => '$data->pasien->jeniskelamin',
                            ),
                            array(
                                'header' => 'Status',
                                'value' => 'isset($data->statusrekammedis) ? $data->statusrekammedis : ""',
                            ),
                            array(
                                'header' => 'Posisi Terakhir',
                                'value' => 'isset($data->TampilkanPosisiTerakhir) ? $data->TampilkanPosisiTerakhir : ""',
                                'type' => 'raw',
                                'htmlOptions' => array(
                                    'style' => 'text-align: center;',
                                ),
                            ),
                        ),
                        'afterAjaxUpdate' => 'function(id, data){
                                    var colors = jQuery(\'input[rel="colorPicker"]\').attr(\'colors\').split(\',\');
                                    jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                                    jQuery(\'input[rel="colorPicker"]\').colorPicker({colors:colors});
                                }',
                    )); ?>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="text/javascript">
    function ubahLokasirak(dokrm) {
        $('#temp_lokasirak').val(dokrm);
        jQuery.ajax({
            'url': '<?php echo $this->createUrl('ubahLokasirak') ?>',
            'data': $(this).serialize(),
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.status == 'create_form') {
                    $('#editLokasiRak div.divForFormEditLokasiRak').html(data.div);
                    $('#editLokasiRak div.divForFormEditLokasiRak form').submit(ubahLokasirak);
                } else {
                    $('#editLokasiRak div.divForFormEditLokasiRak').html(data.div);
                    $.fn.yiiGridView.update('informasidokrekammedis-m-grid', {
                        data: $(this).serialize()
                    });
                    setTimeout("$('#editLokasiRak').dialog('close') ", 500);
                }
            },
            'cache': false
        });
        return false;
    }

    function ubahSubrak(dokrm) {
        $('#temp_subrak').val(dokrm);
        jQuery.ajax({
            'url': '<?php echo $this->createUrl('ubahSubrak') ?>',
            'data': $(this).serialize(),
            'type': 'post',
            'dataType': 'json',
            'success': function(data) {
                if (data.status == 'create_form') {
                    $('#editSubRak div.divForFormEditSubRak').html(data.div);
                    $('#editSubRak div.divForFormEditSubRak form').submit(ubahSubrak);
                } else {
                    $('#editSubRak div.divForFormEditSubRak').html(data.div);
                    $.fn.yiiGridView.update('informasidokrekammedis-m-grid', {
                        data: $(this).serialize()
                    });
                    setTimeout("$('#editSubRak').dialog('close') ", 500);
                }
            },
            'cache': false
        });
        return false;
    }

    function terimaRM(id) {
        myConfirm("Anda yakin untuk menerima dokumen ini?", "Perhatian!", function(r) {
            if (r === true) {
                $.post("<?php echo $this->createUrl("informasi"); ?>", {
                    json: true,
                    f: "terimaRM",
                    param: {
                        id: id
                    }
                }, function(data) {
                    if (data.update == true) {
                        $.fn.yiiGridView.update('informasidokrekammedis-m-grid');
                    }
                    myAlert(data.msg);
                }, "json");
            }
        });
    }

    function ubahWarna(dokrekammedis_id, val) {
        myConfirm("Anda yakin untuk mengubah warna dokumen ini?", "Perhatian!", function(r) {
            if (r === true) {
                $.post("<?php echo $this->createUrl("informasi"); ?>", {
                    json: true,
                    f: "ubahWarnaRM",
                    param: {
                        id: dokrekammedis_id,
                        val: val
                    }
                }, function(data) {
                    if (data.update == true) {
                        $.fn.yiiGridView.update('informasidokrekammedis-m-grid');
                    }
                    myAlert(data.msg);
                }, "json");
            }
        });
    }
</script>
<?php
//=================== Ganti Data Lokasi Rak ==================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'editLokasiRak',
        'options' => array(
            'title' => 'Ganti Lokasi Rak',
            'autoOpen' => false,
            'minWidth' => 500,
            'modal' => true,
        ),
    )
);
echo CHtml::hiddenField('temp_lokasirak', '', array('readonly' => true));
echo '<div class="divForFormEditLokasiRak"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
//=================== Ganti Data Sub Rak ==================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'editSubRak',
        'options' => array(
            'title' => 'Ganti Sub Rak',
            'autoOpen' => false,
            'minWidth' => 500,
            'modal' => true,
        ),
    )
);
echo CHtml::hiddenField('temp_subrak', '', array('readonly' => true));
echo '<div class="divForFormEditSubRak"></div>';
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>