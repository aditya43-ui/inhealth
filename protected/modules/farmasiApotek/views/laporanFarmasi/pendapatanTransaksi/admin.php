<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Pendapatan Transaksi Farmasi Apotek</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-search"></i> Pencarian
                </div>
            </div>
            <div class="panel-body">
                <?php
                $this->breadcrumbs = array(
                    'Laporan Pendapatan Transaksi Farmasi Apotek',
                );
                $url = Yii::app()->createUrl($this->module->id . '/' . $this->id . '/FrameGrafikLaporanPendapatanTransaksi&id=1');
                Yii::app()->clientScript->registerScript('search', "
                            $('.search-button').click(function(){
                                $('.search-form').toggle();
                                return false;
                            });
                            $('.search-form form').submit(function(){
                                $('#Grafik').attr('src','').css('height','0px');
                                $('#tableLaporan').addClass('animation-loading');
                                $.fn.yiiGridView.update('tableLaporan', {
                                        data: $(this).serialize()
                                });
                                return false;
                            });
                            ");
                ?>
                <div class="box search-form">
                    <?php
                    $this->renderPartial('pendapatanTransaksi/_search', array(
                        'model' => $model,
                    ));
                    ?>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Transaksi Farmasi</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('pendapatanTransaksi/_table', array('model' => $model)); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial('_tab'); ?>
                <iframe class="biru" src="" id="Grafik" width="100%" height='0' onload="javascript:resizeIframe(this);"></iframe>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printLaporanPendapatanTransaksi');
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Grafik', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'GRAFIK\')'));
            //$this->renderPartial('_footer', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
            ?>
            <?php
            $content = $this->renderPartial('../tips/tipsLaporanFarmasi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<!--search-form-->
<!--/div-->
<?php

$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#search-laporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?>
<?php
Yii::app()->clientScript->registerScript('test', '
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj, index){
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    $.fn.yiiGridView.update("laporan-grid", {
            data: $(this).serialize()
    });
    if (index==1) {
        index="batang";
    } else if (index==2) {
        index="pie";
    } else if (index==3) {
        index="garis";
    }
    $("#Grafik").attr("src","' . $url . '"+$("#search-laporan").serialize()+"&type="+index);
    return false;
}
', CClientScript::POS_HEAD);

?>