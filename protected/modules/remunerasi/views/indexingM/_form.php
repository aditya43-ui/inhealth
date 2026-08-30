<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>

<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'indexing-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => "return requiredCheck(this);"),
    'focus' => '#',
)); ?>

<!--<p class="help-block"><?php // echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>-->

<?php echo $form->errorSummary($model); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td>
            <?php echo $form->dropDownListRow($model, 'kelrem_id', CHtml::listData($model->getKelremItems(), 'kelrem_id', 'kelrem_nama'), array('empty' => '-- Pilih --')); ?>
            <?php echo $form->textFieldRow($model, 'indexing_nama', array('size' => 60, 'maxlength' => 100)); ?>
        </td>
        <td>
            <?php echo $form->textFieldRow($model, 'indexing_singk', array('size' => 30, 'maxlength' => 30)); ?>
            <?php echo $form->textFieldRow($model, 'indexing_urutan', array('class' => 'numbers-only', 'maxlength' => 7)); ?>
        </td>
    </tr>
    <tr>
        <td colspan="2">
            <?php echo $form->checkBoxRow($model, 'indexing_aktif'); ?>
        </td>
    </tr>
</table>

<fieldset class="box2">
    <legend class="rim">Input Nilai (offset + nilai max * (bobot/total bobot))</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php echo $form->textFieldRow($model, 'indexing_offset', array('class' => 'integer2 span2 offset', 'onblur' => 'hitungNilai()')); ?>
                <?php echo $form->textFieldRow($model, 'indexing_step', array('class' => 'integer2 span2 step', 'onblur' => 'hitungNilai()')); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model, 'indexing_totbobot', array('class' => 'integer2 span2 totbobot', 'onblur' => 'hitungNilai()')); ?>
                <?php echo $form->textFieldRow($model, 'indexing_nilai', array('class' => 'float2 span2 nilai', 'readonly' => true)); ?>
            </td>
        </tr>
    </table>
</fieldset>

<fieldset class="box2">
    <legend class="rim">Nilai Bobot</legend>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Nama', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('nama_bobot', '', array('class' => 'span3')); ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('Nilai Bobot', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('total_bobot', 0, array('class' => 'integer2 span2', 'onblur' => 'hitungSubBobot()')); ?>
                        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array(
                            'class' => 'btn btn-danger',
                            'onclick' => 'tambahBobot()',
                        )); ?>
                    </div>
                </div>
            </td>
            <td>
                <div class="control-group">
                    <?php echo CHtml::label('Nilai', '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::textField('nilai_b', 0, array('class' => 'integer2 span2 total_bobot', 'readonly' => true)); ?>
                    </div>
                </div>
            </td>
        </tr>
    </table>

    <table class="table table-condensed table-bordered" id="tab_bobot">
        <thead>
            <tr>
                <th>Nama</th>
                <th width="100">Nilai Bobot</th>
                <th width="100">Nilai Index</th>
                <th width="50">Hapus</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($det as $item) {
                echo $this->renderPartial('_rowBobot', array(
                    'offset' => $model->indexing_offset,
                    'step' => $model->indexing_step,
                    'totbobot' => $model->indexing_totbobot,
                    'det' => $item,
                ));
            } ?>
        </tbody>
    </table>
</fieldset>

<div class="form-actions">
    <?php echo CHtml::htmlButton(
        $model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
            Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        Yii::app()->createUrl($this->module->id . '/gelarBelakangM/admin'),
        array(
            'class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah Anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'
        )
    ); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Pengaturan Indexing', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')),
        $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])),
        array('class' => 'btn btn-success',)
    ); ?>
    <?php
    $content = $this->renderPartial('sistemAdministrator.views.tips.tipsaddedit', array(), true);
    $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
    ?>
</div>

<?php $this->endWidget(); ?>

<script>
    var row = '<?php echo str_replace("\n", "", $this->renderPartial('_rowBobot', array(), true)); ?>';

    function hitungNilai() {
        var offset = unformatNumber(parseFloat($(".offset").val()));
        $(".nilai").val(formatFloat(calculateNilai(1)));

        $("#tab_bobot tbody tr").each(function() {
            var bobot = unformatNumber(parseFloat($(this).find(".subbobot_nilai").val()));
            $(this).find(".subbobot_total").val(formatFloat(offset + calculateNilai(bobot)));
        });
    }

    function hitungSubBobot() {
        var nama = $("#nama_bobot").val();
        var bobot = unformatNumber(parseFloat($("#total_bobot").val()));
        var offset = unformatNumber(parseFloat($(".offset").val()));

        $("#nilai_b").val(formatFloat(offset + calculateNilai(bobot)));
    }

    function tambahBobot() {
        var nama = $("#nama_bobot").val();
        var bobot = unformatNumber(parseFloat($("#total_bobot").val()));

        $("#tab_bobot tbody").append(row);
        $("#tab_bobot tbody tr:last-child").find(".subbobot_nama").val(nama);
        $("#tab_bobot tbody tr:last-child").find(".lb").html(nama);
        $("#tab_bobot tbody tr:last-child").find(".subbobot_nilai").val(bobot);
        $("#tab_bobot tbody tr:last-child").find(".sp_nilai").html(bobot);

        $("#nama_bobot").val("");
        $("#total_bobot, #nilai_b").val(0);

        hitungNilai();
    }

    function calculateNilai(bobot) {
        //var offset = unformatNumber(parseFloat($(".offset").val()));
        var step = unformatNumber(parseFloat($(".step").val()));
        var totbobot = unformatNumber(parseFloat($(".totbobot").val()));

        return (step * (bobot / totbobot));
    }

    function removeBobot(obj) {
        myConfirm("Apakah Anda yakin untuk menghapus bobot ini?", "Perhatian!", function(r) {
            if (r) {
                $(obj).parents("tr").remove();
            }
        });
    }
</script>