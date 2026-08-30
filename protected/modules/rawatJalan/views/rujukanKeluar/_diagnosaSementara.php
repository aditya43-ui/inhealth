<?php 
    $diagnosa = new DiagnosaM;
    $diagnosa->unsetAttributes();
    if(isset($_GET['DiagnosaM']))
        $diagnosa->attributes = $_GET['DiagnosaM'];

    $this->widget('ext.bootstrap.widgets.BootGridView',array(
	'id'=>'diagnosa-m-grid',
	'dataProvider'=>$diagnosa->search(),
	'filter'=>$diagnosa,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
	'columns'=>array(
                array(
                    'header' => 'Pilih',
                    'type' => 'raw',
                    'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectDiagnosa",
                                            "onClick" => "
                                                        var data = $(\"#' . CHtml::activeId($modRujukanKeluar, 'diagnosasementara_ruj') . '\").val();
                                                        if (data == \"\"){
                                                            $(\"#' . CHtml::activeId($modRujukanKeluar, 'diagnosasementara_ruj') . '\").val(\"$data->diagnosa_nama\");
                                                        } else {
                                                            $(\"#' . CHtml::activeId($modRujukanKeluar, 'diagnosasementara_ruj') . '\").val(data+\", $data->diagnosa_nama\");                                                  
                                                        }
                                                          $(\"#dialogAddDiagnosaSementara\").dialog(\"close\");    
                                                "))',
                ),
                'diagnosa_kode',
                'diagnosa_nama',
                'diagnosa_namalainnya',
                'diagnosa_katakunci',
	),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); ?>