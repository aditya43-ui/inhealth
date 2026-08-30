<style>
    .form-horizontal .control-label{
        width: 135px !important;
    }
</style>
<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model, 'bakemajuanhasilpekerjaan_nomor', array('readonly' => true, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
        <?php echo $form->textFieldRow($model, 'nomor_beritaacara', array('readonly' => false, 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>
        <div class="control-group">
            <?php echo $form->labelEx($model, 'terminke', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'termin_terminke', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>
                <?php echo $form->hiddenField($model, 'terminke', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>
                <label> Dari </label>
                <?php echo $form->textField($model, 'termin_jumlah', array('readonly' => true, 'class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50, 'placeholder' => 'Nomor BA')); ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'bakemajuanhasilpekerjaan_tanggal', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'bakemajuanhasilpekerjaan_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker4', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'bakemajuanhasilpekerjaan_tanggal'); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'tahap_pekerjaan', array('class' => 'span1', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?>

        <div class="control-group">
            <?php echo $form->labelEx($model, 'dokumen_pendukung', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->fileField($model, 'dokumen_pendukung', array('class' => 'span3 ', 'onkeyup' => "return $(this).focusNextInputField(event);")); ?> 
                <?php
                if (!empty($model->dokumen_pendukung)) {
                    echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->bakemajuanhasilpekerjaan_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                }
                ?> 
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <hr>
    <div class="col-sm-6">

        <p><h4><b>PIHAK KESATU</b></h4></p>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'pegpihakkesatu_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->hiddenField($model, 'pegpihakkesatu_id'); ?>
                <?php
                /*
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pegpihakkesatu_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('getPegawai') . '",
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
                            $(this).val( ui.item.nama_pegawai);
                            return false;
                        }',
                        'select' => 'js:function( event, ui ) {
                            $("#' . Chtml::activeId($model, 'pegpihakkesatu_id') . '").val(ui.item.pegawai_id); 
                            $("#' . Chtml::activeId($model, 'pegpihakkesatu_nip') . '").val(ui.item.nomorindukpegawai); 
                            $("#' . Chtml::activeId($model, 'pegpihakkesatu_alamat') . '").val(ui.item.alamat_pegawai); 
                            return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span4 namaPegawai',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Ketikan nama pihak kesatu',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPihak1', 'idTombol' => 'tombolPihak1'),
                ));
                 */
                ?>
                <?php echo $form->textField($model, 'pegpihakkesatu_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Nama Pihak Kesatu')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'NIP', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'pegpihakkesatu_nip', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'NIP Pihak Kesatu')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'Alamat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'pegpihakkesatu_alamat', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Alamat Pihak Kesatu', 'rows' => 4)); ?>
            </div>
        </div>
        <?php echo $form->textFieldRow($model, 'pihakkesatu_jabatan', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 100, 'placeholder' => 'Jabatan Pihak Kesatu')); ?>

    </div>
    <div class="col-sm-6">
        <p><h4><b>PIHAK KEDUA</b></h4></p>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'supplier_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                echo $form->hiddenField($model, 'supplier_id', array('class' => 'supplier_id'));

                $supplier_nama = "";
                if (!empty($model->supplier_id)) {
                    $sup = SupplierM::model()->findByPk($model->supplier_id);
                    $supplier_nama = $sup->supplier_nama;
                }
                echo $form->textField($model, 'supplier_nama', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Nama Supplier'));
                ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'Direktur', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'direktur', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Direktur Penyedia')); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'Alamat', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textArea($model, 'alamat_penyedia', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'placeholder' => 'Alamat Penyedia', 'rows' => 4)); ?>
            </div>
        </div>
        <?php echo CHtml::activeHiddenField($model, 'total_dibulatkan', array('value' => $modSPK->total_pembulatan, 'class' => 'span3', 'readonly' => true)); ?>
    </div>
</div>

<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPihak1',
    'options' => array(
        'title' => 'Pencarian Pegawai Pihak Kesatu',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPihak1 = new PegawaiV('search');
$modPihak1->unsetAttributes();
$modPihak1->pegawai_aktif = true;
if (isset($_GET['PegawaiV'])) {
    $modPihak1->attributes = $_GET['PegawaiV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pihakkesatu-grid',
    'dataProvider' => $modPihak1->search(),
    'filter' => $modPihak1,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                "href"=>"",
                "id" => "selectObat",
                "onClick" => "
                    $(\"#' . CHtml::activeId($model, 'pegpihakkesatu_id') . '\").val(\"$data->pegawai_id\");
                    $(\"#' . CHtml::activeId($model, 'pegpihakkesatu_nama') . '\").val(\"$data->nama_pegawai\");
                    $(\"#' . CHtml::activeId($model, 'pegpihakkesatu_nip') . '\").val(\"$data->nomorindukpegawai\");
                    $(\"#' . CHtml::activeId($model, 'pegpihakkesatu_alamat') . '\").val(\"$data->alamat_pegawai\");
                    $(\"#dialogPihak1\").dialog(\"close\"); 
                    return false;
                "))',
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPihak1, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPihak1, 'jabatan_id', CHtml::listData(
                            JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'
                    ), array('empty' => '-- Pilih --')),
            'value' => function($data) {
                if (empty($data->jabatan_id))
                    return "-";
                $jabatan = JabatanM::model()->findByPk($data->jabatan_id);
                return $jabatan->jabatan_nama;
            },
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
?>
<?php
//========= Dialog untuk ....  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(
    'id' => 'dialogPenyediaBarangJasa',
    'options' => array(
        'title' => 'Penyedia Barang/Jasa',
        'autoOpen' => false,
        'modal' => true,
        'width' => 800,
        'resizable' => false,
    ),
));


$modSupplier = new ADSupplierM('search');
$modSupplier->unsetAttributes();
if (isset($_GET['ADSupplierM'])) {
    $modSupplier->attributes = $_GET['ADSupplierM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'drafter-grid',
    'dataProvider' => $modSupplier->searchDialogPenyedia(),
    'filter' => $modSupplier,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectItem",
                "onClick" => "
                    $(\".supplier_id\").val(".$data->supplier_id.");
                    $(\".supplier_nama\").val(\"".$data->supplier_nama."\");
                    setSupplier(".CJSON::encode($data->attributes).");
                    $(\"#SuratperjanjiankerjaT_nosuratperjanjiankerja\").blur();
                    $(\"#dialogPenyediaBarangJasa\").dialog(\"close\");
                    return false;"))',
        ),
        'supplier_kode',
        'supplier_nama',
        'supplier_alamat',
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
?>