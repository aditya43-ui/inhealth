<style>
    .yellow td {
        background-color: yellow !important;
    }
    .integer-decimal{
      text-align: right;
    }
</style>

<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
        'id'=>'batalalokasidana-form',
        'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);'),//DIMATIKAN KARENA PAKAI VERIFIKASI FORM >> , 'onsubmit'=>'return requiredCheck(this);'
        'focus'=>'#instalasi_id',
)); ?>
<?php echo $form->errorSummary($modKunjungan); ?>
<?php echo $form->errorSummary($model); ?>
<div class="row">
    <div class="col-md-12">
        <div class="panel panel-gradient">
            <div class="panel-heading">
                <div class="panel-title">Transaksi <strong>Order Batal Alokasi Biaya</strong></div>
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
                    <?php echo $form->hiddenField($model, 'statusperiksa', array(
                        'readonly' => true,
                        'class' => 'span2 statusperiksa',
                        'onkeyup' => "return $(this).focusNextInputField(event);",
                        //'style'=>'font-weight: bold;', 
                    )); ?>
                        <div class="row-fluid">
                            <?php $this->renderPartial($this->path_view.'_formInfoKunjungan', array('form'=>$form,'modKunjungan'=>$modKunjungan)); ?>
                        </div>
                    </div>
                </div>
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title"><strong>Daftar Alokasi Biaya</strong></div>
                    </div>
                    <div class="panel-body">
                        <table class="table table-bordered table-condensed" id="tab_alokasi">
                            <thead>
                                <tr>
                                    <th width="50">No.</th>
                                    <th width="50">Order Batal Alokasi Biaya</th>
                                    <th width="100">Tanggal</th>
                                    <th>Uraian Tindakan</th>
                                </tr>
                            </thead>
                            <tbody>

                            </tbody>
                        </table>
                    </div>
                </div>
                
                <div class="form-actions">
                    <?php
                        if(empty($_GET['sukses'])){
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'setVerifikasi();', 'onkeypress'=>'setVerifikasi();')); //formSubmit(this,event)
                        }else{
                            echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="icon-ok icon-white"></i>')),array('class'=>'btn btn-primary', 'type'=>'button', 'onclick'=>'return false', 'onkeypress'=>'return false', 'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                        }
                    ?>
                    <?php
                        if(!isset($_GET['frame'])){
                            echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')),
                            $this->createUrl($this->id.'/index'),
                            array('class'=>'btn btn-danger',
                            'onclick'=>'return refreshForm(this);'));
                        }
                    ?>
                    
                    <?php
                        $content = $this->renderPartial($this->path_view.'tips/tipsPembayaranTagihanPasien',array(),true);
                        $this->widget('UserTips',array('type'=>'transaksi','content'=>$content));
                    ?>
                </div>
                    <?php echo $this->renderPartial($this->path_view.'_jsFunctions', array('modKunjungan'=>$modKunjungan,'model'=>$model), true); ?>
                    
            </div>
        </div>
    </div>
</div>
 <?php $this->endWidget(); ?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogRincianTagihan',
    'options' => array(
        'title' => 'Rincian Tagihan',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 1024,
        'height' => 520,
        'resizable' => true,
    ),
));
?>
<iframe src="" name="iframeRincianTagihan" id="iframeRincianTagihan" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogDetailAlokasi',
    'options' => array(
        'title' => 'Detail Order Batal Alokasi',
        'autoOpen' => false,
        'modal' => true,
        'minWidth' => 980,
        'height' => 460,
    ),
));
?>
<iframe src="" name="frameDetailAlokasi" style="width: 100%; height: 98%;"></iframe>
<?php
$this->endWidget();
?>
