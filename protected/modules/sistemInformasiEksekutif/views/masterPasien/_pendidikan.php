<div class="row">
    <div class="col-sm-6">
        <?php $this->renderPartial('_piePdk', array('dataPieChartPdk' => $dataPieChartPdk)); ?>
    </div>
    <div class="col-sm-6" style="width:45%;">
        <?php $this->renderPartial('_tablePdk', array('model' => $model, 'dataTablePdk' => $dataTablePdk)); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php $this->renderPartial('_stackedPdk', array('model' => $model, 'dataStackChartPdk' => $dataStackChartPdk, 'graphsStackPdk' => $graphsStackPdk)); ?>
    </div>
</div>