<div class="row">
    <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
        'action' => Yii::app()->createUrl($this->route),
        'method' => 'get',
        'id' => 'aspembklaimpiutang-t-search',
        'type' => 'horizontal',
        'focus' => '#' . CHtml::activeId($model, 'nokaskeluar'),
    )); ?>
    <div class="col-sm-6">
        <div class="control-group">
            <?php // $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); 
            ?>
            <?php
            //var_dump($model->tgl_awal, $model->tgl_akhir); die;
            echo CHtml::label('Tgl. Pembayaran Klaim', 'tglPembayaran', array('class' => 'control-label inline')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'nopembayaranklaim', array('class' => 'angkahuruf-only span4', 'placeholder' => 'No. Pembayaran Klaim')); ?>
    </div>
    <div class="col-sm-6">
        <?php /*
    <div class="control-group">
        <?php echo CHtml::label('Jenis Penjamin',' Jenis Penjamin', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php echo $form->dropDownList($model,'carabayar_id', CHtml::listData($model->getCaraBayarItems(), 'carabayar_id', 'carabayar_nama') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",
                    'ajax' => array('type'=>'POST',
                        'url'=> $this->createUrl('GetPenjaminPasien',array('encode'=>false,'namaModel'=>'ARInformasipengajuanklaimpiutangV')),
                        'update'=>'#ARInformasipengajuanklaimpiutangV_penjamin_id'  //selector to update
                    ),
             )); ?>
        </div>
    </div>
     *
     */ ?>
        <div class="control-group">
            <?php echo CHtml::label('Penjamin', ' penjamin_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'penjamin_id', CHtml::listData($model->getPenjaminItems(), 'penjamin_id', 'penjamin_nama'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Status', ' Status Pembayaran', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'statusbayar', array(1 => 'BELUM LUNAS', 2 => 'LUNAS'), array('empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)",)); ?>
            </div>
        </div>
        <!--<div class="control-group">
        <?php //echo CHtml::label('Operator',' Operator', array('class'=>'control-label')) 
        ?>
        <div class="controls">
            <?php //echo $form->dropDownList($model,'pegawai_id', CHtml::listData($model->getPegawaiRuanganItems(), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",)); 
            ?>
        </div>
    </div>-->
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Cari', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    ); ?>
    <?php
    echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/barangM/admin'),
        array(
            'title' => 'Ulang',
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    );
    ?>
    <?php
    $tips = array(
        '0' => 'tanggal',
        '1' => 'detail',
        '2' => 'batal',
        '3' => 'cari',
        '4' => 'ulang2'
    );
    $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>