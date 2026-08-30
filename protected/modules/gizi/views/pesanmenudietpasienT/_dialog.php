<?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogTambahMenu',
        'options' => array(
           'title' => '<span class="judul-tambah"></span>',
            'autoOpen' => false,
            'modal' => true,            
            'width' => 600,
            'height' => 450,
            'resizable' => true,
            'close' => 'js:function(){$("#tambah-menu-diet").html("");}'
        ),
    ));
?>
        <div id="tambah-menu-diet" class="form-horizontal">

        </div>
    
<?php   
    $this->endWidget(); 

    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetail',
        'options' => array(
           'title' => 'Detail Bahan Menu Diet',
            'autoOpen' => false,
            'modal' => true,
            'zIndex' => 1002,
            'width' => 500,
            'height' => 300,
            'resizable' => true,
        ),
    ));
?>
<iframe name='frameDetail' width="100%" height="100%"></iframe>
<?php $this->endWidget();?>
<?php

if (CustomFunction::isGridViewUpdate('gzjenisdiet-m-grid')) {

//========= Dialog buat cari Jenis Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogJenisDiet',
    'options' => array(
        'title' => 'Jenis Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modJenisDiet = new GZJenisdietM('search');
$modJenisDiet->unsetAttributes();
if (isset($_GET['GZJenisdietM'])){
    $modJenisDiet->attributes = $_GET['GZJenisdietM'];    
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzjenisdiet-m-grid',
    'dataProvider' => $modJenisDiet->searchJenisDiet(),
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
				$(\'#jenisdiet\').val(\'$data->jenisdiet_nama\');
				$(\'#GZMenuDietM_jenisdiet_id\').val(\'$data->jenisdiet_id\');
                                $(\'#GZPesanmenudietT_jenisdiet_id\').val(\'$data->jenisdiet_id\');
				refreshDialogMenuDiet();
				$(\'#dialogJenisDiet\').dialog(\'close\');return false;"))',
        ),
        array(
            'header' => 'Jenis Diet',
            'name'=>'jenisdiet_nama',
            //'filter'=>Chtml::dropDownList('GZJenisdietM[jenisdiet_id]', GZJenisdietM->jenisdiet_id, '$data',array('empty'=>'-- Pilih --'))
        ),
        // 'jenisdiet_nama',
        //'jenisdiet_namalainnya',
        'jenisdiet_keterangan',
        'jenisdiet_catatan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();

}


if (CustomFunction::isGridViewUpdate('gzjenisdiet1-m-grid')) {

$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogJenisDiet1',
    'options' => array(
        'title' => 'Jenis Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modJenisDiet = new GZJenisdietM('search');
$modJenisDiet->unsetAttributes();
if (isset($_GET['GZJenisdietM'])){
    $modJenisDiet->attributes = $_GET['GZJenisdietM'];    
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzjenisdiet1-m-grid',
    'dataProvider' => $modJenisDiet->searchJenisDiet(),
    'filter' => $modJenisDiet,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectBahan",
				"onClick" => "
                $(\'#dlg_jenisdiet_id\').val($data->jenisdiet_id);
                $(\'#dlg_jenisdiet_nama\').val(\'$data->jenisdiet_nama\');
                $(\'#dlg_menudiet_id\').val(\'\');
                $(\'#dlg_menudiet_nama\').val(\'\');
				$(\'#jenisdiet\').val(\'$data->jenisdiet_nama\');
				refreshDialogMenuDiet1();
				$(\'#dialogJenisDiet1\').dialog(\'close\');return false;"))',
        ),
        array(
            'header' => 'Jenis Diet',
            'name'=>'jenisdiet_nama',
            //'filter'=>Chtml::dropDownList('GZJenisdietM[jenisdiet_id]', GZJenisdietM->jenisdiet_id, '$data',array('empty'=>'-- Pilih --'))
        ),
        // 'jenisdiet_nama',
        //'jenisdiet_namalainnya',
        'jenisdiet_keterangan',
        'jenisdiet_catatan',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
}
?>

<?php

if (CustomFunction::isGridViewUpdate('gzbahandiet-m-grid')) {

//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogBahanDiet',
    'options' => array(
        'title' => 'Bahan Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modBahanDiet = new GZBahandietM('search');
$modBahanDiet->unsetAttributes();
if (isset($_GET['GZBahandietM'])){
    $modBahanDiet->attributes = $_GET['GZBahandietM'];
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzbahandiet-m-grid',
    'dataProvider' => $modBahanDiet->searchBahanDiet(),
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
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
}
?>

<?php


if (CustomFunction::isGridViewUpdate('gzmenudiet-m-grid')) {

//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogMenuDiet',
    'options' => array(
        'title' => 'Daftar Menu Diet ',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
        // 'close' => 'js:function(){resetChecked();}'
    ),
));

$modMenuDiet = new GZMenuDietM();
$modMenuDiet->unsetAttributes();
if (isset($_GET['GZMenuDietM'])){
    $modMenuDiet->attributes = $_GET['GZMenuDietM'];
    $modMenuDiet->jenisdiet_id = isset($_GET['GZMenuDietM']['jenisdiet_id']) ? $_GET['GZMenuDietM']['jenisdiet_id'] : null;
    $modMenuDiet->menudiet_nama = isset($_GET['GZMenuDietM']['menudiet_nama']) ? $_GET['GZMenuDietM']['menudiet_nama'] : null;
    $modMenuDiet->jeniswaktu_id = isset($_GET['GZMenuDietM']['jeniswaktu_id']) ? $_GET['GZMenuDietM']['jeniswaktu_id'] : null;
    $modMenuDiet->kelaspelayanan_id = isset($_GET['GZMenuDietM']['kelaspelayanan_id']) ? $_GET['GZMenuDietM']['kelaspelayanan_id'] : null;
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
            'value' => function($data){
                $dt['menudiet_id'] = $data->menudiet_id;
                $dt['jenismenudiet_nama'] = $data->menudiet_nama;
                $dt['jenisdiet_id'] = $data->jenisdiet_id;
                $dt['ukuranrumahtangga'] = $data->ukuranrumahtangga;

                // kebutuhan untuk pilih semua saat pilih kelas pelayanan
                echo CHtml::hiddenField('menudiet_id', $data->menudiet_id, ['class' => 'menudiet_id']);
                echo CHtml::hiddenField('jenismenudiet_nama', $data->menudiet_nama, ['class' => 'jenismenudiet_nama']);
                echo CHtml::hiddenField('jenisdiet_id', $data->jenisdiet_id, ['class' => 'jenisdiet_id']);
                echo CHtml::hiddenField('ukuranrumahtangga', $data->ukuranrumahtangga, ['class' => 'ukuranrumahtangga']);
                echo CHtml::hiddenField('jeniswaktu_id', $data->jeniswaktu_id, ['class' => 'jeniswaktu_id']);

                $res = json_encode($dt);

                echo CHtml::activeCheckBox($data,'['.$data->menudiet_id.']menudiet_id',array('class' => 'ceklis_baris', "onChange" => 'setMenuDiet('.$res.')', "data-menudiet" => $data->menudiet_id));            

            },
        ),
        array(
            'header' => 'No.',
            'value' => '$row+1'
        ),
        array(
            'header'=>'Tipe Diet',
            'type'=>'raw',
            'value'=>'!empty($data->tipediet_id) ? $data->tipediet->tipediet_nama : \'\'',
        ),
         array(
            'header'=>'Jenis Diet',
            'name'=>'jenisdiet_nama',
            'type'=>'raw',
            'value'=>'$data->jenisdiet_nama',
            'filter'=>CHtml::activeHiddenField($modMenuDiet, 'jenisdiet_id'),
        ),
        array(
            // 'name'=>'menudiet_nama',
            'header'=>'Nama Menu Diet',
            'value' => '$data->menudiet_nama'
        ),
        array(
            // 'name'=>'jml_porsi',
            'header'=>'Jml Porsi',
            'value' => '$data->jml_porsi',
            'headerHtmlOptions' => array('style' => 'width: 40px;')
        ),
        // array(
        //     'name'=>'ukuranrumahtangga',
        //     'header'=>'Ukuran Rumah Tangga'
        // ),
        array(
            'header'=>'Waktu',
            'type'=>'raw',
            'value'=>'!empty($data->jeniswaktu_id) ? $data->jeniswaktu->jeniswaktu_nama : \'\'',
            // 'filter'=>  CHtml::activeDropDownList($modMenuDiet, 'jeniswaktu_id', CHtml::listData(
            //     JeniswaktuM::model()->findAllByAttributes(array(
            //         'jeniswaktu_aktif'=>true
            //     )), 'jeniswaktu_id', 'jeniswaktu_nama'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Kelas Pelayanan',
            'type'=>'raw',
            'value'=>function($data) {
                echo !empty($data->kelaspelayanan) ? $data->kelaspelayanan->kelaspelayanan_nama : '';
            },
            'filter'=>  CHtml::activeDropDownList($modMenuDiet, 'kelaspelayanan_id', CHtml::listData(
                KelaspelayananM::model()->findAllByAttributes(array(
                    'kelaspelayanan_aktif'=>true
            )), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty'=>'-- Pilih --', 'class' => 'kelaspelayanan_id')),
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); setMenuChecked();pilihAllMenu(this, id, data)}',
));

$this->endWidget();

}


if (CustomFunction::isGridViewUpdate('gzmenudiet1-m-grid')) {

    //========= Dialog buat cari Bahan Diet =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogMenuDiet1',
        'options' => array(
            'title' => 'Daftar Menu Diet ',
            'autoOpen' => false,
            'modal' => true,
            'width' => 800,
            'resizable' => false,
        ),
    ));
    
    $modMenuDiet = new GZMenuDietM();
    $modMenuDiet->unsetAttributes();
    if (isset($_GET['GZMenuDietM'])){
        $modMenuDiet->attributes = $_GET['GZMenuDietM'];
        $modMenuDiet->jenisdiet_id = isset($_GET['GZMenuDietM']['jenisdiet_id']) ? $_GET['GZMenuDietM']['jenisdiet_id'] : null;
        $modMenuDiet->menudiet_nama = isset($_GET['GZMenuDietM']['menudiet_nama']) ? $_GET['GZMenuDietM']['menudiet_nama'] : null;
        $modMenuDiet->jeniswaktu_id = isset($_GET['GZMenuDietM']['jeniswaktu_id']) ? $_GET['GZMenuDietM']['jeniswaktu_id'] : null;
        $modMenuDiet->kelaspelayanan_id = isset($_GET['GZMenuDietM']['kelaspelayanan_id']) ? $_GET['GZMenuDietM']['kelaspelayanan_id'] : null;
    }
    
    $this->widget('ext.bootstrap.widgets.BootGridView', array(
        'id' => 'gzmenudiet1-m-grid',
        'dataProvider' => $modMenuDiet->searchDialogDiet(),
        'filter' => $modMenuDiet,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => function($data){
                    $dt['menudiet_id'] = $data->menudiet_id;
                    $dt['jenismenudiet_nama'] = $data->menudiet_nama;
                    $dt['jenisdiet_id'] = $data->jenisdiet_id;
                    $dt['ukuranrumahtangga'] = $data->ukuranrumahtangga;
        
                    $res = json_encode($dt);

                    echo CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:;",array("class"=>"btn-small", 
				                        "id" => "selectBahan", "onClick" => 'setMenuDietDlg('.$res.')', "data-menudiet" => $data->menudiet_id
                        ));
    
    
                },
            ),
            array(
                'header' => 'No.',
                'value' => '$row+1'
            ),
            array(
                'header'=>'Tipe Diet',
                'type'=>'raw',
                'value'=>'!empty($data->tipediet_id) ? $data->tipediet->tipediet_nama : \'\'',
            ),
             array(
                'header'=>'Jenis Diet',
                'name'=>'jenisdiet_nama',
                'type'=>'raw',
                'value'=>'$data->jenisdiet_nama',
                'filter'=>CHtml::activeHiddenField($modMenuDiet, 'jenisdiet_id'),
            ),
            array(
                'name'=>'menudiet_nama',
                'header'=>'Nama Menu Diet'
            ),
            array(
                'name'=>'jml_porsi',
                'header'=>'Jml Porsi',
                'headerHtmlOptions' => array('style' => 'width: 40px;')
            ),
            // array(
            //     'name'=>'ukuranrumahtangga',
            //     'header'=>'Ukuran Rumah Tangga'
            // ),
            array(
                'header'=>'Waktu',
                'type'=>'raw',
                'value'=>'!empty($data->jeniswaktu_id) ? $data->jeniswaktu->jeniswaktu_nama : \'\'',
                'filter'=>  CHtml::activeDropDownList($modMenuDiet, 'jeniswaktu_id', CHtml::listData(
                    JeniswaktuM::model()->findAllByAttributes(array(
                        'jeniswaktu_aktif'=>true
                    )), 'jeniswaktu_id', 'jeniswaktu_nama'), array('empty'=>'-- Pilih --')),
            ),
            array(
                'header'=>'Kelas Pelayanan',
                'type'=>'raw',
                'value'=>'!empty($data->kelaspelayanan_id) ? $data->kelaspelayanan->kelaspelayanan_nama : \'\'',
                'filter'=>  CHtml::activeDropDownList($modMenuDiet, 'kelaspelayanan_id', CHtml::listData(
                    KelaspelayananM::model()->findAllByAttributes(array(
                        'kelaspelayanan_aktif'=>true
                )), 'kelaspelayanan_id', 'kelaspelayanan_nama'), array('empty'=>'-- Pilih --')),
            ),
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); setMenuChecked();}',
    ));
    
    $this->endWidget();
    
    }

?>
<?php
/*
if (CustomFunction::isGridViewUpdate('gzmenudietlain-m-grid')) {

//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogMenuDietLain',
    'options' => array(
        'title' => 'Daftar Jenis Diet Lainnya',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'resizable' => false,
    ),
));

$modMenuDietLain = new GZTarifTindakanPerdaRuanganV('searchDialogDiet');
$modMenuDietLain->unsetAttributes();
$modMenuDietLain->kelaspelayanan_id = $model->kelaspelayanan_id;
$modMenuDietLain->penjamin_id = $model->penjamin_id;

if (!isset($_GET['ajax'])) {
    $modMenuDiet->daftartindakan_id = -1;
}
if (isset($_GET['GZTarifTindakanPerdaRuanganV'])) {
    $modMenuDietLain->tipediet_id = isset($_GET['GZTarifTindakanPerdaRuanganV']['tipediet_id']) ? $_GET['GZTarifTindakanPerdaRuanganV']['tipediet_id'] : null;
    $modMenuDietLain->jenismakanan_id = isset($_GET['GZTarifTindakanPerdaRuanganV']['jenismakanan_id']) ? $_GET['GZTarifTindakanPerdaRuanganV']['jenismakanan_id'] : null;
    $modMenuDietLain->attributes = $_GET['GZTarifTindakanPerdaRuanganV'];
    $modMenuDietLain->jenisdiet_id = isset($_GET['GZTarifTindakanPerdaRuanganV']['jenisdiet_id']) ? $_GET['GZTarifTindakanPerdaRuanganV']['jenisdiet_id'] : null;
    $modMenuDietLain->kelaspelayanan_id = isset($_GET['GZTarifTindakanPerdaRuanganV']['kelaspelayanan_id']) ? $_GET['GZTarifTindakanPerdaRuanganV']['kelaspelayanan_id'] : null;
// RND-9230   $modMenuDietLain->penjamin_id = isset($_GET['GZTarifTindakanPerdaRuanganV']['penjamin_id']) ? $_GET['GZTarifTindakanPerdaRuanganV']['penjamin_id'] : null;
    $modMenuDietLain->jenistarif_id = isset($_GET['GZTarifTindakanPerdaRuanganV']['jenistarif_id']) ? $_GET['GZTarifTindakanPerdaRuanganV']['jenistarif_id'] : null;
    $modMenuDietLain->menudiet_nama = isset($_GET['GZTarifTindakanPerdaRuanganV']['menudiet_nama']) ? $_GET['GZTarifTindakanPerdaRuanganV']['menudiet_nama'] : null;
    $modMenuDietLain->jenisdiet_nama = isset($_GET['GZTarifTindakanPerdaRuanganV']['jenisdiet_nama']) ? $_GET['GZTarifTindakanPerdaRuanganV']['jenisdiet_nama'] : null;
    $modMenuDietLain->jenismenudiet_nama = isset($_GET['GZTarifTindakanPerdaRuanganV']['jenismenudiet_nama']) ? $_GET['GZTarifTindakanPerdaRuanganV']['jenismenudiet_nama'] : null;
    $modMenuDietLain->jenismenudiet_namalainnya = isset($_GET['GZTarifTindakanPerdaRuanganV']['jenismenudiet_namalainnya']) ? $_GET['GZTarifTindakanPerdaRuanganV']['jenismenudiet_namalainnya'] : null;
    $modMenuDietLain->default = isset($_GET['GZTarifTindakanPerdaRuanganV']['default']) ? $_GET['GZTarifTindakanPerdaRuanganV']['default'] : null;
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'gzmenudietlain-m-grid',
    'dataProvider' => $modMenuDietLain->searchDialogDiet(),
    'filter' => $modMenuDietLain,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $dt['menudiet_id'] = $data->menudiet_id;
                $dt['jenismenudiet_nama'] = $data->jenismenudiet_nama;
                $dt['jenisdiet_id'] = $data->jenisdiet_id;
                $dt['ukuranrumahtangga'] = $data->ukuranrumahtangga;

                $res = json_encode($dt);

                return CHtml::Link("<i class=\"icon-form-check\"></i>", "javascript:;", array("class" => "btn-small",
                            "id" => "selectBahan",
                            "onClick" => 'setMenuDietLain(' . $res . ')'
                ));
            },
        ),
        array(
            'header' => 'No.',
            'value' => '$row+1'
        ),
        array(
            'header' => 'Kelompok Jenis Diet',
            'name' => 'jenisdiet_nama',
            'type' => 'raw',
            'value' => '$data->jenisdiet_nama',
        ),
        array(
            'header' => 'Jenis Diet',
            'name' => 'jenismenudiet_nama',
            'filter' => CHtml::activeTextField($modMenuDietLain, 'jenismenudiet_nama', array()) .
            CHtml::activeHiddenField($modMenuDietLain, 'tipediet_id', array('class' => 'dialogmenudiet_tipediet_id')) .
            CHtml::activeHiddenField($modMenuDietLain, 'jenismakanan_id', array('class' => 'dialogmenudiet_jenismakanan_id')) .
            CHtml::activeHiddenField($modMenuDietLain, 'kelaspelayanan_id') .
            CHtml::activeHiddenField($modMenuDietLain, 'jenistarif_id') .
            CHtml::activeHiddenField($modMenuDietLain, 'penjamin_id')
        ),
        array(
            'header' => 'Nama Lain Jenis Diet',
            'name' => 'jenismenudiet_namalainnya',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();

}

*/

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

<?php

if (CustomFunction::isGridViewUpdate('jeniswaktu-m-grid')) {

//========= Dialog buat cari Jenis Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogJenisWaktu',
    'options' => array(
        'title' => 'Jenis Diet',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));

$modJenisWaktu = new GZKelompokjeniswaktuM('searchJenisWaktu');
$modJenisWaktu->unsetAttributes();
if (isset($_GET['GZKelompokjeniswaktuM'])){
    $modJenisWaktu->attributes = $_GET['GZKelompokjeniswaktuM'];
    $modJenisWaktu->jenismakanan_id = $_GET['GZKelompokjeniswaktuM']['jenismakanan_id'];  
    $modJenisWaktu->jeniswaktu_nama = !empty($_GET['GZKelompokjeniswaktuM']['jeniswaktu_nama']) ? $_GET['GZKelompokjeniswaktuM']['jeniswaktu_nama'] : null;  
    $modJenisWaktu->default = isset($_GET['GZKelompokjeniswaktuM']['default'])?$_GET['GZKelompokjeniswaktuM']['default']:null;
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'jeniswaktu-m-grid',
    'dataProvider'=>$modJenisWaktu->searchJenisWaktu(),
    'filter'=>$modJenisWaktu,
    'template'=>"{summary}\n{items}{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>CHtml::checkBox('pilihSemua', false, array('class'=>'check_all_produk', 'onchange'=>'setSemuaWaktu(this);'
            )).' Pilih Semua',
            'type'=>'raw',
            'value'=>function($data){
                    return CHtml::checkBox('check', false, array(
                        'jeniswaktu_id'=>$data["jeniswaktu_id"], 
                        'onchange'=>'setJenisWaktu(this);',
                        'class'=>'pilih',
                        'value'=>$data["jeniswaktu_id"]
                    ));
            },
            'htmlOptions'=>array(
                    'style'=>'text-align: center',
            ),
            'footer' => CHtml::htmlButton('OK', array('class'=>'btn btn-green', 'onclick'=>'inputWaktu();'))
        ),
        array(
            'header'=>'Waktu',
            'name'=>'jeniswaktu_nama',
            'value'=>'$data["jeniswaktu_nama"]',
            'filter'=>  CHtml::activeHiddenField($modJenisWaktu, 'jenismakanan_id',array('class'=>'dialogjeniswaktu_jenismakanan_id')).
                        CHtml::activeTextField($modJenisWaktu, 'jeniswaktu_nama',array())
        ),
        
    ),
	'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
$this->endWidget();

}

