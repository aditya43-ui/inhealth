
<?php
//========= Dialog buat cari data pendaftaran =========================

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTindakan',
    'options' => array(
        'title' => 'Kode Tarif',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));
$modTindakanRuanganV = new TindakanruanganV('searchDialog');

// $modTindakanRuanganV->daftartindakan_kode = 'OBT';
// $modTindakanRuanganV->ruangan_id = Yii::app()->user->getState('ruangan_id');
if (isset($_GET['TindakanruanganV'])) {
    $modTindakanRuanganV->attributes = $_GET['TindakanruanganV'];
    $modTindakanRuanganV->kelaspelayanan_id = isset($_GET['TindakanruanganV']['kelaspelayanan_id']) ? $_GET['TindakanruanganV']['kelaspelayanan_id'] : '';
    $modTindakanRuanganV->daftartindakan_nama = isset($_GET['TindakanruanganV']['daftartindakan_nama']) ? $_GET['TindakanruanganV']['daftartindakan_nama'] : '';
    $modTindakanRuanganV->daftartindakan_kode = isset($_GET['TindakanruanganV']['daftartindakan_kode']) ? $_GET['TindakanruanganV']['daftartindakan_kode'] : '';
    $modTindakanRuanganV->kategoritindakan_nama = isset($_GET['TindakanruanganV']['kategoritindakan_nama']) ? $_GET['TindakanruanganV']['kategoritindakan_nama'] : '';
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tindakan-grid',
    'dataProvider' => $modTindakanRuanganV->searchDialog(),
    'filter' => $modTindakanRuanganV,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {


                return CHtml::Link('<i class="icon-form-check"></i>', 'javascript:void(0);', array(
                    'class' => 'btn-small',
                    'id' => 'selectPendaftaran',
                    'onClick' => "
                        if('" . $data->harga_tariftindakan . "' == 0) {
                            $('#jumlahtarif').attr('disabled', false);    
                        } else {
                            $('#jumlahtarif').attr('disabled', true);    
                        }
                        $('#jumlahtarif').val('" . $data->harga_tariftindakan . "');
                        $('#daftartindakan_nama').val('" . $data->daftartindakan_nama. "');
                        $('#daftartindakan_id').val('" . $data->daftartindakan_id. "');
                        $('#daftartindakan_kode').val('" . $data->daftartindakan_kode. "');
                        $('#dialogTindakan').dialog('close'); return false;
                    "
                ));
            },
        ),
        [
            'header' => 'Kategori Tindakan',
            'type' => 'raw',
            'value' => '$data->kategoritindakan_nama',
            'filter' => CHtml::textField('TindakanruanganV[kategoritindakan_nama]', $modTindakanRuanganV->kategoritindakan_nama ?? '', array())
        ],
        [
            'header' => 'Kode Tindakan',
            'type' => 'raw',
            'value' => '$data->daftartindakan_kode',
            'filter' => CHtml::textField('TindakanruanganV[daftartindakan_kode]', $modTindakanRuanganV->daftartindakan_kode ?? '', array())
        ],
        [
            'header' => 'Uraian Tindakan',
            'type' => 'raw',
            'value' => '$data->daftartindakan_nama',
            'filter' => CHtml::textField('TindakanruanganV[daftartindakan_nama]', $modTindakanRuanganV->daftartindakan_nama ?? '', array())
        ],
        [
            'header' => 'Kelas Pelayanan',
            'type' => 'raw',
            'value' => function($data) {
                $modKelasPelayanan = KelaspelayananM::model()->findByPk($data->kelaspelayanan_id);

                echo $modKelasPelayanan->kelaspelayanan_nama ?? '';
            },
            'filter' => CHtml::dropDownList('TindakanruanganV[kelaspelayanan_id]', $modTindakanRuanganV->kelaspelayanan_id, CHtml::listData(KelaspelayananM::model()->findAll('kelaspelayanan_aktif is true'), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty' => '-- Pilih --'))
        ],
        

    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '$(".numbers-only").keyup(function() {
                setNumbersOnly(this);
            });
            $(".hurufs-only").keyup(function() {
                setHurufsOnly(this);
            });
            $(".angkahuruf-only").keyup(function() {
                setAngkaHurufOnly(this);
            });'
        . '}',
));

$this->endWidget();
////======= end pendaftaran dialog =============
?>