<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'isiinformasi-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return requiredCheck(this);'),
    'focus' => '#',
)); ?>

<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>

<?php echo $form->errorSummary($model); ?>

<?php

$res_list = array(
    'data' => array(),
    'option' => array(),
);

if (empty($model->jenissurat_id)) {
    $mlist = JenisinformasiM::model()->findAllByAttributes(array(
        'jenisinformasi_aktif' => true
    ), array(
        'order' => 'jenisinformasi_urutan'
    ));
    $list = CHtml::listData(JenisinformasiM::model()->findAllByAttributes(array(
        'jenisinformasi_aktif' => true
    ), array(
        'order' => 'jenisinformasi_urutan'
    )), 'jenisinformasi_id', 'jenisinformasi_nama');
} else {
    $mlist = JenisinformasiM::model()->findAllByAttributes(array(
        'jenisinformasi_aktif' => true
    ), array(
        'order' => 'jenisinformasi_urutan'
    ));
    $list = CHtml::listData(JenisinformasiM::model()->findAllByAttributes(array(
        'jenissurat_id' => $model->jenissurat_id,
        'jenisinformasi_aktif' => true
    ), array(
        'order' => 'jenisinformasi_urutan'
    )), 'jenisinformasi_id', 'jenisinformasi_nama');
}

foreach ($mlist as $item) {
    $res_list['data'][$item->jenisinformasi_id] = $item->jenisinformasi_nama;
    $res_list['option'][$item->jenisinformasi_id]['data-tipe'] = $item->tipeinput_isiinformasi;
}

?>

<div class="row">
    <div class="col-sm-3">
        <?php echo $form->dropDownListRow(
            $model,
            'jenissurat_id',
            CHtml::listData(JenisSuratM::model()->findAll('jenissurat_aktif = true order by jenissurat_nama asc'), 'jenissurat_id', 'jenissurat_nama'),
            array(
                'empty' => '-- Pilih --', 'class' => 'span3 jenissurat_id',
                'ajax' => array(
                    'type' => 'POST',
                    'url' => $this->createUrl('setDropDownJenisInformasi', array('encode' => false, 'namaModel' => get_class($model))),
                    'update' => '#' . CHtml::activeId($model, 'jenisinformasi_id')
                ),
            )
        ); ?>
        <?php echo $form->dropDownListRow($model, 'jenisinformasi_id', $res_list['data'], array('empty' => '-- Pilih --', 'class' => 'span3 jenisinformasi_id', 'options' => $res_list['option'], 'onchange' => 'setJenisInput();')); ?>
        <div class="control-group">
            <label class="control-label">Tipe Input Isi Informasi</label>
            <div class="controls">
                <?php echo CHtml::textField('tipe_input', empty($model->jenisinformasi) ? null : $model->jenisinformasi->tipeinput_isiinformasi, array(
                    'readonly' => true, 'class' => 'span3'
                )); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-9">
        <?php if (!$model->isNewRecord) : ?>
            <div class="control-group">
                <label class="control-label"></label>
                <div class="controls">
                    <?php echo $form->checkBox($model, 'isiinformasi_aktif'); ?><label> Aktif</label>
                </div>
            </div>
        <?php endif; ?>

    </div>
</div>


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Isi Informasi</div>
    </div>
    <div class="panel-body">
        <div class="informasi_input_biasa informasi_panel">
            <?php echo CHtml::textArea('sample_text', '', array('readonly' => true)); ?>
        </div>
        <div class="informasi_penjelasan informasi_panel">
            <?php $this->widget('ext.redactorjs.Redactor', array('model' => $model, 'attribute' => 'isiinformasi_nama', 'toolbar' => 'mini', 'height' => '200px')) ?>
        </div>
        <div class="informasi_checkbox informasi_panel">
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>Informasi Sebelum Checkbox</th>
                        <th>Label Checkbox</th>
                        <th>Urutan</th>
                        <th>Informasi Sesudah Checkbox</th>
                        <th><?php echo CHtml::htmlButton('<i class="glyphicon glyphicon-plus"></i>', array('class' => 'btn btn-success', 'onclick' => 'tambahRowCheckbox();')); ?></th>
                    </tr>
                </thead>
                <tbody id="tab_checkbox_list"></tbody>
            </table>
        </div>
    </div>
