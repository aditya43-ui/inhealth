<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/chartjs-plugin/labels/chartjs-plugin-labels.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/dropdownMulti.js', CClientScript::POS_END);
?>
<?php $this->renderPartial('_search', array('model' => $model)); ?>
<?php $this->renderPartial('_tile', array('model' => $model, 'tile' => $load['tile'])); ?>
<?php $this->renderPartial('_grafik'); ?>
<?php $this->renderPartial('_table', array('model' => $model)); ?>
<?php echo $this->renderPartial('_jsFunction', array('model' => $model)); ?>