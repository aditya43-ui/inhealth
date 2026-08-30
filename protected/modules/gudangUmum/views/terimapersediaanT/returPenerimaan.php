<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js'); ?>
<?php $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'gumutasibrg-t-form',
	'enableAjaxValidation'=>false,
        'type'=>'horizontal',
        'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event)'),
        'focus'=>'#',
)); ?>

<legend>Data Mutasi</legend>
<?php echo $form->textFieldRow($model, 'noreturterima', array('class'=>'span3', 'readonly'=>true)); ?>
<?php echo $form->textFieldRow($model, 'tglreturterima', array('class'=>'span3', 'readonly'=>true)); ?>
<?php echo $form->textFieldRow($model, 'ruangan_nama', array('class'=>'span3', 'readonly'=>true)); ?>
 <?php //echo $form->textFieldRow($model,'barang_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php echo $form->hiddenField($model,'mutasibrg_id'); ?>
            <?php //echo $form->textFieldRow($model,'tglbatalmutasibrg',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <div class="control-group ">
                <?php echo $form->labelEx($model, 'tglbatalmutasibrg', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tglbatalmutasibrg',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'maxDate' => 'd',
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                    ));
                    ?>
                    <?php echo $form->error($model, 'tglbatalmutasibrg'); ?>
                </div>
            </div>
            <?php echo $form->textAreaRow($model,'alasan_pembatalan',array('rows'=>2, 'cols'=>50, 'class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'qty_batal',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
            <?php //echo $form->textFieldRow($model,'hargasatuan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
<legend>Detail Barang</legend>
<table id="tableDetailBarang" class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No.Urut</th>
        <th>Golongan</th>
        <th>Kelompok</th>
        <th>Sub Kelompok</th>
        <th>Bidang</th>
        <th>Barang</th>
        <th>Jumlah Mutasi</th>
        <th>Jumlah Batal</th>
        <th>Harga Satuan</th>
        <th>Ukuran<br/>Bahan</th>
    </thead>
    <tbody>
    <?php
    $no=1;
    if (isset($modBatals)){
        foreach($modBatals AS $i=>$detail): 
            $models = new BatalmutasibrgT();
        $models->attributes = $detail->attributes;
//            $models->hargasatuan 
            $models->barang_id = $detail->barang_id;
            $models->qty_batal = $detail->qty_batal;
            $models->qty_mutasi = $detail->qty_mutasi;
            ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr>   
                <td>
                <?php echo CHtml::activeHiddenField($models, '[barang_id]['.$i.']mutasibrgdetail_id');?>
                <?php echo CHtml::activeHiddenField($models, '[barang_id]['.$i.']barang_id', array('class'=>'barang'));?>
                <?php echo $no; ?>
                </td>
                <td><?php echo $modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama; ?></td>
                <td><?php echo $modBarang->bidang->subkelompok->kelompok->kelompok_nama; ?></td>
                <td><?php echo $modBarang->bidang->subkelompok->subkelompok_nama; ?></td>
                <td><?php echo $modBarang->bidang->bidang_nama; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td>
                <?php echo CHtml::activeTextField($models, '[barang_id]['.$i.']qty_mutasi', array('class'=>'span1 qty_mutasi', 'value'=>$detail->qty_mutasi, 'readonly'=>true)); ?>
                
                </td>
                <td>
                <?php echo CHtml::activeTextField($models, '[barang_id]['.$i.']qty_batal', array('class'=>'span1 qty numbersOnly', 'value'=>$detail->qty_batal, 'onblur'=>'setQty(this);')); ?>
                <?php echo $form->error($detail, 'qty_batal'); ?>
                </td>
                <td>
                <?php echo CHtml::activeTextField($models, '[barang_id]['.$i.']hargasatuan', array('class'=>'span1', 'value'=>$detail->hargasatuan, 'readonly'=>true)); ?>
                <?php echo $form->error($detail, 'hargasatuan'); ?>
                </td>
                <td><?php echo $modBarang->barang_ukuran; ?><br/><?php echo $modBarang->barang_bahan; ?></td>
            </tr>   
            <?php 
        $no++;
        
        endforeach;
    }
    else{
    
        foreach($modDetailMutasi AS $i=>$detail): 
            $models = new BatalmutasibrgT();
            $models->attributes = $detail->attributes;
            $models->barang_id = $detail->barang_id;
            $models->qty_batal = $detail->qty_mutasi;
            $models->qty_mutasi = $detail->qty_mutasi;
            $models->hargasatuan = $detail->inventarisasi->inventarisasi_hargasatuan;
            
            ?>
        <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
            <tr>   
                <td>
                <?php echo CHtml::activeHiddenField($models, '[barang_id]['.$i.']mutasibrgdetail_id');?>
                <?php echo CHtml::activeHiddenField($models, '[barang_id]['.$i.']barang_id', array('class'=>'barang'));?>
                <?php echo $no; ?>
                </td>
                <td><?php echo $modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama; ?></td>
                <td><?php echo $modBarang->bidang->subkelompok->kelompok->kelompok_nama; ?></td>
                <td><?php echo $modBarang->bidang->subkelompok->subkelompok_nama; ?></td>
                <td><?php echo $modBarang->bidang->bidang_nama; ?></td>
                <td><?php echo $modBarang->barang_nama; ?></td>
                <td><?php echo CHtml::activeTextField($models, '[barang_id]['.$i.']qty_mutasi', array('class'=>'span1 qty_mutasi','readonly'=>true )); ?></td>
                <td><?php echo CHtml::activeTextField($models, '[barang_id]['.$i.']qty_batal', array('class'=>'span1 qty numbersOnly', 'onblur'=>'setQty(this);')); ?></td>
                <td><?php echo CHtml::activeTextField($models, '[barang_id]['.$i.']hargasatuan', array('class'=>'span1', 'readonly'=>true)); ?></td>
                <td><?php echo $modBarang->barang_ukuran; ?><br/><?php echo $modBarang->barang_bahan; ?></td>
            </tr>   
            <?php 
        $no++;
        
        endforeach;
    }
    ?>
    </tbody>
</table>

<div class="form-actions">
                <?php if ($model->isNewRecord) { ?>
                    <?php
                    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="icon-ok icon-white"></i>')) :
                                    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
                    ?>
                    <?php
                    echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="icon-ban-circle icon-white"></i>')), array('type' => 'reset', 'class' => 'btn btn-danger',
                        'onclick' => 'if(!confirm("' . Yii::t('mds', 'Do You want to cancel?') . '")) return false;'));
                    ?>
                <?php } ?>
            </div>
