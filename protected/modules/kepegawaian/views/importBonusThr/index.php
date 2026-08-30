<?php
$this->breadcrumbs = array(
    'Import Pajak THR dan Bonus',
); ?>

<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Import Pajak THR dan Bonus
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <form id="form_upload" class="form-horizontal" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Pengajuan <span style="color:red">*</span>', '', array('class' => 'control-label ')); ?>
                        <div class="controls">
                            <?php echo CHtml::dropDownList('jenisgaji', '', LookupM::getItemsUrutan('jenisgaji'), array('empty' => '-- Pilih --', 'class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event);", 'onChange' => 'changeJenisGaji(this)')); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <label class="control-label">Import File</label>
                        <div class="controls">
                            <?php echo CHtml::fileField('file_import', null, array(
                                'id' => 'file_import', 'onchange' => 'uploadFile();',
                            )) ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">Download Template :</label>
                        <div class="controls">
                            <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Download', array('{icon}' => '<i class="icon-pdf icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'button', 'onclick' => 'print()')); ?>
                        </div>
                    </div>
                </div>
            </div>

        </form>

        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'import-excel-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onSubmit' => 'return requiredCheck(this);'),
        )); ?>
        <div style="overflow: auto;">
            <table class="table table-bordered table-condensed" id="tblthr">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NIK</th>
                        <th>Masa</th>
                        <th>Tahun</th>
                        <th>Nama Pegawai</th>
                        <th>THR</th>
                        <th>Tunjangan PPh 21 THR</th>
                        <th>PPh 21 THR</th>
                        <th>THP THR</th>
                    </tr>
                </thead>
                <tbody id="tab_import">

                </tbody>
            </table>
            <table class="table table-bordered table-condensed" id="tblbonus" style="display: none;">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>NIK</th>
                        <th>Masa</th>
                        <th>Tahun</th>
                        <th>Nama Pegawai</th>
                        <th>Bonus</th>
                        <th>Tunjangan PPh 21 Bonus</th>
                        <th>PPh 21 Bonus</th>
                        <th>THP Bonus</th>
                    </tr>
                </thead>
                <tbody id="tab_importbonus">

                </tbody>
            </table>
        </div>
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit')
            );
            ?>
            <?php $this->widget('UserTips', array()); ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script>
    function simpanImport() {
        $('.integer-decimal, .float2, .integer2').each(function() {
            $(this).val(unformatNumber($(this).val()));
        });
        $('#import-excel-form').submit();
    }

    function uploadFile() {
        var jenisgaji = $('#jenisgaji').val();
        if (jenisgaji !== '') {
            var formData = new FormData();
            var file = $("#file_import").get(0).files[0];

            formData.append("file", file, file.name);
            formData.append("upload_file", true);
            formData.append("jenisgaji", jenisgaji);

            $.ajax({
                type: "POST",
                url: "<?php echo $this->createUrl('upload'); ?>",
                success: function(data) {
                    if (data.ok == 1) {
                        if (jenisgaji == 'Bonus') {
                            $('#tblbonus').find("#tab_importbonus").html(data.html);
                        } else {
                            $('#tblthr').find("#tab_import").html(data.html);
                        }
                    } else {
                        myAlert(data.msg);
                    }
                },
                error: function(error) {
                    console.log(error);
                    // handle error
                },
                async: true,
                data: formData,
                dataType: "json",
                cache: false,
                contentType: false,
                processData: false,
                timeout: 60000
            });
        } else {
            myAlert('Silakan Isi Jenis Gaji !!');
        }

    }

    function print() {
        var jenisgaji = $('#jenisgaji').val();
        if (jenisgaji !== '') {
            window.open("<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/downloadTemplate'); ?>&jenisgaji=" + jenisgaji, "", 'location=_new, width=900px, scrollbars=yes');
        } else {
            myAlert('Silakan Isi Jenis Gaji !!');
        }

    }

    function changeJenisGaji(obj) {
        if ($(obj).val() == 'Bonus') {
            $('#tblbonus').show();
            $('#tblthr').hide();
        } else {
            $('#tblthr').show();
            $('#tblbonus').hide();
        }
    }
</script>