<?php 
    $modAmbulans = new AMMobilambulansM('searchDialog');
    $modAmbulans->unsetAttributes();
    if(isset($_GET['AMMobilambulansM'])){
        $modAmbulans->attributes = $_GET['AMMobilambulansM'];
    }

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
        'id'=>'ambulans-t-grid',
        'dataProvider'=>$modAmbulans->searchDialogAmbulansBelumTerpakai(),
        'filter'=>$modAmbulans,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>function($data) {
                    $km_awal = 0;
                    $pakai = PemakaianambulansT::model()->findByAttributes(array(
                        'mobilambulans_id'=>$data->mobilambulans_id
                    ));
                    
                    
                    return CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                "id" => "selectPasien",
                                "onClick" => "inputKendaraan($data->mobilambulans_id,
                                    \"".$data->nopolisi."\",
                                    \"".$data->jeniskendaraan."\",
                                    \"".$data->mobilambulans_kode."\",
                                    \"".$data->kmterakhirkend."\",
                                    \"".$data->isibbmliter."\");return false;"));
                },
            ),
            'mobilambulans_kode',
            'nopolisi',
            'jeniskendaraan',
            array(
                'header'=>$modAmbulans->getAttributeLabel('photokendaraan'),
                'type'=>'raw',
                'value'=>'CHtml::image(Params::urlKendaraanTumbsDirectory()."kecil_".$data->photokendaraan, "Ambulans ".$data->nopolisi, array());',
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?> 

