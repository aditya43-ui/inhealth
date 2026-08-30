<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>

<table>
    <tr>
        <td><label for="tglbatal" class="control-label required">Tgl. Pembatalan <span class="required">*</span></label></td>
        <td>:</td>
        <td>
            <?php echo CHtml::textField('tglbatal', date('Y-m-d H:i:s'),array('readonly'=>true, 'class'=>'realtime')); ?>
            <br>
        </td>
    </tr>
    <tr>
        <td><label for="tglbatal" class="control-label required">Pegawai Pembatalan <span class="required">*</span></label></td>
        <td>:</td>
        <td>
            <?php 
            $namaPeg = "";
                $pegawai = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
                if(isset($pegawai)){
                    $namaPeg = $pegawai->namaLengkap;
                }
            echo CHtml::textField('pegpembatalan', $namaPeg,array('readonly'=>true)); ?>
            <br>
        </td>
    </tr>
    <tr>
        <td><label for="keterangan_batal" class="control-label required">Alasan Pembatalan <span class="required">*</span></label></td>
        <td>:</td>
        <td>
            <?php echo CHtml::textArea('keterangan_batal', ''); ?>
        </td>
    </tr>
</table>
<br>
<div class="form-actions">
    <?php 
        echo CHtml::hiddenField('fakturpembelian_id', '');        
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-primary', 'onclick'=>'ubahFakturKarenaBatal();', 'type' => 'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Batal', array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), array('type'=>'button','onclick'=>'$(\'#DialogBatalFaktur\').dialog(\'close\');','class'=>'btn btn-danger')); ?>
           			
</div>




