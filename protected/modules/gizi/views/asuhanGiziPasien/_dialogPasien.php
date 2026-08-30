<?php 

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPasien',
    'options' => array(
        'title' => 'Pencarian Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 400,
        'resizable' => false,
    ),
));

$modKunjungan = new GZInfopasienmasukkamarV('searchRI');
$modKunjungan->unsetAttributes();
if (isset($_GET['GZInfopasienmasukkamarV'])){
    $modKunjungan->attributes = $_GET['GZInfopasienmasukkamarV'];       
   // if (isset($_GET['GZInfokunjunganriV']['kamarruangan_nokamar'])){
      //  $modKunjungan->kamarruangan_nokamar = $_GET['GZInfokunjunganriV']['kamarruangan_nokamar'];
   // } 
   // if (isset($_GET['GZInfokunjunganriV']['kamarruangan_nobed'])){
   //     $modKunjungan->kamarruangan_nobed = $_GET['GZInfokunjunganriV']['kamarruangan_nobed'];
  //  } 
     
}

$cri = new CDbCriteria;
$empty = array('empty'=>'-- Pilih --');
if (!empty($modKunjungan->carabayar_id)){    
    $cri->addCondition("carabayar_id = '".$modKunjungan->carabayar_id."' ");
    $empty = array();
}else{
    $modKunjungan->penjamin_id = null;
}
$cri->addCondition("penjamin_aktif = TRUE ");
$cri->order = 'penjamin_nama ASC';
$penjamin = PenjaminpasienM::model()->findAll($cri);

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id'=>'pasien-grid', 
    'dataProvider' => $modKunjungan->searchRI(),
    'filter' => $modKunjungan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
				"id" => "selectPasien",
				"onClick" => "
                    $(\"#nama_pasien\").val(\"$data->nama_pasien\");
                    setPasienByPendaftaran($data->pendaftaran_id);
					$(\"#dialogPasien\").dialog(\"close\");
				"))',
            'filter'=>CHtml::activeHiddenField($modKunjungan, 'ruangan_id', array('class'=>'dialog_ruangan_id')),
        ),
        array(
            'header' => 'No. Pendaftaran',            
            'name' => 'no_pendaftaran',
            'filter' => Chtml::activeTextField($modKunjungan, 'no_pendaftaran', array('class'=>'angkahuruf-only'))
        ),        
        array(
            'header' => 'No. Rekam Medik',            
            'name' => 'no_rekam_medik',
            'filter' => Chtml::activeTextField($modKunjungan, 'no_rekam_medik', array('class'=>'numbers-only'))
        ),        
        array(
            'header' => 'Nama Pasien',
            'name' => 'nama_pasien',
            'value' => '$data->namadepan." ".$data->nama_pasien',
            'filter' => Chtml::activeTextField($modKunjungan, 'nama_pasien', array('class'=>'hurufs-only'))
        ),        
        array(
            'header' => 'Umur',
            'name' => 'umur',
            'filter' => Chtml::activeTextField($modKunjungan, 'umur', array('class'=>'angkahuruf-only'))
        ),         
        array(
            'name'=>'jeniskelamin',
            'filter'=> CHtml::dropDownList('GZInfopasienmasukkamarV[jeniskelamin]',$modKunjungan->jeniskelamin,LookupM::getItems('jeniskelamin'),array('empty'=>'-- Pilih --')),
            'value'=>'$data->jeniskelamin'
        ),
        array(
            'name'=>'carabayar_id',
            'value'=>'$data->carabayar_nama',
            'filter'=>  CHtml::activeDropDownList($modKunjungan, 'carabayar_id', CHtml::listData(
           CarabayarM::model()->findAllByAttributes(array(
               'carabayar_aktif'=>true
           )), 'carabayar_id', 'carabayar_nama'), array('empty'=>'-- Pilih --')),
        ),
        array(
            'name'=>'penjamin_id',
            'value'=>'$data->penjamin_nama',
            'filter'=> Chtml::activeDropDownList($modKunjungan, 'penjamin_id', Chtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'),$empty),
        ),
       /* array(
            'name'=>'ruangan_id',
            'filter'=> CHtml::activeHiddenField($modKunjungan, 'ruangan_id', array('class'=>'namaRuangan')).CHtml::dropDownList('GZInfopasienmasukkamarV[ruangan_id]',$modKunjungan->ruangan_id,CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true ORDER BY ruangan_nama ASC'), 'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','disabled'=>TRUE)),            
            'value'=>'$data->ruangan_nama'
        ),*/
        array(
            'header' => 'No. Kamar',
            'name' => 'kamarruangan_nokamar',
            'filter' => Chtml::activeTextField($modKunjungan, 'kamarruangan_nokamar', array('class'=>'angkahuruf-only'))
        ), 
        array(
            'header' => 'No. Bed',
            'name' => 'kamarruangan_nobed',
            'filter' => Chtml::activeTextField($modKunjungan, 'kamarruangan_nobed', array('class'=>'angkahuruf-only'))
        ),         
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'

    . '}',
));

/*
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-grid',
    //'ajaxUrl'=>Yii::app()->createUrl('actionAjax/CariDataPasien'),
    'dataProvider' => $modCariPasien->search(),
    'filter' => $modCariPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                                            array(
                                                    "class"=>"btn-small",
                                                    "id" => "selectJenisdiet",
                                                    "onClick" => "setPasienByPendaftaran($data->pasien_id)"
                                             )
                             )',
        ),
        'no_rekam_medik',
        'nama_pasien',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
*/

$this->endWidget();
?>