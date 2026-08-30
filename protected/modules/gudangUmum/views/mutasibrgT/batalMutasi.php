<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'gumutasibrg-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)'),
    'focus' => '#',
)); ?>

<!--<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Mutasi</b>
        </div>
    </div>
    <div class="panel-body">-->
<?php if (isset($modBatals)) {
    echo $form->errorSummary($modBatals);
    //   $model->alasan_pembatalan = $modBatals[0]->alasan_pembatalan;

} ?>

<div class="col-sm-6">
    <?php echo $form->textFieldRow($modMutasi, 'nomutasibrg', array('class' => 'span3', 'readonly' => true)); ?>
    <?php echo $form->textFieldRow($modMutasi, 'tglmutasibrg', array('class' => 'span3', 'readonly' => true)); ?>
    <?php echo $form->textFieldRow($modMutasi, 'ruangan_nama', array('class' => 'span3', 'readonly' => true)); ?>
</div>
<div class="col-sm-6">
    <?php //echo $form->textFieldRow($model,'barang_id',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
    ?>
    <?php echo $form->hiddenField($model, 'mutasibrg_id'); ?>
    <?php //echo $form->textFieldRow($model,'tglbatalmutasibrg',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
    ?>
    <div class="control-group">
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
                'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
            ));
            ?>
            <?php echo $form->error($model, 'tglbatalmutasibrg'); ?>
        </div>
    </div>
    <?php echo $form->textAreaRow($model, 'alasan_pembatalan', array('placeholder' => 'Alasan Pembatalan', 'rows' => 2, 'cols' => 50, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
    <?php //echo $form->textFieldRow($model,'qty_batal',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
    ?>
    <?php //echo $form->textFieldRow($model,'hargasatuan',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event);")); 
    ?>
</div>

<!--<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Detail <b>Barang</b>
        </div>
    </div>
    <div class="panel-body">-->
<table id="tableDetailBarang" class="table table-striped table-bordered table-condensed">
    <thead>
        <th>No.Urut</th>
        <!--<th>Golongan</th>
                <th>Kelompok</th>
                <th>Sub Kelompok</th>
                <th>Bidang</th>-->
        <th>Barang</th>
        <th>Jumlah Mutasi</th>
        <th>Jumlah Batal</th>
        <th>Harga Satuan (Rp)</th>
        <th>Ukuran<br>Bahan</th>
    </thead>
    <tbody>
        <?php
        $no = 1;
        if (!empty($modBatals)) {
            foreach ($modBatals as $i => $detail) :
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
                        <?php echo CHtml::activeHiddenField($models, '[barang_id][' . $i . ']mutasibrgdetail_id'); ?>
                        <?php echo CHtml::activeHiddenField($models, '[barang_id][' . $i . ']barang_id', array('class' => 'barang')); ?>
                        <?php echo $no; ?>
                    </td>
                    <!--<td><?php //echo !empty($modBarang->bidang_id)?$modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama; 
                            ?></td>
                        <td><?php //echo $modBarang->bidang->subkelompok->kelompok->kelompok_nama; 
                            ?></td>
                        <td><?php //echo $modBarang->bidang->subkelompok->subkelompok_nama; 
                            ?></td>
                        <td><?php //echo $modBarang->bidang->bidang_nama; 
                            ?></td>-->
                    <td><?php echo $modBarang->barang_nama; ?></td>
                    <td>
                        <?php echo CHtml::activeTextField($models, '[barang_id][' . $i . ']qty_mutasi', array('class' => 'span1 qty_mutasi', 'value' => $detail->qty_mutasi, 'readonly' => true)); ?>

                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($models, '[barang_id][' . $i . ']qty_batal', array('class' => 'span1 qty numbersOnly', 'value' => $detail->qty_batal, 'onblur' => 'setQty(this);')); ?>
                        <?php echo $form->error($detail, 'qty_batal'); ?>
                    </td>
                    <td>
                        <?php echo CHtml::activeTextField($models, '[barang_id][' . $i . ']hargasatuan', array('class' => 'span1', 'value' => $detail->hargasatuan)); ?>
                        <?php echo $form->error($detail, 'hargasatuan'); ?>
                    </td>
                    <td><?php echo $modBarang->barang_ukuran; ?><br><?php echo $modBarang->barang_bahan; ?></td>
                </tr>
            <?php
                $no++;

            endforeach;
        } else {

            foreach ($modDetailMutasi as $i => $detail) :
                $models = new BatalmutasibrgT();
                $models->attributes = $detail->attributes;
                $models->barang_id = $detail->barang_id;
                $models->qty_batal = $detail->qty_mutasi;
                $models->qty_mutasi = $detail->qty_mutasi;
                $models->hargasatuan = (isset($detail->inventarisasi) ? $detail->inventarisasi->inventarisasi_hargasatuan : 0);

            ?>
                <?php $modBarang = BarangM::model()->findByPk($detail->barang_id); ?>
                <tr>
                    <td>
                        <?php echo CHtml::activeHiddenField($models, '[barang_id][' . $i . ']mutasibrgdetail_id'); ?>
                        <?php echo CHtml::activeHiddenField($models, '[barang_id][' . $i . ']barang_id', array('class' => 'barang')); ?>
                        <?php echo $no; ?>
                    </td>
                    <!--<td><?php //echo $modBarang->bidang->subkelompok->kelompok->golongan->golongan_nama; 
                            ?></td>
                        <td><?php //echo $modBarang->bidang->subkelompok->kelompok->kelompok_nama; 
                            ?></td>
                        <td><?php //echo $modBarang->bidang->subkelompok->subkelompok_nama; 
                            ?></td>
                        <td><?php //echo $modBarang->bidang->bidang_nama; 
                            ?></td>-->
                    <td><?php echo $modBarang->barang_nama; ?></td>
                    <td><?php echo CHtml::activeTextField($models, '[barang_id][' . $i . ']qty_mutasi', array('class' => 'span1 qty_mutasi', 'readonly' => true)); ?></td>
                    <td><?php echo CHtml::activeTextField($models, '[barang_id][' . $i . ']qty_batal', array('class' => 'span1 qty numbersOnly', 'onblur' => 'setQty(this);')); ?></td>
                    <td><?php echo CHtml::activeTextField($models, '[barang_id][' . $i . ']hargasatuan', array('class' => 'span1')); ?></td>
                    <td><?php echo $modBarang->barang_ukuran; ?><br><?php echo $modBarang->barang_bahan; ?></td>
                </tr>
        <?php
                $no++;

            endforeach;
        }
        ?>
    </tbody>
</table>
<!--</div>
</div>-->

<div class="form-actions">
    <?php if ($model->isNewRecord) { ?>
        <?php
        if (!isset($_GET['sukses'])) {
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'id' => 'btn_submit', 'class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        } else {
            echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('title' => 'Simpan', 'class' => 'btn btn-primary', 'type' => 'button', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => true));
        }
        ?>
        <?php
        //echo CHtml::htmlButton(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-cancel"></i>')), array('type' => 'reset', 'class' => 'btn btn-default',
        //  'onclick' => '$("#dialogDetail").dialog("close");'));
        ?>
    <?php } ?>
</div>
<!--</div>
</div>-->
<?php $this->endWidget(); ?>

<?php
Yii::app()->clientScript->registerScript('onhead', '
function setQty(obj){
    qty = $(obj).val();
    qty_mutasi = $(obj).parents("tr").find(".qty_mutasi").val();
    if (qty > qty_mutasi){
        myAlert("Jumlah yang dibatal Mutasikan tidak boleh lebih besar dari mutasi");
        $(obj).val(0);
        return false;
    }
}
', CClientScript::POS_HEAD);
Yii::app()->clientScript->registerScript('onready', '
    $("form").submit(function(){
        batal = false;
        $(".qty").each(function(){
            if ($(this).val() > 0){
                batal = true;
            }
        });
        if ($("#' . CHtml::activeId($model, 'alasan_pembatalan') . '").val() == ""){
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
        
        $("#btn_submit").prop("disabled", true);
    });
', CClientScript::POS_READY); ?>

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