<div class="row">
    <div class="col-sm-6">
        <?php $this->renderPartial('_pieUmur', array('model' => $model, 'dataPieChartUmur' => $dataPieChartUmur, 'dataPieChartUmurDet' => $dataPieChartUmurDet)); ?>
    </div>
    <div class="col-sm-6">
        <?php $this->renderPartial('_barUmur', array('model' => $model, 'dataBarChartUmur' => $dataBarChartUmur)); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php $this->renderPartial('_tableUmur', array('model' => $model, 'modelUmur' => $modelUmur, 'dataTableUmur' => $dataTableUmur)); ?>
    </div>
</div>