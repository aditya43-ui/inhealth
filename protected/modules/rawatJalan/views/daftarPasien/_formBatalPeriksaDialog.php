<p style="margin: 10px 0; text-align: center;">Apakah Anda Yakin Akan Membatalkan Pemeriksaan Pasien Ini?</p>
<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->
<table>
    <tr>
        <td><label for="tglbatal" class="control-label required">Tanggal Pembatalan <span class="required">*</span></label></td>
        <td>:</td>
        <td>
            <?php echo CHtml::textField('tglbatal_rj', date('Y-m-d H:i:s'), array('readonly' => true, 'class' => 'realtime')); ?>
        </td>
    </tr>
    <tr>
        <td><label for="keterangan_batal" class="control-label required">Alasan Pembatalan <span class="required">*</span></label></td>
        <td>:</td>
        <td>
            <?php echo CHtml::textArea('keterangan_batal_rj', '',['onblur'=>'cekAlasanBatal(this);','class'=>'angkahuruf-only']); ?>
        </td>
    </tr>
</table>
<br>
<div class="form-actions">
    <?php
    echo CHtml::hiddenField('pendaftaran_id_rj', '');
    echo CHtml::htmlButton(Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')), array('class' => 'btn btn-danger', 'onclick' => 'ubahPeriksaKarenaBatal();', 'type' => 'submit')); ?>
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Tidak', array('{icon}' => '<i class="entypo-cancel-circled"></i>')), array('type' => 'button', 'onclick' => '$(\'#DialogBatalperiksa_rj\').dialog(\'close\');', 'class' => 'btn btn-danger')); ?>

    <?php
    //$content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.tips',array(),true);
    //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>

</div>