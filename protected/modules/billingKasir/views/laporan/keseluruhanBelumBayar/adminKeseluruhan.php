<?php
Yii::app()->clientScript->registerScript('search', "
    $('#searchLaporan').submit(function(){
        $.fn.yiiGridView.update('tableLaporanKeseluruhan', {
                data: $(this).serialize()
        });
        return false;
    });
    ");
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Keseluruhan Pasien Belum Bayar</b>
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
                $this->renderPartial('billingKasir.views.laporan.keseluruhanBelumBayar/_searchKeseluruhan', array('model' => $model,));
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Keseluruhan Pasien Belum Bayar</b>
                </div>
            </div>
            <div class="panel-body table-responsive search-form">
                <?php
                $this->renderPartial(
                    'billingKasir.views.laporan.keseluruhanBelumBayar/_tableKeseluruhan',
                    array(
                        'model' => $model
                    )
                );
                ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanKeseluruhanBelumBayar');

            //                $this->widget('bootstrap.widgets.BootButtonGroup', array(
            //                    'type'=>'info',
            //                    'buttons'=>array(
            //                        array('label'=>'Print', 'icon'=>'entypo-print', 'url'=>$urlPrint, 'htmlOptions'=>array('onclick'=>'print(\'PRINT\');return false;')),
            //                        array('label'=>'',
            //                            'items'=>array(
            //                                array('label'=>'PDF', 'icon'=>'icon-book', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'PDF\');return false;')),
            //                                array('label'=>'Excel','icon'=>'icon-pdf', 'url'=>$urlPrint, 'itemOptions'=>array('onclick'=>'print(\'EXCEL\');return false;')),
            //                            )
            //                        ),
            //                    ),
            //                ));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print Detail', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printDetail(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF Detail', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printDetail(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel Detail', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printDetail(\'EXCEL\')'));
            //                echo CHtml::htmlButton(Yii::t('mds','{icon} Grafik Detail',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printDetail(\'GRAFIK\')'));
            ?>

            <?php
            $content = $this->renderPartial('billingKasir.views.laporan.keseluruhanBelumBayar.tips/tipsLaporanKeseluruhan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>

<script type="text/javascript">
    function checkAll() {
        if ($("#checkAllRuangan").is(':checked')) {
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", "checked");
        } else {
            $("#ruangan").find("input[type=\'checkbox\']").attr("checked", false);
        }

    }
</script>

<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai    
$urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanKeseluruhanBelumBayar');
$urlPrintDetail = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printDetailLaporanKeseluruhanBelumBayar');

$js = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}

function printDetail(caraPrint)
{
    window.open("${urlPrintDetail}/"+$('#searchLaporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $js, CClientScript::POS_HEAD);
?>