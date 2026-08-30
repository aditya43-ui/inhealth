<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php $this->renderPartial('_pie', array('model' => $model, 'dataPieChart' => $dataPieChart)); ?>
<?php $this->renderPartial('_bar', array('model' => $model, 'dataCaraBayar' => $dataCaraBayar, 'dataBarLineChart' => $dataBarLineChart)); ?>
<?php $this->renderPartial('_table', array('model' => $model, 'dataTable' => $dataTable)); ?>