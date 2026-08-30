<?php 
echo "Testing Tabbable";

/*
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'pppekerjaan-m-grid',
    'dataProvider'=>$model->search(),
    'filter'=>$model,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        ////'pekerjaan_id',
        array(
                        'name'=>'pekerjaan_id',
                        'value'=>'$data->pekerjaan_id',
                        'filter'=>false,
                ),
        'pekerjaan_nama',
        'pekerjaan_namalainnya',
                array(
                    'header' => 'Status',
                    'value'=>'($data->pekerjaan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                    'htmlOptions'=>array('style'=>'text-align:center;'),
                ),
        //'pekerjaan_aktif',
//                array(
//                        'header'=>'Aktif',
//                        'class'=>'CCheckBoxColumn',     
//                        'selectableRows'=>0,
//                        'id'=>'rows',
//                        'checked'=>'$data->pekerjaan_aktif',
//                ),
        array(
                        'header'=>Yii::t('zii','View'),
            'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{view}',
        ),
        array(
                        'header'=>Yii::t('zii','Update'),
            'class'=>'bootstrap.widgets.BootButtonColumn',
                        'template'=>'{update}',
                        'buttons'=>array(
                            'update' => array (
                                          'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                        ),
                         ),
        ),
        array(
            'header'=>'Hapus',
            'type'=>'raw',
            'value'=>'($data->pekerjaan_aktif)?CHtml::link("<i class=\'icon-remove\'></i> ","javascript:removeTemporary($data->pekerjaan_id)",array("id"=>"$data->pekerjaan_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->pekerjaan_id)",array("id"=>"$data->pekerjaan_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->pekerjaan_id)",array("id"=>"$data->pekerjaan_id","rel"=>"tooltip","title"=>"Hapus"));',
            'htmlOptions'=>array('style'=>'text-align: center; width:40px'),
        ),
    ),
      'afterAjaxUpdate'=>'function(id, data){
            jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
        }',
)); 

*/

?>