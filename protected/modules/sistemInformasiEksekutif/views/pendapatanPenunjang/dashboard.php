<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php $this->renderPartial('_line', array('model' => $model, 'graphs'=>$graphs,'dataBarLineChart' => $dataBarLineChart)); ?>
<?php $this->renderPartial('_table', array('model' => $model, 'dataTable' => $dataTable)); ?>
<?php $this->renderPartial('_stacked', array('model'=>$model,'graphsStack'=>$graphsStack,'dataStackChart' => $dataStackChart)); ?>