<?php
/**
** - digunakan sebagai informasi stok kantong darah
**  @author Aida Rahmawati <aidarahmawati@.com>
**/
?>

<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
    'action'=>Yii::app()->createUrl($this->route),
    'method'=>'get',
    'id'=>'stokkantongdarah-r-search',
    'type'=>'horizontal',
    'focus'=>'#'.CHtml::activeId($model,'nama_pegawai'),
)); 
$format = new MyFormatter();
?>

<div class="row-fluid">
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Tanggal Cetak</label>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->tgl_awal)) ?> - <?php echo date('F d, Y', strtotime($model->tgl_akhir)) ?></span>
                    <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end')) ?>
                </div>
            </div>                        
        </div>
        <div class="control-group">
            <label class="control-label"> <?php echo $form->checkBox($model,'cekTahun',array()); ?> Tahun</label>
            <div class="controls">
                <?php echo $form->dropDownList($model,'tahun', Params::getListTahun(date('Y'), 11),array('empty'=> '-- Pilih --','class' => 'span3')) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"><?php echo $form->checkBox($model,'cekBulan',array()); ?> Bulan</label>
            <div class="controls">
                <?php echo $form->dropDownList($model,'bulan', Params::getBulanTanpaTahun(),array('empty'=> '-- Pilih --','class' => 'span3')) ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group">
            <label class="control-label">Jenis Kantong Darah</label>
            <div class="controls">
                <?php echo $form->textField($model,'jeniskantongdarah_nama',array('class' => 'span3')) ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">No. Barcode Utama</label>
            <div class="controls">
                <?php echo $form->textField($model,'nomorbarcode_utama',array('class' => 'span3')) ?>
            </div>
        </div>
        
        <div class="control-group">
            <label class="control-label">No. Komponen Darah</label>
            <div class="controls">
                <?php echo $form->textField($model,'no_kantongdarah',array('class' => 'span3')) ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds','{icon} Search',array('{icon}'=>'<i class="entypo-search"></i>')),array('class'=>'btn btn-primary', 'type'=>'submit')); ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
        $this->createUrl($this->id.'/index'), 
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
