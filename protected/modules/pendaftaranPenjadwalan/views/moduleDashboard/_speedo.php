<?php
// RND-1887
$data = $modKunjungan->searchMaxSpeedo()->totalItemCount;
$sisa = $data%6;
$akhir = $data + (6-$sisa); 

// if($data > 0){
    $this->widget('ext.jQPlot.widget.gaugeMeterChart', array(
                'dataProvider' => $dataProvider,
                'rendererOptions'=>array(
                    'min'=>0,
                    'max'=>500,
//                    'intervals'=>array(($data*10/100),($data*50/100),$data,$akhir),
                    'intervals'=>array(50,200,350,500),
                    'intervalColors'=>array("#ff9999","#ffff99","#99ff99","#99ddff"),
                    'label'=> $title." : <b>".$dataProvider->totalItemCount."</b>",
                    'labelPosition'=>'bottom',
//                    'labelHeightAdjust'=> -5,
//                    'intervalOuterRadius'=> 85,
                   'ticks'=> array(0,100,200,250,300,400,500),
//                   'ticks'=> array(0,($akhir*10/60),($akhir*20/60),($akhir*30/60),($akhir*40/60),($akhir*50/60),$akhir),
                    // 'ticks'=> array(0,($data*12.5/100),($data*25/100),($data*50/100),($data*75/100),($data*87.5/100),$akhir),
                ),
                'id' => $id,
                'htmlOptions'=>array('class'=>'col-sm-6','style'=>'height:192px;margin:0 0 0 20px;'),
            )
    );
// }else{
//     echo "<div class='alert alert-block alert-error'>Data Speedo Meter Tidak Ditemukan</div>";
// }
?>