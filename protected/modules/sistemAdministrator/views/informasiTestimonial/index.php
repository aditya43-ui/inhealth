<div class="panel panel-primary panel-gradient">
	<div class="panel-heading">
		<div class="panel-title">Informasi Testimonial</div>
	</div>
	<div class="panel-body">
        <?php
        Yii::app()->clientScript->registerScript('search', "
        
        $('#informasipegawailogin-v-search').submit(function(){
                $.fn.yiiGridView.update('informasipegawailogin-v-grid', {
                        data: $(this).serialize()
                });
                return false;
        });
        ");

        $this->widget('bootstrap.widgets.BootAlert'); ?> 
         <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title">Tabel Informasi Testimonial</div>
            </div>
            <div class="panel-body">
                <div class="table-responsive">
                    <?php echo $this->renderPartial($this->path_view.'_table', array('model'=>$model));  ?> 
                </div>
            </div>
         </div>
        <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="fa fa-search"></i>')),'#',array('class'=>'search-button btn')); ?>
        <fieldset class="search-form">
            <?php $this->renderPartial($this->path_view.'_search',array(
                'model'=>$model,'format'=>$format
            )); ?>
        </fieldset><!-- search-form -->

    <?php 

    //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PDF\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="icon-pdf icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'EXCEL\')'))."&nbsp&nbsp"; 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    //        $this->widget('UserTips',array('type'=>'admin'));
//           $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
//           $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//           $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/print');

//$js = <<< JSCRIPT
//function print(caraPrint)
//{
//    window.open("${urlPrint}/"+$('#gumutasibrg-t-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
//}
//JSCRIPT;
//    Yii::app()->clientScript->registerScript('print',$js,CClientScript::POS_HEAD);           
 $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipa
    $url=Yii::app()->createAbsoluteUrl($module.'/'.$controller);             
    ?>
<script type="text/javascript">
    function publish(id){
        console.log(id)
       var url = '<?php echo $url."/publish"; ?>';
        myConfirm("Yakin Akan Publish Data ini ?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){    
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('informasipegawailogin-v-grid');
                            }else{
                                myAlert('Data Gagal di publish')
                            }
                },"json");
           }
       });
    }

    function unpublish(id){
var url = '<?php echo $url."/unpublish"; ?>';
        myConfirm("Yakin Akan Unpublish Data ini ?","Perhatian!",function(r) {
            if (r){
                 $.post(url, {id: id},
                     function(data){    
                        if(data.status == 'proses_form'){
                                $.fn.yiiGridView.update('informasipegawailogin-v-grid');
                            }else{
                                myAlert('Data Gagal di unpublish')
                            }
                },"json");
           }
       });
    }
</script>