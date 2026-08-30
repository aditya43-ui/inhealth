<?php
 $array = array(
                    'header'=>'Lantai',
                    'name'=>'slotbed_noslot',
                );
$this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'saslot-bed-m-grid',
                    'dataProvider' => $model->searchSlotHemodialisa(),
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        array(
                        'header'=>'No.',
                        'value' => '($this->grid->dataProvider->pagination) ? 
                                        ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                                        : ($row+1)',
                        'type'=>'raw',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
                    array(
                            'name'=>'kelaspelayanan_id',
                            'filter'=>  CHtml::listData($model->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                            'value'=>'$data->kelaspelayanan->kelaspelayanan_nama',
                    ),
                     array(
                            'name'=>'ruangan_id',
                            'filter'=>CHtml::listData($model->RuanganItems, 'ruangan_id', 'ruangan_nama'),
                            'value'=>'isset($data->ruangan->ruangan_nama) ? $data->ruangan->ruangan_nama : "-"',
                    ),
                    $array,


                    'slotbed_jmlbed',	
                    'slotbed_nobed',
//                    'koordinat_x',
//                    'koordinat_y',
//                    'ugambar',
                     array
                    (
                        'name'=>'slotbed_status',
                        'type'=>'raw',
                        'value'=>'($data->slotbed_status==1)? Yii::t("mds","Ya") : Yii::t("mds","Tidak")',
                    ),
                    array(
                        'header'=>'<center>Status Aktif</center>',
                        'value'=>'($data->slotbed_aktif == 1 ) ? "Ya" : "Tidak"',
                        'htmlOptions'=>array('style'=>'text-align:center;'),
                    ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                        ),

                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'url' => 'Yii::app()->createUrl("' . Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/update",array("id"=>$data->slotbed_id,"kelaspelayanan_id"=>$data->kelaspelayanan_id,"ruangan_id"=>$data->ruangan_id,"slotbed_noslot"=>$data->slotbed_noslot,))',
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->slotbed_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->slotbed_id)",array("id"=>"$data->slotbed_id","rel"=>"tooltip","title"=>"Menonaktifkan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->slotbed_id)",array("id"=>"$data->slotbed_id","rel"=>"tooltip","title"=>"Hapus")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->slotbed_id)",array("id"=>"$data->slotbed_id","rel"=>"tooltip","title"=>"Hapus"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
            $("table").find("input[type=text]").each(function(){
                cekForm(this);
            })
             $("table").find("select").each(function(){
                cekForm(this);
            })
        }',
                ));