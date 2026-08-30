<?php
Yii::app()->clientScript->registerScript('search', "
    $('#laporan-oppe-search').submit(function(){
        $.fn.yiiGridView.update('laporan-oppe-grid', {
            data: $(this).serialize()
        });
        return false;
    });
");

$this->widget('bootstrap.widgets.BootAlert');
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan<b> OPPE Keperawatan </b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
<i class="entypo-search"></i> <b> Pencarian </b></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('search', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b> OPPE Keperawatan</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_table', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><b>Grafik</b></div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_tab'); ?>
                <iframe style="border: none;" class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);">
                </iframe>
            </div>
        </div>

        <?php
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Grafik', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'GRAFIK\')'));

        $content = $this->renderPartial('mcu.views.tips/laporan', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>

    <?php

    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
    $url = Yii::app()->createAbsoluteUrl($module . '/' . $controller);
    $js = <<< JSCRIPT
                    function cekForm(obj){
                        $("#laporan-tat-search :input[name='"+ obj.name +"']").val(obj.value);
                    }
                    function print(caraPrint)
                    {
                        window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
                    }
JSCRIPT;
    Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
    ?>

</div>

<?php
$urlGrafik = Yii::app()->createUrl('asuhanKeperawatan/laporanOppeKeperawatan/frameGrafikOppe&id=1');

Yii::app()->clientScript->registerScript('test', '
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj){
    console.log($(obj).attr("type"));
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    // $.fn.yiiGridView.update("tableLaporan", {
    //         data: $(this).serialize()
    // });
    $("#Grafik").attr("src","' . $urlGrafik . '"+$(".search-form form").serialize());
    return false;
}
', CClientScript::POS_HEAD);

?>