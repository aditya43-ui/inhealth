<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Jurnal Rekening Kolom</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Jurnal Rekening Kolom' => array('admin'),
            'Lihat',
        );

        $arrMenu = array();
        (Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ? array_push($arrMenu, array('label' => Yii::t('mds', 'Manage') . ' Jurnal Rekening Kolom ', 'icon' => 'folder-open', 'url' => array('admin'))) :  '';

        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'ID',
                    'type' => 'raw',
                    'value' => $model->rekeningcolumn_id,
                ),
                array(
                    'label' => 'Nama Tabel',
                    'value' => $model->table_name,
                ),
                array(
                    'label' => 'Nama Kolom',
                    'value' => $model->column_name,
                ),
                array(
                    'label' => 'Keterangan',
                    'value' => $model->keterangan,
                ),
                array(
                    'label' => 'Rekening Debit',
                    'type' => 'raw',
                    'value' => ($model->debitkredit == "D") ? (isset($model->rekening5_id) ? $model->rekening5->nmrekening5 : "-") : "-",
                ),
                array(
                    'label' => 'Rekening Kredit',
                    'type' => 'raw',
                    'value' => ($model->debitkredit == "K") ? (isset($model->rekening5_id) ? $model->rekening5->nmrekening5 : "-") : "-",
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Jurnal Rekening Kolom', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'], 'tab' => isset($_GET['tab']) ? $_GET['tab'] : '')),
                array('class' => 'btn btn-success')
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>