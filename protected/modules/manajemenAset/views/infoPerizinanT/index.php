<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'invperizinan-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('enctype' => 'multipart/form-data', 'onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);', 'onkeyup' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : '', 'onclick' => (!isset($_GET['sukses'])) ? 'cekDisabled(this);' : ''),
    'focus' => '#',
        ));
?>    

<div class="row-fluid">
    <div class="span6">
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'invperizinan_no', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'invperizinan_no', array('placeholder'=>'Ketik No. Perizinan','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
            <?php echo $form->labelEx($model, 'invperizinan_tgl', array('class' => 'control-label')) ?>
            <div class="controls">
                <div class="daterange daterange-inline input-inline" data-format="MMMM D, YYYY" data-start-date="<?php echo date('F d, Y', strtotime($model->invperizinan_tgl)) ?>" data-end-date="<?php echo date('F d, Y', strtotime($model->invperizinan_sdtgl)) ?>">
                    <i class="entypo-calendar"></i>
                    <span ><?php echo date('F d, Y', strtotime($model->invperizinan_tgl)) ?> - <?php echo date('F d, Y', strtotime($model->invperizinan_sdtgl)) ?></span>
                    <?php echo $form->hiddenField($model,'invperizinan_tgl', array('class' => 'start')) ?>
                    <?php echo $form->hiddenField($model,'invperizinan_sdtgl', array('class' => 'end')) ?>
                </div>
            </div>
        </div>
    </div>
    <div class="span6">
        <div class="control-group ">
                <?php echo $form->labelEx($model, 'pelaksana_id', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'pelaksana',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                url: "' . Yii::app()->createUrl('ActionAutoComplete/Pegawairiwayat') . '",
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
                        'focus' => 'js:function( event, ui ) {
                                    $(this).val( ui.item.label);
                                    return false;
                            }',
                        'select' => 'js:function( event, ui ) {
                                        setPelaksana(ui.item);
                                    return false;
                            }',
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'class' => 'span3 custom-only', 'placeholder'=>'Ketik Nama Pelaksana',
                            'id'=>'nama_pegawai',
                        ),
                        'tombolDialog' => array(
                            'idDialog' => 'dialogPegawai',
                        ),
                    ));
                ?>
                <?php echo $form->error($model, 'pelaksana_id'); ?>
                <?php echo $form->hiddenField($model, 'pelaksana_id', array('id' => 'pelaksana_id')); ?>
            </div>
        </div>
        <div class="control-group ">
                <?php echo $form->labelEx($model, 'invperizinan_ket', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->textField($model, 'invperizinan_ket', array('placeholder' => 'Keterangan Perizinan', 'class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
        <div class="control-group ">
                <?php echo CHtml::label("Dokumen&nbsp;&nbsp;",'lampiranfile_1',['class'=>'control-label']);?>
            <div class="controls">
                <?php echo $form->fileField($model, 'lampiranfile_1', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
            <a class="btn btn-primary" onclick="myFunction()"><i class="icon-white icon-plus"></i></a>
        </div>
        <div id="lampiran2" class="control-group" style="display:none;" >
                <?php echo CHtml::label("Dokumen 2&nbsp;&nbsp;",'lampiranfile_2',['class'=>'control-label']);?>
            <div class="controls">
                <?php echo $form->fileField($model, 'lampiranfile_2', array('class' => 'span4 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
            <a class="btn btn-primary" onclick="myFunction2()"><i class="icon-white icon-plus"></i></a>
        </div>
        <div id="lampiran3" class="control-group" style="display:none;">
                <?php echo CHtml::label("Dokumen 3&nbsp;&nbsp;",'lampiranfile_3',['class'=>'control-label']);?>
            <div class="controls">
                <?php echo $form->fileField($model, 'lampiranfile_3', array('class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 50)); ?>
            </div>
        </div>
    </div>
</div>
<div class="form-actions">
    <?php
    echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
    Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' =>(isset($_GET['sukses']))? 'btn btn-danger' : 'btn btn-danger submit', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)','disabled'=>(isset($_GET['sukses']))? true : false));
    $controller = Yii::app()->controller->id; //mengambil Controller yang sedang dipakai
    $module = Yii::app()->controller->module->id; //mengambil Module yang sedang dipakai
    $url =  Yii::app()->createAbsoluteUrl($module . '/' . $controller);
    ?>
</div>
<br>
<table width="100%" class="table table-bordered table-striped table-condensed">
    <thead>
        <td style="text-align: center; font-weight: bold">No.</td>
        <td style="text-align: center; font-weight: bold">No. Perizinan</td>
        <td style="text-align: center; font-weight: bold">Tgl Perizinan</td>
        <td style="text-align: center; font-weight: bold">Berlaku Sampai</td>
        <td style="text-align: center; font-weight: bold">Pelaksana</td>
        <td style="text-align: center; font-weight: bold">Keterangan</td>
        <td style="text-align: center; font-weight: bold">Dokumen</td>
        <td style="text-align: center; font-weight: bold">Hapus</td>
    </thead>
    <tbody>
        <?php
        if (count($modShow) > 0) {
            foreach ($modShow as $i => $value) {
        ?>
                <tr>
                    <td style="text-align: center"><?php echo $i + 1; ?></td>
                    <td><?php echo (!empty($value->invperizinan_no) ? $value->invperizinan_no : ""); ?></td>
                    <td><?php echo $value->invperizinan_tgl = $format->formatDateTimeForUser($value->invperizinan_tgl); ?></td>
                    <td><?php echo $value->invperizinan_sdtgl = $format->formatDateTimeForUser($value->invperizinan_sdtgl); ?></td>
                    <td><?php echo (!empty($value->pegawai->nama_pegawai) ? $value->pegawai->nama_pegawai : ""); ?></td>
                    <td><?php echo (!empty($value->invperizinan_ket) ? $value->invperizinan_ket : ""); ?></td>
                    <td style="text-align: center"> <?php echo !empty($value->lampiranfile_1 . "<br>") ? CHtml::link($value->lampiranfile_1, $this->createUrl('Unduh', array('id' => $value->invperizinan_id)), array('title' => 'Download dokumen 1', 'rel' => 'tooltip')) . "<br>" : "";
                                                    echo !empty($value->lampiranfile_2 . "<br>") ? CHtml::link($value->lampiranfile_2, $this->createUrl('Unduh2', array('id' => $value->invperizinan_id)), array('title' => 'Download dokumen 2', 'rel' => 'tooltip')) . "<br>" : "";
                                                    echo !empty($value->lampiranfile_3) ? CHtml::link($value->lampiranfile_3, $this->createUrl('Unduh3', array('id' => $value->invperizinan_id)), array('title' => 'Download dokumen 3', 'rel' => 'tooltip')) : "";
                                                    ?>
                    </td>
                    <td style="text-align: center">
                        <?php echo CHtml::link("<i class='glyphicon glyphicon-trash'></i> ", "javascript:deleteRecord(" . $value->invperizinan_id . ")", array("id" => "$value->invperizinan_id", "rel" => "tooltip", "title" => "Hapus")); ?></td>
                </tr>
        <?php
            }
        }
        ?>
    </tbody>
</table>
<?php $this->endWidget(); ?>
<?php
/* ====================================== Widget Dialog Nama Pelaksana ====================================== */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Daftar Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 600,
        'resizable' => false,
    ),
));
$modPegawai = new PegawaiM('search');
$modPegawai->unsetAttributes();
if (isset($_GET['PegawaiM'])) {
    $modPegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawai-m-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                        array(
                            "class"=>"btn-small",
                            "id" => "subkegiatanprogram",
                            "onClick" => "\$(\"#MAInvperizinanT_pelaksana_id\").val($data->pegawai_id);
                                          \$(\"#nama_pegawai\").val(\"$data->nama_pegawai\");
                                          \$(\"#pelaksana_id\").val(\"$data->pegawai_id\");
                                          \$(\"#dialogPegawai\").dialog(\"close\");"
                         )
                     )',
        ),
        'nama_pegawai',
        'nomorindukpegawai',
        'unitkerja.namaunitkerja'
    ),
    'afterAjaxUpdate' => 'function(id, data){
            // $("#kategoritindakan_id").val($("#idKategori").val());
        jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
/* ====================================== endWidget Dialog Nama Pelaksana ====================================== */
?>
<script>
    function myFunction() {
        var x = document.getElementById("lampiran2");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function myFunction2() {
        var x = document.getElementById("lampiran3");
        if (x.style.display === "none") {
            x.style.display = "block";
        } else {
            x.style.display = "none";
        }
    }

    function setPelaksana(data) {
        $("#invperizinan-t-form #pelaksana_id").val(data.pegawai_id);
        $("#invperizinan-t-form #nama_pegawai").val(data.nama_pegawai);
        $("#invperizinan-t-form #nama_pegawai").blur();
    }

    function deleteRecord(id) {
        var id = id;
        console.log(id);
        var url = '<?php echo $url."/delete"; ?>';
        myConfirm('Apakah anda yakin untuk menghapus data ini ?','Perhatian!',function(r){
            if (r){
                $.post(url, {id: id},
                function(data){
                    if(data.status == 'sukses'){
                        window.location.reload();
                    }else{
                        myAlert('Data Gagal di Hapus')
                    }
                },"json");
            }
        });
    }
</script>