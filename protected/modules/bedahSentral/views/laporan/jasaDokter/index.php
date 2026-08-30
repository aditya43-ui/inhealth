<legend class="rim2">Laporan Rekap Jasa Dokter</legend>
<?php

$url = Yii::app()->createUrl(Yii::app()->controller->module->id.'/laporan/frameGrafikLaporanRekapJasaDokter&id=1');
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('#searchLaporan').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('laporanrekapjasadokter-grid', {
            data: $(this).serialize()
    });
    $.fn.yiiGridView.update('laporandetailjasadokter-grid', {
            data: $(this).serialize()
    });
    return false;
});
");
?>
<div id="jasaDokter">
    <div class="search-form">
        <?php 
            $this->renderPartial('jasaDokter/_search',array(
                 'model'=>$model, 'filter'=>$filter
            )); 
       ?>
    </div><!--search-form-->
</div>
<div id="detailJasaDokter">
    <div class="search-form">
        <?php 
            $this->renderPartial('jasaDokter/_searchDetail',array(
                 'model'=>$model, 'filter'=>$filter
            )); 
       ?>
    </div><!--search-form-->
</div>

<div>
    <?php
        $this->widget('bootstrap.widgets.BootMenu',array(
            'type'=>'tabs',
            'stacked'=>false,
            'htmlOptions'=>array('id'=>'tabmenu'),
            'items'=>array(
                array('label'=>'Rekap Jasa Dokter','url'=>'javascript:tab(0);','active'=>true),
                array('label'=>'Detail Rekap Jasa Dokter','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
            ),
        ))
    ?>
</div>

<fieldset> 
    <?php $this->renderPartial('jasaDokter/_table', array('model'=>$model)); ?>
    <?php //$this->renderPartial('_tab'); ?>
    <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
    </iframe>        
</fieldset>

<?php
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanRekapJasaDokter');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
?>

<?php
$js= <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        
        $("#div_rekap").show();
        $("#div_detail").hide();
        $("#jasaDokter").show();
        $("#detailJasaDokter").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('rekap');
            $("#div_rekap").show();
            $("#div_detail").hide();       
            $("#jasaDokter").show();       
            $("#detailJasaDokter").hide();
        } else if (index==1){
            $("#filter_tab").val('detail');
            $("#div_rekap").hide();
            $("#div_detail").show();
            $("#jasaDokter").hide();
            $("#detailJasaDokter").show();
        } 
   }
function onReset()
{
    setTimeout(
        function(){
            $.fn.yiiGridView.update('laporanrekapjasadokter-grid', {
                data: $("#caripasien-form").serialize()
            });
            $.fn.yiiGridView.update('laporandetailjasadokter-grid', {
                data: $("#caripasien-form").serialize()
            });      
        }, 2000
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat',$js,CClientScript::POS_HEAD);
?>