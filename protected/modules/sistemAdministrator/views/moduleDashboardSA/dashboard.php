<?php
$modul_nama = ModulK::model()->findByPk(Yii::app()->user->getState('modul_id'));
$nama_peg = (!empty(Yii::app()->user->getState('nama_pegawai')) ? Yii::app()->user->getState('nama_pegawai') : Yii::app()->user->getState('nama_pemakai'))
?>
<div class="well">
    <h1><?php echo date('d') . ' ' . MyFormatter::getMonthId(date('m')) . ' ' . date('Y'); ?></h1>
    <h3>Selamat Datang di Modul <?php echo $this->module->id; ?>, <b><?php echo $nama_peg; ?></b></h3>
</div>
<div class="dashboard" style="overflow: hidden;">
    <div class="row">
        <?php $this->renderPartial('_kolom', array('dataKolom' => $dataKolom)); ?>
    </div>
    <div class="row">
        <div class="col-md-8">
            <?php
            $this->renderPartial('_charts', array(
                'dataKolom' => $dataKolom,
                'dataAreaChart' => $dataAreaChart,
                'dataLineChart' => $dataLineChart,
                'dataDonutChart' => $dataDonutChart,
            ));
            ?>
        </div>
        <div class="col-sm-6">
            <?php $this->renderPartial('_chartPie', array('dataPieChart' => $dataPieChart)); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->renderPartial('_chartBar', array('dataBarChart' => $dataBarChart)); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->renderPartial('_table', array('dataTable' => $dataTable)); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-md-3">
            <?php
            $this->renderPartial($this->path_view . '_todolist', array(
                'modTodolist' => $modTodolist,
                'dataProviderTodolist' => $dataProviderTodolist,
            ));
            ?>
        </div>
        <?php $map = Yii::app()->user->getState('mapdashboard');
        if ($map == true) { ?>
            <div class="col-md-9">
                <?php $this->renderPartial('_mapNew', array('dataMap' => $dataMap)); ?>
            </div>
        <?php } ?>
    </div>
</div>