<?php $this->endWidget(); ?>
<?php
Yii::app()->clientScript->registerScript('onhead','
function setQty(obj){
    qty = $(obj).val();
    qty_mutasi = $(obj).parents("tr").find(".qty_mutasi").val();
    if (qty > qty_mutasi){
        myAlert("Jumlah yang dibatal Mutasikan tidak boleh lebih besar dari mutasi");
        $(obj).val(0);
        return false;
    }
}
',CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('onready','
    $("form").submit(function(){
        batal = false;
        $(".qty").each(function(){
            if ($(this).val() > 0){
                batal = true;
            }
        });
        if ($("#'.CHtml::activeId($model,'alasan_pembatalan').'").val() == ""){
            myAlert("Alasan Pembatalan Barang Harus Diisi");
            return false;
        }
        else if ($(".barang").length < 1){
            myAlert("Detail Barang Harus Diisi");
            return false;
        }
        else if (batal == false){
            myAlert("Jumlah batal mutasi harus memiliki value yang lebih dari 0");
            return false;
        }
    });
',CClientScript::POS_READY);?>

<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.numbersOnly',
    'config' => array(
        'defaultZero' => true,
        'allowZero' => true,
        'decimal' => ',',
        'thousands' => '',
        'precision' => 0,
    )
));
?>