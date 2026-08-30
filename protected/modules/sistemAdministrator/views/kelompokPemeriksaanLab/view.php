<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kelompok Pemeriksaan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Rdkeadaan Masuk Ms' => array('index'),
            $model->lookup_id,
        );
        $arrMenu = array();
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'lookup_id',
                'lookup_name',
                'lookup_urutan',
                'lookup_kode',
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->lookup_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                ),
            ),
        )); ?>

        <?php //echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Pemeriksaan Laboratorium', array('{icon}'=>'<i class="icon-file icon-white"></i>')), $this->createUrl('admin',array('modul_id'=> Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kelompok Pemeriksaan', array('{icon}' => '<i class="icon-file icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-danger',));
        $this->widget('UserTips', array('type' => 'view'));
        //                                $this->widget('UserTips',array('type'=>'view'));
        ?>
    </div>
</div>