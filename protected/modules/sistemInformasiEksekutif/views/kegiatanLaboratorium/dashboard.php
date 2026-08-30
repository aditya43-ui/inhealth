<?php $this->renderPartial($this->path_view . '_search', array('model' => $model)); ?>
<?php $this->renderPartial($this->path_view . '_bar', array('model' => $model, 'dataPemeriksaanLab' => $dataPemeriksaanLab, 'dataBarLineChart' => $dataBarLineChart)); ?>
<?php $this->renderPartial($this->path_view . '_table', array('model' => $model, 'dataTable' => $dataTable)); ?>
<?php $this->renderPartial($this->path_view . '_pie', array('model' => $model, 'dataPieChart' => $dataPieChart)); ?>