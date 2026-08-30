
<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label("Nomor Transaksi", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'notadinaspptk_nomor', array('class' => 'span3', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Nomor Nota Dinas", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'nomor_notadinas', array('class' => 'span3', 'onblur' => 'cekNomorDokumen();')); ?>
            <?php echo $form->hiddenField($model, 'mappingrekeninganggaran_id', array('class' => 'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Tanggal Nota Dinas <span class='required'>*</span>", "", array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $model,
                'attribute' => 'notadinaspptk_tanggal',
                'mode' => 'datetime',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                ),
                'htmlOptions' => array('class' => 'dtPicker3 span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                ),
            ));
            ?>
        </div>
    </div>
    <div class="control-group">
        <label class="control-label"> Keperluan </label>
        <div class="controls">
            <?php echo $form->textArea($model, 'keperluan', array('class' => 'span3', 'row' => 3)) ?>
        </div>
    </div>
</div>
<div class="col-md-6">
    <div class="control-group">
        <?php echo CHtml::label("Pejabat Pelaksana Teknis Kegiatan <span class='required'>*</span>", "", array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php
//            if (!empty($_GET['sukses'])) {
                echo $form->hiddenField($model, 'pegpptk_id', array('class' => 'span3 pegpptk_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                echo $form->textField($model, 'pegpptk_nama', array('class' => 'span3 pegpptk_nama', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
            ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Pejabat Pembuat Komitmen <span class='required'>*</span>", "", array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php echo $form->hiddenField($model, 'pegppk_id', array('class' => 'span3 required', 'readonly' => true)); ?>
            <?php echo $form->textField($model, 'pegppk_nama', array('class' => 'span3 required', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Penanggung Jawab Kegiatan <span class='required'>*</span>", "", array('class' => 'control-label required')); ?>
        <div class="controls">
            <?php
            if (!empty($_GET['sukses'])) {
                echo $form->hiddenField($model, 'pegpjk_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                echo $form->textField($model, 'pegpjk_nama', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
            } else {
                echo $form->hiddenField($model, 'pegpjk_id', array('class' => 'span3 required pegpjk_id', 'readonly' => true));
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegpjk_nama',
                    'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('AutocompletePjk') . '",
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
                        'minLength' => 3,
                        'select' => 'js:function( event, ui ) {
                                        $(this).val( ui.item.label );
                                        $(".pegpjk_id").val( ui.item.value );
                                        $(".pegpjk_jabatan").val( ui.item.pegpjk_jabatan );
                                        $(".pegpjk_unitkerja").val( ui.item.pegpjk_unitkerja );
                                        return false;
                                    }',
                    ),
                    'htmlOptions' => array(
                        'onblur' => 'if(this.value==""){$(".pegpjk_id").val("");}',
                        'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span3 required', 'placeholder' => 'Pilih Nama Pegawai'),
                    'tombolDialog' => array('idDialog' => 'dialogPjk'),
                ));
            }
            ?>
        </div>
    </div>
    <div class="control-group" id="jabatan">
        <?php echo CHtml::label("Jabatan", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'pegpjk_jabatan', array('class' => 'span3 pegpjk_jabatan', 'readonly' => true)); ?>
        </div>
    </div>
    <div class="control-group" id="unitkerja">
        <?php echo CHtml::label("Unit Kerja", "", array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo $form->textField($model, 'pegpjk_unitkerja', array('class' => 'span3 pegpjk_unitkerja', 'readonly' => true)); ?>
        </div>
    </div>
</div>

<?php
/* =========================== Dialog PPTK =========================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPptk',
    'options' => array(
        'title' => 'Pencarian Pegawai PPTK',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPPTK = new PejabatpengadaanM('searchDialogPPTK');
$modPPTK->unsetAttributes();
if (isset($_GET['PejabatpengadaanM'])) {
    $modPPTK->attributes = $_GET['PejabatpengadaanM'];
    $modPPTK->nama_pegawai = $_GET['PejabatpengadaanM']['nama_pegawai'];
    $modPPTK->nomorindukpegawai = $_GET['PejabatpengadaanM']['nomorindukpegawai'];
    $modPPTK->jabatan_nama = $_GET['PejabatpengadaanM']['jabatan_nama'];
    $modPPTK->namaunitkerja = $_GET['PejabatpengadaanM']['namaunitkerja'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pptk-grid',
    'dataProvider' => $modPPTK->searchDialogPPTK(),
    'filter' => $modPPTK,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $j = PegawaiM::model()->findByPk($data->pegawai_id);
                if (!empty($j)) {
                    $nama_pegawai = $j->nama_pegawai;
                } else {
                    $nama_pegawai = '-';
                }
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "", array("class" => "btn-small",
                            "id" => "selectPegawai",
                            "href" => "",
                            "onClick" => "
                                $('#NotadinaspptkT_pegpptk_id').val('" . $data->pegawai_id . "');
                                $('#NotadinaspptkT_pegpptk_nama').val('" . $nama_pegawai . "');
                                $('#dialogPptk').dialog('close');    
                                return false;
                            "));
            }
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPPTK, 'nomorindukpegawai'),
            'value' => '$data->pegawai->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPPTK, 'nama_pegawai'),
            'value' => '$data->pegawai->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeTextField($modPPTK, 'jabatan_nama'),
            'value' => function($data) {
                if (empty($data->pegawai->jabatan_id))
                    return "-";
                $jabatan = JabatanM::model()->findByPk($data->pegawai->jabatan_id);
                return $jabatan->jabatan_nama;
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'filter' => CHtml::activeTextField($modPPTK, 'namaunitkerja'),
            'value' => function($data) {
                $j = UnitkerjaM::model()->findByPk($data->pegawai->unitkerja_id);

                if (!empty($j)) {
                    return $j->namaunitkerja;
                } else {
                    return '-';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
/* ============================= end PPTK ============================= */


/* =========================== Dialog PJK =========================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPjk',
    'options' => array(
        'title' => 'Pencarian Pegawai PJK',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPJK = new PejabatpengadaanM('searchDialogPJK');
$modPJK->unsetAttributes();
if (isset($_GET['PejabatpengadaanM'])) {
    $modPJK->attributes = $_GET['PejabatpengadaanM'];
    $modPJK->nama_pegawai = $_GET['PejabatpengadaanM']['nama_pegawai'];
    $modPJK->nomorindukpegawai = $_GET['PejabatpengadaanM']['nomorindukpegawai'];
    $modPJK->jabatan_nama = $_GET['PejabatpengadaanM']['jabatan_nama'];
    $modPJK->namaunitkerja = $_GET['PejabatpengadaanM']['namaunitkerja'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pjk-grid',
    'dataProvider' => $modPJK->searchDialogPJK(),
    'filter' => $modPJK,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => function($data) {
                $j = PegawaiM::model()->findByPk($data->pegawai_id);
                if (!empty($j)) {
                    $nama_pegawai = $j->nama_pegawai;
                    $jabatan = $j->jabatan->jabatan_nama;
                    $unitkerja = $j->unitkerja->namaunitkerja;
                } else {
                    $nama_pegawai = '-';
                    $jabatan = '-';
                    $unitkerja = '-';
                }
                return CHtml::Link("<i class=\"icon-form-check\"></i>", "", array("class" => "btn-small",
                            "id" => "selectPegawai",
                            "href" => "",
                            "onClick" => "
                                $('#NotadinaspptkT_pegpjk_id').val('" . $data->pegawai_id . "');
                                $('#NotadinaspptkT_pegpjk_nama').val('" . $nama_pegawai . "');
                                $('#NotadinaspptkT_pegpjk_jabatan').val('" . $jabatan . "');
                                $('#NotadinaspptkT_pegpjk_unitkerja').val('" . $unitkerja . "');
                                $('#dialogPjk').dialog('close');    
                                return false;
                            "));
            }
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPPTK, 'nomorindukpegawai'),
            'value' => '$data->pegawai->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPJK, 'nama_pegawai'),
            'value' => '$data->pegawai->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'filter' => CHtml::activeTextField($modPPTK, 'jabatan_nama'),
            'value' => function($data) {
                if (empty($data->pegawai->jabatan_id))
                    return "-";
                $jabatan = JabatanM::model()->findByPk($data->pegawai->jabatan_id);
                return $jabatan->jabatan_nama;
            },
        ),
        array(
            'header' => 'Unit Kerja',
            'filter' => CHtml::activeTextField($modPPTK, 'namaunitkerja'),
            'value' => function($data) {
                $j = UnitkerjaM::model()->findByPk($data->pegawai->unitkerja_id);

                if (!empty($j)) {
                    return $j->namaunitkerja;
                } else {
                    return '-';
                }
            }
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
/* ============================= end Dialog PJK ============================= */
?>