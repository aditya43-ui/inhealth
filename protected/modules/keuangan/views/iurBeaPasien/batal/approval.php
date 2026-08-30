<style>
    .yellow td {
        background-color: yellow !important;
    }
    .integer-decimal, .num {
      text-align: right !important;
    }
    
</style>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'iurbeapasien-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
        'focus'=>'#instalasi_id',
)); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Transaksi <strong>Approval Batal Iur Bea Pasien</strong></div>
            </div>
            <div class="panel-body">

               
                <div class="panel panel-success panel-shadow" id="form-datakunjungan">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <span class='judul' style="float:left;">Data Kunjungan </span>
                            <?php echo CHtml::htmlButton('<i class="'.MyIcon::getIcons('ulang').'"></i>',array('class'=>'btn btn-danger btn-mini tombol','onclick'=>'setKunjunganReset();','onkeyup'=>"return $(this).focusNextInputField(event)",'rel'=>'tooltip','title'=>'Klik untuk mengulang data kunjungan','style'=>'display:none;')); ?>
                        </div>
                    </div>
                    <div class="panel-body">
                        <div class="row-fluid">
                            <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan, 'is_batal'=>1)); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">Daftar Batal Iur Biaya Pasien</div>
                    </div>
                    <div class="panel-body">
                        <?php $this->renderPartial($this->path_view . 'batal/_formBatalIurBiaya', ['form' => $form]) ?>
                    </div>
                </div>
                
                <?php $this->renderPartial($this->path_view.'batal/_jsFunctions', array('modKunjungan'=>$modKunjungan,'model'=>$model, 'is_approvebatal'=>1)); ?>
                <?php // $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'model'=>$model)); ?>
                    
            </div>
        </div>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php // echo $this->renderPartial($this->path_view."batal/_dialogBatalBea", array(), true); ?>