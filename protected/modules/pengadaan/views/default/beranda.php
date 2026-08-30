<?php
/**
 * Halaman Beranda Pengadaan
 * @author Wahyu Wicaksono <wahyuwicaksono.@gmail.com>
 * @category New Feature RSST-8627
 */
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/Chart.js', CClientScript::POS_END);
//Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/labels/chartjs-plugin-labels.js', CClientScript::POS_END);

?>
<?php echo $this->renderPartial('_jsFunction',array('grafik'=>$load['grafik'], 'model'=>$model)) ?>
<style>
    .persen{
        position: absolute;
        right:0;
        margin-right:60px; 
        color:#333;
        font-weight: bold;
    }
    
    .col-md-2{
        width:19.96666667% !important;
    }
    .merah{
        outline: 1px solid red;
    }
</style>
<?php echo $this->renderPartial('_search',array('model'=>$model, 'pejabat' => $pejabat, 'periode'=>$periode)); ?>
<div class="clear"></div>
<?php echo $this->renderPartial('_panelCount',array('model'=>$model, 'count' => $count)); ?>
<div class="clear"></div>
<?php echo $this->renderPartial('_panelGrafikPengadaan',array('model'=>$model, 'count' => $count)); ?>
<div class="clear"></div>
<?php echo $this->renderPartial('_panelTabelPengadaan',array('model'=>$model, 'modDashboard' => $modDashboard)); ?>
<div class="clear"></div>
<?php echo $this->renderPartial('_panelGrafik'); ?>
<div class="clear"></div>
<?php echo $this->renderPartial('_panelPie'); ?>
