<div class="panel panel-gradient">  
    <div class="panel-heading">
	   <div class="panel-title">Laporan<b> Triase Pasien</b></div>				
    </div>  
    <div class="panel-body">
    <?php
    $url = Yii::app()->createUrl('hemodialisa/laporan/FrameGrafikTriasePasien&id=1');
    Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('.search-form form').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $.fn.yiiGridView.update('tableLaporan', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <div class="panel panel-success"> 
         <div class="panel-heading">  
        <div class="panel-title">Pencarian</div>
        </div> 
        <div class="panel-body"> 
        <?php $this->renderPartial('triase/_search',array(
            'model'=>$model,
        )); ?>
        </div></div><!-- search-form --> 
   <div class="panel panel-success"> 
        <div class="panel-heading">  
        <div class="panel-title"><h6>Tabel <b>Triase Pasien</b></h6></div>
        </div> 
        <div class="panel-body">       
        <?php $this->renderPartial('triase/_table', array('model'=>$model)); ?>
    </div></div>
    <div class="panel panel-success"> 
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanTriasePasien');
        $this->renderPartial('_footer_pisah2', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
    </div></div>