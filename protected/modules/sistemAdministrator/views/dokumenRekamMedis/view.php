<div class="white-container">
    <legend class="rim2">Lihat Dokumen <b>Rekam Medis</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Sadokrekammedis Ms' => array('index'),
        $model->dokrekammedis_id,
    );
    ?>
    <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    <div class="row">
        <div class="col-sm-4">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'dokrekammedis_id',
                    'warnadokrm_id',
                    'subrak_id',
                    'lokasirak_id',
                    'pasien_id',
                    'nodokumenrm',
                    'tglrekammedis',
                    'tglmasukrak',
                ),
            )); ?>
        </div>

        <div class="col-sm-4">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'statusrekammedis',
                    'tglkeluarakhir',
                    'tglmasukakhir',
                    'nomortertier',
                    'nomorsekunder',
                    'nomorprimer',
                    'warnanorm_i',
                    'warnanorm_ii',
                ),
            )); ?>
        </div>
        <div class="col-sm-4">
            <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                'data' => $model,
                'attributes' => array(
                    'tgl_in_aktif',
                    'tglpemusnahan',
                    'create_time',
                    'update_time',
                    'create_loginpemakai_id',
                    'update_loginpemakai_id',
                    'create_ruangan',
                ),
            )); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php
        // RND-5857	link update hanya ada pada modul rekam medis - informasi -	dokumen rekam medis 		
        //echo CHtml::link(Yii::t('mds','{icon} Ubah',array('{icon}'=>'<i class="entypo-pencil"></i>')),$this->createUrl($this->id.'/update&id='.$model->dokrekammedis_id,array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
        ?>
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Dokumen Rekam Medis', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>