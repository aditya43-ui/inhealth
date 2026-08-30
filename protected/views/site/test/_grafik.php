<?php
$this->Widget('ext.jQPlot.jQPlotWidget', array(
    'dataProvider' => $model->searchDashboard(),
    'id' => $id,
    'type' => $id,
//    'setFunction'=>true,
//    'autoUpdate'=>array(
//        'bind'=>array(
//            'form'=>'#searchLaporan',
//        ),
//        'url'=>Yii::app()->createUrl($this->route),
//    ),
    'options' => array(
        'title' => $data['title'],
        'seriesDefaults' => array(
            'renderer' => 'js:$.jqplot.BarRenderer',
            'dataLabels' => 'value',
            'barDirection' => 'vertical',
            'rendererOptions' => array(
                'fillToZero' => true,
                'barPadding' => 8,
                'barMargin' => 10,
                'barWidth' => 50,
                'barHeight' => 100,
                'padding' => 20,
                'sliceMargin' => 5,
            ),
            'pointLabels' => array('show' => true),
        ),
        'animate' => true,
        'axesDefaults' => array(
            'tickRenderer' => 'js:$.jqplot.CanvasAxisTickRenderer',
            'tickOptions' => array(
                'angle' => -30,
                'fontSize' => '10pt'
            ),
        ),
        'axes' => array(
            'xaxis' => array(
                'renderer' => 'js:$.jqplot.CategoryAxisRenderer',
                'width' => 10,
                'ticks' => true,
                'tickOptions' => array(
                    'mark' => 'inside',
                    'showLabel' => true,
                ),
            ),
            'yaxis' => array(
                'labelRenderer' => 'js:$.jqplot.CanvasAxisLabelRenderer',
            )
        ),
    ),
        )
);
?>