</div>


<div class="form-actions">
    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')); ?>
    <?php echo CHtml::link(
        Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
        $this->createUrl('create'),
        array(
            'class' => 'btn btn-danger',
            'onclick' => 'return refreshForm(this);'
        )
    ); ?>
    <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Isi Informasi', array('{icon}' => '<i class="icon-folder-open icon-white"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
    <?php $this->widget('UserTips', array('content' => '')); ?>
</div>
</div>
<?php $this->endWidget(); ?>


<script>
    var row = <?php echo CJSON::encode(array('row' => $this->renderPartial($this->path_view . '_rowCekbox', array('model' => IsiinformasiM::model()), true))); ?>;

    function loadDataPenjelasan() {
        var id = $(".jenisinformasi_id").val();
        $(".informasi_penjelasan").show();
        $(".informasi_penjelasan :input").not("button").prop("disabled", false);
        $.post('<?php echo $this->createUrl('loadInformasiPenjelasan'); ?>', {
            id: id
        }, function(data) {
            $("#IsiinformasiM_isiinformasi_nama").setCode(data.isi);
        }, 'json');
    }

    function loadDataInputPasien() {
        $(".informasi_input_biasa").show();
        $(".informasi_input_biasa :input").not("button").prop("disabled", false);
    }

    function loadDataCekBox() {
        var id = $(".jenisinformasi_id").val();
        $(".informasi_checkbox").show();
        $.post('<?php echo $this->createUrl('loadInformasiCekBox'); ?>', {
            id: id
        }, function(data) {
            $("#tab_checkbox_list").append(data.html);
            $("#tab_checkbox_list .isiinformasi_urutan").maskMoney({
                "symbol": "",
                "defaultZero": true,
                "allowZero": true,
                "decimal": ".",
                "thousands": "",
                "precision": 0
            });
            renameCheckBoxTab();
        }, 'json');
    }

    function tambahRowCheckbox() {
        console.log(row.row);
        $("#tab_checkbox_list").append(row.row);

        var last = $("#tab_checkbox_list tr:last");
        console.log("Last", $(last).find(".isiinformasi_urutan"));
        $(last).find(".isiinformasi_urutan").maskMoney({
            "symbol": "",
            "defaultZero": true,
            "allowZero": true,
            "decimal": ".",
            "thousands": "",
            "precision": 0
        });
        renameCheckBoxTab();
    }

    function renameCheckBoxTab() {
        var cnt = 0;
        $("#tab_checkbox_list tr").each(function() {
            $(this).find(".infosebelumcheckbox").prop("name", "detail[" + cnt + "][infosebelumcheckbox]");
            $(this).find(".isiinformasi_nama").prop("name", "detail[" + cnt + "][isiinformasi_nama]");
            $(this).find(".isiinformasi_urutan").prop("name", "detail[" + cnt + "][isiinformasi_urutan]");
            $(this).find(".infosetelahcheckbox").prop("name", "detail[" + cnt + "][infosetelahcheckbox]");
            cnt++;
        });
    }


    function setJenisInput() {
        var tipe = $(".jenisinformasi_id :selected").data('tipe');

        $("#tipe_input").val(tipe);

        $(".informasi_panel").hide();
        $(".informasi_panel :input").not("button").val("").prop("disabled", true);
        $("#tab_checkbox_list").empty();

        console.log("Tipe", tipe);

        if (tipe == "CHECKBOX") {
            loadDataCekBox();
        } else if (tipe == "PENJELASAN TETAP") {
            loadDataPenjelasan();
        } else if (tipe == "DIINPUT OLEH USER") {
            loadDataInputPasien();
        }
    }

    function hapusRowCheckbox(obj) {
        $(obj).parents("tr").remove();
    }

    $(document).ready(function() {
        $(".jenissurat_id").on('change', function() {
            $(".jenisinformasi_id").val("");
            setJenisInput();
        });

        setJenisInput();
    });
</script>