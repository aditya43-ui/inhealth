<?php
    $this->Widget('ext.jQPlot.jQPlotWidget', array(
        'dataProvider' => $model->searchGrafik(),
        'id'=>'tes',
        'type' => $data['type'],
        'options' => array(
            'title' => $data['title'],
            'seriesColors'=>['#1553cc', '#41962a', '#f1c232', '#ec3323'],
            'seriesDefaults'=>array(
                'renderer'=>'js:$.jqplot.BarRenderer',
                'dataLabels'=>'value',
                'barDirection'=>'vertical',
                'rendererOptions'=>array(
                    'fillToZero'=>true,
                    'barPadding'=>8,
                    'barMargin'=>10,
                    'barWidth'=>50,
                    'barHeight'=>100,
                    'padding'=>20,
                    'sliceMargin'=>5,                
                    // Set varyBarColor to tru to use the custom colors on the bars.
                    'varyBarColor'=> true,
                    ),
                'pointLabels'=>array( 'show'=> true ),
            ),
            'animate'=>true,
            'axesDefaults'=>array(
                'tickRenderer'=> 'js:$.jqplot.CanvasAxisTickRenderer',
                'tickOptions'=>array(
                  'angle'=> -30,
                  'fontSize'=> '10pt'
                ),
            ),
            'axes'=>array(
                'xaxis'=>array(
                    'renderer'=> 'js:$.jqplot.CategoryAxisRenderer',
                    'width'=>10,
                    'ticks'=>true,
                    'tickOptions'=>array(
                        'mark'=>'inside',
                        'showLabel'=>true,
                    ),
                ),
                'yaxis'=> array(
                    'labelRenderer'=>'js:$.jqplot.CanvasAxisLabelRenderer',
                )
            ),
          ),
       )
    );
    ?>
<?php if (isset($caraPrint)){
Yii::app()->clientScript->registerScript('a','
    $(document).ready(function(){
        var elemen = $("#tes").jqplotToImageElem();
        var src = elemen.src;
        $("#tes").empty();
        $("#tes").append(elemen); 
        
    });
', CClientScript::POS_READY);
}
else{
Yii::app()->clientScript->registerScript('a','
    $(".grafik").click(function(){
        $("#tes").jqplotSaveImage();
        return false;
    });
', CClientScript::POS_READY);
}

Yii::app()->clientScript->registerScript('b',"
    function test(){
        $('#tes').jqplotSaveImage();
    }
",  CClientScript::POS_HEAD);
?>