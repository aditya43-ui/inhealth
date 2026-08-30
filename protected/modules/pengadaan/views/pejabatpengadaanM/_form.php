<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pejabatpengadaan-m-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'onKeyPress' => 'return disableKeyPress(event);', 
        'onsubmit' => 'return requiredCheck(this);',
        'enctype'=>'multipart/form-data',
    ),
    'focus' => '#' . CHtml::activeId($model, 'pejabatpengadaan_nama')
        ));
?>
<style>        
     .control-label{
        width:140px !important;
        vertical-align: top !important;
    }        
</style>
<p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
<?php echo $form->errorSummary($model); ?>
<div class="row-fluid">

    <div class = "col-sm-6">
        <?= $form->dropDownListRow($model,'periodeanggaran_id',CHtml ::listData(PeriodeanggaranK::model()->findAll(['order'=>'tahunanggaran DESC']), 'periodeanggaran_id', 'anggaran_nama'),['empty'=>'-- Pilih --']) ?>
        <div class="control-group">
            <?php echo CHtml::label('Jabatan <span class="required">*</span>', '', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo $form->dropDownList($model, 'jabatan_pengadaan', LookupM::getItems("jabatanpengadaan"), array('class' => 'span3 required', 'onkeypress' => "return $(this).focusNextInputField(event)", 'empty' => '-- Pilih --'));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label('Nama Pegawai <span class="required">*</span>', 'pegawai_id', array('class' => 'control-label')); ?>
            <div class="controls">
                <?php
                if (!empty($_GET['id'])) {
                    $model->nama_pegawai = $model->pegawai->namaLengkap;
                }
                echo $form->hiddenField($model, 'pegawai_id');

                $this->widget('MyJuiAutoComplete', array(
                    'model' => $model,
                    'attribute' => 'nama_pegawai',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                                url: "' . Yii::app()->createUrl('ActionAutoComplete/getPegawai') . '",
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
                                $("#' . Chtml::activeId($model, 'pegawai_id') . '").val(ui.item.pegawai_id); 
                                return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'class' => 'span3 namaPegawai',
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => 'Ketikan Nama Pegawai',
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogPegawai'),
                ));
                ?>
            </div>
        </div>
        
        <div class="control-group">
                <?php echo CHtml::label("Bidang/Bagian/Instalasi", 'instalasi_id', array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->dropDownList($modDet, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll('instalasi_aktif = true ORDER BY instalasi_nama ASC'), 'instalasi_id', 'instalasi_nama'), array('class' => 'form-control', 'multiple' => 'multiple'));?>
            </div>				
        </div>
        <?php if (!empty($_GET['id'])) { ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'pejabatpengadaan_aktif', array('class' => 'control-label')) ?>
            <div class="controls"> 
                <table id="table-insiden-detail" class="table table-bordered table-condensed" width="100%">
                    <thead>
                        <tr>
                            <td colspan="2"><b>Bidang/Bagian/Instalasi Sebelumnya</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if (!empty($model->pejabatpengadaan_id)){                                                                                        
                                $cekDetail = PejabatpengadaandetM::model()->findAllByAttributes(array('pejabatpengadaan_id'=>$model->pejabatpengadaan_id));
                                foreach($cekDetail as $i => $det){                                                                                               
                                    echo $this->renderPartial('_rowDetail',array('modDet'=>$det, 'i'=>$i));
                                }                                                                                       
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    
        
        <?php } ?>
        <div class="control-group">
                <?php echo CHtml::label("Unit Kerja", 'unitkerja_id', array('class' => 'control-label'));?>
            <div class="controls">
                <?php echo $form->dropDownList($modUnit, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll('unitkerja_aktif = true ORDER BY namaunitkerja ASC'), 'unitkerja_id', 'namaunitkerja'), array('class' => 'form-control', 'multiple' => 'multiple'));?>
            </div>				
        </div>
                 
        <div class="control-group">
            <?php echo CHtml::label("", 'pejabatpengadaan_aktif', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php echo $form->checkBox($model, 'pejabatpengadaan_aktif', array('checked' => 'pejabatpengadaan_aktif','style'=>'display:none')); ?>
            </div>				
        </div>
         <?php if (!empty($_GET['id'])) { ?>
        <div class="control-group">
            <?php echo CHtml::label("", 'pejabatpengadaan_aktif', array('class' => 'control-label')) ?>
            <div class="controls"> 
                <table id="table-insiden-detail" class="table table-bordered table-condensed" width="100%">
                    <thead>
                        <tr>
                            <td colspan="2"><b>Unit Kerja Sebelumnya</b></td>
                        </tr>
                    </thead>
                    <tbody>
                        <?php 
                            if (!empty($model->pejabatpengadaan_id)){                                                                                        
                                $cekDetail = PejabatpengadaanunitM::model()->findAllByAttributes(array('pejabatpengadaan_id'=>$model->pejabatpengadaan_id));
                                foreach($cekDetail as $i => $det){                                                                                               
                                    echo $this->renderPartial('_rowDetailUnit',array('modDet'=>$det, 'i'=>$i));
                                }                                                                                       
                            }
                        ?>
                    </tbody>
                </table>
            </div>
        </div>
    
        
        <?php } ?>
    </div>
    <div class="col-md-6">
        <div class="control-group">
           <?php echo $form->labelEx($model,'no_sk',array('class' => 'control-label')); ?>
           <div class="controls">
               <?php echo $form->textField($model,'no_sk',array('class'=>'span3','placeholder'=>'No SK','maxlength'=>100)); ?>
           </div>
        </div>
       <div class="control-group ">
            <?php echo $form->labelEx($model, 'tgl_sk', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'tgl_sk',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                        'maxDate' => 'd',
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'span3 dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                ?>
                <?php echo $form->error($model, 'tgl_sk'); ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label">File SK<span class="required"><?php echo !empty($req)?'*':'' ?></span></label></label>
            <div class="controls">
            <?php
                echo CHtml::link("File",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'btn btn-primary')).'&nbsp;'.CHtml::link("<u></u>",'javascript:;',array('onclick'=>'fileLoad(this);','class'=>'labelbrowse'));
                echo CHtml::activeHiddenField($model, 'temp_file',array('readonly' => true, 'class'=>'temp_picture_nama'));
                echo "<br/>".CHtml::link("<u>".$model->temp_file."</u>",$this->createUrl('unduhDok',array('id'=>$model->pejabatpengadaan_id)),array('rel'=>'tooltip','data-original-title'=>'Klik untuk mengunduh file', 'style'=>'color:blue;', 'target'=>'_BLANK'));
                echo "<div class='hide'>";
                echo CHtml::activeFileField($model,'file_sk',array( 'onchange'=>'cekFile(this);', 'class'=>!empty($req)?'required':''));
                echo "</div>";                                   
            ?>    
            </div>
        </div> 
        <div class="control-group">
           <?php echo $form->labelEx($model,'kode_dokumen',array('class' => 'control-label')); ?>
           <div class="controls">
               <?php echo $form->textField($model,'kode_dokumen',array('class'=>'span3','placeholder'=>'Kode Dokumen','maxlength'=>100)); ?>
           </div>
        </div>
    </div>   
    </div>
<div class="row-fluid">
    <div class="form-actions">
        <?php
        echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'));
        ?>
        <?php
        echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), $this->createUrl('admin'), array('class' => 'btn btn-default',
            'onclick' => 'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) window.location = window.location.href;}); return false;'));
        ?>
        <?php echo CHtml::link(Yii::t('mds', '{icon} Pengaturan Pejabat Pengadaan', array('{icon}' => '<i class="entypo-folder"></i>')), $this->createUrl('admin', array('modul_id' => Yii::app()->session['modul_id'])), array('class' => 'btn btn-success')); ?>
        <?php
        $tips = array(
            '0' => 'autocomplete-search',
            '1' => 'simpan',
            '2' => 'ulang',
        );
        $content = $this->renderPartial('sistemAdministrator.views.tips.detailTips', array('tips' => $tips), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
        ?>
    </div>
</div>
<?php $this->endWidget(); ?>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
    'options' => array(
        'title' => 'Pencarian Nama Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
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
    'id' => 'pegawaimengetahui-grid',
    'dataProvider' => $modPegawai->search(),
    'filter' => $modPegawai,
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
                                                  $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                                                  $(\"#' . CHtml::activeId($model, 'nama_pegawai') . '\").val(\"$data->nama_pegawai\");
                                                  $(\"#dialogPegawai\").dialog(\"close\"); 
                                                  $(\"#ADPermintaanPenawaranT_keteranganpenawaran\").blur();
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
            'filter' => Chtml::activeTextField($modPegawai, 'nomorindukpegawai', array('class' => 'numbers-only'))
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
            'filter' => Chtml::activeTextField($modPegawai, 'nama_pegawai', array('class' => 'hurufs-only'))
        ),
        array(
            'header' => 'Jabatan',
            'name' => 'jabatan_id',
            'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id', Chtml::listData(JabatanM::model()->findAll("jabatan_aktif  = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'), array('empty' => '-- Pilih --')),
            'value' => '!empty($data->jabatan_id)?$data->jabatan->jabatan_nama:"-"',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
    . '         $(".numbers-only").keyup(function(){setNumbersOnly(this);});$(".hurufs-only").keyup(function(){setHurufsOnly(this);});}',
));
$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
<script>
    
    function cekFile(obj){       
        
        var cek = $(obj).val();        
        
        if (cek != ''){
            var type = $(obj).get(0).files[0]['type'];
            var tipeFile = type.split('/');                          
            var ext = '.'+$(obj).val().split('.').pop().toLowerCase();           

            var sizee = $(obj).get(0).files[0].size; //file size in bytes
            sizee = sizee / 1024; //file size in Kb
            sizee = sizee / 1024; //file size in Mb

            if (sizee > 5) {
                window.parent.toastr.warning("Ukuran file tidak boleh lebih dari 5mb","perhatian !");
                $(obj).val("");                 
                $(obj).parents(".control-group").find('.labelbrowse').html('');                
                return false;
            }else{
                $(obj).parents(".control-group").find('.labelbrowse').html("<u>"+$(obj).get(0).files[0]['name']+"</u>");
            }
        }       
    }
    
    function fileLoad(obj){
        $(obj).parents(".control-group").find('input:file').trigger('click');
    }
    
    $(document).ready(function () {
        var ins = jQuery('#<?php echo CHtml::activeId($modDet, 'instalasi_id') ?>');
        var unit = jQuery('#<?php echo CHtml::activeId($modUnit, 'unitkerja_id') ?>');
        
        jQuery(ins).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];


                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

            },
            onSelectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = [];

                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

            },
            onDeselectAll: function () {
                var ins = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>');
                var ins_all = jQuery('#<?php echo CHtml::activeId($model, 'instalasi_id') ?>   option:selected');
                var ru = jQuery('#<?php echo CHtml::activeId($model, 'ruangan_id') ?>');

                var brands = ins_all;
                var selected = '';
            }
        }).hide();
        
        jQuery(unit).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true,
            onChange: function (element, checked) {
                var unit = jQuery('#<?php echo CHtml::activeId($modUnit, 'unitkerja_id') ?>');
                var unit_all = jQuery('#<?php echo CHtml::activeId($modUnit, 'unitkerja_id') ?>   option:selected');

                var brands = unit_all;
                var selected = [];


                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

                //alert(selected);

            },
            onSelectAll: function () {
                var unit = jQuery('#<?php echo CHtml::activeId($modUnit, 'unitkerja_id') ?>');
                var unit_all = jQuery('#<?php echo CHtml::activeId($modUnit, 'unitkerja_id') ?>   option:selected');

                var brands = unit_all;
                var selected = [];

                $(brands).each(function (index, brand) {
                    selected.push($(this).val());
                });

            },
            onDeselectAll: function () {
                var unit = jQuery('#<?php echo CHtml::activeId($modUnit, 'unitkerja_id') ?>');
                var unit_all = jQuery('#<?php echo CHtml::activeId($modUnit, 'unitkerja_id') ?>   option:selected');

                var brands = unit_all;
                var selected = '';
            }
        }).hide();

    });
</script>