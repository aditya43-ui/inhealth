<?php 
$this->widget('bootstrap.widgets.BootAlert');
    $form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
            'id'=>'penunjukanpenyedia-t-form',
            'enableAjaxValidation'=>false,
            'type'=>'horizontal',
            'htmlOptions'=>array(
                'enctype' => 'multipart/form-data',
                'onKeyPress'=>'return disableKeyPress(event);', 
                'onsubmit'=>'return requiredCheck(this);',
            ),
        )); 
?>
    <div class="row-fluid">
        <div class="col-sm-6">
            <?php echo $form->dropDownListRow($model,'konfigtemplatesurat_id', CHtml::listData(KonfigtemplatesuratK::model()->findAll("konfigtemplatesurat_nama LIKE '%Penunjukan Penyedia%' AND konfigtemplatesurat_aktif = true order by konfigtemplatesurat_nama ASC"), 'konfigtemplatesurat_id', 'konfigtemplatesurat_nama'),array('empty' => '-- Pilih --', 'class'=>'span3  required jenisform','onkeyup'=>"return $(this).focusNextInputField(event)",'return false;')); ?>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textFieldRow($model,'penunjukanpenyedia_nomor', array('readonly' => true, 'class' => 'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </div>
    </div>
    <hr>
    <div class="row-fluid">
        <div class="col-sm-6">
            <div class = "control-group">
            <?php echo CHtml::label("Nomor Surat <span class='required'>*</span>", 'nomor_dokumen', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($model, 'nomor_dokumen', array('class' => 'span3 required', 'maxlength' => 100)); ?>
                    <?php echo $form->hiddenField($model, 'persiapanpengadaan_id', array('class' => 'span3', 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class = "control-group">
            <?php echo CHtml::label("Tanggal Surat", 'dasar_tanggal', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'penunjukanpenyedia_tanggal',
                        'mode' => 'datetime',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class = "control-group">
            <?php echo CHtml::label("Dasar Surat", 'dasar_nomor', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($model, 'dasar_nomor', array('class' => 'span3', 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class = "control-group">
            <?php echo CHtml::label('Tanggal Dasar Surat', 'dasar_tanggal', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'dasar_tanggal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onClick' => 'hitungTanggal();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class = "control-group">
            <?php echo CHtml::label('Tanggal Awal Pelaksanaan', 'tanggal_awal', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tanggal_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3', 'onChange' => 'hitungTanggal();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class = "control-group">
            <?php echo CHtml::label('Tanggal Akhir Pelaksanaan', 'tanggal_akhir', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => 'tanggal_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                        ),
                        'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3 span3',  'onChange' => 'hitungTanggal();', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:180px;'
                        ),
                    ));
                    ?>
                </div>
            </div>
            <div class = "control-group">
            <?php echo CHtml::label('Jangka Waktu', 'jangka_pelaksanaan', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($model, 'jangka_pelaksanaan', array('disabled' => true, 'class' => 'span1', 'maxlength' => 100)); ?> <label>hari kalender</label>
                </div>
            </div>
            <div class = "control-group">
            <?php echo CHtml::label("Nilai Setelah Negosiasi <span class='required'>*</span>", 'harga_negosiasi', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($model, 'harga_negosiasi', array('readonly' => false, 'class' => 'span3 integer2 required', 'maxlength' => 100)); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-6">
            <div class="control-group">
                <?php echo CHtml::label("Nomor Penawaran <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'penawaranpenyedia_id', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        echo $form->textField($model, 'penawaran_nomor', array('class' => 'span3 required', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
            <div class = "control-group">
                <?php echo CHtml::label('Tanggal Penawaran', 'penawaran_tanggal', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php
                        echo $form->textField($model, 'penawaran_tanggal', array('class' => 'span3', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
            <div class="control-group">
                <?php echo CHtml::label("Nama Supplier <i style='color: red'> * </i>", "", array('class' => 'control-label'));?>
                <div class="controls">
                    <?php
                        echo $form->hiddenField($model, 'supplier_id', array('class' => 'span3 penyedia_id', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        echo $form->textField($model, 'supplier_nama', array('class' => 'span3 required', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event)"));
                    ?>
                </div>
            </div>
            <div class = "control-group">
                <?php echo CHtml::label('Alamat Supplier', 'supplier_alamat', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textArea($model, 'supplier_alamat', array('disabled' => true, 'class' => 'span3', 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class = "control-group">
            <?php echo CHtml::label('Direktur', 'direktursupplier', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($model, 'direktursupplier', array('disabled' => true, 'class' => 'span3', 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class = "control-group">
            <?php echo CHtml::label('Pejabat Pembuat Komitmen', 'pejabat_pembuatkomponen', array('class'=>'control-label')) ?>
                <div class = "controls">
                    <?php echo $form->textField($model, 'pejabat_pembuatkomitmen', array('disabled' => true, 'class' => 'span3', 'maxlength' => 100)); ?>
                </div>
            </div>
            <div class="control-group ">
            <?php echo CHtml::label("Dokumen Pendukung", '', array('class' => 'control-label')); ?>
                <div class="controls">
                <?php echo $form->fileField($model, 'dokumen_pendukung', array('accept'=>'application/pdf','class' => 'span4', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 500)); ?>
            <?php
                if (!empty($model->dokumen_pendukung)) {
                    echo CHtml::link("$model->dokumen_pendukung", $this->createUrl('Unduh', array('id' => $model->penunjukanpenyedia_id)), array('title' => 'Unduh dokumen pendukung', 'rel' => 'tooltip', 'style' => 'color:blue;'));
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
            if (isset($model->penunjukanpenyedia_id)) {
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
        array(
            'header' => 'Alamat',
            'name' => 'supplier_alamat',
            'value' => '$data->supplier_alamat',
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
    'id' => 'dialogPenawaran',
    'options' => array(
        'title' => 'Pencarian Penawaran Penyedia',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'resizable' => false,
    ),
));

$modPenawaran = new PenawaranpenyediaT();
$modPenawaran->unsetAttributes();
if (isset($_GET['PenawaranpenyediaT'])) {
    $modPenawaran->attributes = $_GET['PenawaranpenyediaT'];
    $modPenawaran->ispemenang = true;
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'penawaran-m-grid',
    'dataProvider' => $modPenawaran->searchPenawaranPemenang(),
    'filter' => $modPenawaran,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                "id" => "selectPemberiTugas",
                "onClick" => "$(\"#' . CHtml::activeId($model, 'penawaran_nomor') . '\").val(\"$data->penawaranpenyedia_nomor\");
                              $(\"#' . CHtml::activeId($model, 'penawaranpenyedia_id') . '\").val(\"$data->penawaranpenyedia_id\");
                              $(\"#' . CHtml::activeId($model, 'penyedia_id') . '\").val(\"$data->penyedia_id\")
                              $(\"#' . CHtml::activeId($model, 'penyedia_nama') . '\").val(\"$data->penyedia_nama\")
                              $(\"#' . CHtml::activeId($model, 'penyedia_alamat') . '\").val(\"$data->penyedia_alamat\")
                              $(\"#' . CHtml::activeId($model, 'penyedia_direktur') . '\").val(\"$data->penyedia_direktur\")
                              $(\"#' . CHtml::activeId($model, 'penawaran_tanggal') . '\").val(\"$data->penawaranpenyedia_tanggal\")
                              $(\"#' . CHtml::activeId($model, 'harga_negosiasi') . '\").val(formatNumber(\"$data->penawaranpenyedia_harga\"));
                              $(\"#dialogPenawaran\").dialog(\"close\");    
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
            'header' => 'Nomor Penawaran',
            'name' => 'penawaranpenyedia_nomor',
            'value' => '$data->penawaranpenyedia_nomor',
        ),
        array(
            'header' => 'Tanggal Penawaran',
            'name' => 'penawaranpenyedia_tanggal',
            'value' => '$data->penawaranpenyedia_tanggal',
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
        'title' => 'Pencarian Pemantau',
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
//========= end Pegawai Pemantau2 dialog =============================
?>


<script>
    $("#penunjukanpenyedia-t-form").find('.integer2').maskMoney({"symbol":"","defaultZero":true,"allowZero":true,"decimal":",","thousands":".","precision":2});
    
    function hitungTanggal(obj){
        var tgl_awal = $('#PenunjukanpenyediaT_tanggal_awal').val();
        var tgl_akhir = $('#PenunjukanpenyediaT_tanggal_akhir').val();
        
        $.ajax({
                type:'POST',
                data: {tgl_awal : tgl_awal, tgl_akhir : tgl_akhir},
                url:'<?php echo $this->createUrl('cekTanggal'); ?>',
                dataType: "json",
                success:function(data) {
                    $('#PenunjukanpenyediaT_jangka_pelaksanaan').val(data.hari);
                },
                error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
    }
    
    $(document).ready(function() {
    
         setValidasiCekDisabled($("#penunjukanpenyedia-t-form"), function() {
                return true;
        });
        var penawaran = $('#PenunjukanpenyediaT_penawaranpenyedia_id').val();
        <?php
        if ($model->isNewRecord) {
            if ($model->cekpenawaran == 0) {
                echo 'myAlert("Data Penawaran belum dimasukkan.")';
            }
        }
        ?>
            
    });
    
    function print(){
        window.open('<?php echo $this->createUrl('print',array('id'=>$model->penunjukanpenyedia_id)); ?>','printwin','left=100,top=100,width=640,height=480');
    }
    
    document.getElementById("PenunjukanpenyediaT_dokumen_pendukung").onchange = function () {
        if(this.files[0].size>5000000){
            myAlert("ukuran maks : 5Mb");
            $("#PenunjukanpenyediaT_dokumen_pendukung").attr("src","blank");
            $('#PenunjukanpenyediaT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#PenunjukanpenyediaT_dokumen_pendukung').unwrap();     
            return false;
        }
        if(this.files[0].type.indexOf("pdf")==-1){
            myAlert("Tipe file harus PDF");
            $("#PenunjukanpenyediaT_dokumen_pendukung").attr("src","blank");
            $('#PenunjukanpenyediaT_dokumen_pendukung').wrap('<form>').closest('form').get(0).reset();
            $('#PenunjukanpenyediaT_dokumen_pendukung').unwrap();         
            return false;
        } 
    };
</script>