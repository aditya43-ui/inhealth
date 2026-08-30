<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kelompok Umur</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Lbkelkumurhasillab Ms' => array('index'),
            $model->kelkumurhasillab_id,
        );
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'kelkumurhasillab_id',
                        'kelkumurhasillabnama',
                        'umurminlab',
                        'umurmakslab',
                        //'satuankelumur',
                        //'kelkumurhasillab_aktif',
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        //'kelkumurhasillab_id',
                        //'kelkumurhasillabnama',
                        //'umurminlab',
                        'satuankelumur',
                        'kelkumurhasillab_urutan',
                        array(
                            'name' => 'kelkumurhasillab_aktif',
                            'type' => 'raw',
                            'value' => (($model->kelkumurhasillab_aktif == 1) ? '' . Yii::t('mds', 'Aktif') . '' : '' . Yii::t('mds', 'Tidak Aktif') . ''),
                        )
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php //echo CHtml::link(Yii::t('mds','{icon} Pengaturan Kelompok Umur Hasil Lab',array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),$this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',)); 
            ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Kelompok', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>

<!--<fieldset class="box">-->
<!--<legend class="rim">Lihat Kelompok Umur Hasil Lab</legend>-->