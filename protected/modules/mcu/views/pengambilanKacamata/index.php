<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB  
?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Pergantian <b>Kacamata</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'gantikacamata-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
            'focus' => '#cari_nomorindukpegawai',
        ));
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', "Data pengambilan kacamata berhasil disimpan!");
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php echo $form->errorSummary($model); ?>
        <fieldset class="box" id="form-pasien">
            <div class="rim">Data Pasien
                <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPegawaiBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
            </div>
            <div class="row">
                <?php $this->renderPartial($this->path_view . '_formPasien', array('form' => $form, 'model' => $model, 'modPegawai' => $modPegawai)); ?>
            </div>
        </fieldset>
        <hr>
        <fieldset>
            <div class="panel panel-success">
                <div class="panel-heading">
                    <div class="panel-title">
                        <i class="far fa-eye"></i> Ukuran Visus Mata
                    </div>
                </div>
                <div class="panel-body" id="form-tindakanpemeriksaan-diluar-paket">
                    <table class="table table-condensed table-bordered">
                        <thead>
                            <tr>
                                <th colspan="2">
                                    <p style="margin: 0; text-align: center;">VOD</p>
                                </th>
                                <th colspan="2">
                                    <p style="margin: 0; text-align: center;">VOS</p>
                                </th>
                                <th rowspan="2">
                                    <p style="margin: 0; text-align: center;">ADD</p>
                                </th>
                            </tr>
                            <tr>
                                <th>Spheris</th>
                                <th>Cylindrys</th>
                                <th>Spheris</th>
                                <th>Cylindrys</th>
                            </tr>
                        </thead>
                        <tbody>
                            <?php echo $this->renderPartial($this->path_view . '_rowDataKacamata', array('model' => $model)); ?>
                        </tbody>
                    </table>
                </div>
            </div>
            <fieldset id="form-gantikacaamta">
                <div class="row">
                    <?php $this->renderPartial($this->path_view . '_formGantiKacamata', array('form' => $form, 'model' => $model, 'modPegawai' => $modPegawai)); ?>
                </div>
            </fieldset>

            <div class="form-actions">
                <?php
                //                if (!isset($_GET['sukses'])) {
                echo CHtml::htmlButton(
                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                    array('title' => 'Simpan', 'class' => (isset($_GET['sukses'])) ? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false, 'onkeypress' => 'formSubmit(this,event)')
                );

                //                } else {
                //                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                //					echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-primary-blue','type'=>'button','onclick'=>'print(\'PRINT\')','disabled'=>false));
                //                }
                ?>
                <?php
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/index'),
                    array(
                        'title' => 'Ulang',
                        'class' => 'btn btn-default',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
                ?>
                <?php
                if (!isset($_GET['sukses'])) {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'disabled' => true));
                } else {
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'type' => 'button', 'onclick' => 'print(\'PRINT\')', 'disabled' => false));
                }
                ?>
                <?php
                $content = $this->renderPartial($this->path_view . 'tips/tipsPergantianKacamata', array(), true);
                $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                ?>
            </div>
    </div>
    </fieldset>
    <?php $this->endWidget(); ?>
    <?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model, 'modPegawai' => $modPegawai)); ?>
</div>
</div>