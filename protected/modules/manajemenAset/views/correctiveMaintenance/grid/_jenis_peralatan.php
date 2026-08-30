<?php
$modinvperalatan_noregister = new MAInvperalatanT();
$modinvperalatan_noregister->unsetAttributes();
if (isset($_GET['MAInvperalatanT'])) {
    $modinvperalatan_noregister->attributes = $_GET['MAInvperalatanT'];
    $modinvperalatan_noregister->default = isset($_GET['MAInvperalatanT']['default'])?$_GET['MAInvperalatanT']['default']:null;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialoginvperalatanjnsperalatan-m-grid',
    'dataProvider' => $modinvperalatan_noregister->searchDialog(),
    'template' => "{summary}\n{items}\n{pager}",
    'filter' => $modinvperalatan_noregister,
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "href"=>"",
                                        "onClick" => "
                                                      $(\"#invperalatan_id\").val(\"$data->invperalatan_id\");
                                                      $(\"#invperalatan_namabrg\").val(\"$data->invperalatan_namabrg\");
                                                      $(\"#invperalatan_kode\").val(\"$data->invperalatan_kode\");
                                                      $(\"#invperalatan_keadaan\").val(\"$data->invperalatan_keadaan\");
                                                      $(\".lokasiaset_namalokasi\").val(\"$data->lokasiaset_namalokasi\");
                                                      $(\".lokasi_id\").val(\"$data->lokasi_id\");
                                                      $(\"#dialoginvperalatanjnsperalatan\").dialog(\"close\");    
                                                      return false;
                                            "))',
        ),
        'invperalatan_kode',
        'invperalatan_namabrg',
        'invperalatan_merk'
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));