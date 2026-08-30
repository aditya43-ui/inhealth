<div class="row">
    <div class="col-sm-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="far fa-plus-square"></i> Pencatatan <b>Pasien</b>
                </div>
            </div>
            <div class="panel-body">
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'pasien-m-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return validasiInput()'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
                    'focus' => '#' . CHtml::activeId($modPasien, 'no_rekam_medik'),
                )); ?>
                <?php
                $model = new PPPendaftaranT;
                if (isset($_GET['sukses'])) {
                    Yii::app()->user->setFlash('success', "Data pasien berhasil disimpan!");
                }
                ?>
                <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

                <?php echo $form->errorSummary($modPasien); ?>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="entypo-user"></i> Data <b>Pasien Baru</b>
                            <span class='tombol' style='display:none;'><?php echo CHtml::htmlButton('<i class="entypo-arrows-ccw"></i>', array('class' => 'btn btn-default btn-mini', 'onclick' => 'setPasienBaru();', 'onkeyup' => "return $(this).focusNextInputField(event)", 'rel' => 'tooltip', 'title' => 'Klik untuk kembali ke Pasien Baru')); ?></span>
                        </div>
                    </div>
                    <div class="panel-body">
                        <fieldset class="box" id="form-pasien">
                            <div class="row">
                                <?php $this->renderPartial($this->path_view . '_formPasien', array('form' => $form, 'modPasien' => $modPasien)); ?>
                            </div>
                        </fieldset>
                    </div>
                </div>

                <div class="form-actions">
                    <?php //JIKA TANPA VERIFIKASI >> echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 'onkeypress'=>'formSubmit(this,event)')); 
                    ?>
                    <?php
                    if ($modPasien->isNewRecord) {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit')
                        ); //formSubmit(this,event)
                    } else {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'button', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;')
                        );
                    }
                    ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'return refreshForm(this);'
                        )
                    ); ?>
                    <?php
                    if ($modPasien->isNewRecord) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel' => 'tooltip', 'title' => 'Tombol akan aktif setelah data tersimpan', 'class' => 'btn btn-info', 'onclick' => "return false", 'disabled' => true, 'style' => 'cursor:not-allowed;'));
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Print Kartu Pasien', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "printKartuPasien('$modPasien->pasien_id');return false", 'disabled' => FALSE));
                    }
                    ?>
                    <?php
                    $content = $this->renderPartial('rekamMedis.views.tips.transaksi2', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>

                    <?php
                    //$content = $this->renderPartial($this->path_view.'tips/tipsPendaftaranRawatJalan',array(),true);
                    //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content));  
                    ?>
                </div>

                <?php $this->endWidget(); ?>
            </div>
        </div>
    </div>
</div>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('modPasien' => $modPasien, 'model' => $model)); ?>