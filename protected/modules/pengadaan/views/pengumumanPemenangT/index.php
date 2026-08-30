<?php 
$this->widget('bootstrap.widgets.BootAlert');
$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'pengumumanpemenang-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('enctype' => 'multipart/form-data', 'onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); ?>
<div class="row-fluid">
    <div class="col-sm-6">
        <?php echo $form->dropDownListRow($model,'konfigtemplatesurat_id', CHtml::listData(KonfigtemplatesuratK::model()->findAll("konfigtemplatesurat_nama LIKE '%Pengumuman Pemenang%' AND konfigtemplatesurat_aktif = true order by konfigtemplatesurat_nama ASC"), 'konfigtemplatesurat_id', 'konfigtemplatesurat_nama'),array('empty' => '-- Pilih --', 'class'=>'span4  required jenisform','onkeyup'=>"return $(this).focusNextInputField(event)",'return false;')); ?>
    </div>
    <div class="col-sm-6">
        <?php echo $form->textFieldRow($model,'pengumumanpemenang_nomor', array('disabled' => true, 'class' => 'span4 required', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
    </div>
</div>
<hr>
<div class="row-fluid">
    <div class="col-sm-6">
        <div class = "control-group">
        <?php echo CHtml::label('Nomor Surat <span class="required">*</span>', 'nomor_dokumen', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'nomor_dokumen', array('class' => 'span4 required', 'maxlength' => 100)); ?>
                <?php echo $form->hiddenField($model, 'persiapanpengadaan_id', array('class' => 'span4', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class = "control-group">
        <?php echo CHtml::label("Tanggal Surat <i style='color: red'> * </i>", 'pengumumanpemenang_tanggal', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php
                $this->widget('MyDateTimePicker', array(
                    'model' => $model,
                    'attribute' => 'pengumumanpemenang_tanggal',
                    'mode' => 'datetime',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span4 required', 'onkeypress' => "return $(this).focusNextInputField(event)"
                    ),
                ));
                ?>
            </div>
        </div>
        <div class="control-group">
            <?php echo CHtml::label("Penetapan Pemenang <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
            <div class="controls">
                <?php
                    echo $form->hiddenField($model, 'penetapanpemenang_id', array('class' => 'span4', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                    echo $form->textField($model, 'penetapanpemenang_nomor', array('class' => 'span4 required', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                ?>
            </div>
        </div>
        <div class = "control-group">
        <?php echo CHtml::label("Tanggal Penetapan Pemenang <i style='color: red'> * </i>", 'pengumumanpemenang_tanggal', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'penetapanpemenang_tanggal', array('class' => 'span4', 'readonly' => true ,'maxlength' => 100)); ?>
            </div>
        </div>
            <div class="control-group">
                <?php echo CHtml::label("Nama Supplier <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'supplier_id', array('class' => 'span4', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        echo $form->textField($model, 'supplier_nama', array('class' => 'span4', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
            <div class = "control-group">
            <?php echo CHtml::label('Alamat Penyedia', 'supplier_alamat', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textArea($model, 'supplier_alamat', array('disabled' => true, 'class' => 'span4', 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class = "control-group">
            <?php echo CHtml::label('Direktur', 'direktursupplier', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($model, 'direktursupplier', array('disabled' => true, 'class' => 'span4', 'maxlength' => 100)); ?>
                </div>
            </div>
        </div>
    <div class="col-sm-6">
        <?php 
            $cekInfoUmum = InfoumumpengadaanT::model()->findByAttributes(array('persiapanpengadaan_id' => $model->persiapanpengadaan_id));
            if(!empty($cekInfoUmum->pegpengadaan_id)) { 
        ?>
         <div class="control-group ">
            <?php echo CHtml::label('Pejabat Pengadaan','',array('class'=>'control-label')); ?>
                <div class="controls">
                    <?php 
                        echo $form->hiddenField($model, 'pegawai_id', array('readonly' => true));
                        echo $form->textField($model, 'pegawai_nama', array('readonly' => true, 'class' => 'span4'));
                    ?>
                </div>
            </div>
            <div class = "control-group">
            <?php echo CHtml::label('NIP', 'nomorindukpegawai', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($model, 'nomorindukpegawai', array('disabled' => true, 'class' => 'span4', 'maxlength' => 100)); ?>
                </div>
            </div>
        <div class = "control-group">
        <?php echo CHtml::label('Jabatan Pengadaan', 'jabatan', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'peg_jabatan', array('readonly' => true, 'class' => 'span4', 'maxlength' => 100)); ?>
            </div>
        </div>
        <?php } ?>
        <div class = "control-group">
        <?php echo CHtml::label('NPWP', 'npwp', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'supplier_npwp', array('disabled' => true, 'class' => 'span4', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class = "control-group">
        <?php echo CHtml::label('Harga setelah Negosiasi', 'harga_negosiasi', array('class'=>'control-label')) ?>
            <div class = "controls">
                <?php echo $form->textField($model, 'harga_negosiasi', array('readonly' => true, 'class' => 'span4 integer2', 'maxlength' => 100)); ?>
            </div>
        </div>
        <div class="control-group ">
        <?php echo CHtml::label("Dokumen Pendukung", '', array('class' => 'control-label')); ?>
            <div class="controls">
            <?php echo $form->fileField($model, 'dokumen_pendukung', array('accept'=>'application/pdf','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
            <?php
                if (!empty($model->dokumen_pendukung)) {
                    echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->pengumumanpemenang_t)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
                }
                ?>
            </div>
        </div>
        <div class="control-group">
            <label class="control-label"></label>
            <div class="controls" >
                <span class="required" style="font-size: 10px;"><i>Hanya file dengan ekstensi .pdf (maks 5mb)</i></span>
            </div>
        </div>
    </div>
</div>
<div class="row-fluid">
    <?php 
        $cekSPK = SuratperjanjiankerjaT::model()->findByAttributes(array('persiapanpengadaan_id' => $_GET['id'],'isbatal' => false, 'isaddendum' => true));
        if (!empty($cekSPK)) {
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'onclick' => 'formSubmit(this,event);', 'onkeypress' => 'formSubmit(this,event);', 'disabled' => true));
            echo "&nbsp;";
        }else{
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary submit',
                'type' => 'submit'));
        }
        ?>
    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="icon-refresh icon-white"></i>')), 
                    $this->createUrl('index&id='.$_GET['id']), 
                    array('class'=>'btn btn-danger',
                              'onclick'=>'return refreshForm(this);')); ?>
    <?php 
        $content = $this->renderPartial('pengadaan.views.tips/transaksi', array(), true);
        $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));?>

     <?php
        if (isset($model->pengumumanpemenang_t)) {
            echo CHtml::htmlButton(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="icon-print icon-white"></i>')),array('class'=>'btn btn-primary-blue', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));
        }
    ?>
</div>
    
<?php $this->endWidget(); ?>

    <?php
//========= Dialog buat cari data Program Studi  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPenyedia',
    'options' => array(
        'title' => 'Pencarian Supplier',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modSupplier = new SupplierM('search');
$modSupplier->unsetAttributes();
if (isset($_GET['SupplierM'])) {
    $modSupplier->attributes = $_GET['SupplierM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'prodi-m-grid',
    'dataProvider' => $modSupplier->searchSupplierDialog(),
    'filter' => $modSupplier,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($model, 'supplier_id') . '\").val(\"$data->supplier_id\");
                              $(\"#' . CHtml::activeId($model, 'supplier_nama') . '\").val(\"$data->supplier_nama\");
                              $(\"#' . CHtml::activeId($model, 'supplier_alamat') . '\").val(\"$data->supplier_alamat\");
                              $(\"#' . CHtml::activeId($model, 'direktursupplier') . '\").val(\"$data->direktursupplier\");
                              $(\"#' . CHtml::activeId($model, 'supplier_npwp') . '\").val(\"$data->supplier_npwp\");
                              $(\"#dialogPenyedia\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        array(
            'header' => 'Kode Supplier',
            'name' => 'supplier_kode',
            'value' => '$data->supplier_kode',
        ),
        array(
            'header' => 'Nama Supplier',
            'name' => 'supplier_nama',
            'value' => '$data->supplier_nama',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Program Studi =============================
?>

<?php
//========= Dialog buat cari data Program Studi  =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPenetapan',
    'options' => array(
        'title' => 'Pencarian Penetapan Pemenang',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPenetapan = new PenetapanpemenangT();
$modPenetapan->unsetAttributes();
if (isset($_GET['PenetapanpemenangT'])) {
    $modPenetapan->attributes = $_GET['PenetapanpemenangT'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penetapan-m-grid',
    'dataProvider' => $modPenetapan->searchDialogPenetapan(),
    'filter' => $modPenetapan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($model, 'penetapanpemenang_id') . '\").val(\"$data->penetapanpemenang_id\");
                              $(\"#' . CHtml::activeId($model, 'penetapanpemenang_nomor') . '\").val(\"$data->penetapanpemenang_nomor\");
                              $(\"#' . CHtml::activeId($model, 'penetapanpemenang_tanggal') . '\").val(\"$data->penetapanpemenang_tanggal\");
                              $(\"#' . CHtml::activeId($model, 'supplier_id') . '\").val(\"$data->supplier_id\");
                              $(\"#' . CHtml::activeId($model, 'supplier_nama') . '\").val(\"$data->supplier_nama\");
                              $(\"#' . CHtml::activeId($model, 'direktursupplier') . '\").val(\"$data->direktursupplier\");
                              $(\"#' . CHtml::activeId($model, 'supplier_alamat') . '\").val(\"$data->supplier_alamat\");
                              $(\"#' . CHtml::activeId($model, 'pegawai_id') . '\").val(\"$data->pegawai_id\");
                              $(\"#' . CHtml::activeId($model, 'nomorindukpegawai') . '\").val(\"$data->nomorindukpegawai\");
                              $(\"#' . CHtml::activeId($model, 'jabatan') . '\").val(\"$data->jabatan\");
                              $(\"#' . CHtml::activeId($model, 'pegawai_nama') . '\").val(\"$data->nama_pegawai\");
                              $(\"#' . CHtml::activeId($model, 'harga_negosiasi') . '\").val(formatNumber(\"$data->harga_negosiasi\"));
                              $(\"#dialogPenetapan\").dialog(\"close\");    
                              return false;
                    "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        array(
            'header' => 'Tanggal Penetapan Pemenang',
            'type' => 'raw',
            'value' => 'MyFormatter::formatDateTimeforUser($data->penetapanpemenang_tanggal)',
            'filter' => false,
        ),
        array(
            'header' => 'No. Penetapan Pemenang',
            'type' => 'raw',
            'value' => '$data->penetapanpemenang_nomor',
            'filter' => false,
        ),
        array(
            'header' => 'Nama Penyedia',
            'type' => 'raw',
            'value' => '$data->supplier_nama',
            'filter' => false,
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

$this->endWidget();
//========= end Program Studi =============================
?>

<?php
//========= Dialog buat cari data Pegawai Pemantau2 =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPemantau2',
    'options' => array(
        'title' => 'Pencarian Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modPegawai = new PegawaiM();
$modPegawai->unsetAttributes();
if (isset($_GET['PegawaiM'])) {
    $modPegawai->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaipemantau2-grid',
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
                                                  $(\"#' . CHtml::activeId($model, 'pegawai_nama') . '\").val(\"$data->namaLengkap\");                                
                                                  $(\"#' . CHtml::activeId($model, 'jabatan') . '\").val(\"$data->namaJabatan\");                                                 
                                                  $(\"#' . CHtml::activeId($model, 'nomorindukpegawai') . '\").val(\"$data->nomorindukpegawai\");                                                 
                                                  $(\"#dialogPemantau2\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawai, 'nama_pegawai'),
            'value' => '$data->namaLengkap',
        ),
         array(
                'header'=>'Jabatan',
                'filter'=>  CHtml::activeDropDownList($modPegawai, 'jabatan_id', CHtml::listData(JabatanM::model()->findAll("jabatan_aktif = TRUE ORDER BY jabatan_nama ASC"), 'jabatan_id', 'jabatan_nama'),array('empty'=>'-- Pilih --')),
                'value'=> function($data){
                    $j = JabatanM::model()->findByPk($data->jabatan_id);

                    if (!empty($j)){
                        return $j->jabatan_nama;
                    }else{
                        return '-';
                    }
                } 
        ),
        array(
                'header'=>'Unit Kerja',
                'filter'=>  CHtml::activeDropDownList($modPegawai, 'unitkerja_id', CHtml::listData(UnitkerjaM::model()->findAll("unitkerja_aktif = TRUE ORDER BY namaunitkerja ASC"), 'unitkerja_id', 'namaunitkerja'),array('empty'=>'-- Pilih --')),
                'value'=> function($data){
                    $j = UnitkerjaM::model()->findByPk($data->unitkerja_id);

                    if (!empty($j)){
                        return $j->namaunitkerja;
                    }else{
                        return '-';
                    }
                }   
        ),
       
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Pemantau2 dialog ============================
?>

<script>    
    function cekForm(){
        if (requiredCheck($("#penetapanpemenang-t-form"))){
            $('#penetapanpemenang-t-form').submit();
        }
       return false;
    }
    
    
    $(document).ready(function(){
        setValidasiCekDisabled($("#pengumumanpemenang-t-form"), function() {
                return true;
            });
        <?php
        if ($model->isNewRecord) {
            if ($model->cekPenetapan == 0) {
                echo 'myAlert("Data Penetapan Pemenang tidak ditemukan.")';
            }
        }
        ?>
    });
    
    function print(){
        window.open('<?php echo $this->createUrl('print',array('id'=>$model->pengumumanpemenang_t)); ?>','printwin','left=100,top=100,width=640,height=480');
    }
    $("#penetapanpemenang-t-form").find('.integer2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2});


    document.getElementById("PengumumanpemenangT_dokumen_pendukung").onchange = function () {
        if(this.files[0].size>5000000){
            myAlert("ukuran maks : 5Mb");
            $("#PengumumanpemenangT_dokumen_pendukung").attr("src","blank");
            $('#PengumumanpemenangT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#PengumumanpemenangT_dokumen_pendukung').unwrap();     
            return false;
        }
        if(this.files[0].type.indexOf("pdf")==-1){
            myAlert("Tipe file harus PDF");
            $("#PengumumanpemenangT_dokumen_pendukung").attr("src","blank");
            $('#PengumumanpemenangT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#PengumumanpemenangT_dokumen_pendukung').unwrap();         
            return false;
        } 
    };
</script>