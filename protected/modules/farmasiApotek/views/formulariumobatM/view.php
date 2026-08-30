<!--div class="white-container"-->
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Master Formularium Obat</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Formularium Obat' => array('admin'),
            $model->formulariumobat_id,
        );
        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Diagnosa Kasus Penyakit ', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';
        $this->menu = $arrMenu;
        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php
        $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'jenisformularium',
                array(
                    'label' => 'Nama Obat dan Alkes',
                    'type' => 'raw',
                    'value' => $model->obatalkes->obatalkes_nama,
                ),
                array(
                    'label' => 'Jenis Penjamin',
                    'type' => 'raw',
                    'value' => $model->carabayar->carabayar_nama,
                ),
                array(
                    'label' => 'Penjamin',
                    'type' => 'raw',
                    'value' => $model->penjamin->penjamin_nama,
                ),
            ),
        ));
        ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Master Formularium Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('FormulariumobatM/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>
<!--/div-->