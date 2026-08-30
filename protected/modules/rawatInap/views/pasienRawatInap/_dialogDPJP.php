<?php 
// TINDAKAN =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDokterDPJP',
    'options' => array(
        'title' => 'Detail Persetujuan & Penolakan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 550,
        'resizable' => true,
    ),
));

// ============== Table List DPJP ===========================
$format = new MyFormatter();
$modDPJP = new PegawaiV('search');
$modDPJP->unsetAttributes();
if (isset($_GET['PegawaiV'])) {
    $modDPJP->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp-m-grid',
    'dataProvider' => $modDPJP->searchDokterSpesialis(),
    'filter' => $modDPJP,
    'template' => "{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => " setDokterAdmisi('" . $data->namaLengkap . "'," . $data->pegawai_id . "); return false; "
                ));
            },
        ),
        array(
            'name' => 'nama_pegawai',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
// ============== End Table List DPJP ===========================    

$this->endWidget(); ?>