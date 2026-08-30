<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-book-open"></i></i> Detail <b>Buat Janji</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                //		'buatjanjipoli_id',\
                'tglbuatjanji',
                'pasien.no_rekam_medik',
                'pasien.nama_pasien',
                'no_kartu_bpjs',
                'tgljadwal',
                'harijadwal',
                'pegawai.nama_pegawai',
                'ruangan.ruangan_nama',
                array(
                    'name' => 'byphone',
                    'type' => 'raw',
                    'value' => (($model->byphone == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
                'keteranganbuatjanji',
                //		'create_time',
                //		'update_time',
                //		'create_loginpemakai_id',
                //		'update_loginpemakai_id',
                //		'create_ruangan',
            ),
        )); ?>
        <?php
        //	echo CHtml::link(Yii::t('mds','{icon} Kembali',array('{icon}'=>'<i class="icon-arrow-left icon-white"></i>')), 
        //				 Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/admin'), 
        //				 array('class'=>'btn btn-primary',));
        ?>
        <?php // $this->widget('UserTips',array('type'=>'view'));
        ?>

    </div>
</div>