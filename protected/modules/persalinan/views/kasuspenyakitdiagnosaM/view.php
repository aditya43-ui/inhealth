<div class="white-container">
    <legend class="rim2">Lihat Kasus <b>Penyakit Diagnosa</b></legend>
    <?php
    $this->breadcrumbs = array(
        'Rjkasuspenyakitdiagnosa Ms' => array('index'),
        $model->jeniskasuspenyakit_id,
    );

    $arrMenu = array();
    //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Diagnosa Kasus Penyakit ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
    //                (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>Yii::t('mds','Manage').' Diagnosa Kasus Penyakit ', 'icon'=>'folder-open', 'url'=>array('admin'))) :  '' ;

    $this->menu = $arrMenu;

    $this->widget('bootstrap.widgets.BootAlert'); ?>

    <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
        'data' => $model,
        'attributes' => array(
            'jeniskasuspenyakit.jeniskasuspenyakit_nama',
            array(
                'label' => 'Diagnosa',
                'type' => 'raw',
                'value' => $this->renderPartial('_diagnosa', array('jeniskasuspenyakit_id' => $model->jeniskasuspenyakit_id), true),
            ),
        ),
    )); ?>

    <div class="form-actions">
        <?php echo CHtml::link(
            Yii::t('mds', '{icon} Pengaturan Kasus Penyakit Diagnosa', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
            $this->createUrl('/persalinan/kasuspenyakitdiagnosaM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
            array('class' => 'btn btn-success',)
        ); ?>
        <?php $this->widget('UserTips', array('type' => 'view')); ?>
    </div>
</div>