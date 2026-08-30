<div class="panel panel-gradient">  
    <div class="panel-heading">
	   <div class="panel-title">Informasi <b>Buku Register</b></div>				
    </div>  
     <div class="panel-body">
    <?php
    //$this->breadcrumbs=array(
    //    'Ppinfo Kunjungan Rjvs'=>array('index'),
    //    'Manage',
    //);

    $url = Yii::app()->createUrl('hemodialisa/informasiBukuRegisterHD/frameGrafikBukuRegister&id=1');
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
    <?php 
            $this->renderPartial('hemodialisa.views.informasiBukuRegisterHD._search2',array(
            'model'=>$model, 'modPasien'=>$modPasien
        )); ?>  
    <div class="panel panel-success">
        <div class="panel-heading">  
        <div class="panel-title"><h6>Tabel <b>Buku Register</b></h6></div>
        </div>      
        <div class="panel-body">
        <?php $this->renderPartial('hemodialisa.views.informasiBukuRegisterHD._tableBukuRegister', array('model'=>$model)); ?>
        </div>
    </div> 
    <div class="panel panel-success">
        <?php $this->renderPartial('_tab'); ?>
        <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
        </iframe>        
    </div>
    <?php 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
    //        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'$("#Grafik")[0].contentWindow.test();
    //')); 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanBukuRegister');
    $this->renderPartial('hemodialisa.views.informasiBukuRegisterHD._footer_pisah2', array('urlPrint'=>$urlPrint, 'url'=>$url));
    ?>
</div> 
</div>