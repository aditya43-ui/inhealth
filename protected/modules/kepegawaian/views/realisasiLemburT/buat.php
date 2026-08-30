<?php
$arrMenu = array(
    'Transaksi Realisasi Lembur',
);
//(Yii::app()->user->checkAccess(Params::DEFAULT_ADMIN)) ?array_push($arrMenu,array('label'=>'Realisasi Lembur ', 'header'=>true, 'itemOptions'=>array('class'=>'heading-master'))) :  '' ;
$this->breadcrumbs = $arrMenu;
?>
<?php
$checkLoginPegawai = false;
$modePgLogin = PegawaiM::model()->findByPk(Yii::app()->user->getState('pegawai_id'));
if (isset($modePgLogin)) {
    if ($modePgLogin->jabatan_id == 71 || $modePgLogin->jabatan_id == 131 || $modePgLogin->jabatan_id == 97) {
        $checkLoginPegawai = true;
    }
}
$sukses = null;
if (isset($_GET['sukses'])) {
    $sukses = $_GET['sukses'];
}
if ($sukses > 0)
    Yii::app()->user->setFlash('success', "Data nomor Realisasi Lembur " . $modRealisasiLembur->norealisasi . " berhasil disimpan!");
$this->widget('bootstrap.widgets.BootAlert');
?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form.js'); ?>
<?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'buat-realisasi-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event);', 'onsubmit' => 'return check(this);'),
    'focus' => '#',
)); ?>
<style>
    table .input-append {
        width: 140px;
    }

    table .input-append input {
        float: left;
        width: calc(100% - 45px);
        margin: 0 !important;
    }

    table .input-append .add-on {
        float: left;
        margin: 0 !important;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-check"></i> Transaksi <b>Realisasi Lembur</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-saved"></i> Realisasi Lembur
                </div>
            </div>
            <div class="panel-body">
                <?php echo $form->errorSummary($modRealisasiLembur); ?>
                <?php //if(isset($_GET['id'])){ 
                ?>
                <div class="row">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">No. Rencana <span class='required'>*</span></label>
                            <div class="controls">
                                <?php
                                if (isset($_GET['id'])) {
                                    echo $form->textField($modRencanaLembur, 'norencana', array('class' => 'span4 required', 'readonly' => true));
                                } else {
                                    $this->widget('MyJuiAutoComplete', array(
                                        'model' => $modRencanaLembur,
                                        'attribute' => 'norencana',
                                        'source' => 'js: function(request, response) {
															$.ajax({
																 url: "' . $this->createUrl('/ActionAutoComplete/NoRencanaLembur') . '",
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
																loadRencana(ui.item.rencanalembur_id);
																return false;
															}',
                                        ),
                                        'htmlOptions' => array(
                                            'class' => 'span4 required',
                                            'rel' => 'tooltip',
                                            'data-original-title' => 'Ketik no rencana lembur, yang sudah disetujui',
                                            'onkeypress' => "return $(this).focusNextInputField(event)",
                                            'placeholder' => 'No Rencana Lembur',
                                            'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modRencanaLembur, 'norencana') . '").val("");'
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogRencanaLembur'),
                                    ));
                                }
                                ?>
                                <?php echo $form->hiddenField($modRencanaLembur, 'rencanalembur_id'); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <label class="control-label">Tanggal <span class='required'>*</span></label>
                            <div class="controls">
                                <?php echo $form->textField($modRencanaLembur, 'tglrencana', array('class' => 'span4 required', 'readonly' => true)); ?>
                            </div>
                        </div>
                    </div>
                    <?php //} 
                    ?>
                    <div class='clear'></div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo $form->labelEx($modRealisasiLembur, 'norealisasi', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php echo $form->textField($modRealisasiLembur, 'norealisasi', array('class' => 'span4 isRequiredNoRea', 'readonly' => true, 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 20, 'autofocus' => true)); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modRealisasiLembur, 'tglrealisasi', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php
                                $modRealisasiLembur->tglrealisasi = (!empty($modRealisasiLembur->tglrealisasi) ? date("d/m/Y", strtotime($modRealisasiLembur->tglrealisasi)) : null);
                                $this->widget('MyDateTimePicker', array(
                                    'model' => $modRealisasiLembur,
                                    'attribute' => 'tglrealisasi',
                                    'mode' => 'date',
                                    'options' => array(
                                        //                                            'dateFormat'=>Params::DATE_FORMAT,
                                        'showOn' => false,
                                        'minDate' => 'd',
                                        'yearRange' => "-150:+0",
                                    ),
                                    'htmlOptions' => array(
                                        'placeholder' => '00/00/0000', 'class' => 'dtPicker3 datemask span4', 'onkeyup' => "return $(this).focusNextInputField(event)"
                                    ),
                                )); ?>
                                <?php echo $form->error($modRealisasiLembur, 'tglrealisasi'); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Jenis Lembur <span class="required">*</span>', 'jenislembur', array('class' => 'control-label required')); ?>
                            <div class="controls">
                                <?php
                                $listLookup = LookupM::model()->findAllByAttributes(array(
                                    'lookup_type' => 'jenislembur',
                                ), array(
                                    'order' => 'lookup_urutan',
                                ));
                                $listData = array();
                                $listOption = array();
                                foreach ($listLookup as $item) {
                                    $listData[$item->lookup_value] = $item->lookup_name;
                                    $listOption[$item->lookup_value] = array(
                                        'data-kode' => $item->lookup_kode
                                    );
                                }
                                echo $form->dropDownList($modRealisasiLembur, 'jenislembur', $listData, array(
                                    'onkeypress' => "return $(this).focusNextInputField(event);", 'onchange' => 'setNilaiLembur();',
                                    'options' => $listOption,
                                    'class' => 'span4',
                                    'empty' => '-- Pilih --',
                                )); ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo $form->labelEx($modRencanaLembur, 'keterangan', array('class' => 'control-label')); ?>
                            <div class="controls">
                                <?php echo $form->textArea($modRencanaLembur, 'keterangan', array('class' => 'span4', 'placeholder' => 'Keterangan', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php $modRencanaLembur->pemberitugas_nama = $modRencanaLembur->getPegawaiAttributes($modRencanaLembur->pemberitugas_id, 'nama_pegawai'); ?>
                            <label class="control-label required">
                                Pemberi Tugas
                                <span class="required">*</span>
                            </label>
                            <div class="controls">
                                <?php echo CHtml::activeHiddenField($modRencanaLembur, 'pemberitugas_id', array('class' => 'isRequiredPemb')); ?>
                                <div style="float:left;">
                                    <?php $this->widget('MyJuiAutoComplete', array(
                                        'model' => $modRencanaLembur,
                                        'attribute' => 'pemberitugas_nama',
                                        'sourceUrl' => Yii::app()->createUrl('kepegawaian/ActionAutoCompleteKP/PemberiTugas'),
                                        'options' => array(
                                            'showAnim' => 'fold',
                                            'minLength' => 2,
                                            'select' => 'js:function( event, ui ) {
                                                        $("#KPRencanaLemburT_pemberitugas_id").val(ui.item.pegawai_id);
                                                    }',
                                        ),
                                        'tombolDialog' => array('idDialog' => 'dialogPemberiTugas'),
                                        'htmlOptions' => array('placeholder' => 'Pemberi Tugas', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4', 'style' => 'float:left;'),
                                    )); ?>
                                </div>
                            </div>
                        </div>
                        <!--<div class="control-group">
                                        <?php // $modRencanaLembur->mengetahui_nama = $modRencanaLembur->getPegawaiAttributes($modRencanaLembur->mengetahui_id,'nama_pegawai'); 
                                        ?>
                                        <?php //echo $form->uneditableRow($modRencanaLembur,  'mengetahui_nama',array('class'=>'span4')); 
                                        ?>
                                        <?php //echo $form->labelEx($modRencanaLembur,'mengetahui_id', array('class'=>'control-label')) 
                                        ?>
                                        <label class="control-label required">
                                            Mengetahui
                                            <span class="required">*</span>
                                      </label>
                                        <div class="controls">
                                            <?php // echo CHtml::activeHiddenField($modRencanaLembur,'mengetahui_id', array('class'=>'isRequiredMeng'));
                                            ?>
                                            <div style="float:left;">
                                            <?php // $this->widget('MyJuiAutoComplete',array(
                                            //                                                'model'=>$modRencanaLembur,
                                            //                                                'attribute'=>'mengetahui_nama',
                                            //                                                'sourceUrl'=> Yii::app()->createUrl('kepegawaian/ActionAutoCompleteKP/Mengetahui'),
                                            //                                                'options'=>array(
                                            //                                                   'showAnim'=>'fold',
                                            //                                                   'minLength' => 2,
                                            //                                                   'select'=>'js:function( event, ui ) {
                                            //                                                        $("#KPRencanaLemburT_mengetahui_id").val(ui.item.pegawai_id);
                                            //                                                    }',
                                            //                                                ),
                                            //                                                'tombolDialog'=>array('idDialog'=>'dialogMengetahui'),
                                            //                                                'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span4','style'=>'float:left;'),
                                            //                                            )); 
                                            ?>
                                                </div>
                                        </div>
                                    </div>-->
                        <div class="control-group">
                            <?php $modRencanaLembur->menyetujui_nama = $modRencanaLembur->getPegawaiAttributes($modRencanaLembur->menyetujui_id, 'nama_pegawai'); ?>
                            <?php //echo $form->uneditableRow($modRencanaLembur,  'menyetujui_nama',array('class'=>'span4')); 
                            ?>
                            <?php //echo $form->labelEx($modRencanaLembur,'menyetujui_id', array('class'=>'control-label')) 
                            ?>
                            <label class="control-label required">
                                Menyetujui
                                <span class="required">*</span>
                            </label>
                            <div class="controls">
                                <?php echo CHtml::activeHiddenField($modRencanaLembur, 'menyetujui_id', array('class' => 'isRequiredMeny')); ?>
                                <?php echo $form->textField($modRencanaLembur, 'menyetujui_nama', array('readonly' => true, 'class' => 'span4',)); ?>
                                <!--<div style="float:left;">-->
                                <?php
                                // $this->widget('MyJuiAutoComplete', array(
                                //     'model' => $modRencanaLembur,
                                //     'attribute' => 'menyetujui_nama',
                                //     'sourceUrl' => Yii::app()->createUrl('kepegawaian/ActionAutoCompleteKP/Menyetujui'),
                                //     'options' => array(
                                //         'showAnim' => 'fold',
                                //         'minLength' => 2,
                                //         'select' => 'js:function( event, ui ) {
                                //                     $("#KPRencanaLemburT_menyetujui_id").val(ui.item.pegawai_id);
                                //                 }',
                                //     ),
                                //     'tombolDialog' => array('idDialog' => 'dialogMenyetujui'),
                                //     'htmlOptions' => array('placeholder' => 'Menyetujui', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'span4', 'style' => 'float:left;'),
                                // ));
                                //  
                                ?>
                                <!--</div>-->
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Tabel <b>Realisasi Lembur</b>
                </div>
            </div>
            <div class="panel-body table-responsive">
                <table class="items table table-bordered table-striped table-condensed" id="table-pegawai">
                    <thead>
                        <tr>
                            <th rowspan="2">No.</th>
                            <th rowspan="2">No. Induk Pegawai</th>
                            <th rowspan="2">Nama Pegawai</th>
                            <!--<th>Departemen</th>-->
                            <th rowspan="2">Jam Mulai</th>
                            <th rowspan="2">Jam Selesai</th>
                            <th rowspan="2" hidden>Total Jam</th>
                            <th rowspan="2">Jam Lembur</th>
                            <th rowspan="2">Jam Normal</th>
                            <th rowspan="2">Upah Sejam Lembur Hari Kerja</th>
                            <th rowspan="2">Upah Bulanan</th>
                            <th colspan="3">Upah Lembur</th>
                            <th rowspan="2">Total</th>
                            <th rowspan="2">Alasan Lembur</th>
                        </tr>
                        <tr>
                            <th>Jam Ke-1</th>
                            <th>Jam Ke-2</th>
                            <th>Jam Ke-3</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        $tr = '';
                        $no = 1;
                        $index = 0;
                        $format = new MyFormatter;
                        if (!empty($modDetail)) {
                            foreach ($modDetail as $key => $detail) {
                                $modRealisasiLemburDetail = $detail;
                                $biayaLembur = BiayalemburM::model()->findByPk($detail->biayalembur_id);
                                if ($modDetail[$key]->tglmulai != null) {
                                    $modRealisasiLemburDetail->jamMulai = date('H:i:s', strtotime($modDetail[$key]->tglmulai));
                                }
                                if ($modDetail[$key]->tglselesai != null) {
                                    $modRealisasiLemburDetail->jamSelesai = date('H:i:s', strtotime($modDetail[$key]->tglselesai));
                                }
                                $modRealisasiLemburDetail->pegawai_id = $detail->pegawai_id;
                                $modRealisasiLemburDetail->alasanlembur = $detail->alasanlembur;
                                $modRealisasiLemburDetail->nourut = $no;
                                $tr .= "<tr>
                                               <td>" . CHtml::activeTextField($modRealisasiLemburDetail, '[' . $index . ']nourut', array('class' => 'span1 no_urut', 'readonly' => TRUE))
                                    //.CHtml::activeHiddenField($modRealisasiLemburDetail, '['.$index.']rencanalembur_id')
                                    . CHtml::activeHiddenField($modRealisasiLemburDetail, '[' . $index . ']pegawai_id')
                                    . "</td>
                                               <td>" . $modRealisasiLemburDetail->pegawai->nomorindukpegawai . "</td>
                                               <td>" . $modRealisasiLemburDetail->pegawai->nama_pegawai . "</td>
                                               <td>" . $modRealisasiLemburDetail->jamMulai . "</td>
                                               <td>" . $modRealisasiLemburDetail->jamSelesai . "</td>
                                               <td style=\"text-align: right;\">" . $modRealisasiLemburDetail->total_jam . "</td>
                                               <td>" . $biayaLembur->biayalembur_nama . "</td>
                                                   <td style=\"text-align: right;\">" . (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($modRealisasiLemburDetail->upahsejamlembur) : "Hidden") . "</td>
                                               <td style=\"text-align: right;\">" . (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($modRealisasiLemburDetail->upah_bulanan) : "Hidden") . "</td>
                                               <td style=\"text-align: right;\">" . (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($modRealisasiLemburDetail->nilai_lembur) : "Hidden") . "</td>
                                               <td style=\"text-align: right;\">" . (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($modRealisasiLemburDetail->upah_lembur_jam2) : "Hidden") . "</td>
                                               <td style=\"text-align: right;\">" . (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($modRealisasiLemburDetail->upah_lembur_jam3) : "Hidden") . "</td>
                                               <td style=\"text-align: right;\">" . (($checkLoginPegawai == true) ? MyFormatter::formatNumberForPrint($modRealisasiLemburDetail->total_nilai_lembur) : "Hidden") . "</td>
                                               <td>" . $modRealisasiLemburDetail->alasanlembur . "</td>
                                               <td></td>
                                               </tr>   
                                           "; // <td>".$modDetail[$key]->pegawai->departement->departement_nama."</td>
                                $no++;
                                $index++;
                            }
                            echo $tr;
                        } else if ($modRencanaLemburDetail > 0) {
                            $this->renderPartial($this->path_view . '_rowRealisasiRencana', array('modRealisasiLemburDetail' => $modRealisasiLemburDetail, 'modRencanaLemburDetail' => $modRencanaLemburDetail, 'modPegawai' => $modPegawai));
                        } //else{ 
                        // $trTindakan = $this->renderPartial($this->path_view.'_rowDetail',array('modRealisasiLemburDetail'=>$modRealisasiLemburDetail,'modPegawai'=>$modPegawai),true); 
                        // echo $trTindakan;
                        //}
                        ?>
                    </tbody>
                </table>
                <?php
                if ($modRealisasiLembur->isNewRecord)
                    echo CHtml::link('<i class="entypo-plus-circled"></i> Tambah', '#', array(
                        'class' => 'btn btn-primary',
                        'onclick' => 'addRow();return false;',
                    )); ?>
            </div>
        </div>
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['id_realisasi'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)', 'disabled' => $disableSave)
            );
            //  jika dengan cek obat
            /**
                         echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'button', 'onclick'=>'cekObat();', 'onkeypress'=>'cekObat();','disabled'=>$disableSave)); //formSubmit(this,event)        
             * 
             * 
             */
            ?>
            <?php if (!isset($_GET['frame'])) {
                echo CHtml::link(
                    Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                    $this->createUrl($this->id . '/buat'),
                    array(
                        'class' => 'btn btn-default',
                        'title' => 'Ulang',
                        'onclick' => 'return refreshForm(this);'
                    )
                );
            } ?>
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('class' => 'btn btn-info', 'disabled' => $disablePrint, 'type' => 'button', 'onclick' => 'print(\'PRINT\')'));
            ?>
            <?php
            $content = $this->renderPartial('kepegawaian.views.tips.transaksi_penggajian', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content));
            ?>
        </div>
        <?php $this->endWidget(); ?>
    </div>
</div>
<?php
/**
 * Java Script untuk Cek Validasi jam mulai dan jam selesai tidak boleh kosong
 */
$jscript = <<<JS
function cekValidasi(event)
{ 
  kosong = ' ';
  pilih = true;
  detailRequired = $("#tabelPegawaiLembur tbody").find(".detailRequired[value="+kosong+"]");
  karlemburPilih = $("#tabelPegawaiLembur tbody").find(".pilih[value="+pilih+"]");
  jumlah =  detailRequired.length;      
  jumPilih =  karlemburPilih.length;      
  if ($('.isRequiredNoRea').val()==''){
    alert ('Silakan Isi No. Realisasi');
    return false;
  }else 
  if ($('.isRequiredMeng').val()==''){
    alert ('Silakan Isi Mengetahui');
    return false;
  }else 
  if ($('.isRequiredMeny').val()==''){
    alert ('Silakan Isi Menyetujui');
    return false;
  }else
  if ($('.isRequiredPemb').val()==''){
    alert ('Silakan Isi Pemberi Tugas');
    return false;
  }
//  else{
//    $('#btn_simpan').click();
//    return true; 
//  }
      else 
  if (jumlah==0){        
    $('#btn_simpan').click();
    return true;        
  }else{
    alert ('Jam Mulai, Jam Selesai dan Alasan Lembur Tidak Boleh Kosong!');
    return false;
  }
}
// Original JavaScript code by Chirp Internet: www.chirp.com.au 
// Please acknowledge use of this code by including this header. 
    function checkTime(field) { 
        var errorMsg = ""; 
        // regular expression to match required time format 
        re = /^(\d{1,2}):(\d{2})(:00)?([ap]m)?$/; 
        if(field.value != '') { 
            if(regs = field.value.match(re)) { 
                // 24-hour time format 
                if(regs[1] > 23) { 
                    errorMsg = "Kesalahan format jam : " + regs[1] + ". Masukan jam antara 00 s.d 23 !"; 
                } 
                if(!errorMsg && regs[2] > 59) { 
                    errorMsg = "Kesalahan format menit: " + regs[2] + ". Masukan menit antara 00 s.d 59 !"; 
                } 
            } else { 
                errorMsg = "Kesalahan format waktu: " + field.value + ". Masukan jam dan waktu antara 00:00 s.d 23:59 !"; 
            } 
       } 
       if(errorMsg != "") { 
           myAlert(errorMsg);
           field.value = "";
           field.focus();
           return false; 
       } 
       return true; 
}
JS;
Yii::app()->clientScript->registerScript('inputPegawai', $jscript, CClientScript::POS_HEAD);
?>
<?php
//========= Dialog buat cari data Pegawai Mengetahui =========================
//$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
//    'id'=>'dialogMengetahui',
//    'options'=>array(
//        'title'=>'Pencarian Mengetahui Pegawai',
//        'autoOpen'=>false,
//        'modal'=>true,
//        'width'=>600,
//        'height'=>450,
//        'resizable'=>false,
//    ),
//));
//
//$modMengetahui = new PegawaiM('search');
//$modMengetahui -> unsetAttributes();
//$modMengetahui->jabatan_id = Params::getKepalaUnitApp();
//if(isset($_GET['PegawaiM'])) {
//    $modMengetahui->attributes = $_GET['PegawaiM'];
//	$modMengetahui->jabatan_id = Params::getKepalaUnitApp();
//}
//$this->widget('ext.bootstrap.widgets.BootGridView',array(
//	'id'=>'mengetahui-m-grid',
//	'dataProvider'=>$modMengetahui->search(),
//	'filter'=>$modMengetahui,
//    'template'=>"{summary}\n{items}\n{pager}",
//    'itemsCssClass'=>'table table-striped table-bordered table-condensed',
//	'columns'=>array(
//        array(
//            'header'=>'Pilih',
//            'type'=>'raw',
//            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
//                            "id" => "selectMengetahui",
//                            "onClick" => "$(\"#KPRencanaLemburT_mengetahui_id\").val(\"$data->pegawai_id\");
//                                          $(\"#'.CHtml::activeId($modRencanaLembur,'mengetahui_nama').'\").val(\"$data->nama_pegawai\");
//                                          $(\"#dialogMengetahui\").dialog(\"close\");    
//                                          return false;
//                                "))',
//        ),
//        array(
//            'header'=>'No.',
//            'type'=>'raw',
//            'value'=>'$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
//            'filter'=>false,
//        ),
//        'nomorindukpegawai',                
//        array(
//            'name'=>'nama_pegawai',
//            'value'=>'$data->namaLengkap',
//        ),
////                        array(
////                            'header'=>'Departement',
////                            'value'=>'$data->departement->departement_nama',
////                            'filter'=>false,
////                        ),       
//                
//
//	),
//        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
//));
//
//$this->endWidget();
//========= end Pegawai Mengetahui dialog =============================
?>
<?php
//========= Dialog buat cari data Pegawai Menyetujui =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogMenyetujui',
    'options' => array(
        'title' => 'Pencarian Menyetujui Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 450,
        'resizable' => false,
    ),
));
$modMenyetujui = new PegawaiM('search');
$modMenyetujui->unsetAttributes();
$modMenyetujui->jabatan_id = Params::getKepalaUnitApp();
if (isset($_GET['PegawaiM'])) {
    $modMenyetujui->attributes = $_GET['PegawaiM'];
    $modMenyetujui->jabatan_id = Params::getKepalaUnitApp();
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'menyetujui-m-grid',
    'dataProvider' => $modMenyetujui->search(),
    'filter' => $modMenyetujui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectMenyetujui",
                            "onClick" => "$(\"#KPRencanaLemburT_menyetujui_id\").val(\"$data->pegawai_id\");
                                          $(\"#' . CHtml::activeId($modRencanaLembur, 'menyetujui_nama') . '\").val(\"$data->nama_pegawai\");
                                          $(\"#dialogMenyetujui\").dialog(\"close\");    
                                          return false;
                                "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        //                        array(
        //                            'header'=>'Departement',
        //                            'value'=>'$data->departement->departement_nama',
        //                            'filter'=>false,
        //                        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Menyetujui dialog =============================
?>
<?php
//========= Dialog buat cari data Pegawai Lembur =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiLembur',
    'options' => array(
        'title' => 'Pencarian Pegawai Lembur',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 450,
        'resizable' => false,
    ),
));
$modPegawaiLembur = new PegawaiM('search');
$modPegawaiLembur->unsetAttributes();
if (isset($_GET['PegawaiM'])) {
    $modPegawaiLembur->attributes = $_GET['PegawaiM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'karlembur-m-grid',
    'dataProvider' => $modPegawaiLembur->search(),
    'filter' => $modPegawaiLembur,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPegawaiLembur",
                                            "onClick" => "$(\"#pegawailembur_id\").val(\"$data->pegawai_id\");
                                                          $(\"#' . CHtml::activeId($modRencanaLembur, 'karlembur_nama') . '\").val(\"$data->nama_pegawai\");
                                                          submitPegawaiLembur(this);
                                                          $(\"#dialogPegawaiLembur\").dialog(\"close\");    
                                                          return false;
                                                "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        //                        array(
        //                            'header'=>'Departement',
        //                            'value'=>'$data->departement->departement_nama',
        //                            'filter'=>false,
        //                        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai Lembur dialog =============================
?>
<?php
//========= Dialog buat cari data Pemberi Tugas =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPemberiTugas',
    'options' => array(
        'title' => 'Pencarian Pemberi Tugas',
        'autoOpen' => false,
        'modal' => true,
        'width' => 600,
        'height' => 450,
        'resizable' => false,
    ),
));
if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_KEPEGAWAIAN) {
    $classPegawai = 'PegawaiV';
    $modPemberiTugas = new $classPegawai('search');
    $modPemberiTugas->unsetAttributes();
} else {
    $classPegawai = 'PegawairuanganV';
    $modPemberiTugas = new $classPegawai('search');
    $modPemberiTugas->unsetAttributes();
    $modPemberiTugas->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
// $modPemberiTugas = new PegawaiM('search');
// $modPemberiTugas -> unsetAttributes();
if (isset($_GET[$classPegawai])) {
    $modPemberiTugas->attributes = $_GET[$classPegawai];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pemberitugas-m-grid',
    'dataProvider' => $modPemberiTugas->search(),
    'filter' => $modPemberiTugas,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                                            "id" => "selectPemberiTugas",
                                            "onClick" => "$(\"#KPRencanaLemburT_pemberitugas_id\").val(\"$data->pegawai_id\");
                                                          $(\"#' . CHtml::activeId($modRencanaLembur, 'pemberitugas_nama') . '\").val(\"$data->nama_pegawai\");
                                                          $(\"#dialogPemberiTugas\").dialog(\"close\");    
                                                          return false;
                                                "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        'nomorindukpegawai',
        array(
            'name' => 'nama_pegawai',
            'value' => '$data->namaLengkap',
        ),
        //                        array(
        //                            'header'=>'Departement',
        //                            'value'=>'$data->departement->departement_nama',
        //                            'filter'=>false,
        //                        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pemberi Tugas dialog =============================
?>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogPegawaiBadak',
    'options' => array(
        'title' => 'Pencarian Data Pegawai',
        'autoOpen' => false,
        'modal' => true,
        'width' => 1060,
        'height' => 480,
        'resizable' => false,
    ),
));
echo CHtml::hiddenField('tindakan_untuk', 0, array('readonly' => true));
if (Yii::app()->user->getState('modul_id') == Params::MODUL_ID_KEPEGAWAIAN) {
    $classPegawai = 'PegawaiV';
    $modPegawaiLembur = new $classPegawai('search');
    $modPegawaiLembur->unsetAttributes();
} else {
    $classPegawai = 'PegawairuanganV';
    $modPegawaiLembur = new $classPegawai('search');
    $modPegawaiLembur->unsetAttributes();
    $modPegawaiLembur->ruangan_id = Yii::app()->user->getState('ruangan_id');
}
// $modPegawaiLembur = new PegawaiM('search');
// $modPegawaiLembur->unsetAttributes();
if (isset($_GET[$classPegawai])) {
    $modPegawaiLembur->attributes = $_GET[$classPegawai];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaibadak-m-grid',
    'dataProvider' => $modPegawaiLembur->searchNonDokter(),
    'filter' => $modPegawaiLembur,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","javascript:void(0);",array("class"=>"btn-small", 
                                        "id" => "selectPasien",
                                        "onClick" => "
											setPegawaiAuto(\"$data->pegawai_id\",0);
                                            $(\"#dialogPegawaiBadak\").dialog(\"close\");
                                        "))',
        ),
        array(
            'header' => 'No.',
            'type' => 'raw',
            'value' => '$this->grid->dataProvider->pagination->currentPage * $this->grid->dataProvider->pagination->pageSize + ($row+1)',
            'filter' => false,
        ),
        array(
            'header' => 'NIP',
            'name' => 'nomorindukpegawai',
            'type' => 'raw',
            'value' => '$data->nomorindukpegawai',
        ),
        'nama_pegawai',
    ),
    'afterAjaxUpdate' => 'function(id, data){
                 jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});
                 jQuery(\'#tanggal_lahir\').datepicker(jQuery.extend({
                        showMonthAfterYear:false}, 
                        jQuery.datepicker.regional[\'id\'], 
                       {\'dateFormat\':\'dd M yy\',\'maxDate\':\'d\',\'timeText\':\'Waktu\',\'hourText\':\'Jam\',\'minuteText\':\'Menit\',
                       \'secondText\':\'Detik\',\'showSecond\':true,\'timeOnlyTitle\':\'Pilih Waktu\',\'timeFormat\':\'hh:mms\',
                       \'changeYear\':true,\'changeMonth\':true,\'showAnim\':\'fold\',\'yearRange\':\'-80y:+20y\'})); 
                jQuery(\'#tanggal_lahir_date\').on(\'click\', function(){jQuery(\'#tanggal_lahir\').datepicker(\'show\');});
            }',
));
$this->endWidget();
?>
<?php
//========= Dialog buat cari data No Rencana Diklat =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogRencanaLembur',
    'options' => array(
        'title' => 'Pencarian Rencana Lembur (DISETUJUI)',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 500,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));
$modRencanaDiklat = new KPRencanaLemburT('searchDialog');
if (isset($_GET['KPRencanaLemburT'])) {
    $modRencanaDiklat->attributes = $_GET['KPRencanaLemburT'];
    //$modRencanaDiklat->nomorindukpegawai = $_GET['KPRencanadiklatT']['nomorindukpegawai'];
    //$modRencanaDiklat->nama_pegawai = $_GET['KPRencanadiklatT']['nama_pegawai'];
}
$this->widget('ext.bootstrap.widgets.BootGroupGridView', array(
    'id' => 'rencanalemburload-grid',
    'dataProvider' => $modRencanaDiklat->searchDialog(),
    'filter' => $modRencanaDiklat,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectRencanaLembur",
                                    "onClick" => "
                                                loadRencana($data->rencanalembur_id);
                                                $(\"#dialogRencanaLembur\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'No. Rencana',
            'name' => 'norencana',
            'value' => '$data->norencana',
        ),
        array(
            'header' => 'Keterangan',
            'name' => 'keterangan',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
        . '     $(".hurufs-only").keyup(function() {
            setHurufsOnly(this);
            });
            $(".numbers-only").keyup(function() {
            setNumbersOnly(this);
            });}',
));
$this->endWidget();
//========= end No Rencana Diklat dialog =============================
?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array(
    'modRencanaLembur' => $modRencanaLembur, 'modDetail' => $modDetail, 'modRealisasiLembur' => $modRealisasiLembur,
    'modRealisasiLemburDetail' => $modRealisasiLemburDetail, 'modPegawai' => $modPegawai,
), true); ?>