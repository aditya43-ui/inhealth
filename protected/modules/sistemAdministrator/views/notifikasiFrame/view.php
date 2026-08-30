<?php
$this->breadcrumbs = array(
    'Sapengumumen' => array('index'),
    $model->nofitikasi_id,
);
?>
<!--<legend class="rim2">Lihat Pengumuman</legend>-->
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>

<?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
    'data' => $model,
    'attributes' => array(
        'nofitikasi_id',
        array(
            'name' => 'update_time',
            'value' => MyFormatter::formatDateTimeForUser($model->tglnotifikasi),
            'filter' => false,
        ),
        array(
            'name' => 'judulnotifikasi',
            'type' => 'raw',
        ),
        array(
            'name' => 'isinotifikasi',
            'type' => 'raw',
        ),
        array(
            'name' => 'Ruangan Asal',
            'value' => $model->ruangan->ruangan_nama,
            'type' => 'raw',
        ),
        array(
            'name' => 'Pembuat',
            'value' => $model->pemakai->nama_pemakai,
            'type' => 'raw',
        ),
        // 'isread',
        // 'create_loginpemakai_id',
        //'create_time',
        //'update_loginpemakai_id',
        //'update_time',
        //'publish_loginpemakai_id',
    ),
)); ?>
</div>

<div class="form-actions">
    <?php //echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl($this->id.'/update&id='.$model->pengumuman_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
    ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); ?>
    <?php //$this->widget('UserTips',array('type'=>'view'));
    ?>
</div>