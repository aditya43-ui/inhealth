<div id="dtd-div" style="display: block;" >
                 <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                'id'=>'dtd-grid',
                'dataProvider'=>$modDTDM->searchRJ(),
                'filter'=>$modDTDM, 
                'template'=>"{summary}\n{items}\n{pager}",
                'itemsCssClass'=>'table table-striped table-condensed',
                'columns'=>array(   
                        array(
                           'name'=>'dtd_kode',
                           'type'=>'raw',
                           'value'=>'CHtml::link($data->dtd_kode, "javascript:cariDiagnosa(\'$data->dtd_id\');",array("id"=>"$data->dtd_id","rel"=>"tooltip","title"=>"Klik Untuk Melihat Diagnosa"))',
                           'htmlOptions'=>array('style'=>'text-align: left; width:120px')
                        ),
                        //'dtd_kode',   
                        'dtd_nama',
                 ),
                'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
                )); ?>
            </div>