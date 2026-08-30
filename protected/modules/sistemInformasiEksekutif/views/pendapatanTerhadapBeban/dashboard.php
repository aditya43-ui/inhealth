<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php $this->renderPartial('_pie', array('dataPieChart' => $dataPieChart)); ?>
<?php $this->renderPartial('_line', array('model' => $model,'dataBarLineChart' => $dataBarLineChart)); ?>
<?php $this->renderPartial('_table', array('model' => $model, 'dataTable' => $dataTable)); ?>