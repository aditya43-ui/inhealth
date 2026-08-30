<?php

/**
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * 
 * Dialog Obat Alkes Non Racikan
 */


$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogObat',
    'options'=>array(
        'title'=>'Daftar Obat Alkes',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'minHeight'=>400,
        'resizable'=>false,
    ),
));

$modObatDialog = new PIObatalkesM('searchObatFarmasiRuangan');
$modObatDialog->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['PIObatalkesM'])){
	$modObatDialog->attributes = $_GET['PIObatalkesM'];
    if(isset($_GET['PIObatalkesM']['ruangan_id'])){
		$modObatDialog->ruangan_id = $_GET['PIObatalkesM']['ruangan_id'];
	}
//	if(isset($_GET['RIObatalkesM']['therapiobat_id'])){
		$modObatDialog->therapiobat_id = isset($_GET['PIObatalkesM']['therapiobat_id']) ? $_GET['PIObatalkesM']['therapiobat_id'] : null;
//	}
//	if(isset($_GET['RIObatalkesM']['ruangan_id'])){
		// $modObatDialog->ruangan_id = isset($_GET['RIObatalkesM']['ruangan_id']) ? $_GET['RIObatalkesM']['ruangan_id'] : null;
//	}
}
    
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatAlkesDialog-m-grid',
//    'dataProvider'=>$modObatDialog->searchObatFarmasi(),
    'dataProvider'=>$modObatDialog->searchObatFarmasiRuangan(),
    'filter'=>$modObatDialog,
    'template'=>"{items}\n{pager}",
//    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("rel"=>"tooltip","title"=>"Pilih Obat/Alkes","class"=>"btn_small",
                "id"=>"selectObat",
                "onClick"=>"
                            $(\"#form-nonracikan #obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#obatalkes_kode\").val(\"$data->obatalkes_kode\");
                            $(\"#form-nonracikan #namaObatNonRacik\").val(\"$data->obatalkes_nama\");
							setThreapiobat_id(\"$data->obatalkes_id\");
							$(\"#form-nonracikan #signa\").val(\"$data->signa\");
							$(\"#dialogObat\").dialog(\"close\");
                            return false;
                ",
               ))',
			'filter'=>CHtml::activeHiddenField($modObatDialog, 'therapiobat_id'),//RND-7948
        ),
        
        array(
            'header' => 'Jenis Kelompok',
            'name' => 'jnskelompok',
            'value' => '$data->lookup_name',
            'filter' => 
            CHtml::activeHiddenField($modObatDialog, 'ruangan_id').
            CHtml::activeDropDownList($modObatDialog, 'jnskelompok', LookupM::getItems('jnskelompok'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'name'=>'jenisobatalkes_id',
            'value'=>'!empty($data->jenisobatalkes_id)?(($data->jenisobatalkes_nama==null)?$data->jenisobatalkes->jenisobatalkes_nama:$data->jenisobatalkes_nama):"-"',
            'filter'=>CHtml::activeDropDownlist($modObatDialog, 'jenisobatalkes_id', JenisobatalkesM::model()->listItem(), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header' => 'Kategori',
            'value' => '$data->obatalkes_kategori',
            'filter'=>CHtml::activeDropDownList($modObatDialog, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header' => 'Golongan',
            'value' => '$data->obatalkes_golongan',
            'filter'=>CHtml::activeDropDownList($modObatDialog, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --')),
        ),
        
        'obatalkes_kode',
        'obatalkes_nama',
        array(
            'header'=>'Tanggal Kedaluwarsa',
            'name'=>'tglkadaluarsa',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tglkadaluarsa)',
            'filter'=>'',
        ),     /*   
        array(
            'name'=>'satuankecil.satuankecil_nama',
            'header'=>'Satuan Kecil',
        ),
        array(
            'name'=>'satuanbesar.satuanbesar_nama',
            'header'=>'Satuan Besar',
        ),
         * 
         */
		// dicomment karena RND-5732
//        array(
//            'header'=>'HJA Resep',
//            'type'=>'raw',
//            'value'=>'number_format($data->hjaresep, 0, ",", ".")',
//            'filter'=>'',
//            'htmlOptions'=>array('style'=>'text-align:right;'),
//        ),
//        array(
//            'header'=>'HJA Non Resep',
//            'value'=>'number_format($data->hjanonresep, 0, ",", ".")',
//            'filter'=>'',
//            'htmlOptions'=>array('style'=>'text-align:right;'),
//        ),
		array(
				'name'=>'hargajual',
				'value'=>'number_format($data->hargajual)',
                                'visible'=> Params::HIDDEN_GRID_HARGA
			),
        array(
            'header'=>'Stok - Satuan',
            'type'=>'raw',
            'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id,"'.$modObatDialog->ruangan_id.'")." - ".$data->satuankecil_nama',
            'htmlOptions'=>array(
                'style'=>'text-align: right',
            )
        ),

        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>