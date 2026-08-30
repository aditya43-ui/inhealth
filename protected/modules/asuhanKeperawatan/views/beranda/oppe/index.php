<?php

/**
 * digunakan untuk pembuatan interface beranda penelitian kesehatan
 * RSST-2633
 * @author          Yusuf Putra Anugrah <yusufputra@.com>
 * @version         2.0.0
 * @link            http://172.9.1.15/simpp/docs/
 *
 */

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/datalabels/chartjs-plugin-datalabels.js', CClientScript::POS_END);
?>
<style>
    .persen {
        position: absolute;
        right: 0;
        margin-right: 60px;
        color: #333;
        font-weight: bold;
    }

    .legend-ul-span {
        width: 25px;
        height: 12px;
        margin: 0 5px 0px 0;
        padding-top: 10px;
    }

    .legend-hide {
        text-decoration: line-through;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Dashboard OPPE</b>
        </div>
    </div>
    <div class="panel-body">
        <?php echo CHtml::hiddenField("jenisdialog", "", array('readonly' => true)); ?>
        <?php echo CHtml::hiddenField("norow", "", array('readonly' => true)); ?>
        <?php echo $this->renderPartial($this->path_view . 'oppe/_search', array('model' => $model)); ?>
        <div class="clear"></div>
        <div class="panel panel-primary" id="charts_env">
            <div class="panel-body reset-grafik">
                <?php echo $this->renderPartial($this->path_view . 'oppe/_grafikChart', array('list' => $data_grafik['list'])) ?>
            </div>
        </div>
        <div class="clear"></div>

        <?php echo $this->renderPartial($this->path_view . 'oppe/_jsFunctions', array('model' => $model, 'data_grafik' => $data_grafik)) ?>
        <?php echo $this->renderPartial($this->path_view . 'oppe/_dialog', array()) ?>
    </div>
</div>