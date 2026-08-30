<legend class="rim2">Laporan Penjamin Pasien</legend>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
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