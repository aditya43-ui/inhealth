<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php $this->renderPartial('_line1', array('model' => $model, 'dataBarLineChart' => $dataBarLineChart)); ?>
<?php $this->renderPartial('_line2', array('model' => $model, 'dataBarLineChart' => $dataBarLineChart)); ?>
<?php $this->renderPartial('_table', array('model' => $model, 'dataTable' => $dataTable)); ?>