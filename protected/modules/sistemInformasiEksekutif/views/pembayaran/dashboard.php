<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php $this->renderPartial('_stacked', array('model' => $model,'dataBarLineChart' => $dataBarLineChart)); ?>
<?php $this->renderPartial('_cylinder', array('dataCylChart' => $dataCylChart)); ?>
<?php $this->renderPartial('_table', array('model' => $model, 'dataTable' => $dataTable)); ?>