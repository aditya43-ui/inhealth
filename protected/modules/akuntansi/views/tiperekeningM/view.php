<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Tipe Rekening</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Tipe Rekening' => Yii::app()->request->getUrlReferrer(),
        );

        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Tipe Rekening '.$model->tiperekening_id, 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Tipe Rekening ', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert');

        ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'tiperekening_id',
                'tiperekening',
                'keterangan',
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->tiperekening_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Tipe Rekening', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>