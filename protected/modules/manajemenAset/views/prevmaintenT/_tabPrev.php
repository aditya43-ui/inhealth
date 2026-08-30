<?php

/**
 * Form Tabulasi Preventive Maintenance.
 * 
 * @author Deni Hamdani <denihamdani@piindonesia.co.id>
 */

$prev = new PrevmaintenT;
$prev->invperalatan_id = $model->invperalatan_id;

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'preventifmainten-m-grid',
    'dataProvider'=>$prev->searchPrev(),
    'template'=>"{summary}\n{items}\n{pager}",
    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
    'columns'=>array(
        array(
            'header'=>'Tgl. Pemeliharaan',
            'name'=>'tglprevmainten',
            'value'=>'MyFormatter::formatDateTimeForUser($data->tglprevmainten);',
        ),
        array(
            'header'=>'Frekuensi',
            'type'=>'raw',
            'value'=>'$data->frekuansi_prev." ".$data->frekuensi_jml_prev." ".$data->frekuensi_sat_prev',
        ),
        array(
            'header'=>'Ceklis',
            'type'=>'raw',
            'value'=>function($data) {
                $det = PrevmaintendetT::model()->findAllByAttributes(array(
                    'prevmainten_id'=>$data->prevmainten_id
                ));
                
                $res = array();
                
                foreach ($det as $item) {
                    
                    if (!$item->ipmchecklist_status) {
                        continue;
                    }
                    
                    $ipm = IpmchecklistM::model()->findByPk($item->ipmchecklist_id);
                    
                    if (empty($res[$ipm->ipm_jenis])) {
                        $res[$ipm->ipm_jenis] = array();
                    }
                    
                    $res[$ipm->ipm_jenis][] = $item;
                }
                
                $str = "";
                
                foreach ($res as $jenis => $grup) {
                
                    $str .= "<strong>".$jenis."</strong>";
                    $str .= '<ul style="list-style-type:none">';
                    foreach ($grup as $item) { 
                        if (!$item->ipmchecklist_status) {
                            continue;
                        }
                        $str .= '<li><ul style="list-style-type:'.($item->ipmchecklist_status ? 'disc' : 'circle').'"><li>';

                        $ceklis = IpmchecklistM::model()->findByPk($item->ipmchecklist_id);
                        $str .= $ceklis->ipm_listnama;

                        $str .= '</li></ul></li>';

                    }
                    
                    $str .= '</ul>';
                }
                
                
                
                return $str;
            },
        ),
        array(
            'header'=>Yii::t('zii','Delete'),
            'class'=>'bootstrap.widgets.BootButtonColumn',
            'template'=>'{delete}',
            'buttons'=>array(
                    'delete' => array (
                    'label'=>"<i class='".  MyIcon::getIcons('hapus')."'></i>",
                    'options'=>array('title'=>Yii::t('mds','Delete')),
                        'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->prevmainten_id"))',
                        //    'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/delete",array("id"=>"$data->lookup_name"))',               
                    ),
            ),
            'htmlOptions'=>array(
                'style'=>'text-align: center',
            )
        ),
    ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
));

?>