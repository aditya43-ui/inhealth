<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Penjamin Pasien</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Sapenjamin Pasien Ms' => array('index'),
            $model->penjamin_id,
        );

        $arrMenu = array();
        //    array_push($arrMenu,array('label'=>Yii::t('mds','View').' Penjamin Pasien ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                'penjamin_id',
                'carabayar.carabayar_nama',
                'penjamin_nama',
                'penjamin_namalainnya',
                array(               // related city displayed as a link
                    'name' => 'penjamin_aktif',
                    'type' => 'raw',
                    'value' => (($model->penjamin_aktif == 1) ? Yii::t('mds', 'Yes') : Yii::t('mds', 'No')),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Penjamin Pasien', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('/sistemAdministrator/PenjaminPasienM/Admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>