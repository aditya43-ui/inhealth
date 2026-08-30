<div class="white-container">
    <legend class="rim2">Laporan Rekapitulasi Penerimaan <b>Kas Harian IGD</b></legend>
    <?php
        $url = Yii::app()->createUrl(Yii::app()->controller->module->id.'/laporan/frameGrafikKasHarian&id=1');
        Yii::app()->clientScript->registerScript('search', "
        $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
        });
        $('#searchLaporan').submit(function(){
            $('#Grafik').attr('src','').css('height','0px');
            $.fn.yiiGridView.update('laporanrekapkasharianigd-grid', {
                    data: $(this).serialize()
            });
            return false;
        });
        ");
    ?>
    <fieldset class="box search-form">
        <?php 
            $this->renderPartial('rekapRD/_search',array(
                 'model'=>$model,'format'=>$format
            )); 
       ?>
    </fieldset>
    <div>
        <?php
        $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
        $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
        ?>
    </div>
    <div class="block-tabel"> 
        <?php $this->renderPartial('rekapRD/_table', array('model'=>$model)); ?>
        <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);"></iframe>      
    </div>
    <?php
    //    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKasHarian');
        //$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
         echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
                        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
    //                    echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'GRAFIK\')')); 

        $content = $this->renderPartial('billingKasir.views.laporanRekapPenerimaanKasHarianIGD.tips.tips2',array(),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>
<?php
$js= <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        
    });
   function onReset()
   {
        setTimeout(
            function(){
                $.fn.yiiGridView.update('laporanrekapkasharianigd-grid', {
                    data: $(this).serialize()
                });                   
            }, 2000
        );
        return false;
   }   
JS;
Yii::app()->clientScript->registerScript('laporankasharian',$js,CClientScript::POS_HEAD);
?>