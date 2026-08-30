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

    .col-md-2 {
        width: 19.96666667% !important;
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

    table {
        border-collapse: separate;
        border-spacing: 0;
    }
</style>
<?php
$modul_nama = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'));
$nama_peg = (!empty(Yii::app()->user->getState('nama_pegawai')) ? Yii::app()->user->getState('nama_pegawai') : Yii::app()->user->getState('nama_pemakai'))
?>
<div class="well">
    <h1><?php echo date('d') . ' ' . MyFormatter::getMonthId(date('m')) . ' ' . date('Y'); ?></h1>
    <h3>Selamat Datang di Modul <?php echo $this->module->id; ?>, <b><?php echo $nama_peg; ?></b></h3>
</div>
<div class="dashboard" style="overflow: hidden;">
    <?php echo $this->renderPartial($this->path_view . 'default/_tile', array('tile' => $load['tile'])); ?>
    <?php echo $this->renderPartial($this->path_view . 'default/_tigaGrafik') ?>
    <?php echo $this->renderPartial($this->path_view . 'default/_1_duaGrafik') ?>
    <?php echo $this->renderPartial($this->path_view . 'default/_2_duaGrafik') ?>
    <?php echo $this->renderPartial($this->path_view . 'default/_jsFunctions', array('grafik' => $load['grafik'], 'model' => $model)) ?>
</div>