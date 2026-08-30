<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'sakamar-ruangan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#SAKamarRuanganM_kelaspelayanan_id',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                            ?></p>-->

<?php echo $form->errorSummary($model); ?>

<div class="col-sm-6">
    <?php echo $form->dropDownListRow(
        $model,
        'kelaspelayanan_id',
        CHtml::listData($model->KelasPelayananItems, 'kelaspelayanan_id', 'kelaspelayanan_nama'),
        array(
            'disabled' => true, 'class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)",
            'empty' => '-- Pilih Kelas Pelayanan --', 'ajax' => array(
                'type' => 'POST',
                'url' => Yii::app()->createUrl('ActionDynamic/GetRuangan', array('encode' => false, 'namaModel' => 'SAKamarRuanganM')),
                'update' => '#SAKamarRuanganM_ruangan_id'  //selector to update
            )
        )
    );
    echo $form->hiddenField($model, 'kelaspelayanan_id');
    ?>
    <?php
    echo $form->dropDownListRow($model, 'ruangan_id', CHtml::listData($model->RuanganKamarItems, 'ruangan_id', 'ruangan_nama'), array('class' => 'inputRequire', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih Ruangan --', 'disabled' => true));
    echo $form->hiddenField($model, 'ruangan_id');
    ?>
</div>

<div class="col-sm-6">
    <?php 
        if ($this->module->id != 'hemodialisa'){
            echo $form->textFieldRow($model, 'kamarruangan_nokamar', array('onkeypress' => "return $(this).focusNextInputField(event);")); 
        }
    ?>
    <?php echo $form->textFieldRow($model, 'kamarruangan_jmlbed', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 2, 'readonly' => true)); ?>
</div>

<div class="clear"></div>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>No. Bed</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <table id="tabel-kamarruangan" class="table  table-bordered ">
            <thead>
                <tr>
                    <th>No. Bed</th>
                    <th>Status</th>
                    <?php if ($this->module->id == 'hemodialisa'){ ?>
                    <th>Lantai</th>
                    <?php } ?>
                    <th></th>
                    <th></th>
                    <th></th>
                    <th><?php echo CHtml::link('<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>', 'javascript:;', array('class' => 'btn btn-primary white', 'onclick' => 'tambahBaris();', "data-toggle" => "tooltip", "data-placement" => "bottom", "title" => "", "data-original-title" => "Klik Icon ini, untuk menambahkan bed baru", "data-html" => true)); ?></th>
                </tr>
            </thead>
            <tbody>
                <?php
                if (count((array)$loadKamar) > 0) {
                    $i = 0;
                    foreach ($loadKamar as $det) {
                        $det->kamarTerpakai = ($det->kamarruangan_status == true) ? false : true;
                        //$det->pernah_dipakai = !empty(MasukkamarT::model()->find(" kamarruangan_id = ".$det->kamarruangan_id));

                        echo $this->renderPartial($this->path_view."_rowBed", array('det' => $det, 'i' => $i), true);

                        $i++;
                    }
                }
                ?>
            </tbody>
        </table>
    </div>
</div>



<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/kamarRuanganM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda yakin ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php
    echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Kamar Ruangan', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl(Yii::app()->controller->id . '/admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-info',)) . "&nbsp";
    $content = $this->renderPartial('sistemAdministrator.views.tips/tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget();

$modDet = new SAKamarRuanganM();
?>



<script>
    function tambahBaris() {
        var row = '<?php echo CJSON::encode($this->renderPartial($this->path_view.'_rowBed', array('det' => $modDet, 'i' => 0), true)); ?>';
        var jmlbed = $("#<?php echo CHtml::activeId($model, 'kamarruangan_jmlbed') ?>").val();
        $('#tabel-kamarruangan > tbody ').append(row);

        renameInputRow($("#tabel-kamarruangan"), 'banyakbed');
        if (jmlbed != '') {
            $("#<?php echo CHtml::activeId($model, 'kamarruangan_jmlbed') ?>").val(parseInt(jmlbed) + 1);
        }
        //alert('adasda');
    }

    /**
     * rename input grid
     */
    function renameInputRow(obj_table, get) {
        var row = 0;
        $(obj_table).find("tbody > tr").each(function() {
            $(this).find('input,select,textarea').each(function() { //element <input>
                var old_name = $(this).attr("name").replace(/]/g, "");
                var old_name_arr = old_name.split("[");

                if (old_name_arr.length == 4) {
                    $(this).attr("id", old_name_arr[0] + "_" + get + "_" + row + "_" + old_name_arr[3]);
                    $(this).attr("name", old_name_arr[0] + "[" + get + "][" + row + "][" + old_name_arr[3] + "]");
                }
            });
            row++;
        });
    }


    function hapusBaris(obj) {
        var jmlbed = $("#<?php echo CHtml::activeId($model, 'kamarruangan_jmlbed') ?>").val();

        myConfirm(" Apakah Anda yakin akan menghapus/membatalkan data ini?", " Perhatian ", function(r) {
            if (r) {
                if (jmlbed != '') {
                    $("#<?php echo CHtml::activeId($model, 'kamarruangan_jmlbed') ?>").val(parseInt(jmlbed) - 1);
                }
                $(obj).parents('tr').detach();
                renameInputRow($("#tabel-kamarruangan"), 'banyakbed');

            } else {
                return false;
            }
        });

    }
</script>