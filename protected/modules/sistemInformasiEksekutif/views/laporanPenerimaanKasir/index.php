<?php
$this->breadcrumbs = array(
    'Laporan Penerimaan Kasir',
); ?>
<?php
$this->menu = array(
    array('label' => 'Laporan Penerimaan Kasir', 'header' => true, 'itemOptions' => array('class' => 'heading-master')),
);
$this->breadcrumbs = array(
    'Laporan Penerimaan Kasir'
);
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan Penerimaan Kasir
        </div>
    </div>
    <div class="panel-body">
        <?php $this->renderPartial('_search', array('model' => $model)); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->renderPartial('sistemInformasiEksekutif.views._grafik', array('data' => $data, 'dataProvider' => $dataProvider, 'id' => 'pie')); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->renderPartial('sistemInformasiEksekutif.views._speedo', array('dataProvider' => $dataProviderSpeedo, 'title' => $data['title'])); ?>
            </div>
        </div>
        <div class="panel panel-success">
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
            </div>
        </div>
        <div class="form-actions">
            <?php
            $tips = array(
                '0' => 'cari',
                '1' => 'ulang',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>
    </div>
</div>