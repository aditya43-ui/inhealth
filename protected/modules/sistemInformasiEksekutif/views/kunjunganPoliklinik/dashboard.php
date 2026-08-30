<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php $this->renderPartial('_line2', array('model' => $model, 'dataLineChart' => $dataLineChart,)); ?>
<?php $this->renderPartial('_pie2', array('model' => $model, 'dataPieChart' => $dataPieChart)); ?>
<?php $this->renderPartial('_table', array('model' => $model, 'dataTable' => $dataTable)); ?>
<div class="form-actions">
    <?php // echo CHtml::htmlButton(Yii::t('mds','{icon} PRINT',array('{icon}'=>'<i class="icon-book icon-white"></i>')),array('class'=>'btn btn-info', 'type'=>'button','onclick'=>'print(\'PRINT\')'))."&nbsp&nbsp"; 
    ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Export Laporan', array('{icon}' => '<i class="icon-book icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp"; ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak Grafik', array('{icon}' => '<i class="icon-print icon-white"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'downloadPDF();')) . "&nbsp&nbsp"; ?>
</div>
<?php
$controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
$module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
$urlPrint = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/printLaporan');
$jsx = <<< JSCRIPT
function print(caraPrint)
{
    window.open("${urlPrint}/"+$('#search-laporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px, scrollbars=yes');
}
JSCRIPT;
Yii::app()->clientScript->registerScript('print', $jsx, CClientScript::POS_HEAD);
?>
<script>
    function downloadPDF() {
        var canvas_line = document.querySelector('#chart_line');
        var canvasLineImg = canvas_line.toDataURL("image/png", 1.0);
        var canvas_pie = document.querySelector('#chart_pie');
        var canvasPieImg = canvas_pie.toDataURL("image/png", 1.0);
        var doc = new jsPDF('potrait');
        doc.setFontSize(20);
        doc.addImage(canvasLineImg, 'PNG', 10, 10, 180, 100);
        doc.addImage(canvasPieImg, 'PNG', 10, 120, 180, 90);
        doc.save('Grafik Kunjungan Poli Klinik.pdf');
    }
</script>