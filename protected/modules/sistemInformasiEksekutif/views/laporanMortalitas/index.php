<?php
$this->breadcrumbs = array(
    'Laporan Mortalitas'
);
?>
<?php $this->menu = array(array('label' => 'Laporan Mortalitas', 'header' => true, 'itemOptions' => array('class' => 'heading-master')),); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>Mortalitas</b>
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_search', array('model' => $model)); ?>
        <div class="panel panel-success" style="margin-top: 17px;">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data
                </div>
            </div>
            <div class="panel-body">
                <div class="row">
                    <div class="col-sm-6">
                        <?php $this->renderPartial('sistemInformasiEksekutif.views._grafik', array('data' => $data, 'dataProvider' => $dataProvider, 'id' => 'pie')); ?>
                    </div>
                    <div class="col-sm-6">
                        <?php $this->renderPartial('sistemInformasiEksekutif.views._speedo', array('dataProvider' => $dataProviderSpeedo, 'title' => $data['title'])); ?>
                    </div>
                </div>
                <?php $this->renderPartial('sistemInformasiEksekutif.views._grafik', array('data' => $data, 'dataProvider' => $dataProvider, 'id' => 'batang')); ?>
                <?php $this->renderPartial('sistemInformasiEksekutif.views._grafik', array('data' => $data, 'dataProvider' => $dataProviderGaris, 'id' => 'garis')); ?>
                <?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
            </div>
        </div>
    </div>
</div>