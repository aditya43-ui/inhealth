<?php
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);
?>
<div class="col-sm-10">
    <canvas id="chart_tekanandarah"> </canvas>
</div>
<div class="clear"></div>
<hr/>
<div class="clear"></div>
<hr/>

<div class="col-sm-10">
    <canvas id="chart_temperature"> </canvas>
</div>