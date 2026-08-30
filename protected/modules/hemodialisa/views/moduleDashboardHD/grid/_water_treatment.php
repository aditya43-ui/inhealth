<?php
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'table-grid',
    'dataProvider'=>$dataTable->listWaterTreatment(),
    'template'=>"{items}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed table-responsive',
    'columns'=>array(
        array(
            'header'=>'Water Treatment',
            'name'=>'water_treatment',                    
        ),				
        array(
            'header'=>'Status',
            'type'=>'raw',
            'name'=>'status',                    
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
        ),
    ),
)); 