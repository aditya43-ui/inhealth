<?php
$data = $model->search();
if ($this->module->id == 'hemodialisa'){
    $data = $model->searchSlotHemodialisa();
}

$this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'saslot-bed-m-grid',
                    'dataProvider' => $data,
                    'filter' => $model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        ////'slotbed_id',
                        /*array(
                        'name'=>'slotbed_id',
                        'value'=>'$data->slotbed_id',
                        'filter'=>false,
                ),*/
                        array(
                            'header' => 'No.',
                            'value' => '$row+1'
                        ),
                        array(
                            'name' => 'kelaspelayanan_id',
                            'filter' =>  CHtml::listData($model->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'),
                            'value' => '$data->kelaspelayanan->kelaspelayanan_nama',
                        ),
                        array(
                            'header' => 'Instalasi',
                            'name' => 'instalasi_id',
                            'filter' => CHtml::listData($model->InstalasiItems, 'instalasi_id', 'instalasi_nama'),
                            'value' => 'isset($data->ruangan->instalasi_id) ? $data->ruangan->instalasi->instalasi_nama : "-"',
                        ),
                        array(
                            'name' => 'ruangan_id',
                            'filter' => CHtml::listData($model->RuanganSlotItems, 'ruangan_id', 'ruangan_nama'),
                            'value' => 'isset($data->ruangan->ruangan_nama) ? $data->ruangan->ruangan_nama : "-"',
                        ),
                        [   
                            'header' => ($this->module->id == 'hemodialisa')?'Lantai':'Nama Slot',
                            'name' => 'slotbed_noslot'
                        ],
                        'slotbed_jmlbed',
                        'slotbed_nobed',
                        // array(
                        //     'header' => 'Bed Bayangan',
                        //     'value' => '($data->is_bedbayangan == 1 ) ? "Ya" : "Tidak"',
                        //     'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        //     'filter' => CHtml::activeDropDownList($model, 'is_bedbayangan', array("0" => "Tidak", "1" => "Ya"), array(
                        //         'empty'=>'-- Pilih --',
                        //     )),
                        // ),
                        array(
                            'name' => 'slotbed_status',
                            'type' => 'raw',
                            'filter' => false,
                            'value' => '($data->slotbed_status==1)? Yii::t("mds","No") : Yii::t("mds","Yes")',
                        ),
                        array(
                            'header' => 'Status Aktif',
                            'value' => '($data->slotbed_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //                 array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',     
                        //                        'selectableRows'=>0,
                        //                        'id'=>'rows',
                        //                        'checked'=>'$data->slotbed_aktif',
                        //                ), 

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