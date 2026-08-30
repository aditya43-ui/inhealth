<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-edit"></i> Pengaturan <b>Kelompok Diagnosa</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Sakelompok Diagnosa Ms' => array('index'),
            'Manage',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Kelompok Diagnosa ', 'header' => true, 'itemOptions' => array('class' => 'heading-master'))) :  '';
        //                array_push($arrMenu,array('label'=>Yii::t('mds','List').' Kelompok Diagnosa', 'icon'=>'list', 'url'=>array('index'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Create') . ' Kelompok Diagnosa', 'icon' => 'file', 'url' => array('create'))) :  '';

        //$this->menu=$arrMenu;

        Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){        
$('.search-form').toggle();
$('#SAKelompokDiagnosaM_kelompokdiagnosa_nama').focus();
return false;
});
$('.search-form form').submit(function(){
$.fn.yiiGridView.update('sakelompok-diagnosa-m-grid', {
    data: $(this).serialize()
});
return false;
});
");

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php echo CHtml::link(Yii::t('mds', '{icon} Advanced Search', array('{icon}' => '<i class="icon-accordion icon-white"></i>')), '#', array('class' => 'search-button btn')); ?>
        <div class="cari-lanjut search-form">
            <?php $this->renderPartial($this->path_view . '_search', array(
                'model' => $model,
            )); ?>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Kelompok Diagnosa</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->widget('ext.bootstrap.widgets.BootGridView', array(
                    'id' => 'sakelompok-diagnosa-m-grid',
                    'dataProvider' => $model->search(),
                    //'filter'=>$model,
                    'template' => "{summary}\n{items}\n{pager}",
                    'itemsCssClass' => 'table table-bordered table-striped datatable',
                    'columns' => array(
                        ////'kelompokdiagnosa_id',
                        array(
                            'header' => 'No.',
                            'value' => '($this->grid->dataProvider->pagination) ? 
                    ($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
                    : ($row+1)',
                            'type' => 'raw',
                            'htmlOptions' => array('style' => 'text-align: right;'),
                        ),
                        'kelompokdiagnosa_nama',
                        'kelompokdiagnosa_namalainnya',
                        array(
                            'header' => 'Status',
                            'value' => '($data->kelompokdiagnosa_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                        //		 array(
                        //                        'header'=>'Aktif',
                        //                        'class'=>'CCheckBoxColumn',     
                        //                        'selectableRows'=>0,
                        //                        'id'=>'rows',
                        //                        'checked'=>'$data->kelompokdiagnosa_aktif',
                        //                ),
                        array(
                            'header' => 'Lihat',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{view}',
                            'buttons' => array(
                                'view' => array(
                                    'options' => array('rel' => 'tooltip', 'title' => 'Lihat Kelompok Diagnosa'),
                                ),
                            ),
                        ),
                        array(
                            'header' => 'Ubah',
                            'class' => 'bootstrap.widgets.BootButtonColumn',
                            'htmlOptions' => array('style' => 'text-align: center; width: 60px;'),
                            'template' => '{update}',
                            'buttons' => array(
                                'update' => array(
                                    'visible' => 'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                    'options' => array('rel' => 'tooltip', 'title' => 'Ubah Kelompok Diagnosa'),
                                ),
                            ),
                        ),
                        //		array(
                        //				'header'=>Yii::t('zii','Delete'),
                        //			'class'=>'bootstrap.widgets.BootButtonColumn',
                        //                        'template'=>'{remove} {delete}',
                        //                        'buttons'=>array(
                        //                                        'remove' => array (
                        //                                                'label'=>"<i class='icon-form-sampah'></i>",
                        //                                                'options'=>array('rel' => 'tooltip' , 'title'=> 'Menonaktifkan Kelompok Diagnosa' ),
                        //                                                'url'=>'Yii::app()->createUrl("'.Yii::app()->controller->module->id.'/'.Yii::app()->controller->id.'/removeTemporary",array("id"=>"$data->kelompokdiagnosa_id"))',
                        ////                                                'visible'=>'($data->kelompokdiagnosa_aktif && Yii::app()->user->checkAccess(Params::DEFAULT_UPDATE)) ? TRUE : FALSE',
                        ////                                                'click'=>'function(){return confirm("'.Yii::t("mds","Do You want to remove this item temporary?").'");}',
                        //                                                'click'=>'function(){ removeTemporary(this); return false;}',
                        //                                        ),
                        //                                        'delete'=> array(
                        ////                                                'visible'=>'true',
                        //                                                'options'=>array('rel' => 'tooltip' , 'title'=> 'Hapus Kelompok Diagnosa' ),
                        //                                        ),
                        //                        )
                        //		),
                        /*array(
    'header'=>'Hapus',
    'type'=>'raw',
    'value'=>'($data->kelompokdiagnosa_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->kelompokdiagnosa_id)",array("id"=>"$data->kelompokdiagnosa_id","rel"=>"tooltip","title"=>"Menonaktifkan Kelompok Diagnosa"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->kelompokdiagnosa_id)",array("id"=>"$data->kelompokdiagnosa_id","rel"=>"tooltip","title"=>"Hapus Kelompok Diagnosa")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->kelompokdiagnosa_id)",array("id"=>"$data->kelompokdiagnosa_id","rel"=>"tooltip","title"=>"Hapus Kelompok Diagnosa"));',
    'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
),*/
                        array(
                            'header' => 'Hapus',
                            'type' => 'raw',
                            'value' => '($data->kelompokdiagnosa_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->kelompokdiagnosa_id)",array("id"=>"$data->kelompokdiagnosa_id","rel"=>"tooltip","title"=>"Menonaktifkan Tabular List"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->kelompokdiagnosa_id)",array("id"=>"$data->kelompokdiagnosa_id","rel"=>"tooltip","title"=>"Hapus Tabular List")):CHtml::link("<i class=\'icon-form-check\'></i> ","javascript:addTemporary($data->kelompokdiagnosa_id, 1)",array("id"=>"$data->kelompokdiagnosa_id","rel"=>"tooltip","title"=>"Aktifkan Tabular List"))." ".CHtml::link("<i class=\'entpypo-trash\'></i> ", "javascript:deleteRecord($data->kelompokdiagnosa_id)",array("id"=>"$data->kelompokdiagnosa_id","rel"=>"tooltip","title"=>"Hapus Tabular List"));',
                            'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                        ),
                    ),
                    'afterAjaxUpdate' => 'function(id, data){
jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
$("table").find("input[type=text]").each(function(){
    cekForm(this);
})
}',
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Kelompok Diagnosa', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                $this->createUrl('create', array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Tambah kelompok diagnosa', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial($this->path_view . 'tips/tipsAdmin', array(), true);
            $this->widget('UserTips', array('content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');

            $js = <<< JSCRIPT
function cekForm(obj){
$("#sakelompok-diagnosa-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint){
window.open("${urlPrint}/"+$('#sakelompok-diagnosa-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);

            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
            ?>
            <script type="text/javascript">
                //    function removeTemporary(obj){
                //        var url = $(obj).attr('href');
                //        myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
                //            if (r){
                //                 $.ajax({
                //                    type:'GET',
                //                    url:url,
                //                    data: {},
                //                    dataType: "json",
                //                    success:function(data){
                //                        if(data.status == 'proses_form'){
                //                            $.fn.yiiGridView.update('sakelompok-diagnosa-m-grid');
                //                        }else{
                //                            myAlert('Data gagal dinonaktifkan!.')
                //                        }
                //                    },
                //                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
                //                });
                //           }
                //       });
                //    }
                function removeTemporary(id) {
                    var url = '<?php echo $url . "/removeTemporary"; ?>';
                    myConfirm("Anda yakin akan menonaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('sakelompok-diagnosa-m-grid');
                                    } else {
                                        myAlert('Data gagal dinonaktifkan!.')
                                    }
                                }, "json");
                        }
                    });
                }

                function addTemporary(id, add) {
                    var url = '<?php echo $url . "/removeTemporary"; ?>';
                    myConfirm("Anda yakin akan mengaktifkan data ini untuk sementara?", "Perhatian!", function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id,
                                    add: add
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('sakelompok-diagnosa-m-grid');
                                    } else {
                                        myAlert('Data Gagal di Aktifkan.')
                                    }
                                }, "json");
                        }
                    });
                }

                function deleteRecord(id) {
                    var id = id;
                    var url = '<?php echo $url . "/delete"; ?>';
                    myConfirm("Anda yakin akan menghapus data ini?", "Perhatian!", function(r) {
                        if (r) {
                            $.post(url, {
                                    id: id
                                },
                                function(data) {
                                    if (data.status == 'proses_form') {
                                        $.fn.yiiGridView.update('sakelompok-diagnosa-m-grid');
                                    } else {
                                        myAlert('Data gagal dihapus!.')
                                    }
                                }, "json");
                        }
                    });
                }
                $(document).ready(function() {
                    $('input[name="SAKelompokDiagnosaM[kelompokdiagnosa_nama]"]').focus();
                });
            </script>
        </div>
    </div>
</div>