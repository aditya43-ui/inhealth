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
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/labels/chartjs-plugin-labels.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScript('search', "
    $('.search-button').click(function(){
            $('.search-form').toggle();
            return false;
    });
    $('.search-form form').submit(function(){
            $.fn.yiiGridView.update('penilaian-indikator-m-search', {
                    data: $(this).serialize()
            });
            return false;
    });
    ");
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php $this->renderPartial('_tile', array('tile' => $load['tile'])); ?>
<?php $this->renderPartial('_grafikPersentase'); ?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Tindak Lanjut IGD</b>
        </div>
        <div class="panel-options">
            <a data-rel="collapse" href="#"><i class="entypo-down-open"></i></a>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_table', array('model' => $model)); ?>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-pdf icon-white"></i> Export Laporan')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'EXCEL\')')) . "&nbsp&nbsp";
    echo CHtml::htmlButton(Yii::t('mds', '{icon}', array('{icon}' => '<i class="icon-book icon-white"></i> Cetak Grafik')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'printSemua(\'GRAFIK\')')) . "&nbsp&nbsp";
    ?>
</div>
<?php echo $this->renderPartial('_jsFunction', array('model' => $model)); ?>