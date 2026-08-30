<?php
//========= Dialog buat cari Jenis Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogJenisDiet',
    'options' => array(
        'title' => 'Jenis Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modJenisDiet = new GZJenisdietM('search');
$modJenisDiet->unsetAttributes();
if (isset($_GET['GZJenisdietM']))
    $modJenisDiet->attributes = $_GET['GZJenisdietM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzjenisdiet-m-grid',
    'dataProvider' => $modJenisDiet->search(),
    'filter' => $modJenisDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "$(\'#'.Chtml::activeId($model,'jenisdiet_id').'\').val($data->jenisdiet_id);
                                    cekJenisDiet($data->jenisdiet_id,\'$data->jenisdiet_nama\');
//                                    $(\'#jenisdiet\').val(\'$data->jenisdiet_nama\');
                                    $(\'#dialogJenisDiet\').dialog(\'close\');return false;
                            "))',
                                    
        ),
        'jenisdiet_nama',
        'jenisdiet_namalainnya',
        'jenisdiet_keterangan',
        'jenisdiet_catatan',
//        'jenisdiet_aktif',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBahanDiet',
    'options' => array(
        'title' => 'Bahan Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modBahanDiet = new GZBahandietM('search');
$modBahanDiet->unsetAttributes();
if (isset($_GET['GZBahandietM']))
    $modBahanDiet->attributes = $_GET['GZBahandietM'];

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzbahandiet-m-grid',
    'dataProvider' => $modBahanDiet->search(),
    'filter' => $modBahanDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "$(\'#'.Chtml::activeId($model,'bahandiet_id').'\').val($data->bahandiet_id);
                                    $(\'#bahandiet\').val(\'$data->bahandiet_nama\');
                                    $(\'#dialogBahanDiet\').dialog(\'close\');return false;"))',
        ),
        'bahandiet_nama',
        'bahandiet_namalain',
//        'bahandiet_aktif',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogMenuDiet',
    'options' => array(
        'title' => 'Daftar Menu Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 500,
        'resizable' => false,
    ),
));

$modMenuDiet = new GZMenuDietM('search');
$modMenuDiet->unsetAttributes();

if (strtolower($this->action->id) == "indexpegawai") {
    $modMenuDiet->isPasien = false;
} else {
    $modMenuDiet->isPasien = true;
}
    

if (isset($_GET['GZMenuDietM']))
$modMenuDiet->attributes = $_GET['GZMenuDietM'];
if (isset($_GET['kelaspelayanan_id'])){
    $modMenuDiet->kelaspelayanan_id = $_GET['kelaspelayanan_id'];
}
if (isset($_GET['GZJenisdietM']['jenisdiet_id'])){
    $modMenuDiet->idJenisDiet = $_GET['GZJenisdietM']['jenisdiet_id'];
}
if (isset($_POST['kelaspelayanan_id'])){
    $kelaspelayanan = $_POST['kelaspelayanan_id'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzmenudiet-m-grid',
    'dataProvider' => $modMenuDiet->searchDialogDiet(),
    'filter' => $modMenuDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                    "id" => "selectBahan",
                                    "onClick" => "$(\'#menudiet_id\').val($data->menudiet_id);
                                    $(\'#menuDiet\').val(\'$data->menudiet_nama\');
                                    $(\'#daftartindakan_id\').val(\'$data->daftartindakan_id\');
                                    $(\'#URT\').val(\'$data->ukuranrumahtangga\');
                                    $(\'#dialogMenuDiet\').dialog(\'close\');return false;"))',
        ),
//        array(
//                        'name'=>'menudiet_id',
//                        'value'=>'$data->menudiet_id',
//                        'filter'=>false,
//                ),
        array(
                'header'=>'No. Urut',
                'value'=>'$row+1',
                'filter'=>CHtml::activeHiddenField($modMenuDiet, 'jenisdiet_id'),
        ),
        array(
            'header'=>'Jenis Diet',
            'name'=>'jenisdiet_nama',
            'type'=>'raw',
            'value'=>'$data->jenisdiet->jenisdiet_nama',
            'filter'=>false,
        ),
        'menudiet_nama',
        'menudiet_namalain',
        'jml_porsi',
        'ukuranrumahtangga',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>
<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>
