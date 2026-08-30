<!--<div class="white-container">-->
    <!--<legend class="rim2">Master <b>Wilayah - Propinsi</b></legend>-->
    <?php 
//    $this->widget('bootstrap.widgets.BootMenu', array(
//        'type'=>'tabs', // '', 'tabs', 'pills' (or 'list')
//        'stacked'=>false, // whether this is a stacked menu
//        'items'=>array(
//            array('label'=>'Propinsi', 'url'=>$this->createUrl('/hemodialisa/propinsiM'), 'active'=>true),
//            array('label'=>'Kabupaten', 'url'=>$this->createUrl('/hemodialisa/kabupatenM')),
//            array('label'=>'Kecamatan', 'url'=>$this->createUrl('/hemodialisa/kecamatanM')),
//            array('label'=>'Kelurahan', 'url'=>$this->createUrl('/hemodialisa/kelurahanM')),
//        ),
//    )); 
//    ?>
<!--    <div class="biru">
        <div class="white">-->
            <?php
            $this->breadcrumbs=array(
                    'Sapropinsi Ms'=>array('index'),
                    'Manage',
            );
//            $arrMenu = array();
//                            (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Propinsi ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
//
//                            // (Yii::app()->user->checkAccess(Params::DEFAULT_CREATE))?array_push($arrMenu,array('label'=>Yii::t('mds','Create').' Propinsi', 'icon'=>'file', 'url'=>array('create'))) :  '' ;
//
//            $this->menu=$arrMenu;

            Yii::app()->clientScript->registerScript('search', "
            $('.search-button').click(function(){
                    $('.search-form').toggle();
                $('#SAPropinsiM_propinsi_nama').focus();
                    return false;
            });
            $('.search-form form').submit(function(){
                    $.fn.yiiGridView.update('sapropinsi-m-grid', {
                            data: $(this).serialize()
                    });
                    return false;
            });
            ");
            ?>
<div class="panel panel-gradient">  
     <div class="panel-heading">
	   <div class="panel-title">Pengaturan <b>Propinsi</b></div>				
    </div> 
    <div class="panel-body">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            <?php echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-accordion icon-white"></i>')),'#',array('class'=>'search-button btn')); ?>
            <div class="cari-lanjut search-form" style="display:none">
                <?php $this->renderPartial('_search',array(
                        'model'=>$model,
                )); ?>
            </div><!-- search-form -->
            <hr>
	<div class="panel panel-success"> 
            <div class="panel-heading">  
                <div class="panel-title">Tabel <b>Propinsi</b></div>
            </div>      
          <div class="panel-body">
            <!--<div class="block-tabel">-->
                <!--<h6>Tabel <b>Propinsi</b></h6>-->
                <?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
                    'id'=>'sapropinsi-m-grid',
                    'dataProvider'=>$model->search(),
                    'filter'=>$model,
//                    'enableSort'=>true,
                    'template'=>"{summary}\n{items}\n{pager}",
                    'itemsCssClass'=>'table table-striped table-condensed',
                    'columns'=>array(
                            ////'propinsi_id',
                            array(
				'header'=>'No.',
				'value' => '($this->grid->dataProvider->pagination) ? 
						($this->grid->dataProvider->pagination->currentPage*$this->grid->dataProvider->pagination->pageSize + $row+1)
						: ($row+1)',
				'type'=>'raw',
				'htmlOptions'=>array('style'=>'text-align:right;'),
                            ),		
                            'propinsi_nama',
                            'propinsi_namalainnya',
                            //'propinsi_aktif',
                            array(
                                'header'=>'<center>Status</center>',
                                'value'=>'($data->propinsi_aktif == 1 ) ? "Aktif" : "Tidak Aktif"',
                                'htmlOptions'=>array('style'=>'text-align:center;'),
                            ),
                            array(
                                    'header'=>Yii::t('zii','View'),
                                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                    'template'=>'{view}',
                                    'buttons'=>array(
                                        'view' => array (
                                                      'options'=>array('title'=>'Lihat Propinsi'),
                                                    ),
                                     ),
                            ),
                            array(
                                'header'=>Yii::t('zii','Update'),
                                'class'=>'bootstrap.widgets.BootButtonColumn',
                                'template'=>'{update}',
                                'buttons'=>array(
                                'update' => array
                                            (
                                              'visible'=>'Yii::app()->controller->checkAccess(array("action"=>Params::DEFAULT_UPDATE))',
//                                                                                      'options'=>array('title'=>'Ubah Propinsi'),
                                            ),
                                        ),
                            ),
                            array(
                                'header'=>'Hapus',
                                'type'=>'raw',
                                'value'=>'($data->propinsi_aktif)?CHtml::link("<i class=\'icon-remove\'></i> ","javascript:removeTemporary($data->propinsi_id)",array("id"=>"$data->propinsi_id","rel"=>"tooltip","title"=>"Menonaktifkan Propinsi"))." ".CHtml::link("<i class=\'icon-trash\'></i> ", "javascript:deleteRecord($data->propinsi_id)",array("id"=>"$data->propinsi_id","rel"=>"tooltip","title"=>"Hapus  Propinsi")):CHtml::link("<i class=\'entypo-trash\'></i> ", "javascript:deleteRecord($data->propinsi_id)",array("id"=>"$data->propinsi_id","rel"=>"tooltip","title"=>"Hapus Propinsi"));',
                                'htmlOptions'=>array('style'=>'text-align: center; width:80px'),
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
    echo CHtml::link(Yii::t('mds','{icon} Tambah Propinsi',array('{icon}'=>'<i class="icon-plus icon-white"></i>')), 
                                Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/create'), 
                                array('class'=>'btn btn-success'));
    echo "&nbsp;";
    echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    $content = $this->renderPartial('../tips/master',array(),true);
    $this->widget('UserTips',array('type'=>'create','content'=>$content));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');
    $url=  Yii::app()->createAbsoluteUrl($module.'/'.$controller);

?>
        <div class="form-actions">
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Tambah Provinsi', array('{icon}' => '<i class="icon-plus icon-white"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . Yii::app()->controller->id . '/create'),
                array('title' => 'Tambah propinsi', 'class' => 'btn btn-danger',)
            );
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            $content = $this->renderPartial('../tips/master', array(), true);
            $this->widget('UserTips', array('type' => 'create', 'content' => $content));
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);

            $js = <<< JSCRIPT
          function cekForm(obj)
{
    $("#sapropinsi-m-search :input[name='"+ obj.name +"']").val(obj.value);
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('sapropinsi-m-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);                        
    ?>
    </div>
</div>
<script type="text/javascript">
    function removeTemporary(id){
        var url = '<?php echo $url."/removeTemporary"; ?>';
        myConfirm("Yakin akan menonaktifkan data ini untuk sementara?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sapropinsi-m-grid');
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
        myConfirm("Yakin Akan Menghapus Data ini ?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('sapropinsi-m-grid');
                            }else{
                                myAlert('Data gagal dihapus karena data digunakan oleh Master Kabupaten.');
                            }
                },"json");
           }
       });
    }

    $(document).ready(function(){
        $('input[name="SAPropinsiM[propinsi_nama]"]').focus();
    })
</script>