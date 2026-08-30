<div class="row">
    <div class="col-sm-6">
        <?php $this->renderPartial('_pieKerja', array('dataPieChartKerja' => $dataPieChartKerja)); ?>
    </div>
    <div class="col-sm-6" style="width:45%">
        <?php $this->renderPartial('_tableKerja', array('model' => $model, 'dataTableKerja' => $dataTableKerja)); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php $this->renderPartial('_stackedKerja', array('model' => $model, 'dataStackChartKerja' => $dataStackChartKerja, 'graphsStackKerja' => $graphsStackKerja)); ?>
    </div>
</div>