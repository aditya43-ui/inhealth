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
				refreshDialogMenuDiet();
				$(\'#dialogJenisDiet\').dialog(\'close\');return false;"))',
        ),
        array(
            'header' => 'Jenis Diet',
            'name'=>'jenisdiet_nama',
            'value'=>'$data->jenisdiet_nama',
            //'filter'=>Chtml::dropDownList('GZJenisdietM[jenisdiet_id]', GZJenisdietM->jenisdiet_id, '$data',array('empty'=>'-- Pilih --'))
        ),
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
?>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogMenuDiet',
    'options' => array(
        'title' => 'Daftar Menu Diet ',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1100,
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
                                $(\'#jenisdiet_id\').val(\'$data->jenisdiet_id\');
				$(\'#URT\').val(\'$data->ukuranrumahtangga\');
                $(\'.jeniswaktu\').prop(\'checked\', false);
				$(\'.jeniswaktu[value=$data->jeniswaktu_id]\').prop(\'checked\', \'checked\');
				$(\'#dialogMenuDiet\').dialog(\'close\');return false;"))',
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
<script type="text/javascript">
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
			"GZMenuDietM[kelaspelayanan_id]":kelaspelayanan_id,
			"GZMenuDietM[jenistarif_id]":jenistarif_id,
			"GZMenuDietM[penjamin_id]":penjamin_id,
		}
	});
}
</script>
