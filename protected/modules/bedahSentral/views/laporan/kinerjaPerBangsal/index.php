<legend class="rim2">Laporan Kinerja per Bangsal</legend>
<?php

$url = Yii::app()->createUrl(Yii::app()->controller->module->id.'/laporan/frameGrafikLaporanKinerjaPerBangsal&id=1');
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

<div class="search-form">
    <?php 
        $this->renderPartial('kinerjaPerBangsal/_search',array(
            'model'=>$model, 'filter'=>$filter
        )); 
    ?>
</div>
<div>
    <?php
//        $this->widget('bootstrap.widgets.BootMenu',array(
//            'type'=>'tabs',
//            'stacked'=>false,
//            'htmlOptions'=>array('id'=>'tabmenu'),
//            'items'=>array(
//                array('label'=>'Ruangan','url'=>'javascript:tab(0);','active'=>true),
//                array('label'=>'Tindakan','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
//                array('label'=>'Administrasi / Biaya Umum','url'=>'javascript:tab2);', 'itemOptions'=>array("index"=>2)),
//                array('label'=>'Tambahan','url'=>'javascript:tab(3);', 'itemOptions'=>array("index"=>3)),
//            ),
//        ))
    ?>
</div>

<fieldset> 
    <?php $this->renderPartial('kinerjaPerBangsal/_table', array('model'=>$model,'tgl_awal'=>$tgl_awal,'tgl_akhir'=>$tgl_akhir)); ?>
    <?php $this->renderPartial('_tab'); ?>
    <iframe src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
    </iframe>        
</fieldset>
<?php 
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanKinerjaPerBangsal');
    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); ?>
<?php
$js= <<< JS
    $(document).ready(function() {
        $("#tabmenu").children("li").children("a").click(function() {
            $("#tabmenu").children("li").attr('class','');
            $(this).parents("li").attr('class','active');
            $(".icon-pencil").remove();
            // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
        });
        
        $("#div_ruangan").show();
        $("#div_tindakan").hide();
        $("#div_administrasi").hide();
        $("#div_tambahan").hide();
    });

    function tab(index){
        $(this).hide();
        if (index==0){
            $("#filter_tab").val('ruangan');
            $("#div_ruangan").show();
            $("#div_tindakan").hide();       
            $("#div_administrasi").hide();       
            $("#div_tambahan").hide();       
        } else if (index==1){
            $("#filter_tab").val('tindakan');
            $("#div_ruangan").hide();
            $("#div_tindakan").show();
            $("#div_administrasi").hide();
            $("#div_tambahan").hide();
        } else if (index==2){
            $("#filter_tab").val('administrasi');
            $("#div_ruangan").hide();
            $("#div_tindakan").hide();
            $("#div_administrasi").show();
            $("#div_tambahan").hide();
        } else if(index==3){
            $("#filter_tab").val('tambahan');
            $("#div_ruangan").hide();
            $("#div_tindakan").hide();
            $("#div_administrasi").hide();
            $("#div_tambahan").show();
        }
   }
function onReset()
{
    setTimeout(
        function(){
            $.fn.yiiGridView.update('kinerjabangsalruangan-grid', {
                data: $("#searchLaporan").serialize()
            });
            $.fn.yiiGridView.update('kinerjabangsaltindakan-grid', {
                data: $("#searchLaporan").serialize()
            });      
            $.fn.yiiGridView.update('kinerjabangsaladministrasi-grid', {
                data: $("#searchLaporan").serialize()
            });      
            $.fn.yiiGridView.update('kinerjabangsaltambahan-grid', {
                data: $("#searchLaporan").serialize()
            });      
        }, 2000
    );
    return false;
}   
JS;
Yii::app()->clientScript->registerScript('pencatatanriwayat',$js,CClientScript::POS_HEAD);
?>