<?php
/**
* - digunakan sebagai informasi pengiriman kantong darah
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'pengirimankantongdarah-r-search',
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'nama_pegawai'),
)); 
$format = new MyFormatter();
?>

<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">		
            <?php echo CHtml::label("Waktu Pengiriman",'dari_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nomor Pengiriman",'no_kirimkantong', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model,'no_kirimkantong',array('placeholder'=>'Ketik Nomor Kirim Kantong Darah')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class = "control-group">
            <?php echo Chtml::label("Ruangan Asal",'ruangankirim_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php //echo $form->dropDownListRow($model, 'bidang_id', CHtml::listData(BidangM::model()->findAll(), 'bidang_id', 'bidang_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); 
                echo $form->dropDownList($model,'ruangankirim_id', CHtml::listData(RuanganM::model()->findAllByAttributes(array('instalasi_id'=>Yii::app()->user->getState('instalasi_id'))), 'ruangan_id', 'ruangan_nama'), array(
				'empty'=>'-- Pilih --',
				//'class'=>'span3', 
				'ajax' => array('type'=>'POST',
					'url'=> $this->createUrl('/actionDynamic/getPegawaiRuangan',array('encode'=>false,'namaModel'=>get_class($model))), 
					'success'=>'function(data){$("#'.CHtml::activeId($model, "petugaskirim_id").'").html(data); }',
				),
			 ));
        ?>
            </div>
        </div>
        <div class = "control-group">
            <?php echo Chtml::label("Nama Petugas",'petugaskirim_id', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->dropDownList($model,'petugaskirim_id', CHtml::listData(PegawaiM::model()->findAll(), 'pegawai_id', 'pegawai_nama'),array('empty'=>'-- Pilih --')) ?>
            </div>
        </div>
    </div>
</div>

<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/indexPribadi'), 
        array('class'=>'btn btn-danger',
            'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;')); ?>
    <?php
        $tips = array(
            '0' => 'tanggal',
            '1' => 'cari',
            '2' => 'ulang'
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips',array('tips'=>$tips),true);
        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content)); 
    ?>
</div>

<?php $this->endWidget(); ?>
