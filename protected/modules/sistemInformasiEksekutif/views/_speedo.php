<?php
$data = $dataProvider->totalItemCount;
if($data > 0){
    $this->widget('ext.jQPlot.widget.gaugeMeterChart', array(
                'dataProvider' => $dataProvider,
//                OFF AUTO UPDATE | EHJ-1725
//                'autoUpdate'=>array(  //you can use this property to set this widget autoupdate 
//                    'bind'=>array(
//                        'form'=>'#search-laporan',
//                    ),
//                    'url'=>Yii::app()->createUrl($this->route),
//                ),
                'rendererOptions'=>array(
                    'min'=>0,
                    'max'=>$data,
                    'intervals'=>array(($data*10/100),($data*50/100),$data),
                    'intervalColors'=>array("#ff9999","#ffff99","#99ff99"),
                    'label'=> $title,
                    'labelPosition'=>'bottom',
                    'labelHeightAdjust'=> -5,
                    'intervalOuterRadius'=> 85,
                    'ticks'=> array(0,($data*10/100),($data*20/100),($data*30/100),($data*40/100),($data*50/100),($data*60/100),($data*70/100),($data*80/100),($data*90/100),$data),
                ),
                'id' => 'speedo',
                'htmlOptions'=>array('style'=>'width:100%'),
            )
    );
}else{
    echo "Data Speedo Meter Tidak Ditemukan";
}
?>