<?php
$this->breadcrumbs = array(
    'Laporan',
    'Laporan Pemakain Mesin Pencucian',
);


Yii::app()->clientScript->registerScript('search', "

$('.search-form form').submit(function(){
    $.fn.yiiGridView.update('tableLaporan', {
        data: $(this).serialize()
    });
    return false;
});
");

?>


<div class="panel panel-primary panel-gradient">
    <div class="panel-heading">
        <div class="panel-title"><b>Laporan Pemakaian Mesin Pencucian</b></div>
    </div>
    <div class="panel-body">
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
            </div>
            <div class="panel-body search-form">
                <?php
                $this->renderPartial($this->path_view.'_search', array(
                    'model' => $model,
                ));
                ?>
            </div>
        </div>
        <div class="panel panel-primary panel-success">
            <div class="panel-heading">
                <div class="panel-title"><b>Tabel Pemakaian Mesin Pencucian</b></div>
            </div>
            <div class="panel-body  overflow-x">
                <?= $this->renderPartial($this->path_view.'_tabel',['model'=>$model]) ?>

            </div>
        </div>
        <div class="form-actions">
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PRINT', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PRINT\')')) . "&nbsp&nbsp";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Excel', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
            echo CHtml::htmlButton(Yii::t('mds', '{icon} PDF', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
            $content = $this->renderPartial('kepegawaian.views.tips.laporan_presensi', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));

            $jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#laporanlogbookpemasukanlimbahb3-search').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
            Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
            ?> 

        </div>
    </div>



