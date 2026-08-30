<?php
$cs = Yii::app()->clientScript;
$path = Yii::app()->baseUrl;
$cs->registerScriptFile($path . '/js/highchart/highcharts.js');
$cs->registerScriptFile($path . '/js/highchart/modules/exporting.js');
$cs->registerScriptFile($path . '/js/highchart/modules/export-data.js');


$this->breadcrumbs = array(
    'Laporan '.$judul_laporan,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b><?php echo $judul_laporan; ?></b>
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
                <?php $this->renderPartial('_search', array('model' => $model, 'tgl_awal' => $tgl_awal, 'tgl_akhir' => $tgl_akhir)); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b><?php echo $judul_laporan; ?></b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php
                $this->renderPartial(
                    '_table',
                    array(
                        'tgl_awal' => $tgl_awal, 'tgl_akhir' => $tgl_akhir,
                        'model' => $model
                    )
                );
                ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="fas fa-chart-bar"></i> Grafik
                </div>
            </div>
            <div class="panel-body table-responsive">
                <div class="panel-body table-responsive">
                    <?php
                    $this->renderPartial('grafik/_grafik_batang', array(
                        'tgl_awal' => $tgl_awal, 'tgl_akhir' => $tgl_akhir,
                        'model' => $model,
                        'judul_laporan' => $judul_laporan, 'tahun' => $tahun
                    ));
                    ?>
                </div>
            </div>
        </div>

        <div class="form-actions">
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/printLaporan');
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="entypo-book"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PDF\')'));
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="entypo-doc-text"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')'));
            // echo CHtml::htmlButton(Yii::t('mds', '{icon} Grafik', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'GRAFIK\')'));
            ?>
            <?php
            $content = $this->renderPartial('../tips/tipsLaporan', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
    </div>
</div>
<?php
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#laporan-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?>