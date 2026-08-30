<div id='tblDiagnosa'>
<?php 
$modDiagnosaPasien = new PIDiagnosaM('searchDiagnosis');
$modDiagnosaPasien->unsetAttributes();  // clear any default values
if(isset($_GET['PIDiagnosaM'])){
	$modDiagnosaPasien->attributes=$_GET['PIDiagnosaM'];
	$modDiagnosaPasien->diagnosa_aktif=TRUE;
}
	
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rjdiagnosa-m-grid',
    'dataProvider'=>$modDiagnosaPasien->search(),
    'filter'=>$modDiagnosaPasien,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-condensed',
    'columns'=>array(        
        array(
            'name'=>'diagnosa_nourut',
            'value'=>'$data->diagnosa_nourut',
            'filter'=>false,
        ),
		array(
			'header'=>'Klasifikasi Diagnosa',
            'name'=>'klasifikasidiagnosa_id',
            'value'=>'isset($data->klasifikasidiagnosa_id) ? $data->klasifikasidiagnosa->KlasifikasiKodeNama : ""',
			'filter'=> CHtml::activeDropDownList($modDiagnosaPasien,'klasifikasidiagnosa_id',CHtml::listData(PIKlasifikasidiagnosaM::model()->findAll("klasifikasidiagnosa_aktif is true"), "klasifikasidiagnosa_id", "KlasifikasiKodeNama"),array('empty'=>'-- Pilih --')),
        ),
        'diagnosa_kode',
        'diagnosa_nama',
        'diagnosa_namalainnya',
        'diagnosa_katakunci',
        array(
            'header'=>'Kelompok Diagnosa',
            'type'=>'raw',
            'value'=>'CHtml::dropDownList("kelompokDiagnosa_$data->diagnosa_id","",CHtml::listData(PIKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif is true"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);",))',
        ), 
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputDiagnosa(this,$data->diagnosa_id);return false;"))',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?> 
</div>
   
<div id="tblKasuspenyakitDiagnosa" class="hide">
<?php 
//$modDiagnosaKasusPenyakit = new PIKasusPenyakitDiagnosaM('search');
//$modDiagnosaKasusPenyakit->unsetAttributes();  // clear any default values
//$modDiagnosaKasusPenyakit->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
//if(isset($_GET['PIKasusPenyakitDiagnosaM'])){
//    $modDiagnosaKasusPenyakit->attributes=$_GET['PIKasusPenyakitDiagnosaM'];
//    $modDiagnosaKasusPenyakit->jeniskasuspenyakit_id = $modPendaftaran->jeniskasuspenyakit_id;
//}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rikasuspenyakitdiagnosa-m-grid',
    'dataProvider'=>$modKasuspenyakitDiagnosa->search(),
    'filter'=>$modKasuspenyakitDiagnosa,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-bordered table-condensed',
    'columns'=>array(        
        array(
            'header'=>'No. Urut',
            'value'=>'(isset($data->diagnosa->diagnosa_nourut) ? $data->diagnosa->diagnosa_nourut : "")',
//            'filter'=>false,
        ),
		array(
			'header'=>'Klasifikasi Diagnosa',
            'value'=>'isset($data->diagnosa->klasifikasidiagnosa_id) ? $data->diagnosa->klasifikasidiagnosa->KlasifikasiKodeNama : ""',
			'filter'=> CHtml::activeDropDownList($modDiagnosaPasien,'klasifikasidiagnosa_id',CHtml::listData(PIKlasifikasidiagnosaM::model()->findAll("klasifikasidiagnosa_aktif is true"), "klasifikasidiagnosa_id", "KlasifikasiKodeNama"),array('empty'=>'-- Pilih --')),
        ),
        array(
			'name'=>'diagnosa_kode',
            'header'=>'Kode Diagnosa',
            'value'=>'(isset($data->diagnosa->diagnosa_kode) ? $data->diagnosa->diagnosa_kode : "")',
        ),
        array(
			'name'=>'diagnosa_nama',
            'header'=>'Nama Diagnosa',
            'value'=>'(isset($data->diagnosa->diagnosa_nama) ? $data->diagnosa->diagnosa_nama : "")',
        ),
        array(
			'name'=>'diagnosa_namalainnya',
            'header'=>'Nama Lain ',
            'value'=>'(isset($data->diagnosa->diagnosa_namalainnya) ? $data->diagnosa->diagnosa_namalainnya : "")',
        ),
        array(
			'name'=>'diagnosa_katakunci',
            'header'=>'Kata Kunci',
            'value'=>'(isset($data->diagnosa->diagnosa_katakunci) ? $data->diagnosa->diagnosa_katakunci : "")',
        ),
        array(
            'header'=>'Kelompok Diagnosa',
            'type'=>'raw',
            'value'=>'CHtml::dropDownList("kelompokDiagnosa_$data->diagnosa_id","",CHtml::listData(PIKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif is true"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);",))',
        ),
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputDiagnosa(this,$data->diagnosa_id);return false;"))',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 
?> 
</div>