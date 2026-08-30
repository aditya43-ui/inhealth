<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-briefcase"></i> Import Pajak Jasa Dokter
        </div>
    </div>
    <div class="panel-body">
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>

        <form id="form_upload" class="form-horizontal" enctype="multipart/form-data">
            <div class="row">
                <div class="col-sm-6">
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
            <table class="table table-bordered table-condensed">
                <thead>
                    <tr>
                        <th>No.</th>
                        <th>Nik</th>
                        <th>Nama WP</th>
                        <th>Tahun</th>
                        <th>Masa</th>
                        <th>NPWP</th>
                        <th>Kode OP</th>
                        <th>Bruto</th>
                        <th>PPh 21</th>
                    </tr>
                </thead>
                <tbody id="tab_import">

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
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>

<script>
    function uploadFile() {
        var formData = new FormData();
        var file = $("#file_import").get(0).files[0];

        formData.append("file", file, file.name);
        formData.append("upload_file", true);

        $.ajax({
            type: "POST",
            url: "<?php echo $this->createUrl('upload'); ?>",
            success: function(data) {
                if (data.ok == 1) {
                    $("#tab_import").html(data.html);
                } else {
                    myAlert(data.msg);
                }
            },
            error: function(error) {
                console.log(error);
            },
            async: true,
            data: formData,
            dataType: "json",
            cache: false,
            contentType: false,
            processData: false,
            timeout: 60000
        });
    }

    function print() {
        window.open("<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/downloadTemplate'); ?>", "", 'location=_new, width=900px, scrollbars=yes');
    }
</script>