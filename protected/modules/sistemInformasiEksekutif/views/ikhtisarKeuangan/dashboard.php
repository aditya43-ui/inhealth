<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php $this->renderPartial('_linePendapatan', array('model' => $model, 'dataChartPendapatan' => $dataChartPendapatan)); ?>
<?php $this->renderPartial('_lineLabaRugi', array('model' => $model, 'dataChartLabaRugi' => $dataChartLabaRugi)); ?>
<?php $this->renderPartial('_lineAset', array('model' => $model, 'dataChartAset' => $dataChartAset)); ?>
<?php $this->renderPartial('_lineLiabilitas', array('model' => $model, 'dataChartLiabilitas' => $dataChartLiabilitas)); ?>
<?php $this->renderPartial('_lineEkuitas', array('model' => $model, 'dataChartEkuitas' => $dataChartEkuitas)); ?>