<?php 
    $modTarif = new BKTarifambulansM;
    $modTarif->unsetAttributes();
    if(isset($_GET['BKTarifambulansM'])){
        $modTarif->attributes = $_GET['BKTarifambulansM'];
    }

    $this->widget('ext.bootstrap.widgets.HeaderGroupGridView',array(
        'id'=>'tarifambulans-t-grid',
        'dataProvider'=>$modTarif->search(),
        'filter'=>$modTarif,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputTarifAmbulans($data->jmlkilometer,
                                        $data->TarifPerKm,
                                        $data->TarifAmbulans,
                                        \'$data->kepropinsi_nama\',
                                        \'$data->kekabupaten_nama\',
                                        \'$data->kekecamatan_nama\',
                                        \'$data->kekelurahan_nama\',
                                        \'$data->daftartindakan_id\');
                                        $(\"#ispilihtarif\").val(1);
                                        return false;"))',
            ),
            array(
                'name'=>'tarifambulans_kode',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'name'=>'daftartindakan.daftartindakan_nama',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'name'=>'kepropinsi_nama',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'name'=>'kekabupaten_nama',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'name'=>'kekecamatan_nama',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'name'=>'kekelurahan_nama',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'name'=>'jmlkilometer',
                'value'=>'number_format($data->jmlkilometer)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'name'=>'tarifperkm',
                'value'=>'number_format($data->tarifperkm)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),
            array(
                'name'=>'tarifambulans',
                'value'=>'number_format($data->tarifambulans)',
                'headerHtmlOptions'=>array('style'=>'vertical-align:middle;text-align:center;'),
            ),        
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )); 
?> 
    
