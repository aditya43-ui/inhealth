<span id='tombolTambah'>
    <?php 
    if(!empty($frame) && $frame == 1){
        echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}'=>'<i class="icon-plus icon-white"></i> Tambah')), $this->createUrl('/anestesi/monitoringIntraAnastesi/tambah',array('pasienanastesi_id'=>$model->pasienanastesi_id, 'frame' => 1)), array('class'=>'btn btn-blue')); 
    } else {
        echo CHtml::link(Yii::t('mds', '{icon}', array('{icon}'=>'<i class="icon-plus icon-white"></i> Tambah')), $this->createUrl('/anestesi/monitoringIntraAnastesi/tambah',array('pasienanastesi_id'=>$model->pasienanastesi_id)), array('class'=>'btn btn-blue')); 
    }
    ?>
</span>