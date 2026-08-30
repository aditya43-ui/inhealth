<div class="row">
    <div class="col-sm-12">
        
<center>Apakah Anda Yakin Akan Membatalkan Permintaan Pembelian Barang Ini?</center>
<p class="help-block"><?php echo Yii::t('mds','Fields with <span class="required">*</span> are required.') ?></p>
<!--    <div class="control-group">
        <?php // echo CHtml::label('Tanggal Pembatalan <span class="required">*</span>', '', array('class'=>'control-label required')) ?>
        <div class="controls">
             <?php // echo CHtml::textField('tglbatal', date('Y-m-d H:i:s'),array('readonly'=>true, 'class'=>'realtime')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php // echo CHtml::label('Pegawai yang Membatalkan', '', array('class'=>'control-label required')) ?>
        <div class="controls">
             <?php 
//            $userNama = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->NamaLengkap;
//            echo CHtml::textField('pegawaipembatalan', $userNama,array('readonly'=>true, 'class'=>'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php // echo CHtml::label('Alasan Pembatalan <span class="required">*</span>', '', array('class'=>'control-label required')) ?>
        <div class="controls">
             <?php // echo CHtml::textArea('keterangan_batal', ''); ?>
        </div>
    </div>-->


<table>
    <tr class="control-group">
        <td><label for="tglbatal" class="control-label required">Tanggal Pembatalan <span class="required">*</span></label></td>
        <td>:</td>
        <td>
            <?php echo CHtml::textField('tglbatal', date('Y-m-d H:i:s'),array('readonly'=>true, 'class'=>'realtime')); ?>
        </td>
    </tr>
    <tr class="control-group">
        <td><label for="pegawaipembatalan" class="control-label required">Pegawai yang Membatalkan</label></td>
        <td>:</td>
        <td>
            <?php 
            $userNama = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->NamaLengkap;
            echo CHtml::textField('pegawaipembatalan', $userNama,array('readonly'=>true, 'class'=>'span3')); ?>
        </td>
    </tr>
    <tr class="control-group">
        <td><label for="keterangan_batal" class="control-label required">Alasan Pembatalan <span class="required">*</span></label></td>
        <td>:</td>
        <td>
            <?php echo CHtml::textArea('keterangan_batal', ''); ?>
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php 
        echo CHtml::hiddenField('terimapersediaan_id', '');        
        echo CHtml::htmlButton(Yii::t('mds', '{icon} Ya', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-primary', 'onclick'=>'ubahPeriksaKarenaBatal();', 'type' => 'submit')); ?>
        <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Batal', array('{icon}'=>'<i class="icon-ban-circle icon-white"></i>')), array('type'=>'button','onclick'=>'$(\'#DialogBatalPermintaan\').dialog(\'close\');','class'=>'btn btn-danger')); ?>
           			
<?php 
//$content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.tips',array(),true);
//$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); ?>	
		
</div>
   </div>
</div>



