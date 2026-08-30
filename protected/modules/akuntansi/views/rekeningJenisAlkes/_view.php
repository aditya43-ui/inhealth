<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jurnal Jenis Obat Alkes</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Jurnal Jenis Obat Alkes' => array('admin'),
            'Lihat'
        );
        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(

                array(
                    'label' => 'Rekening',
                    'type' => 'raw',
                    'value' => $model->rekening5->nmrekening5,
                ),
                array(
                    'label' => 'Saldo Normal',
                    'type' => 'raw',
                    'value' => $model->debitkredit,
                ),
                array(
                    'label' => 'Jenis Obat Alkes',
                    'type' => 'raw',
                    'value' => $model->jenisobatalkes->jenisobatalkes_nama,
                )
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jurnal Rekening Jenis Obat Alkes', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('class' => 'btn btn-success',)
            ); ?>

            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
        <!--</div>-->
    </div>
</div>