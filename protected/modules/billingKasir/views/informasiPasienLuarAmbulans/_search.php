<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'action' => Yii::app()->createUrl($this->route),
    'method' => 'get',
    'id' => 'search',
    'focus' => '#' . CHtml::activeId($model, 'no_rekam_medik'),
    'type' => 'horizontal',
));
?>
<div class="row">
    <div class="col-sm-6">
        <div class="control-group">
            <?php echo CHtml::label("Tgl. Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model, 'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model, 'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'no_rekam_medik', array('placeholder' => 'No. Rekam Medik', 'class' => 'span4', 'maxlength' => 50)); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'nama_pasien', array('placeholder' => 'Nama Pasien', 'class' => 'span4', 'maxlength' => 50)); ?>
        <?php echo $form->textFieldRow($model, 'no_pendaftaran', array('placeholder' => 'No. Pendaftaran', 'class' => 'span4', 'maxlength' => 20)); ?>
    </div>
    <div class="col-sm-6">
        <?php /*
		<div class="control-group">
			<?php 
            $sp = LookupM::getItems('statusperiksa');
            unset($sp['BATAL PERIKSA'], $sp['SEDANG DIRAWAT INAP']);
            $carabayar = CarabayarM::model()->findAll(array(
                'condition'=>'carabayar_aktif = true',
                'order'=>'carabayar_nourut',
            ));
            $penjamin = PenjaminpasienM::model()->findAll(array(
                'condition'=>'penjamin_aktif = true',
                'order'=>'penjamin_nama',
            ));
            $pegawai = DokterV::model()->findAllByAttributes(array(
                'pegawai_aktif'=>true,
            ), array(
                'order'=>'nama_pegawai',
            ));
            foreach ($carabayar as $idx=>$item) {
                $penjamins = PenjaminpasienM::model()->findByAttributes(array(
                    'carabayar_id'=>$item->carabayar_id,
                    'penjamin_aktif'=>true,
               ));
               if (empty($penjamins)) unset($carabayar[$idx]);
            }
            echo $form->dropDownListRow($model,'carabayar_id', CHtml::listData($carabayar, 'carabayar_id', 'carabayar_nama'), array(
                'empty'=>'-- Pilih --',
                'class'=>'span4', 
                'ajax' => array('type'=>'POST',
                    'url'=> $this->createUrl('/actionDynamic/getPenjaminPasien',array('encode'=>false,'namaModel'=>get_class($model))), 
                    'success'=>'function(data){$("#'.CHtml::activeId($model, "penjamin_id").'").html(data); }',
                ),
             ));
            echo $form->dropDownListRow($model,'penjamin_id', CHtml::listData($penjamin, 'penjamin_id', 'penjamin_nama'), array('empty'=>'-- Pilih --', 'class'=>'span4', 'maxlength'=>50));
            ?>
            <?php echo $form->dropDownListRow($model,'ruangan_id', Chtml::listData(RuanganM::model()->findAllByAttributes(array(
                'instalasi_id'=>array(5, 6, 8), 'ruangan_aktif'=>true,
            ), array('order'=>'ruangan_nama')),'ruangan_id', 'ruangan_nama'),array('empty'=>'-- Pilih --','class'=>'span4', 'maxlength'=>20)); ?>
            <?php echo $form->dropDownListRow($model,'pegawai_id', CHtml::listData($pegawai, 'pegawai_id', 'namaLengkap'), array('empty'=>'-- Pilih --', 'class'=>'span4')); ?>
            <?php echo $form->dropDownListRow($model,'statusperiksa', $sp, array('empty'=>'-- Pilih --', 'class'=>'span4')); ?>
            <?php // echo $form->dropDownListRow($model,'statusBayar', LookupM::getItems('statusbayar'), array('empty'=>'-- Pilih --', 'class'=>'span4', 'maxlength'=>20)); ?>      
		</div>
         * 
         */ ?>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
        array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
    );
    ?>
    <?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        array(
            'title' => 'Ulang', 'class' => 'btn btn-default', 'type' => 'reset',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    $content = $this->renderPartial('laboratorium.views.tips.informasi_pencarian', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>
<?php $this->endWidget(); ?>