?>
<script type="text/javascript">

function setMenuChecked() {
    
}

    
function refreshDialogMenuDiet(){
	var jenisdiet_id = $('#<?php echo Chtml::activeId($model,'jenisdiet_id') ?>').val();
	var kelaspelayanan= $('#<?php echo Chtml::activeId($model,'kelaspelayanan_id') ?>').val();
	var penjamin_id = $('#<?php echo Chtml::activeId($model,'penjamin_id') ?>').val();
	var jenistarif_id = $('#jenistarif_id').val();

	if(kelaspelayanan != ''){
		kelaspelayanan_id = kelaspelayanan;
	}else{
		var kelaspelayanan_id = $('#kelaspelayanan_id').val();
	}

	if(penjamin_id != ''){
		penjamin_id = penjamin_id;
	}else{
		var penjamin_id = $('#penjamin_id').val();
	}

	$.fn.yiiGridView.update('gzmenudiet-m-grid', {
		data: {
			"GZMenuDietM[jenisdiet_id]":jenisdiet_id,
			"GZMenuDietM[kelaspelayanan_id]":null,
			"GZMenuDietM[jenistarif_id]":jenistarif_id,
			"GZMenuDietM[penjamin_id]":penjamin_id,
		}
	});
}

function refreshDialogMenuDiet1(){
    var jenisdiet_id = $('#dlg_jenisdiet_id').val();
	var kelaspelayanan= $('#dlg_kelaspelayanan_id').val();
	var penjamin_id = $('#<?php echo Chtml::activeId($model,'penjamin_id') ?>').val();
	var jenistarif_id = $('#jenistarif_id').val();

	if(kelaspelayanan != ''){
		kelaspelayanan_id = kelaspelayanan;
	}else{
		var kelaspelayanan_id = $('#kelaspelayanan_id').val();
	}

	if(penjamin_id != ''){
		penjamin_id = penjamin_id;
	}else{
		var penjamin_id = $('#penjamin_id').val();
	}

	$.fn.yiiGridView.update('gzmenudiet1-m-grid', {
		data: {
			"GZMenuDietM[jenisdiet_id]":jenisdiet_id,
			//"GZTarifTindakanPerdaRuanganV[kelaspelayanan_id]":kelaspelayanan_id,
			"GZMenuDietM[jenistarif_id]":jenistarif_id,
			"GZMenuDietM[penjamin_id]":penjamin_id,
		}
	});
    
	$.fn.yiiGridView.update('grid-menudiet', {
		data: {
			"GZMenuDietM[jenisdiet_id]":jenisdiet_id,
			//"GZTarifTindakanPerdaRuanganV[kelaspelayanan_id]":kelaspelayanan_id,
			"GZMenuDietM[jenistarif_id]":jenistarif_id,
			"GZMenuDietM[penjamin_id]":penjamin_id,
		}
	});
}


    var is_checked = {};
    
    function isEmpty(obj) {
        for(var key in obj) {
            if(obj.hasOwnProperty(key))
                return false;
        }
        return true;
    }
        
    function setJenisWaktu(obj){
        var waktu = $(obj).attr('jeniswaktu_id');
        
        if ($(obj).prop("checked") == true){
            is_checked[waktu] = waktu;
        }else{
            is_checked[waktu] = 0;
        }
    }
    
    function setSemuaWaktu(obj){
        if ($(obj).prop("checked") == true){
            $("input:checkbox.pilih").each(function(){                   
                $(this).prop("checked",true).change();
            });
        }else{
            $("input:checkbox.pilih").each(function(){                       
                $(this).prop("checked",false).change();
            });
        }
        
    }
    
    function inputWaktu(){
        var jeniswaktu = is_checked;
        
	if (isEmpty(jeniswaktu)){
            myAlert('jenis waktu belum dipilih');
            return false;
	}else{
            $('#table-detailwaktu').addClass("animation-loading");
            cekList(jeniswaktu);
                
	}        
    }
    
    function cekSudahAda(nomor,obj){
        var x = true;
        
        $('.jeniswaktu').each(function(){
            if ($(this).val() == nomor){                
                x = false;
                $('#table-detailwaktu').removeClass("animation-loading");                
            }else{
                
            }
	});
        
        if (x == false){
            myAlert('Waktu telah ada di list');
            $(obj).val('');
        }else{
            tambahKantong(nomor);
            $(obj).val('');
        }
    }
    
    function setCeklisKantong(){           
        $("input:checkbox.pilih").each(function(){                                   
            var nomor = $(this);
            nomor.prop("checked",false);
            nomor.removeAttr("disabled");
            $("#table-detailwaktu > tbody > tr").find(".jeniswaktu").each(function(){                                                             
                if (nomor.attr('jeniswaktu_id') == $(this).val()){                    
                    nomor.prop("checked", true);
                    nomor.attr("disabled", true);
                }
            });                       
        });
    }
    
    function cekList(id){
	x = true;

	if(x==true){
            tambahKantong(is_checked);
            $("#dialogJenisWaktu").dialog("close");
            return x;
        }
        return false;
    }   
    
   function tambahKantong(nomor) {        
        $.ajax({
            type:'POST',
            url:'<?php echo $this->createUrl('getWaktu'); ?>',
            data: {jeniswaktu_id:nomor},
            dataType: "json",
            success:function(data){
                $('#table-detailwaktu > tbody').append(data);
                $('#table-detailwaktu').removeClass("animation-loading");
                renameInputRowBarang($("#table-detailwaktu"));
                is_checked = {};            
            },
            error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
        });
    }
    
    function renameInputRowBarang(obj_table){
        var row = 0;
        $(obj_table).find("tbody > tr").each(function(){
            $(this).find("#no_urut").val(row+1);
            $(this).attr("rowdata",row);
            $(this).find('span').each(function(){ //element <input>
                if (typeof $(this).attr("name") != 'undefined'){
                    var old_name = $(this).attr("name").replace(/]/g,"");
                    var old_name_arr = old_name.split("[");
                    if(old_name_arr.length == 3){
                        $(this).attr("name","["+row+"]["+old_name_arr[2]+"]");
                    }
                }
            });
            $(this).find('input,select,textarea').each(function(){ //element <input>
                var old_name = $(this).attr("name").replace(/]/g,"");
                var old_name_arr = old_name.split("[");
                if(old_name_arr.length == 3){
                    $(this).attr("id",old_name_arr[0]+"_"+row+"_"+old_name_arr[2]);
                    $(this).attr("name",old_name_arr[0]+"["+row+"]["+old_name_arr[2]+"]");
                }                        
            });
          
            row++;
        });
    }
</script>
