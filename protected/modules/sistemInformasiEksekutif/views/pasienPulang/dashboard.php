<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jsPDF/jspdf.min.js', CClientScript::POS_END); ?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php $this->renderPartial('_tile', array('model' => $model, 'dataTile' => $dataTile, 'map' => $map)); ?>
<!--?php $this->renderPartial('_bar', array('model' => $model,'graphs'=>$graphs,'dataBarLineChart' => $dataBarLineChart)); ?-->
<?php $this->renderPartial('_lineNew', array('model' => $model, 'dataBar' => $dataBar)); ?>
<!--?php $this->renderPartial('_pie', array('dataPieChart' => $dataPieChart)); ?-->
<?php $this->renderPartial('_pieNew', array('dataPieChart' => $dataPieChart)); ?>
<!--?php $this->renderPartial('_table', array('model' => $model, 'dataTable' => $dataTable)); ?-->
<?php $this->renderPartial('_tableNew', array('model' => $model, 'dataTable' => $dataTable)); ?>
<?php
echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-pdf icon-white"></i> Export Laporan')), array('class' => 'btn btn-red', 'type' => 'button', 'onclick' => 'cetak(\'EXCEL\')')) . "&nbsp&nbsp";
echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-book icon-white"></i> Cetak Grafik')), array('class' => 'btn btn-success', 'type' => 'button', 'onclick' => 'printSemua(\'GRAFIK\')')) . "&nbsp&nbsp";
?>
<?php
$controller = Yii::app()->controller->id;
$module     = Yii::app()->controller->module->id;
$urlPrint   = Yii::app()->createAbsoluteUrl($module . '/' . $controller . '/print');
$js = <<< JSCRIPT
    function cetak(caraPrint){        
        window.open("${urlPrint}/"+$('#search-laporan').serialize()+"&caraPrint="+caraPrint,"",'location=_new, width=900px');
    }
JSCRIPT;
Yii::app()->clientScript->registerScript('cetak', $js, CClientScript::POS_HEAD);
?>
<script>
    function printSemua(caraPrint) {
        var doc = new jsPDF('landscape');
        var canvas1 = document.querySelector('#garis');
        doc.text("Grafik Prosentase Cara Pasien Pulang", 150, 10, {
            align: 'center'
        });
        var canvasImg1 = canvas1.toDataURL("image/png", 1.0);
        doc.setFontSize(20);
        doc.addImage(canvasImg1, 'PNG', 10, 10, 280, 150);
        doc.addPage();
        var canvas2 = document.querySelector('#pie');
        doc.text("Laporan Cara Pasien Pulang", 150, 10, {
            align: 'center'
        });
        var canvasImg2 = canvas2.toDataURL("image/png", 1.0);
        console.log(canvasImg2);
        doc.setFontSize(20);
        doc.addImage(canvasImg2, 'PNG', 10, 10, 280, 150);
        doc.save('GrafikPasienPulang.pdf');
        //var cek = chart_pie;
        //console.log(cek.getImage());
    }
</script>