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
            'name'=>'jenisdiet_id',
            'value'=>'$data->jenisdiet_nama',
            //'filter'=>Chtml::dropDownList('GZJenisdietM[jenisdiet_id]', GZJenisdietM->jenisdiet_id, '$data',array('empty'=>'-- Pilih --'))
        ),
        'jenisdiet_nama',
        //'jenisdiet_namalainnya',
        'jenisdiet_keterangan',
        'jenisdiet_catatan',
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
        'width' => 750,
        'resizable' => false,
    ),
));

$modMenuDiet = new GZTarifTindakanPerdaRuanganV('searchDialogDiet');
$modMenuDiet->unsetAttributes();
$modMenuDiet->kelaspelayanan_id = $model->kelaspelayanan_id;
$modMenuDiet->penjamin_id = $model->penjamin_id;
if (isset($_GET['GZTarifTindakanPerdaRuanganV'])){
    $modMenuDiet->attributes = $_GET['GZTarifTindakanPerdaRuanganV'];
    $modMenuDiet->jenisdiet_id = isset($_GET['GZTarifTindakanPerdaRuanganV']['jenisdiet_id']) ? $_GET['GZTarifTindakanPerdaRuanganV']['jenisdiet_id'] : null;
    $modMenuDiet->kelaspelayanan_id = isset($_GET['GZTarifTindakanPerdaRuanganV']['kelaspelayanan_id']) ? $_GET['GZTarifTindakanPerdaRuanganV']['kelaspelayanan_id'] : null;
// RND-9230   $modMenuDiet->penjamin_id = isset($_GET['GZTarifTindakanPerdaRuanganV']['penjamin_id']) ? $_GET['GZTarifTindakanPerdaRuanganV']['penjamin_id'] : null;
    $modMenuDiet->jenistarif_id = isset($_GET['GZTarifTindakanPerdaRuanganV']['jenistarif_id']) ? $_GET['GZTarifTindakanPerdaRuanganV']['jenistarif_id'] : null;
    $modMenuDiet->menudiet_nama = isset($_GET['GZTarifTindakanPerdaRuanganV']['menudiet_nama']) ? $_GET['GZTarifTindakanPerdaRuanganV']['menudiet_nama'] : null;
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
				$(\'#dialogMenuDiet\').dialog(\'close\');return false;"))',
        ),
        array(
            'header' => 'No.',
            'value' => '$row+1'
        ),
         array(
            'header'=>'Jenis Diet',
            'name'=>'jenisdiet_nama',
            'type'=>'raw',
            'value'=>'$data->jenisdiet_nama',
            'filter'=>CHtml::activeHiddenField($modMenuDiet, 'jenisdiet_id').
					CHtml::activeHiddenField($modMenuDiet, 'kelaspelayanan_id').
					CHtml::activeHiddenField($modMenuDiet, 'jenistarif_id').
					CHtml::activeHiddenField($modMenuDiet, 'penjamin_id'),
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
			"GZTarifTindakanPerdaRuanganV[jenisdiet_id]":jenisdiet_id,
			"GZTarifTindakanPerdaRuanganV[kelaspelayanan_id]":kelaspelayanan_id,
			"GZTarifTindakanPerdaRuanganV[jenistarif_id]":jenistarif_id,
			"GZTarifTindakanPerdaRuanganV[penjamin_id]":penjamin_id,
		}
	});
}
</script>
