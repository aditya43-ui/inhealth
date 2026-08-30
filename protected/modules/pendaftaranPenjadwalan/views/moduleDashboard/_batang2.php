<?php
    $this->Widget('ext.jQPlot.jQPlotWidget', array(
        'dataProvider' => $modKunjungan->searchGrafikStatusPeriksa(),
        'id'=>$id,
        'type' => 'batang',
        'options' => array(
//            'stackSeries'=>true,
//            'title' => $title,
            'seriesDefaults'=>array(
                'rendererOptions'=>array(
//                    'barDirection'=>'horizontal',
//                    'barWidth'=>15,
//                    'barMargin'=>25,
                    'sliceMargin'=>4,
                    'showDataLabels'=>true,
                    ),
                ),
            'animate'=>true,
            'axes'=>array(
                'xaxis'=>array(
                    'renderer'=> 'js:$.jqplot.CategoryAxisRenderer',
                    'width'=>0,
                    'ticks'=>false,
                ),
                'yaxis'=> array(
                    'labelRenderer'=>'js:$.jqplot.CanvasAxisLabelRenderer',
                )
            ),
          ),
        'htmlOptions'=>array('class'=>'col-sm-6','style'=>'height:192px;margin:0'),
       )
    );
    ?>
<?php 
Yii::app()->clientScript->registerScript('a','
    $(".grafik").click(function(){
        $("#tes").jqplotSaveImage();
        return false;
    });
', CClientScript::POS_READY);

//Yii::app()->clientScript->registerScript('b',"
//    function test(){
//        $('#tes').jqplotSaveImage();
//    }
//",  CClientScript::POS_HEAD);
?>
<script type="text/javascript">
/**
* function untuk menyembunyikan white object setelah diagram
*/
$(document).ready(function(){
   $('div#<?php echo $id; ?> > .keys').parent().attr('style','display:none;');
});
</script>