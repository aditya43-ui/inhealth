<?php
    $this->Widget('ext.jQPlot.jQPlotWidget', array(
        'dataProvider' => $model->searchGrafikDitolak(),
        'id'=>'grafik',
        'type' => $data['type'],
        'options' => array(
            'title' => $data['title'],
            'labels' => 'Jenis Tindakan', 
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
                        ),
                    'pointLabels'=>array( 'show'=> true ),
                    ),
            'animate'=>true,
            'axes'=>array(
                'xaxis'=>array(
                    'renderer'=> 'js:$.jqplot.CategoryAxisRenderer',
                    'width'=>10,
                    'ticks'=>true,
                    'tickOptions'=>array(
                        'mark'=>'inside',
                        'showLabel'=>true,
                    ),
                    'tickRenderer' => 'js: $.jqplot.CanvasAxisTickRenderer',
                    'label' => 'Jenis Pemeriksaan',
                ),
                'yaxis'=> array(
                    'label' => 'Jumlah Pemeriksaan',
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
        var elemen = $("#grafik").jqplotToImageElem();
        var src = elemen.src;
        $("#grafik").empty();
        $("#grafik").append(elemen); 
        
    });
', CClientScript::POS_READY);
}
else{
Yii::app()->clientScript->registerScript('a','
    $(".grafik").click(function(){
        $("#grafik").jqplotSaveImage();
        return false;
    });
', CClientScript::POS_READY);
}

Yii::app()->clientScript->registerScript('b',"
    function test(){
        $('#grafik').jqplotSaveImage();
    }
",  CClientScript::POS_HEAD);