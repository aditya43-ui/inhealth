<?php
//Yii::app()->clientScript->registerScript('search', "
//$('.search-form form').submit(function(){
//    $.fn.yiiGridView.update('tableLaporanJmlPasienHarian', {
//        data: $(this).serialize()
//    });
//    $.fn.yiiGridView.update('tableRekapJmlPasienHarian', {
//        data: $(this).serialize()
//    });
//    return false;
//});
//");
?>

<?php
$this->breadcrumbs = array(
    'Laporan Jumlah Pasien Harian',
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Jumlah Pasien Harian</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->renderPartial('gizi.views.laporan.jumlahPasienHarian/_searchJmlPasienHarian', array(
            'model' => $model,
        ));
        ?>

        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Jumlah Pasien Harian</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->widget('bootstrap.widgets.BootMenu', array(
                    'type' => 'tabs',
                    'stacked' => false,
                    'htmlOptions' => array('id' => 'tabmenu'),
                    'items' => array(
                        array('label' => 'Laporan Jumlah Harian', 'url' => 'javascript:tab(0);', 'itemOptions' => array("index" => 1), 'active' => true),
                        array('label' => 'Rekap Jumlah', 'url' => 'javascript:tab(1);', 'itemOptions' => array("index" => 1)),
                    ),
                ));
                ?>

                <div class="table-responsive" id="tables">
                    <?php
                    $this->renderPartial(
                        'gizi.views.laporan.jumlahPasienHarian/_tables',
                        array(
                            'model' => $model,
                            'models' => $models,
                            'modRekaps' => $modRekaps,
                        )
                    );
                    ?>
                </div>
            </div>
        </div>

        <div class="form-actions" style="margin-top:10px;">
            <?php
            $url = Yii::app()->createUrl('rawatJalan/laporan/frameGrafikLaporanJumlahPorsiKelas&id=1');
            //mengambil Controller yang sedang dipakai
            $controller = Yii::app()->controller->id;
            //mengambil Module yang sedang dipakai
            $module = Yii::app()->controller->module->id;
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanJumlahPorsiKelas');
            $this->renderPartial('_footer', array('urlPrint' => $urlPrint, 'url' => $url, 'grafik' => 'none'));
            ?>
        </div>

    </div>
</div>

<?php
//mengambil Controller yang sedang dipakai
$controller = Yii::app()->controller->id;
//mengambil Module yang sedang dipakai    
$module = Yii::app()->controller->module->id;
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/PrintLaporanJumlahPasienHarian');

$js = <<< JSCRIPT
$(document).ready(function() {
    $("#tabmenu").children("li").children("a").click(function() {
        $("#tabmenu").children("li").attr('class','');
        $(this).parents("li").attr('class','active');
        $(".icon-pencil").remove();
        // $(this).append("<li class='icon-pencil icon-white' style='float:left'></li>");
    });

    $("#div_reportJmlPasienHarian").show();
    $("#div_rekapJmlPasienHarian").hide();
});

function tab(index){
    $(this).hide();
    if (index==0){
        $("#GZLaporanjmlpasienhariangiziV_pilihan_tab").val("report");
        $("#div_reportJmlPasienHarian").show();
        $("#div_rekapJmlPasienHarian").hide();
    }else if(index==1){
        $("#GZLaporanjmlpasienhariangiziV_pilihan_tab").val("rekap");
        $("#div_reportJmlPasienHarian").hide();
        $("#div_rekapJmlPasienHarian").show();
    }
}
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>

<?php $this->renderPartial('gizi.views.laporan/_jsFunctions', array('model' => $model)); ?>
<script type="text/javascript">
    function checkAll() {
        if ($("#checkAllRuangan").is(':checked')) {
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", false);
        }

    }
</script>