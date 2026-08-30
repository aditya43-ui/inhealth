<?php
$this->breadcrumbs = array(
    'Saperanpengguna Ks' => array('index'),
    $model->peranpengguna_id,
);
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-eye"></i> Lihat <b>Peran Pemakai</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="row">
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        'peranpengguna_id',
                        'peranpenggunanama',
                        //'peranpenggunanamalain',
                        //'peranpengguna_aktif',
                    ),
                )); ?>
            </div>
            <div class="col-sm-6">
                <?php $this->widget('ext.bootstrap.widgets.BootDetailView', array(
                    'data' => $model,
                    'attributes' => array(
                        //'peranpengguna_id',
                        //'peranpenggunanama',
                        'peranpenggunanamalain',
                        'peranpengguna_aktif',
                    ),
                )); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Ubah', array('{icon}' => '<i class="entypo-pencil"></i>')),
                $this->createUrl($this->id . '/update&id=' . $model->peranpengguna_id, array('modul_id' => Yii::app()->session['modul_id'])),
                array('title' => 'Ubah', 'class' => 'btn btn-danger',)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Pengaturan Peran Pemakai', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
                $this->createUrl($this->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])),
                array('class' => 'btn btn-success',)
            ); ?>
            <?php $this->widget('UserTips', array('type' => 'view')); ?>
        </div>
    </div>
</div>

<script>
    $(document).ready(function() {
        <?php if (!$model->isNewRecord) {
            if (!Params::cekAkses(Yii::app()->user->getState('peranpengguna_id'))) {
                if (Params::cekAkses($_GET['id'])) {
        ?>
                    window.location.href = "<?php echo $this->createUrl(Yii::app()->controller->id . "/admin&modul_id=" . Yii::app()->session['modul_id']); ?>";
            <?php
                }
            }
            ?>

        <?php } ?>
    });
</script>