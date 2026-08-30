<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php
$this->breadcrumbs = array(
    'Laporan Catatan Atas Laporan Keuangan',
);
$url = Yii::app()->createUrl('akuntansi/laporanAkuntansi/frameGrafikLaporanModal&id=1');
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

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Catatan Atas Laporan Keuangan</b>
        </div>
    </div>
    <div class="panel-body " search-form">
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.calk/_search', array('model' => $model));
        ?>
        <?php $this->renderPartial('akuntansi.views.laporanAkuntansi.calk/_table', array('model' => $model, 'format' => $format)); ?>
        <div class="form-actions">
            <?php
            // $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            // $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            // $urlPrint=  Yii::app()->createAbsoluteUrl($module.'/'.$controller.'/printLaporanCALK');
            // $this->renderPartial('akuntansi.views.laporanAkuntansi._footerNoGraph', array('urlPrint'=>$urlPrint, 'url'=>$url)); 
            ?>
            <?php /*
	echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'PDF\')')); 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'print(\'EXCEL\')')); 
	echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')')); 

        $tips = array(
            '0' => 'cari',
            '1' => 'ulang2',
            '2' => 'masterPDF',
            '3' => 'masterEXCEL',
            '4' => 'masterPRINT',
        );
	//$content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
	//$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
	
	 * ?>
	 */ ?>
            <?php
            $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
            $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
            $urlPrint =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporanCALK');
            $urlPrintLap =  Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporan');
            $this->renderPartial('akuntansi.views.laporanAkuntansi._footerNoGraph', array('urlPrint' => $urlPrintLap, 'url' => $url));
            ?>
        </div>
    </div>
</div>
<script type="text/javascript">
    function printCALK(id) {
        window.open("<?php echo $urlPrint; ?>" + "&id=" + id + "&caraPrint=PRINT", "", 'location=_new, width=900px, scrollbars=yes');
    }
</script>