<p style="margin: 10px 0; text-align: center;">Apakah Anda Yakin Akan Membatalkan Pemeriksaan Pasien Ini?</p>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<table>
    <tr>
        <td><?php echo CHtml::label('Tgl. Batal <span class="required">*</span>', '', array('class' => 'control-label required')); ?></td>
        <td>
            <?php echo CHtml::textField('tglbatal', date('Y-m-d H:i:s'), array('class' => 'span3', 'readonly' => true)); ?>
        </td>
    </tr>
    <tr>
        <td><label for="keterangan_batal" class="control-label required">Alasan Pembatalan <span class="required">*</span></label></td>
        <td>
            <?php echo CHtml::textArea('keterangan_batal', '', array('class' => 'span3')); ?>
        </td>
    </tr>
    <tr>
        <td><?php echo CHtml::label('Nama Pemakai', 'username', array('class' => 'control-label')) ?></td>
        <td>
            <?php echo CHtml::textField('username', '', array('class' => 'span3')); ?>
        </td>
    </tr>
    <tr>
        <td><?php echo CHtml::label('Kata Kunci', 'password', array('class' => 'control-label')) ?></td>
        <td>
            <?php echo CHtml::passwordField('password', '', array('class' => 'span3')); ?>
        </td>
    </tr>
</table>
<div class="form-actions">
    <?php
    echo CHtml::hiddenField('pendaftaran_id', '');
    echo CHtml::hiddenField('statusperiksa', '');
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'batalperiksa();', 'type' => 'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Tidak', array('{icon}' => '<i class="entypo-cancel"></i>')), array('type' => 'button', 'onclick' => '$(\'#DialogBatalperiksa\').dialog(\'close\');', 'class' => 'btn btn-danger')); ?>
</div>

