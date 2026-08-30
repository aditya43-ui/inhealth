<div class='white-container'>
    <legend class='rim2'>Pengaturan <b>Golongan</b></legend>
    <?php $this->renderPartial('_tabMenu',array()); ?>
    <div class="biru">
        <div class="white">
            <?php
            $this->breadcrumbs=array(
                    'Sagolongan Ms'=>array('index'),
                    'Manage',
            );

            $arrMenu = array();
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Golongan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
                            //array_push($arrMenu,array('label'=>Yii::t('mds','List').' GUGolonganM', 'icon'=>'list', 'url'=>array('index'))) ;
            //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Golongan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

            $this->menu=$arrMenu;

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#SAGolonganM_golongan_kode').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('sagolongan-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");

            $this->widget('bootstrap.widgets.BootAlert'); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut search-form">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!--search-form-->
            
                <!--<h6>Tabel <b>Golongan</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'sagolongan-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
                    'columns'=>array(
                            ////'golongan_id',
                            array(
                                    'name'=>'golongan_id',
                                    'value'=>'$data->golongan_id',
                                    'filter'=>false,
                            ),
                            array(
                                    'name'=>'golongan_kode',
                                    'value'=>'$data->golongan_kode',
                                    'filter'=>CHtml::activeTextField($model, 'golongan_kode'),
                            ),
                            'golongan_nama',
                            'golongan_namalainnya',
                             array(
                                'header' => 'Status',
                                'value'=>'($data->golongan_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions'=>array('style'=>'text-align:center;'),
                            ),
            //		array(
            //                        'header'=>'Aktif',
            //                        'class'=>'CCheckBoxColumn',     
            //                        'selectableRows'=>0,
            //                        'id'=>'rows',
            //                        'checked'=>'$data->golongan_aktif',
            //                ),
                            array(
                                'header'=>Yii::t('zii','View'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{view}',
                                'buttons'=>array(
                                    'view'=>array(
                                        'options'=>array('rel'=>'tooltip','title'=>'Lihat Golongan'),
                                    ),
                                ),
                            ),
                            array(
                                    'header'=>Yii::t('zii','Update'),
                                    'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{update}',
                                    'buttons'=>array(
                                        'update' => array (
                                            'options'=>array('rel'=>'tooltip','title'=>'Ubah Golongan'),
                                            'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                            ),
                                     ),
                            ),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>'($data->golongan_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->golongan_id)",array("id"=>"$data->golongan_id","rel"=>"tooltip","title"=>"Menonaktifkan Golongan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->golongan_id)",array("id"=>"$data->golongan_id","rel"=>"tooltip","title"=>"Hapus Golongan")):CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->golongan_id)",array("id"=>"$data->golongan_id","rel"=>"tooltip","title"=>"Hapus Golongan"));',
                        'htmlOptions' => array('style' => 'text-align: center; width: 100px;'),
                    ),
                    ),
                    'afterAjaxUpdate'=>'function(id, data){
                        jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                        $("table").find("input[type=text]").each(function(){
                            cekForm(this);
                        })
                    }',
                )); ?>
            <!--</div>-->
        </div>
    </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Golongan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('/gudangUmum/golonganM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
        function cekForm(obj)
{
    $("#sagolongan-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#sagolongan-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sagolongan-m-grid');
                            }else{
                                myAlert('Data gagal dinonaktifkan!')
                            }
                },"json");
           }
        });
    }
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?','Perhatian!',function(r){
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sagolongan-m-grid');
                            }else{
                                myAlert('Data gagal dihapus!')
                            }
                },"json");
           }
        });
    }
    $('.filters #SAGolonganM_golongan_kode').focus();
</script>