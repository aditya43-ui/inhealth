<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jurnal Rekening Penjamin</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Jurnal Rekening Penjamin' => array('admin'),
            'Lihat'
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Jurnal Rekening Penjamin ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Jurnal Rekening Penjamin', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'Jenis Penjamin',
                    'type' => 'raw',
                    'value' => $model->penjamin->carabayar->carabayar_nama,
                ),
                array(
                    'label' => 'Penjamin',
                    'type' => 'raw',
                    'value' => $model->penjamin->penjamin_nama,
                ),
                array(
                    'label' => 'Rekening Debit',
                    'type' => 'raw',
                    'value' => $this->renderPartial('_viewDebit', array('penjamin_id' => $model->penjamin_id, 'saldonormal' => 'D'), true),
                ),
                array(
                    'label' => 'Rekening Kredit',
                    'type' => 'raw',
                    'value' => $this->renderPartial('_viewKredit', array('penjamin_id' => $model->penjamin_id, 'saldonormal' => 'K'), true),
                ),
                array(
                    'label' => 'Aktif',
                    'type' => 'raw',
                    'value' => (($model->penjamin->penjamin_aktif == 1) ? '' . Yii::t('mds', 'Yes') . '' : '' . Yii::t('mds', 'No') . ''),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jurnal Rekening Penjamin', array('{icon}' => '<i class="' . MyIcon::getIcons('pengaturan') . '"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('class' => 'btn btn-danger',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
        <!--</div>-->
    </div>
</div>