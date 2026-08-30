<?php
$this->breadcrumbs = array(
    'Laporan Rekap Jasa & Pajak Dokter',
);

$url = Yii::app()->createUrl(Yii::app()->controller->module->id . '/laporan/frameGrafikLaporanRekapJasaDokter&id=1');
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
        $('.search-form').toggle();
        return false;
    });
    $('#searchLaporan').submit(function(){
        $('#Grafik').attr('src','').css('height','0px');
        $('#laporanrekapjasadokter-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('laporanrekapjasadokter-grid', {
                data: $(this).serialize()
        });
        $('#laporandetailjasadokter-grid').addClass('animation-loading');
        $.fn.yiiGridView.update('laporandetailjasadokter-grid', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Laporan <b>Rekap Jasa & Pajak Dokter</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('bedahSentral.views.laporan.rekapJasaDokter/_tabMenu', array()); ?>
        <?php $this->renderPartial('bedahSentral.views.laporan.rekapJasaDokter/_jsFunctions', array()); ?>

        <iframe id="frame" class="biru" src="" style="width: 100%; overflow-y: scroll; border: none;"></iframe>
    </div>
</div>

<!--<div id="jasaDokter">-->
<!--<div class="search-form">
        //<?php //$format = new MyFormatter();
            //            $this->renderPartial('rekapJasaDokter/_search',array(
            //                 'model'=>$model, 'format'=>$format 
            //            )); 
            //       
            ?>
       
         
</div>-->
<!--<div>
    <?php
    //        $this->widget('bootstrap.widgets.BootMenu',array(
    //            'type'=>'tabs',
    //            'stacked'=>false,
    //            'htmlOptions'=>array('id'=>'tabmenu'),
    //            'items'=>array(
    //                array('label'=>'Rekap Jasa Dokter','url'=>'javascript:tab(0);','active'=>true),
    //                array('label'=>'Detail Rekap Jasa Dokter','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
    //            ),
    //        ))
    ?>
</div>-->

<?php
//    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
//    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
//    $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanRekapJasaDokter');
//    $this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
?>

<?php
$js = <<< JS
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
        } else if (index==1){
            $("#filter_tab").val('detail');
            $("#div_rekap").hide();
            $("#div_detail").show();
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
Yii::app()->clientScript->registerScript('pencatatanriwayat', $js, CClientScript::POS_HEAD);
?>