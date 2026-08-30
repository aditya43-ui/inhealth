<?php

$cb_rujuk = CHtml::radioButton('rujukan', $model->rujukan == 1, array('class' => 'cb_tindaklanjut', 'value' => 1, 'data-group' => '.tindak_lanjut', 'onchange' => 'setTindakLanjut(this);'));
$cb_rujuk_luar = CHtml::radioButton('rujukan', $model->rujukan == 2, array('class' => 'cb_tindaklanjut', 'value' => 2, 'data-group' => '.rujuk_keluar', 'onchange' => 'setTindakLanjut(this);'));
$cb_pulang = CHtml::radioButton('rujukan', $model->rujukan == 3, array('class' => 'cb_tindaklanjut', 'value' => 3, 'data-group' => '.pulang', 'onchange' => 'setTindakLanjut(this);'));

?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Tindak Lanjut & Edukasi Kesehatan Pasien</div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <div class="control-group tindak_lanjut">
                    <?php echo CHtml::label($cb_rujuk . " Tindak Lanjut", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList($model, 'tindakanlanjutan', LookupM::getItems('tindakanlanjutan'), array(
                            'empty' => '-- Pilih --',
                            'class' => 'span3',
                        )); ?>
                    </div>
                </div>
                <div class="control-group rujuk_keluar">

                    <?php

                    $val = null;
                    if (!empty($model->rujukankeluar_id)) {
                        $rujuk = RujukankeluarM::model()->findByPk($model->rujukankeluar_id);
                        $val = $rujuk->rumahsakitrujukan;
                    }

                    echo CHtml::label($cb_rujuk_luar . " Dirujuk ke Rumah Sakit", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeHiddenField($model, 'rujukankeluar_id', array('id' => 'rujukankeluar_id'));
                        $this->widget('MyJuiAutoComplete', array(
                            'name' => 'rujukankeluar',
                            'value' => $val,
                            'source' => 'js: function(request, response) {
                                $.ajax({
                                url: "' . $this->createUrl('getRujukanKeluar') . '",
                                dataType: "json",
                                data: {
                                    term: request.term,
                                },
                                success: function (data) {
                                    response(data);
                                }
                            })
                        }',
                            'options' => array(
                                'showAnim' => 'fold',
                                'minLength' => 2,
                                'focus' => 'js:function( event, ui ) {
                                 $(this).val( ui.item.label);
                                 return false;
                             }',
                                'select' => 'js:function( event, ui ) {
                                 $("#dokterpenerima_id").val(ui.item.value); 
                                 console.log("selected");
                                 return false;
                             }',
                            ),
                            'htmlOptions' => array(
                                'onblur' => 'console.log("blurred")',
                                'class' => 'span3',
                            ),
                            'tombolDialog' => array(
                                'idDialog' => 'dialogRujukKeluar',
                            ),
                        ));
                        ?>

                    </div>
                </div>
                <div class="control-group pulang">
                    <?php echo CHtml::label($cb_pulang . " Dipulangkan", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList(
                            $model,
                            'dipulangkan',
                            CHtml::listData(CarakeluarM::model()->findAllByAttributes(array(
                                'carakeluar_aktif' => true,
                                'carakeluar_id' => array(1, 4),
                            )), 'carakeluar_id', 'carakeluar_nama'),
                            array(
                                'empty' => '-- Pilih --',
                                'class' => 'span3',
                            )
                        ); ?>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'dipulangkan_tgl',
                            'value' => null,
                            'mode' => 'datetime',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'onkeypress' => "return $(this).focusNextInputField(event)",
                                'class' => 'span3',
                            ),
                        ));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-6">
                <div class="control-group">
                    <?php echo CHtml::label("Edukasi Kesehatan Pasien", '', array('class' => 'control-label')); ?>
                    <div class="controls">
                        <?php echo CHtml::activeDropDownList($model, 'edukasipasien', LookupM::getItems('edukasipasien'), array(
                            'id' => 'edukasipasien', 'multiple' => 'multiple'
                        )); ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<?php
//=============================== Dialog DPJP =======================================
$this->beginWidget(
    'zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogRujukKeluar',
        'options' => array(
            'title' => 'Rujukan Keluar',
            'autoOpen' => false,
            'width' => 840,
            'height' => 420,
            'resizable' => true,
        ),
    )
);

$format = new MyFormatter();
$rujukan = new RujukankeluarM('search');
$rujukan->unsetAttributes();
$rujukan->rujukankeluar_aktif = true;
if (isset($_GET['RujukankeluarM'])) {
    $rujukan->attributes = $_GET['RujukankeluarM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'dialog-dpjp-m-grid',
    'dataProvider' => $rujukan->search(),
    'filter' => $rujukan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function ($data) {
                return CHtml::Link('<i class="icon-form-check"></i>', "#", array(
                    "class" => "btn-small",
                    "onclick" => " setRujukan('" . $data->rumahsakitrujukan . "'," . $data->rujukankeluar_id . "); return false; "
                ));
            },
        ),
        array(
            'name' => 'rumahsakitrujukan',
            // 'filter'=>  CHtml::listData(PPPendaftaranT::model()->getDokterItems(), 'pegawai_id', 'nama_pegawai'),
            'value' => '$data->rumahsakitrujukan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget('zii.widgets.jui.CJuiDialog');
//=============================== END DPJP =======================================
?>

<script>
    function setRujukan(nama, id) {
        $("#rujukankeluar_id").val(id);
        $("#rujukankeluar").val(nama);

        $("#dialogRujukKeluar").dialog("close");
    }

    function setTindakLanjut(obj) {
        var group = $(obj).data('group');
        $(".cb_tindaklanjut").parents(".control-group").find(".controls :input").val("").prop("disabled", true).prop("readonly", true);
        $(group).find(".controls :input").prop("disabled", false).prop("readonly", false);
    }

    $(document).ready(function() {
        $(".cb_tindaklanjut").each(function() {
            if (!$(this).is(":checked")) {
                $(this).parents(".control-group").find(".controls :input").val("").prop("disabled", true).prop("readonly", true);
            }
        });
    });
</script>