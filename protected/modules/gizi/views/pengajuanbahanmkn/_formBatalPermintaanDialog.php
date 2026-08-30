<div class="col-sm-12">
    <p style="margin: 10px 0; text-align: center;">Apakah Anda Yakin Akan Membatalkan Permintaan Pembelian Bahan Makanan Ini?</p>
    <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                ?></p>-->
    <!--<div class="control-group">
        <?php // echo CHtml::label('Tgl. Pembatalan <span class="required">*</span>', '', array('class'=>'control-label required')) 
        ?>
        <div class="controls">
             <?php // echo CHtml::textField('tglbatal', date('Y-m-d H:i:s'),array('readonly'=>true, 'class'=>'realtime')); 
                ?>
        </div>
    </div>
    <div class="control-group">
        <?php // echo CHtml::label('Pegawai yang Membatalkan', '', array('class'=>'control-label required')) 
        ?>
        <div class="controls">
             <?php
                //            $userNama = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->NamaLengkap;
                //            echo CHtml::textField('pegawaipembatalan', $userNama,array('readonly'=>true, 'class'=>'span3')); 
                ?>
        </div>
    </div>
    <div class="control-group">
        <?php // echo CHtml::label('Alasan Pembatalan <span class="required">*</span>', '', array('class'=>'control-label required')) 
        ?>
        <div class="controls">
             <?php // echo CHtml::textArea('keterangan_batal', ''); 
                ?>
        </div>
    </div>-->

    <div class="row">
        <div class="col-sm-6">
            <div class="control-group">
                <label for="tglbatal" class="control-label required">Tanggal Pembatalan <span class="required">*</span></label>
                <div class="controls">
                    <?php echo CHtml::textField('tglbatal', date('Y-m-d H:i:s'), array('readonly' => true, 'class' => 'realtime span3')); ?>
                </div>
            </div>
            <div class="control-group">
                <label for="pegawaipembatalan" class="control-label required">Pegawai yang Membatalkan</label>
                <div class="controls">
                    <?php
                    $userNama = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'))->NamaLengkap;
                    echo CHtml::textField('pegawaipembatalan', $userNama, array('readonly' => true, 'class' => 'span3'));
                    ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <label for="keterangan_batal" class="control-label required">Alasan Pembatalan <span class="required">*</span></label>
                <div class="controls">
                    <?php echo CHtml::textArea('keterangan_batal', '', array('rows' => '4', 'placeholder' => 'Alasan Pembatalan',)); ?>
                </div>
            </div>
        </div>
    </div>

    <div class="form-actions">
        <?php
        echo CHtml::hiddenField('pengajuanbahanmkn_id', '');
        echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="' . MyIcon::getIcons('simpan') . '"></i>')),
            array('title' => 'Simpan', 'class' => 'btn btn-danger', 'onclick' => 'ubahPeriksaKarenaBatal();', 'type' => 'submit')
        ); ?>
        <?php echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-cancel"></i>')),
            array('title' => 'Ulang', 'type' => 'button', 'onclick' => '$(\'#DialogBatalPermintaan\').dialog(\'close\');', 'class' => 'btn btn-default')
        ); ?>
        <?php
        //$content = $this->renderPartial('pendaftaranPenjadwalan.views.tips.tips',array(),true);
        //$this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
        ?>
    </div>
</div>