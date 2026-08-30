<style>
    .control-label {
        width: 120px;
    }

    .controls {
        display: inline-block;
    }
</style>

<div class="col-sm-12">
    <p style="margin: 10px 0; text-align: center;">Apakah Anda Yakin Akan Membatalkan Pemeriksaan Pasien Ini?</p>
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <div class="control-group">
        <label class="control-label">Tanggal Pembatalan <span class="required">*</span></label>
        <div class="controls">
            <?php echo CHtml::textField('tglbatal', date('Y-m-d H:i:s'), array('readonly' => true, 'class' => 'realtime span4')); ?>
        </div>
    </div>

    <div class="control-group">
        <label class="control-label">Alasan Pembatalan <span class="required">*</span></label>
        <div class="controls">
            <?php echo CHtml::textArea('keterangan_batal', '', array('placeholder' => 'Alasan Pembatalan', 'class' => 'span4',)); ?>
        </div>
    </div>

    <div class="form-actions">
        <?php
        echo CHtml::hiddenField('pendaftaran_id', '');
        echo CHtml::hiddenField('penunjang_id', '');
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'ubahPeriksaKarenaBatal();', 'type' => 'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Tidak', array('{icon}' => '<i class="entypo-cancel"></i>')), array('type' => 'button', 'onclick' => '$(\'#DialogBatalperiksa\').dialog(\'close\');', 'class' => 'btn btn-default')); ?>

        <?php
        //$content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.tips',array(),true);
        //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</div>