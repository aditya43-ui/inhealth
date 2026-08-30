<?php
Yii::import('persalinan.models.PSInfokunjunganpersalinanV');

//$modKunjungan = new GZInfokunjunganriV('searchDialog');
$modKunjungan = new PSInfokunjunganpersalinanV('searchRI');
$modKunjungan->unsetAttributes();
if (isset($_GET['PSInfokunjunganpersalinanV'])){
    $modKunjungan->attributes = $_GET['PSInfokunjunganpersalinanV'];       
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

$prov = $modKunjungan->searchPasien();
$prov->criteria->addCondition("(t.konsulpoli_id is not null or (t.konsulpoli_id is null and statusperiksa not in ('".Params::STATUSPERIKSA_SEDANG_DIRAWATINAP."', '".Params::STATUSPERIKSA_SUDAH_PULANG."')))");

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id'=>'gzinfokunjunganri-v-grid', 
    'dataProvider' => $prov,
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
					$(\"#pasien_id\").val($data->pasien_id);
					$(\"#pendaftaran_id\").val($data->pendaftaran_id);
					$(\"#pasienadmisi_id\").val($data->pasienadmisi_id);
					$(\"#kelaspelayanan_id\").val($data->kelaspelayanan_id);
					$(\"#penjamin_id\").val($data->penjamin_id);
					$(\'#namaPasien\').val(\'$data->nama_pasien\');
					$(\"#dialogPasien\").dialog(\"close\");
//                                dialogMenuPasien($data->pendaftaran_id);
					refreshDialogMenuDiet();
				"))',
            'filter'=>CHtml::activeHiddenField($modKunjungan, 'kelaspelayanan_id'),
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
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '$(".angkahuruf-only").keyup(function() {
            setAngkaHurufsOnly(this);
        });
        $(".numbers-only").keyup(function() {
            setNumbersOnly(this);
        });
        $(".hurufs-only").keyup(function() {
            setHurufsOnly(this);
        });'
    . '}',
));