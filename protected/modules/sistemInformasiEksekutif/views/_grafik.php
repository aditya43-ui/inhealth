<style>
    #pie > table.jqplot-table-legend {
        display: block;
        height: 330px !important;
        overflow-y: scroll;    
        z-index:99999;
    }
</style>

<?php
$total = 0;
$labels = false;
if (!empty($dataProvider->getData())){
    foreach($dataProvider->getData() as $det){
        $total += $det->jumlah;
    }
    
    if ($id !== 'pie'){
        $labels = array(
                    'Jumlah : '.$total,
        );
    }
}


if ($id == 'batang'):
    $width = 'width:85%;';
else:
    $width = 'width:100%;';
endif;

if($id == "garis"){
    $data['title'] = "Grafik ".$data['title']."<br>Periode : ".$data['tgl_awal']." s.d ".$data['tgl_akhir'];
}
$this->Widget('ext.jQPlot.jQPlotWidget', array(
    'dataProvider' => $dataProvider,
    'id' => $id,
    'type' => $id,
    // OFF AUTO UPDATE | EHJ-1725
    // 'setFunction'=>true,
    // 'autoUpdate'=>array(
    //     'bind'=>array(
    //         'form'=>'#searchLaporan',
    //     ),
    //     'url'=>Yii::app()->createUrl($this->route),
    // ),
    'options' => array(
        'title' => $data['title'],
        'seriesDefaults' => array(
            'renderer' => 'js:$.jqplot.BarRenderer',
            'dataLabels' => 'value',
            'barDirection' => 'vertical',
            'rendererOptions' => array(
//                'fillToZero' => true,
//                'barPadding' => 8,
//                'barMargin' => 10,
//                'barWidth' => 50,
//                'barHeight' => 100,
//                'padding' => 20,
//                'sliceMargin' => 5, 
                'varyBarColor' =>  true
            ),                           
            'pointLabels' => array('show' => true),                        
        ),        
        'legend' =>  array( 
            'show' => true, 
            'labels'=> $labels,
            'location' => 'nw',
            'placement'=> "inside",
//            'rendererOptions' => array(
//                'numberColumns'=> 1
//            ),
            'xoffset'=> 1,            
            'rowSpacing'=> '10px',
        ),
        'animate' => true,
        'axesDefaults' => array(
            'tickRenderer' => 'js:$.jqplot.CanvasAxisTickRenderer',
            'tickOptions' => array(
                'angle' => 90,
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
                    'angle' => -30,
                ),
            ),
            'yaxis' => array(
                'labelRenderer' => 'js:$.jqplot.CanvasAxisLabelRenderer',
                'min'=>0,
            )
        ),
    ),
    'htmlOptions'=>array(
            'style'=>$width,
    )
        )
);


?>
