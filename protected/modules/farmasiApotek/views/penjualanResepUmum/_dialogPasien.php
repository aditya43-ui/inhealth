<?php 
//========= Dialog buat cari data pasien =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogPasien',
    'options'=>array(
        'title'=>'Pencarian Data Pasien Apotek',
        'autoOpen'=>false,
        'modal'=>true,
        'width'=>900,
        'height'=>600,
        'resizable'=>false,
    ),
));

$modDataPasien = new FAPasienM('searchPasienApotek');
$modDataPasien->unsetAttributes();
if(isset($_GET['FAPasienM'])) {
    $modDataPasien->attributes = $_GET['FAPasienM'];
    $modDataPasien->propinsiNama = isset($_GET['FAPasienM']['propinsiNama']) ? $_GET['FAPasienM']['propinsiNama'] : null;
    $modDataPasien->kabupatenNama = isset($_GET['FAPasienM']['kabupatenNama']) ? $_GET['FAPasienM']['kabupatenNama'] : null;
    $modDataPasien->kecamatanNama = isset($_GET['FAPasienM']['kecamatanNama']) ? $_GET['FAPasienM']['kecamatanNama'] : null;
    $modDataPasien->kelurahanNama = isset($_GET['FAPasienM']['kelurahanNama']) ? $_GET['FAPasienM']['kelurahanNama'] : null;
}
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pasien-m-grid',
    'dataProvider'=>$modDataPasien->searchPasienApotek(),
    'filter'=>$modDataPasien,
    'template'=>"{items}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPasien",
                "onClick" => "
                    $(\"#dialogPasien\").dialog(\"close\");
                    $(\"#noPasienApotek\").val(\"$data->no_rekam_medik\");
                    setInfoPasien(\"$data->no_rekam_medik\",$data->pasien_id);
                    
                    setJenisKelaminPasien(\"$data->jeniskelamin\");
                "))',
        ),
        array(
                'name'=>'no_rekam_medik',
                'header'=>'No. Rekam Medik',
                'value'=>'$data->no_rekam_medik',
        ),
        'nama_pasien',
        array(
                'name'=>'nama_bin',
                'header'=>'Alias',
                'value'=>'$data->nama_bin',
        ),
        'alamat_pasien',
        'rw',
        'rt',
        array(
            'name'=>'propinsiNama',
            'value'=>'$data->propinsi->propinsi_nama',
        ),
        array(
            'name'=>'kabupatenNama',
            'value'=>'$data->kabupaten->kabupaten_nama',
        ),
        array(
            'name'=>'kecamatanNama',
            'value'=>'$data->kecamatan->kecamatan_nama',
        ),
        array(
            'name'=>'kelurahanNama',
            'value'=>'isset($data->kelurahan->kelurahan_nama)?($data->kelurahan->kelurahan_nama):""',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

$this->endWidget();
//========= end pasien dialog =============================
?>