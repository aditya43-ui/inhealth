<?php

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/themes/neon/assets/js/daterangepicker/moment.min.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/Chart.js', CClientScript::POS_END);
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/chartjs-plugin/annotation/chartjs-plugin-annotation.js', CClientScript::POS_END);

?>

<div class="panel panel-success">
    <div class="panel-body">
        <div class="row-fluid">
            <div class="col-sm-11">
                <canvas id="chart_tandavital"> </canvas>
            </div> 
        </div>
    </div>
</div>

