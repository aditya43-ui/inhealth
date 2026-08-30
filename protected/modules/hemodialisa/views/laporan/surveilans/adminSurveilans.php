<div class="white-container">
    <legend class="rim2">Laporan <b>Surveilans Hais</b></legend>
    <?php
    //$this->breadcrumbs=array(
    //    'Ppinfo Kunjungan Rjvs'=>array('index'),
    //    'Manage',
    //);

    $url = Yii::app()->createUrl('rawatInap/laporan/frameGrafikSurveilans&id=1');
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
		 $.fn.yiiGridView.update('tableRekapLaporan', {
            data: $(this).serialize()
        });
        return false;
    });
    ");
    ?>
    <?php //echo CHtml::link(Yii::t('mds','{icon} Advanced Search',array('{icon}'=>'<i class="icon-search"></i>')),'#',array('class'=>'search-button btn')); ?>
    <fieldset class="box search-form">
        <?php $this->renderPartial('surveilans/_search',array(
            'model'=>$model,'format'=>$format
        )); ?>
    </fieldset><!-- search-form -->  
	
	<div class="tab">
        <?php
            $this->widget('bootstrap.widgets.BootMenu',array(
                'type'=>'tabs',
                'stacked'=>false,
                'htmlOptions'=>array('id'=>'tabmenu'),
                'items'=>array(
                    array('label'=>'Laporan Detail','url'=>'javascript:tab(0);', 'itemOptions'=>array("index"=>1),'active'=>true),
                    array('label'=>'Laporan Rekap','url'=>'javascript:tab(1);', 'itemOptions'=>array("index"=>1)),
                ),
            ))
            ?>
            <div id="div_LaporanDetail">
                <div class="block-tabel">
                    <i class="entypo-credit-card"></i> Tabel <b>Surveilans Hais</b>
                    <?php $this->renderPartial('surveilans/_table', array('model' => $model)); ?>
                </div>
            </div>

            <div id="div_LaporanRekap">
                <div class="block-tabel">
                    <i class="entypo-credit-card"></i> Tabel <b>Rekap Surveilans Hais</b>

                    <?php $this->renderPartial('surveilans/_tableRekap', array('model' => $model)); ?>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//        echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 
//        echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik',array('{icon}'=>'<i class="entypo-chart-area"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'$("#Grafik")[0].contentWindow.test();
//')); 

$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanSurveilans');
$this->renderPartial('surveilans/_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
?>
<script type='text/javascript'> 
	
	$(document).ready(function() {
    $("#tabmenu").children("li").children("a").click(function() {
        $("#tabmenu").children("li").attr('class','');
        $(this).parents("li").attr('class','active');
        $(".icon-pencil").remove();
        $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
    });

    $("#div_LaporanDetail").show();
    $("#div_LaporanRekap").hide();
}); 

function tab(index){
    $(this).hide();
    if (index==0){
        $("#HDLaporansurveilansV_pilihan_tab").val("report");
        $("#div_LaporanDetail").show();
        $("#div_LaporanRekap").hide();
    }else if(index==1){
        $("#HDLaporansurveilansV_pilihan_tab").val("rekap");
        $("#div_LaporanDetail").hide();
        $("#div_LaporanRekap").show();
    }
} 
</script>