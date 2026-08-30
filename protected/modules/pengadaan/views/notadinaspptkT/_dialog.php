<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogSPK',
            'options'=>array(
                'title'=>'Pencarian Rincian Surat Perjanjian Kerja' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
                'resizable' => true,
            ),
        )
    );
$modRincianSPK = new SuratperjanjiankerjarincianT('search');
$modRincianSPK->unsetAttributes();
if (isset($_GET['SuratperjanjiankerjarincianT'])) {
    $modRincianSPK->attributes = $_GET['SuratperjanjiankerjarincianT'];
    $modRincianSPK->suratperjanjiankerja_id = isset($_GET['SuratperjanjiankerjarincianT']['suratperjanjiankerja_id']) ? $_GET['SuratperjanjiankerjarincianT']['suratperjanjiankerja_id'] : null;    
    $modRincianSPK->kodeanggaran = isset($_GET['SuratperjanjiankerjarincianT']['kodeanggaran']) ? $_GET['SuratperjanjiankerjarincianT']['kodeanggaran'] : null;
}

echo CHtml::hiddenField("noUrutRow","",array('readonly' => true));

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialogrincianspk-m-grid',
    'dataProvider' => $modRincianSPK->searchDialogVerifikasi(),
    'filter' => $modRincianSPK,
   'template'=>"{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('pilihSemua', false, array(
                'class' => 'check_all_produk', 'onchange' => 'setSemuaRincian(this);'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::checkBox('check', false, array(
                            'dokumenpelaksanaananggarandet_id' => $data["dokumenpelaksanaananggarandet_id"],
                            'onchange' => 'setPilihan(this);',
                            'class' => 'pilih',
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-green', 'onclick' => 'inputRincian();'))
        ),
        array(
            'header' => 'Kode Rekening',
            'filter' =>  CHtml::activeTextField($modRincianSPK, 'kodeanggaran') . CHtml::activeHiddenField($modRincianSPK, 'suratperjanjiankerja_id', array('class' => 'spk_id')),
            'name' => 'kodeanggaran',
            'value' => '$data->kodeanggaran'
        ), 
        array(
            'header' => 'Uraian',
            'name' => 'barang_nama',
            'value' => '$data->barang_nama',
        ), 
        array(
            'header' => 'Volume',
            'value' => '$data->barang_jumlah',
        ), 
        array(
            'header' => 'Harga Satuan',
            'htmlOptions' => array('style' => 'text-align: right',),
            'value' => function($data){
                echo MyFormatter::formatNumberForPrint($data->barang_harga, 2);
            },
        ), 
        array(
            'header' => 'Total',
            'htmlOptions' => array('style' => 'text-align: right',),
            'value' => function($data){
                echo MyFormatter::formatNumberForPrint($data->barang_total, 2);
            },
        ), 
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); cekListSpk();}',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
        array(
            'id'=>'dialogRUP',
            'options'=>array(
                'title'=>'Pencarian Rincian Rencana Umum Pengadaan' ,
                'autoOpen'=>false,
                'width' => 760,
                'height' => 600,
                'resizable' => true,
            ),
        )
    );
$modRincianRUP = new ADRencanaumumpengadaandetT('search');
$modRincianRUP->unsetAttributes();
if (isset($_GET['ADRencanaumumpengadaandetT'])) {
    $modRincianRUP->attributes = $_GET['ADRencanaumumpengadaandetT'];
}

echo CHtml::hiddenField("noUrutRow","",array('readonly' => true));

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialogrincianrup-m-grid',
    'dataProvider' => $modRincianRUP->searchDialogNotaDinasPPTK(),
    'filter' => $modRincianRUP,
   'template'=>"{summaryNonPage}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => CHtml::checkBox('pilihSemua', false, array(
                'class' => 'check_all_produk', 'onchange' => 'setSemuaRincian(this);'
            )) . ' Pilih Semua',
            'type' => 'raw',
            'value' => function($data) {
                return CHtml::checkBox('check', false, array(
                            'dokumenpelaksanaananggarandet_id' => $data["dokumenpelaksanaananggarandet_id"],
                            'onchange' => 'setPilihan(this);',
                            'class' => 'pilih',
                ));
            },
            'htmlOptions' => array(
                'style' => 'text-align: center',
            ),
            'footer' => CHtml::htmlButton('OK', array('class' => 'btn btn-green', 'onclick' => 'inputRincian();'))
        ),
        array(
            'header' => 'Uraian',
            'name' => 'rencanaumumpengadaandet_nama',
            'value' => '$data->rencanaumumpengadaandet_nama',
        ), 
        array(
            'header' => 'Volume',            
            'filter' => CHtml::activeHiddenField($modRincianRUP, 'rencanaumumpengadaan_id', array('class' => 'rencanaumumpengadaan_id')),
            'value' => '$data->rencanaumumpengadaandet_volume',
        ), 
        array(
            'header' => 'Harga Satuan',
            'htmlOptions' => array('style' => 'text-align: right',),
            'value' => function($data){
                echo MyFormatter::formatNumberForPrint($data->rencanaumumpengadaandet_harga, 2);
            },
        ), 
        array(
            'header' => 'Total',
            'htmlOptions' => array('style' => 'text-align: right',),
            'value' => function($data){
                echo MyFormatter::formatNumberForPrint($data->rencanaumumpengadaandet_jumlah, 2);
            },
        ), 
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); cekListRup();}',
));
$this->endWidget('zii.widgets.jui.CJuiDialog');
?>