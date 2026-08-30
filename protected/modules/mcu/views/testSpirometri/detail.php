<?php
$this->breadcrumbs = array(
    'Mcu',
);
if (isset($_GET['sukses'])) {
    Yii::app()->user->setFlash('success', "Data Pemeriksaan Tes Spirometri berhasil disimpan");
}
$this->widget('bootstrap.widgets.BootAlert');
?>

<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'tesspirometri-mcu-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event)',
        'onsubmit' => 'return requiredCheck(this);'
    ),
));
?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            Hasil Tes Spirometri
        </div>
    </div>
    <div class="panel-body">
        <div class="panel-body">
            <?php
            $modPegawai = new PegawairuanganV();

            $modPegawai->unsetAttributes();
            $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

            if (isset($_GET['PegawairuanganV'])) {
                $modPegawai->attributes = $_GET['PegawairuanganV'];
            }

            $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                'id' => 'tes-spirometri-form',
                'enableAjaxValidation' => false,
                'type' => 'horizontal',
                'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
            ));

            $this->widget('bootstrap.widgets.BootAlert');

            echo $this->renderPartial($this->path_view . '_info', array(
                'form' => $form,
                'model' => $model,
                'modPemeriksaanFisik' => $modPemeriksaanFisik,
            ), true);

            echo $this->renderPartial($this->path_view . '_formSpirometri', array(
                'form' => $form,
                'model' => $model,
            ), true);
            ?>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        Kesimpulan dan Saran
                    </div>
                </div>
                <div class="panel-body">
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'kesimpulan', array('class' => 'control-label')); ?>
                        <div class="controls" style="width: calc(100% - 150px);">
                            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'kesimpulan', 'toolbar' => 'mini', 'height' => '100px')) ?>
                        </div>
                    </div>

                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'test_spirometri', array('class' => 'control-label', 'label' => 'Tes Spirometri')); ?>
                        <div class="controls" style="width: calc(100% - 150px);">
                            <?php
                            echo $form->textField($model, 'test_spirometri', array(
                                'class' => 'span4',
                                'readonly' => true,
                            )); ?>
                        </div>
                    </div>


                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'test_reversibilitas_plus', array('class' => 'control-label', 'label' => 'Tes Reversibilitas')); ?>
                        <div class="controls" style="width: calc(100% - 150px);">
                            <?php
                            echo $form->textField($model, 'test_reversibilitas_nilai', array('class' => 'angkacoma-only span1', 'style' => 'text-align: right;'));
                            echo "&emsp;";
                            echo $form->radioButtonList($model, 'test_reversibilitas_is_positif', [0 => 'Negatif', 1 => 'Positif'], array(
                                'template' => '<span style="margin-right: 10px;">{input}{label}</span>',
                                'onclick' => 'checkInputLevel(this);',
                                'class' => 'radio_reversibilitas'
                            ));
                            ?>

                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'saran', array('class' => 'control-label')); ?>
                        <div class="controls" style="width: calc(100% - 150px);">
                            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'saran', 'toolbar' => 'mini', 'height' => '100px')) ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->labelEx($model, 'pengetahui_id', array('class' => 'control-label', 'label' => 'Pegawai Mengetahui')); ?>
                        <div class="controls">
                            <?php echo CHtml::hiddenField('pengetahui_id', '', array('readonly' => TRUE)); ?>
                            <?php
                            echo $form->textField($model, 'mengetahui_nama', array(
                                'class' => 'span4',
                                'readonly' => true,
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>

        <?php $this->endWidget(); ?>
        <?php echo CHtml::link('<i class="entypo-back" style="color: white;"></i> Kembali', '#', array('class' => 'btn btn-primary', 'onclick' => 'window.history.back(); return false;', 'style' => 'color: white;')) ?>
    </div>
</div>

<?php $this->endWidget(); ?>
<?php
echo $this->renderPartial($this->path_view . '_jsFunctions', array(
    'form' => $form,
    'model' => $model,
), true);
?>
<script>
    $(document).ready(function() {
        $("input, select, textarea").attr("readonly", true);
    });
</script>