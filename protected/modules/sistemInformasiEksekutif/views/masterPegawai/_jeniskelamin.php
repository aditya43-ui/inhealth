<div class="row">
    <div class="col-sm-6">
        <?php $this->renderPartial('_pieJk', array('model' => $model, 'dataPieChartJk' => $dataPieChartJk)); ?>
    </div>
    <div class="col-sm-6">
        <?php $this->renderPartial('_stackedJk', array('model' => $model, 'dataBarLineChartJk' => $dataBarLineChartJk)); ?>
    </div>
</div>
<div class="row">
    <div class="col-sm-6">
        <?php $this->renderPartial('_barJk', array('model' => $model, 'dataBarLineChartJk' => $dataBarLineChartJk)); ?>
    </div>
    <div class="col-sm-6">
        <?php $this->renderPartial('_tableJk', array('model' => $model, 'dataTableJk' => $dataTableJk)); ?>
    </div>
</div>