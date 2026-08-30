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
        <div class="col-sm-12">
            <?php
            $this->renderPartial('_charts', array(
                'dataKolom' => $dataKolom,
                'dataAreaChart' => $dataAreaChart,
                'dataLineChart' => $dataLineChart,
                'dataDonutChart' => $dataDonutChart,
            ));
            ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php $this->renderPartial('_chartPie', array('dataPieChart' => $dataPieChart)); ?>
        </div>
        <div class="col-sm-6">
            <?php $this->renderPartial('_chartBar', array('dataBarChart' => $dataBarChart)); ?>
        </div>
    </div>
    <div class="row">
        <div class="col-sm-6">
            <?php
            $this->renderPartial($this->path_view . '_todolist', array(
                'modTodolist' => $modTodolist,
                'dataProviderTodolist' => $dataProviderTodolist,
            ));
            ?>
        </div>
        <div class="col-sm-6">
            <?php $this->renderPartial('_table', array('dataTable' => $dataTable)); ?>
        </div>
    </div>
    <div class="panel panel-default">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-map"></i> Peta
            </div>
            <div class="panel-options">
                <a data-rel="collapse" href="#">
                    <i class="entypo-down-open"></i>
                </a>
                <a data-rel="reload" href="#">
                    <i class="entypo-arrows-ccw"></i>
                </a>
            </div>
        </div>
        <div class="panel-body fluid">
            <?php $map = Yii::app()->user->getState('mapdashboard');
            if ($map == true) { ?>
                <?php $this->renderPartial('_mapNew', array('dataMap' => $dataMap)); ?>
            <?php } ?>
        </div>
    </div>
</div>