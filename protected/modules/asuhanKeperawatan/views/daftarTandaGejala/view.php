<?php
$this->breadcrumbs = array(
    'Daftar Tanda Gejala' => array('admin'),
    $model->tandagejala_daftar_id,
);
?>

    <div class="panel panel-gradient">
        <div class="panel panel-heading">
            <div class="panel-title"> Lihat <b> Daftar Tanda Gejala</b> </div>
        </div>
        <div class="panel-body table-responsive">
            <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
            <div class="row">
                <div class="col-sm-6">
                    <?php
                    $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                        'data' => $model,
                        'attributes' => array(
                            'tandagejala_daftar_nama',
                            'tandagejala_daftar_namalain',                                                        
                            array(
                                'label' => 'Status',
                                'value' => ($model->tandagejala_daftar_aktif == 1 ) ? "Aktif" : "Tidak Aktif",
                            ),
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class="row">
                <div class="form-actions">
                    <?php echo CHtml::link(Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="icon-pencil icon-white"></i>')), $this->createUrl('update', array('id' => $model->tandagejala_daftar_id, 'modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Daftar Tanda Gejala', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
                    <?php
                    $tips = array(
                        '0' => 'ubah',
                    );
                    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
            </div>
        </div>
    </div>

