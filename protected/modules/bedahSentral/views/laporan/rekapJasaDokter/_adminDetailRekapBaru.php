<?php
Yii::app()->clientScript->registerScript('search', "
$('.search-button').click(function(){
    $('.search-form').toggle();
    return false;
});
$('.search-form form').submit(function(){
    $('#Grafik').attr('src','').css('height','0px');
    $.fn.yiiGridView.update('laporandetailjasadokter-grid', {
            data: $(this).serialize()
    });
    return false;
});
");
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-search"></i> Pencarian
        </div>
    </div>
    <div class="panel-body">
        <?php
        //$format = new MyFormatter();
        $this->renderPartial('rekapJasaDokter/_search', array(
            'model' => $model, 'format' => $format
        ));
        ?>
    </div>
</div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Rekap Detail Jasa Dokter</b>
        </div>
    </div>
    <div class="panel-body table-responsive" id="div_detail">
        <?php $this->renderPartial("rekapJasaDokter/_tableDetailRekapBaru", array('model' => $model)) ?>
        <!--<div class="">
            <?php //$this->renderPartial('_tab'); 
            ?>
            <iframe class="biru" src="" id="Grafik" width="100%" height='0'  onload="javascript:resizeIframe(this);">
            </iframe>        
        </div>-->
    </div>
</div>

<div class="form-actions">
    <?php
    $url = Yii::app()->createUrl('bedahSentral/laporan/frameGrafikLaporanPendapatan&id=1');
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanDetailRekapJasaDokter');
    $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url, 'tips' => '10besarpenyakit', 'grafik' => 'none'));
    ?>
</div>

<?php
$filterruangan = in_array(Yii::app()->user->getState('instalasi_id'), array(Params::INSTALASI_ID_IBS)) ? 1 : '';
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint+"&filterruangan=${filterruangan}","",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?>
<?php
Yii::app()->clientScript->registerScript('test', '
function resizeIframe(obj){
       obj.style.height = obj.contentWindow.document.body.scrollHeight + "px";
    }    
function setType(obj){
    $("#type").val($(obj).attr("type"));
    $(obj).parents("ul").find("li").each(function(){
        $(this).removeClass("active");
    });
    $(obj).addClass("active");
    $.fn.yiiGridView.update("tableLaporan", {
            data: $(this).serialize()
    });
    $("#Grafik").attr("src","' . $url . '"+$(".search-form form").serialize());
    return false;
}
', CClientScript::POS_HEAD);
?>