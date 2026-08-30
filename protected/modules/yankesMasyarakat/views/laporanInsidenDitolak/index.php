<?php
Yii::app()->clientScript->registerScript('search', "
    $('#laporan-insidenditolak-search').submit(function(){
        $.fn.yiiGridView.update('laporan-insidenditolak-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Laporan<strong> Insiden Ditolak </strong></div>
            </div>
            <div class="panel-body">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><i class="entypo-search"></i> <b> Pencarian</b></div>
                    </div>
                    <div class="panel-body search-form">
                        <?php $this->renderPartial('_search', array('model' => $model)); ?>
                    </div>
                </div>								
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Tabel <strong>Insiden Ditolak </strong></div>
                    </div>
                    <div class="panel-body overflow-x" >
                        <?php $this->renderPartial('_table', array('model' => $model)); ?>
                    </div>
                </div>	
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Grafik</div>
                    </div>
                    <div class="panel-body">
                        <div class="block-tabel">
                            <?php $this->renderPartial('_tab'); ?>
                            <iframe class="biru" src="" id="Grafik" width="100%" height='0'></iframe>        
                        </div>
                    </div>
                </div>

                <?php
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
                echo CHtml::htmlButton(Yii::t('mds','{icon} GRAFIK',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button','onclick'=>'print(\'GRAFIK\')'))."&nbsp&nbsp";     

                $content = $this->renderPartial('mcu.views.tips/laporan', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

                $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
                $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
                $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
                $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
                $js = <<< JSCRIPT
                    function cekForm(obj){
                        $("#laporan-tat-search :input[name='"+ obj.name +"']").val(obj.value);
                    }
                    function print(caraPrint){
                        window.open("${urlPrint}/"+$('#laporan-insidenditolak-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
                    }
JSCRIPT;
                Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
                ?>

            </div>
        </div>
    </div>
</div>
<?php 
$urlGrafik = Yii::app()->createUrl('yankesMasyarakat/laporanInsidenDitolak/FrameGrafikLaporanInsidenDitolak&id=1');

Yii::app()->clientScript->registerScript('test','
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj){
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    // $.fn.yiiGridView.update("tableLaporan", {
    //         data: $(this).serialize()
    // });
    $("#Grafik").attr("src","'.$urlGrafik.'"+$(".search-form form").serialize());
    return false;
}
', CClientScript::POS_HEAD);

?>

