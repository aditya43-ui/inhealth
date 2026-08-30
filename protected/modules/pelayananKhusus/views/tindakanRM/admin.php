<div class='panel panel-gradient'>
    <div class="panel-heading">
        <div class="panel-title">Pengaturan <b>Tindakan</b></div>
    </div>
    <div class="panel-body">
    <?php
    $this->breadcrumbs=array(
            'Rmtindakanrm Ms'=>array('index'),
            'Manage',
    );

    $arrMenu = array();
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Tindakan ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Tindakan', 'icon'=>'file', 'url'=>array('create'))) :  '' ;

    $this->menu=$arrMenu;

    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('rmtindakanrm-m-grid', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");

    $this->widget('bootstrap.widgets.BootAlert'); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-white icon-accordion"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="cari-lanjut2 search-form" style="display:none">
        <?php $this->renderPartial('_search',array(
                'model'=>$model,
        )); ?>
    </div><!-- search-form -->
    <hr/>
    <div class='panel panel-success'>
        <div class="panel-heading">
            <div class="panel-title">Tabel Tindakan</div>
        </div>
        <div class="panel-body">
        <!--<h6>Tabel <b>Tindakan</b></h6>-->
        <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
            'id'=>'rmtindakanrm-m-grid',
            'dataProvider'=>$model->search(),
            'filter'=>$model,
            'template'=>"{summary}\n{items}\n{pager}",
            'itemsCssClass'=>'table table-striped table-condensed',
            'columns'=>array(
                    ////'tindakanrm_id',
                    array(
                            'name'=>'jenistindakanrm_id',
                            'value'=>'$data->jenistindakanrm->jenistindakanrm_nama',
                            'filter'=>CHtml::listData($model->getJenisTindakanItems(), 'jenistindakanrm_id', 'jenistindakanrm_nama'),
            ),
            array(
                            'header'=>'Daftar Uraian Tindakan',
                            'name'=>'daftartindakan_nama',
                            'value'=>'$data->daftartindakan->daftartindakan_nama',
            ),
                    'tindakanrm_nama',
                    'tindakanrm_namalainnya',
            array(
                            'header'=>'Status',
                            'value'=>'($data->tindakanrm_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                            'htmlOptions'=>array('style'=>'text-align:left;'),
            ),
                    array(
                            'header'=>Yii::t('zii','View'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{view}',
                            'buttons'=>array(
                                'view' => array(
                                              'options'=>array('rel' => 'tooltip' , 'title'=> 'Lihat tindakan'),
                                            ),
                             ),
                    ),
                    array(
                            'header'=>Yii::t('zii','Update'),
                            'class'=>'bootstrap.widgets.BootButtonColumn',
                            'template'=>'{update}',
                            'buttons'=>array(
                                'update' => array (
//                                              'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
                                              'options'=>array('rel' => 'tooltip' , 'title'=> 'Ubah tindakan'),
                                            ),
                             ),
                    ),
            array(
                'header'=>'Hapus',
                'type'=>'raw',
                'value'=>'($data->tindakanrm_aktif)?CHtml::link("<i class=\'icon-form-silang\'></i> ","javascript:removeTemporary($data->tindakanrm_id)",array("id"=>"$data->tindakanrm_id","rel"=>"tooltip","title"=>"Menonaktifkan tindakan"))." ".CHtml::link("<i class=\'icon-form-sampah\'></i> ", "javascript:deleteRecord($data->tindakanrm_id)",array("id"=>"$data->tindakanrm_id","rel"=>"tooltip","title"=>"Hapus tindakan")):CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->tindakanrm_id)",array("id"=>"$data->tindakanrm_id","rel"=>"tooltip","title"=>"Hapus tindakan"));',
                'htmlOptions'=>array('style'=>'text-align:left; width:80px'),
            ),
            ),
             'afterAjaxUpdate'=>'function(id, data){
                jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});
                $("table").find("input[type=text]").each(function(){
                    cekForm(this);
                })
                 $("table").find("select").each(function(){
                    cekForm(this);
                })
            }',
        )); ?>
    </div>
        </div>
    <?php 
    echo CHtml::link(Yii::t('mds', '{icon} Tambah Tindakan', array('{icon}'=>'<i class="icon-plus icon-white"></i>')), $this->createUrl('tindakanRM/create',array('modul_id'=> Yii::app()->session['modul_id'])), array('class'=>'btn btn-success'))."&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $this->widget('UserTips',array('type'=>'admin'));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);

$js = <<< JSCRIPT
         function cekForm(obj)
{
    $("#rmtindakanrm-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#rmtindakanrm-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
</div>
</div>
<script type="text/javascript">

    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';

        myConfirm('Yakin akan menonaktifkan data ini untuk sementara?','Perhatian!',
        function(r){
            if(r){
               $.post(url, {id: id},
                    function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('rmtindakanrm-m-grid');
                            }else{
                                myAlert('Data Gagal di Nonaktifkan')
                            }
                },"json");
            }
        }); 
    }
    
    function deleteRecord(id){
        var id = id;
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Yakin Akan Menghapus Data ini?','Perhatian!',
        function(r){
            if(r){
               $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('rmtindakanrm-m-grid');
                            }else{
                                myAlert('Data Gagal di Hapus')
                            }
                },"json");
            }
        }); 
    }


$(document).ready(function(){
        $("input[name='RMTindakanrmM[daftartindakan_nama]']").focus();
    });
</script>