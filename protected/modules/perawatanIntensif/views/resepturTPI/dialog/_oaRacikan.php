<?php

/**
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 * 
 * Dialog Obat Alkes Racikan
 */

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( 
    'id'=>'dialogObatRacikan',
    'options'=>array(
        'title'=>'Daftar Obat Alkes Racikan',
        'autoOpen'=>false,
        'modal'=>true,
        'minWidth'=>900,
        'minHeight'=>400,
        'resizable'=>false,
    ),
));

$modObatDialogRacikan = new PIObatalkesM('searchObatFarmasi');
$modObatDialogRacikan->unsetAttributes();
$format = new MyFormatter();
if (isset($_GET['PIObatalkesM'])){
	$modObatDialogRacikan->attributes = $_GET['PIObatalkesM'];
	if(isset($_GET['PIObatalkesM']['ruangan_id'])){
		$modObatDialogRacikan->ruangan_id = $_GET['PIObatalkesM']['ruangan_id'];
	}
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'obatAlkesDialogRacikan-m-grid',
    'dataProvider'=>$modObatDialogRacikan->searchObatFarmasiRuangan(),
    'filter'=>$modObatDialogRacikan,
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
                           
                            $(\"#form-racikan #obatalkes_id\").val(\"$data->obatalkes_id\");
                            $(\"#obatalkes_kode\").val(\"$data->obatalkes_kode\");
                            $(\"#form-racikan #namaObatRacik\").val(\"$data->obatalkes_nama\");
                            $(\"#form-racikan #kekuatanObat\").val(\"".number_format($data->kekuatan, 2, ",", "")."\");
							hitungJumlahObat();
                            $(\"#dialogObatRacikan\").dialog(\"close\");
                            return false;
                ",
               ))',
        ),
array(
            'header' => 'Jenis Kelompok',
            'name' => 'jnskelompok',
            'value' => '$data->lookup_name',
            'filter' => 
                CHtml::activeHiddenField($modObatDialogRacikan, 'ruangan_id').
                CHtml::activeDropDownList($modObatDialogRacikan, 'jnskelompok', LookupM::getItems('jnskelompok'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'name'=>'jenisobatalkes_id',
            'value'=>'!empty($data->jenisobatalkes_id)?(($data->jenisobatalkes_nama==null)?$data->jenisobatalkes->jenisobatalkes_nama:$data->jenisobatalkes_nama):"-"',
            'filter'=>CHtml::activeDropDownlist($modObatDialogRacikan, 'jenisobatalkes_id', JenisobatalkesM::model()->listItem(), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header' => 'Kategori',
            'value' => '$data->obatalkes_kategori',
            'filter'=>CHtml::activeDropDownList($modObatDialogRacikan, 'obatalkes_kategori', LookupM::getItems('obatalkes_kategori'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header' => 'Golongan',
            'value' => '$data->obatalkes_golongan',
            'filter'=>CHtml::activeDropDownList($modObatDialogRacikan, 'obatalkes_golongan', LookupM::getItems('obatalkes_golongan'), array('empty'=>'-- Pilih --')),
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
            'value'=>'StokobatalkesT::getJumlahStok($data->obatalkes_id,"'.$modObatDialogRacikan->ruangan_id.'")." - ".$data->satuankecil_nama',
            'htmlOptions'=>array(
                'style'=>'text-align: right',
            )
        ),

        
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));
        
$this->endWidget();
?>