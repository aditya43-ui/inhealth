<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php $this->renderPartial('_line', array('model' => $model,'dataBarLineChart' => $dataBubbleChart)); ?>
<?php $this->renderPartial('_table', array('model' => $model, 'dataTable' => $dataTable)); ?>