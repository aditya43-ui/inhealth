<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kasus Penyakit Obat</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Rjkasuspenyakitdiagnosa Ms' => array('index'),
            $model->jeniskasuspenyakit_id,
        );
        $arrMenu = array();
        //                    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Diagnosa Kasus Penyakit ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Diagnosa Kasus Penyakit ', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                //		'jeniskasuspenyakit_nama',
                array(
                    'label' => 'Jenis Kasus Penyakit',
                    'type' => 'raw',
                    'value' => $model->jeniskasuspenyakit_nama,
                ),
                array(
                    'label' => 'Obat Alkes',
                    'type' => 'raw',
                    'value' => $this->renderPartial('_obatalkes', array('jeniskasuspenyakit_id' => $model->jeniskasuspenyakit_id), true),
                ),
            ),
        ));
        ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Kasus Penyakit Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('kasuspenyakitobatM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>
<!--/div-->