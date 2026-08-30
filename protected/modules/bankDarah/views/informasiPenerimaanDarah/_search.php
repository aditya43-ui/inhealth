<?php
/**
* - digunakan sebagai informasi penerimaan kantong darah
* @author : Elham Budianto
* @email : elhambudianto1@gmail.com
* @wiki : ..
**/
?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'penerimaankantongdarah-r-search',
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'nama_pegawai'),
)); 
$format = new MyFormatter();
?>

<?php //echo $form->textFieldRow($model,'pelamar_id',array('class'=>'span5')); ?>

<div class="row-fluid">
    <div class="col-md-6">
        <div class="row">
            <div class="control-group">
                <div class="col-md-4">
                <?php echo CHtml::label("Waktu Penerimaan",'dari_tanggal', array('class' => 'control-label')) ?>
                </div>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                        <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                    </div>
                </div>
            </div>
        </div>    
        <div class="row">
            <div class = "control-group">
                <div class="col-md-4">
                <?php echo Chtml::label("Nomor Pengiriman",'no_terimakantong', array('class'=>'control-label')) ?>
                </div>
                <div class = "controls">
                    <?php echo $form->textField($model,'no_kirimkantong',array('placeholder'=>'Ketik Nomor Kirim Kantong Darah')) ?>
                </div>
            </div>
        </div>    
    </div>
    <div class="col-md-6">
        <div class="row">
            <div class = "control-group">
                <div class="col-md-4">
                        <?php echo Chtml::label("Ruangan Asal",'', array('class'=>'')) ?>
                </div>
                <div class = "controls col-md-2" >
                    <?php //echo $form->dropDownListRow($model, 'bidang_id', CHtml::listData(BidangM::model()->findAll(), 'bidang_id', 'bidang_nama'), array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --')); 
                    $creteria=new CDbCriteria;
                    $creteria->join="join instalasi_m inl on inl.instalasi_id=t.instalasi_id";


                    echo $form->dropDownList($model,'ruangankirim_id', CHtml::listData(RuanganM::model()->findAll($creteria), 'ruangan_id', 'ruangan_nama'), array(
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
        </div>
        <div class="row">
            <div class = "control-group">
                <div class="col-md-4">
                    <?php echo Chtml::label("Nama Petugas Penerima",'', array('class'=>'')) ?>
                </div>
                <div class = "controls col-md-2">  
                    <?php 
                   $criteria=new CDbCriteria();
                   $criteria->addCondition("ruangan_id=".Yii::app()->user->getState('ruangan_id'));
                    echo $form->dropDownList($model,'pegawaiterima_id', CHtml::listData(PegawairuanganV::model()->findAll($criteria), 'pegawai_id', 'nama_pegawai'),array('empty'=>'-- Pilih --')) ?>
                </div>
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
