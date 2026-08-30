<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-ticket"></i> Karcis <b>Antrian Ke Farmasi</b>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Anantrianfarmasi Ts' => array('index'),
            'Tiket Antrian Farmasi ',
        );
        ?>
        <?php
        if (isset($_GET['sukses'])) {
            Yii::app()->user->setFlash('success', 'Data karcis farmasi berhasil disimpan!');
        }
        ?>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-ticket"></i> Buat Karcis
                </div>
            </div>
            <div class="panel-body">
                <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'anantrianfarmasi-t-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
                    'focus' => '#' . CHtml::activeId($model, 'racikan_id'),
                )); ?>

                <!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') 
                                            ?></p>-->

                <?php echo $form->errorSummary($model); ?>

                <div class="row">
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'tglambilantrian', array('class' => 'span3 realtime', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?>
                        <?php echo $form->dropDownListRow($model, 'racikan_id', $model->getListRacikans(), array('class' => 'span3', 'empty' => '-- Pilih --')) ?>
                    </div>
                    <div class="col-sm-6">
                        <?php echo $form->textFieldRow($model, 'noantrian', array('readonly' => true, 'placeholder' => 'Otomatis', 'class' => 'span3', 'onkeyup' => "return $(this).focusNextInputField(event);", 'maxlength' => 6)); ?>
                        <?php // echo $form->textFieldRow($model,'racikan_id',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); 
                        ?>
                    </div>
                </div>
                <div class="form-actions">
                    <?php
                    if ($model->isNewRecord) {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
                        );
                    } else {
                        echo CHtml::htmlButton(
                            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                            array('title' => 'Simpan', 'disabled' => true, 'class' => 'btn btn-danger', 'type' => 'button', 'style' => 'cursor:not-allowed;')
                        );
                    }
                    ?>
                    <?php echo CHtml::link(
                        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                        $this->createUrl($this->id . '/index'),
                        array(
                            'title' => 'Ulang',
                            'class' => 'btn btn-default',
                            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = "' . $this->createUrl('index') . '";}); return false;'
                        )
                    ); ?>
                    <?php
                    $content = $this->renderPartial($this->path_view . 'tips/tipsAmbilKarcisFarmasi', array(), true);
                    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
                    ?>
                </div>
                <?php $this->endWidget(); ?>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Karcis Terakhir</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php echo $this->renderPartial($this->path_view . '_tableKarcisTerakhir'); ?>
            </div>
        </div>

        <div class="form-actions">
            <?php
            if (isset($_GET['id'])) {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn btn-info', 'type' => 'button', 'onclick' => 'printKarcisFarmasi(' . $model->antrianfarmasi_id . ',\'PRINT\')'));
            } else {
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn btn-info', 'disabled' => true, 'type' => 'button', 'style' => 'cursor:not-allowed;'));
            }
            ?>
            <?php
            $tips = array(
                '0' => 'simpan',
                '1' => 'ulang',
                '2' => 'print',
            );
            $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>

        <?php echo $this->renderPartial($this->path_view . '_jsFunctions'); ?>
    </div>
</div>