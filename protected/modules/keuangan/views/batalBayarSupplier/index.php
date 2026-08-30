<div class="white-container">
    <?php
    $this->breadcrumbs = array(
        'Batal Bayar Supplier',
    ); ?>

    <legend class="rim2">Transaksi Batal <b>Bayar Supplier</b></legend>

    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'id' => 'batalbayarsupplier-t-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event)',
            // 'onsubmit'=>'return cekOtorisasi();'
            'onsubmit' => 'return requiredCheck(this);'
        ),
        'focus' => '#' . CHtml::activeId($modBuktiKeluar, 'nokaskeluar'),
    )); ?>

    <?php $this->renderPartial($this->path_view . '_infoBayarSupplier', array(
        'form' => $form,
        'modBuktiKeluar' => $modBuktiKeluar,
        'modBatalBayar' => $modBatalBayar,
        'modBayarSupplier' => $modBayarSupplier
    )) ?>
    <fieldset class="box">
        <legend class="rim">Pembatalan</legend>
        <table style="width: 100%; border: none;">
            <tr>
                <td width="50%">
                    <div class="control-group">
                        <?php $modBatalBayar->tglbatalbayar = Yii::app()->dateFormatter->formatDateTime(CDateTimeParser::parse($modBatalBayar->tglbatalbayar, 'yyyy-MM-dd hh:mm:ss', 'medium', null)); ?>
                        <?php echo $form->labelEx($modBatalBayar, 'tglbatalbayar', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modBatalBayar,
                                'attribute' => 'tglbatalbayar',
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'class' => 'dtPicker2-5', 'onkeypress' => "return $(this).focusNextInputField(event)"
                                ),
                            )); ?>

                        </div>
                    </div>
                </td>
                <td p>
                    <?php echo $form->textAreaRow($modBatalBayar, 'alasanbatalbayar', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                    <?php echo CHtml::activeHiddenField($modBatalBayar, 'user_id_otorisasi', array('class' => 'span3', 'readonly' => true)); ?>
                    <?php echo CHtml::activeHiddenField($modBatalBayar, 'user_name_otoritasi', array('class' => 'span3', 'readonly' => true)); ?>
                    <?php echo CHtml::activeHiddenField($modBatalBayar, 'tandabuktikeluar_id', array('class' => 'span3', 'readonly' => true)); ?>
                    <?php echo CHtml::activeHiddenField($modBatalBayar, 'bayarkesupplier_id', array('class' => 'span3', 'readonly' => true)); ?>
                </td>

            </tr>
        </table>
    </fieldset>

    <div class="form-actions">
        <?php
        // echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),
        //                     array('class' => 'btn btn-danger', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)')); 
        //echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}'=>'<i class="entypo-print"></i>')), '#', array('class'=>'btn btn-info','onclick'=>"printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false",'disabled'=>false)); 

        if ($modBatalBayar->isNewRecord) {
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Simpan', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
            );
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-info', 'disabled' => true));
        } else {
            echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), '#', array('class' => 'btn btn-info', 'onclick' => "printKasir($('#FAPendaftaranT_pendaftaran_id').val());return false", 'disabled' => false));
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true)
            );
        }

        ?>
        <?php
        echo CHtml::link(
            Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
            $this->createUrl('index'),
            array(
                'class' => 'btn btn-danger'
            )
        );
        ?>
        <?php
        $content = $this->renderPartial($this->path_view . 'tips', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
    <?php $this->endWidget(); ?>

    <?php
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'loginDialog',
        'options' => array(
            'title' => 'Login',
            'autoOpen' => false,
            'modal' => true,
            'width' => 400,
            'height' => 190,
            'resizable' => false,
        ),
    )); ?>
    <?php echo CHtml::beginForm('', 'POST', array('class' => 'form-horizontal', 'id' => 'formLogin')); ?>
    <div class="control-group">
        <?php echo CHtml::label('Login Pemakai', 'username', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::textField('username', '', array()); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label('Password', 'password', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php echo CHtml::passwordField('password', '', array()); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Login', array('{icon}' => '<i class="icon-lock icon-white"></i>')),
            array('class' => 'btn btn-danger', 'type' => 'submit', 'onclick' => 'cekLogin();return false;')
        ); ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Cancel', array('{icon}' => '<i class="entypo-cancel"></i>')), '#', array('class' => 'btn btn-default', 'onclick' => "$('#loginDialog').dialog('close');return false", 'disabled' => false)); ?>
    </div>
    <?php echo CHtml::endForm(); ?>
    <?php $this->endWidget(); ?>