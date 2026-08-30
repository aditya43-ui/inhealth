
<!--============================== Widget Dialog Diagnosa ====================================-->
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialog_pasien',
    'options' => array(
        'title' => 'Dialog Pasien',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'resizable' => false,
    ),
));

$modPasien = new RJPendaftaranT();
$modPasien->unsetAttributes();
if (isset($_GET['RJPendaftaranT'])) {
    $modPasien->attributes = $_GET['RJPendaftaranT'];
    $modPasien->nama_pasien = $_GET['RJPendaftaranT']['nama_pasien'];
    $modPasien->jeniskelamin = $_GET['RJPendaftaranT']['jeniskelamin'];
    $modPasien->no_rekam_medik = $_GET['RJPendaftaranT']['no_rekam_medik'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pasien-grid',
    'dataProvider' => $this->searchPasien($modPasien),
    'filter' => $modPasien,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-bordered table-striped table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) use (&$json_data) {
    
                $json_data = $data->getJSONKunjunganPasienUntukSurveilance();
                $pasien = PasienM::model()->findByPk($data->pasien_id);
                $modRiwayatSurveilans = RJSurveilansT::model()->findAllByAttributes(array('pasien_id'=>$data->pasien_id));
                
                $sub['riwayat'] = "";
            
                foreach($modRiwayatSurveilans as $item2) {
                    $sub['riwayat'] = $this->renderPartial($this->path_view."_rowRiwayatPasien", array(
                        'data'=>$item2,
                        'modPasien'=>$pasien,
                    ), true);
                }
    
                return CHtml::Link('<i class="icon-form-check"></i>',"#",array("class"=>"btn-small", 
                                    "id" => "selectKasuspenyakit",
                                    "onClick" => "
                                    loadPasien(".CJSON::encode($json_data).");
                                    $(\"#dialog_pasien\").dialog(\"close\");	
                                    return false;"));
            },
        ),
        'no_pendaftaran',
        array(
            'name'=>'tgl_pendaftaran',
            'type'=>'raw',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tgl_pendaftaran)'
        ),
        array(
            'name'=>'nama_pasien',
            'type'=>'raw',
            'value'=>function($data) use (&$json_data) {
                return $json_data['nama_pasien'];
            }
        ),
        array(
            'name'=>'jeniskelamin',
            'filter'=>CHtml::activeDropDownList($modPasien, 'jeniskelamin', LookupM::getItems('jeniskelamin'), array(
                'empty'=>'-- Pilih --',
            )),
        ),
         
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>