<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Kelas Terapi Obat</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php
        $this->breadcrumbs = array(
            'Kelas Terapi Obat' => array('admin'),
            $model->obatalkes_id,
        );

        $arrMenu = array();
        //                array_push($arrMenu,array('label'=>Yii::t('mds','View').' Kelas Terapi Obat ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) ;
        $this->menu = $arrMenu;

        $this->widget('bootstrap.widgets.BootAlert'); ?>

        <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
            'data' => $model,
            'attributes' => array(
                array(
                    'label' => 'Nama Kelas Terapi',
                    'type' => 'raw',
                    'value' => (isset($model->therapiobat_id) ? $model->therapiobat->therapiobat_nama : "-"),
                ),
                array(
                    'label' => 'Obat Alkes Kode',
                    'type' => 'raw',
                    'value' => (isset($model->obatalkes->obatalkes_kode) ? $model->obatalkes->obatalkes_kode : "-"),
                ),
                array(
                    'label' => 'Nama Obat Alkes',
                    'type' => 'raw',
                    'value' => (isset($model->obatalkes_id) ? $model->obatalkes->obatalkes_nama : "-"),
                ),
                array(
                    'label' => 'Jenis Obat Alkes',
                    'type' => 'raw',
                    'value' => (isset($model->jenisobatalkes_id) ? $model->obatalkes->jenisobatalkes->jenisobatalkes_nama : "-"),
                ),
                array(
                    'label' => 'Tanggal Kedaluwarsa',
                    'type' => 'raw',
                    'value' => (isset($model->obatalkes->tglkadaluarsa) ? MyFormatter::FormatDateTimeForUser($model->obatalkes->tglkadaluarsa) : "-"),
                ),
            ),
        )); ?>

        <div class="form-actions">
            <?php //echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Mapping Kelas Terapi Obat', array('{icon}'=>'<i class="icon-folder-open icon-white"></i>')),
            echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Kelas Terapi Obat', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl(
                    Yii::app()->controller->id . '/admin',
                    array('modul_id' => Yii::app()->session['modul_id'])
                ),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>