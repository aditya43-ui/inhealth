<?php

/* ========= Dialog buat Cari Tanda Gejala ========================= */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogTandaGejala',
    'options' => array(
        'title' => 'Daftar Tanda Gejala',
        'autoOpen' => false,
        'modal' => true,
        'width' => 500,
        'height' => 500,
        'resizable' => false,
    ),
));

$modGejala = new TandagejalaDaftarM('searchDialog');
if (isset($_GET['TandagejalaDaftarM'])) {
    $modGejala->attributes = $_GET['TandagejalaDaftarM'];
    $modGejala->tandagejala_daftar_nama = !empty($_GET['TandagejalaDaftarM']['tandagejala_daftar_nama']) ? $_GET['TandagejalaDaftarM']['tandagejala_daftar_nama'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'tandagejaladaftar-m-grid',
    'dataProvider' => $modGejala->searchDialog(),
    'filter' => $modGejala,
    'template' => "{summary}\n{items}{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('pilihSemua', false, array(
                'class' => 'check_all_produk', 'onchange' => 'setSemuaGejala(this);'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::checkBox('check', false, array(
                            'tandagejala_daftar_id' => $data["tandagejala_daftar_id"],
                            'onchange' => 'setGejala(this);',
                            'class' => 'pilih',
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center;',
            ),
            'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-primary', 'onclick' => 'inputGejala();'))
        ),
        array(
            'header' => 'Nama Tanda Gejala',
            'name' => 'tandagejala_daftar_nama',
            'value' => '$data->tandagejala_daftar_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
                            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                        }',
));
$this->endWidget();
?>