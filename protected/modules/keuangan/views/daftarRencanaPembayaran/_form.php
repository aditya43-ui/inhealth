<div class="row-fluid">
    <p class="help-block"><?php echo Yii::t('mds', 'Fields with <span class="required">*</span> are required.') ?></p>
    <div class="span6">
         <?php if(isset($_GET['sukses'])){ ?> 
             <?php echo CHtml::hiddenField('daftarrencanapembayaran_id',$modVer->daftarrencanapembayaran_id,array('readonly'=>true,'class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event)")); ?>
         <?php } ?>
        
        <?php // echo $form->textFieldRow($modVer, 'no_voucher', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'disabled'=>true)); ?>
		
		<div class="control-group ">
            <?php echo CHtml::label('No BKU  <span class="required">*</span>', '',array('class' => 'control-label')); ?>
            <div class="controls">
                <?php echo CHtml::hiddenField("tgl_awal_piutang") ?>
                <?php echo CHtml::hiddenField("tgl_akhir_piutang") ?>
                <?php echo CHtml::hiddenField("nojaminan_piutang") ?>
                <?php echo CHtml::hiddenField("nama_perusahaan_piutang") ?>
                <?php 
                $default = "0001";
//                $prefix = date('Ymd');
                $sql = "SELECT count(*) nomaksimal FROM bkupengembalianuangmuka_t";
                
//                $sql = "SELECT CAST(MAX(SUBSTR(no_penagihan," . (strlen($prefix) + 1) . "," . (strlen($default)) . ")) AS integer) nomaksimal 
//				FROM penagihanpiutang_t";
        $voucher = Yii::app()->db->createCommand($sql)->queryRow();
        $no_baru = (isset($voucher['nomaksimal']) ? (str_pad($voucher['nomaksimal'] + 1, strlen($default), 0, STR_PAD_LEFT)) : $default);
        
                    echo CHtml::textField('voucherno_counter',$no_baru,array('class' => 'span1'));
					echo " / " . CHtml::textField('voucherno_kode','U',array('class' => 'span1', 'readonly'=>false));
					echo " / " . CHtml::textField('voucherno_kd','BM',array('class' => 'span1', 'readonly'=>false));
					$tgl = date('d');
                    echo " / " . CHtml::textField('voucherno_tgl',$tgl,array('class' => 'span1', 'readonly'=>false));
					$bln = date('m');
                    echo " / " . CHtml::textField('voucherno_bulan',$bln,array('class' => 'span1', 'readonly'=>false));
                    echo " / " .CHtml::textField('voucherno_tahun',date('Y'),array('class' => 'span1', 'readonly'=>false));
                ?>
            </div>
        </div>
		
		<div class="control-group ">
            <?php echo $form->labelEx($modVer, 'tglvoucher', array('class' => 'control-label')) ?>
            <div class="controls">
                <?php
                $modVer->tglvoucher = !empty($modVer->tglvoucher) ? $format->formatDateTimeForUser($modVer->tglvoucher) : date('d M Y');
                $this->widget('MyDateTimePicker', array(
                    'model' => $modVer,
                    'attribute' => 'tglvoucher',
                    'mode' => 'date',
                    'options' => array(
                        'dateFormat' => Params::DATE_FORMAT,
                    ),
                    'htmlOptions' => array('readonly' => true, 'class' => 'dtPicker3', 'onkeypress' => "return $(this).focusNextInputField(event)",),
                ));
                $modVer->tglvoucher = !empty($modVer->tglvoucher) ? $format->formatDateTimeForDb($modVer->tglvoucher) : date('Y-m-d');
                ?>
                <?php echo $form->error($modVer, 'tglvoucher'); ?>
            </div>
        </div>
		
        <div class='control-group'>
			<label class="control-label">Cara Pembayaran </label>
			<div class="controls">
				<?php echo $form->dropDownList($modVer, 'no_voucher', LookupM::getItems('carapembayaran'), array('class' => 'span2', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
			</div>
		</div>
		<div class='control-group'>
			<label class="control-label">Jenis Pengeluaran <span class="required">*</span></label>
            <div class="controls">
                <?php echo $form->hiddenField($modVer, 'jenispengeluaran_id', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
                <?php
                $this->widget('MyJuiAutoComplete', array(
                    'model' => $modVer,
                    'attribute' => 'jenispengeluaran_nama',
                    'source' => 'js: function(request, response) {
                            $.ajax({
                                    url: "' . $this->createUrl('AutocompleteJenisPengeluaran') . '",
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
                        'select'=>'js:function( event, ui ) {
							$(this).val( ui.item.label);
                            $("#' . Chtml::activeId($modVer, 'jenispengeluaran_id') . '").val(ui.item.value);
							return false;
						}'
                    ),
                    'htmlOptions' => array(
                        'class' => 'jenispengeluaran_id span3',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogJenisPengeluaran'),
                ));
                ?>
                <?php // echo $form->dropDownList($modVer, 'jenispenerimaan_id', CHtml::listData(VRJenispenerimaanM::model()->findAllByAttributes(array('jenispenerimaan_aktif' => true), array('order' => 'jenispenerimaan_id')), 'jenispenerimaan_id', 'jenispenerimaan_nama'), array('class' => 'span3', 'empty' => '-- Pilih --', 'onkeypress' => "return $(this).focusNextInputField(event)")); ?>
            </div>
        </div>
		<div class="control-group ">
			<label class="control-label">Nama Bank <span class="required">*</span></label>
			<div class="controls">
				<?php echo $form->dropDownList($modVer, 'bank_id', CHtml::listData(BankM::model()->findAllByAttributes(array('bank_aktif' => true), array('order' => 'bank_id')), 'bank_id', 'namabank'), array('class' => 'span2', 'empty' => '-- Pilih --', 'onchange'=>'changeNoRekening(this);')); ?>
			</div>
		</div>
		<div class='control-group'>
			<label class="control-label">Nama Perusahaan </label>
			<div class="controls">
				<?php echo $form->textField($modVer, 'supplier_nama', array('class' => 'span3', 'readonly' => true)); ?>
			</div>
		</div>
    </div>
    <div class="span6">
        <div class="control-group">
			<label class="control-label">Jumlah Pengembalian<span class="required">*</span></label>
			<div class="controls">  
				<?php echo $form->textField($modVer, 'nama_perusahaan', array('class' => 'span3 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
        <div class="control-group">
			<label class="control-label">Biaya Administrasi <span class="required">*</span></label>
			<div class="controls">  
				<?php // echo $form->textField($modVer, 'biaya_administrasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->textField($modVer, 'nama_perusahaan', array('class' => 'span3 integer', 'onblur'=>'totalPengembalian();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
        <div class="control-group">
			<label class="control-label">Biaya Materai <span class="required">*</span></label>
			<div class="controls">  
				<?php // echo $form->textField($modVer, 'biaya_materai', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->textField($modVer, 'nama_perusahaan', array('class' => 'span3 integer', 'onblur'=>'totalPengembalian();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
       <div class="control-group">
			<label class="control-label">Keringanan <span class="required">*</span></label>
			<div class="controls">  
				<?php // echo $form->textField($modVer, 'diskon', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->textField($modVer, 'diskon', array('class' => 'span3 integer', 'onblur'=>'totalPengembalian();', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
			</div>
		</div>
		<div class="control-group">
			<label class="control-label">Total Pengembalian <span class="required">*</span></label>
			<div class="controls">  
				<?php // echo $form->textField($modVer, 'total_pengembalian', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->textField($modVer, 'nama_perusahaan', array('class' => 'span2 integer', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?>
				<?php echo $form->hiddenField($modVer,'ver_pengembalianuangmuka_id',array('class'=>'span1','readonly'=>true)); ?>
				<?php echo $form->hiddenField($modVer,'daftarrencanapembayaran_id',array('class'=>'span1','readonly'=>true)); ?>
			</div>
		</div>
    </div>
</div>

<?php 
//========= Dialog buat cari data dialogJenisPenerimaan =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogJenisPengeluaran',
    'options' => array(
        'title' => 'Jenis Penerimaan',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modJenisPenerimaan = new KUJenispengeluaranM('searchDialog');
$modJenisPenerimaan->unsetAttributes();
if (isset($_GET['KUJenispengeluaranM'])) {
    $modJenisPenerimaan->attributes = $_GET['KUJenispengeluaranM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'jenispenerimaan-grid',
    'dataProvider' => $modJenisPenerimaan->searchDialog(),
    'filter' => $modJenisPenerimaan,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "$(\"#' . CHtml::activeId($modVer, 'jenispengeluaran_nama') . '\").val(\"$data->jenispengeluaran_nama\");
                                                  $(\"#' . CHtml::activeId($modVer, 'jenispengeluaran_id') . '\").val(\"$data->jenispengeluaran_id\");
                                                      $(\"#dialogJenisPengeluaran\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'Kode',
            'name'  =>'jenispengeluaran_kode',
            'value' => '$data->jenispengeluaran_kode',
        ),
        array(
            'header' => 'Nama',
            'name'  =>'jenispengeluaran_nama',
            'value' => '$data->jenispengeluaran_nama',
        ),
        array(
            'header' => 'Status',
//            'filter' => CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
            'value' => '($data->jenispengeluaran_aktif == 1) ? "Aktif" : "Tidak Aktif" ',
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end mak dialog =============================
?>

<?php 
//========= Dialog buat cari data dialogMak =========================
// dicomment karena RSHK-730
/*$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogMak',
    'options' => array(
        'title' => 'Mata Anggaran',
        'autoOpen' => false,
        'modal' => true,
        'width' => 900,
        'height' => 600,
        'zIndex' => 1002,
        'resizable' => false,
    ),
));

$modMak = new VRMataanggaranM('search');
$modMak->unsetAttributes();
if (isset($_GET['VRMataanggaranM'])) {
    $modMak->attributes = $_GET['VRMataanggaranM'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modMak->search(),
    'filter' => $modMak,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "$(\"#' . CHtml::activeId($modVer, 'mak') . '\").val(\"$data->matananggaran_kode\");
                                                  $(\"#' . CHtml::activeId($modVer, 'nama_mak') . '\").val(\"$data->mataanggaran_nama\");
                                                  $(\"#' . CHtml::activeId($modVer, 'rekeningmak_id') . '\").val(\"$data->mataanggaran_id\");    
                                                  $(\"#dialogMak\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'Kode',
            'name'  =>'matananggaran_kode',
            'value' => '$data->matananggaran_kode',
        ),
        array(
            'header' => 'Nama MAK',
            'name'  =>'mataanggaran_nama',
            'value' => '$data->mataanggaran_nama',
        ),
        array(
            'header' => 'Sumber Anggaran',
//            'filter' => CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
            'value'=>'$data->getSumberAnggaran($data->sumberanggaran_id)',
        ),
        array(
            'header' => 'Status',
//            'filter' => CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
            'value' => '($data->mataanggaran_aktif == 1) ? "Aktif" : "Tidak Aktif" ',
        ),
        
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
 * 
 */
//========= end mak dialog =============================
?>

<?php 
//========= Dialog buat cari data Pegawai =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogPegawai',
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

$modPegawaiMenyetujui = new VRPegawairuanganV('search');
$modPegawaiMenyetujui->unsetAttributes();
if (isset($_GET['VRPegawairuanganV'])) {
    $modPegawaiMenyetujui->attributes = $_GET['VRPegawairuanganV'];
}
$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'pegawaimenyetujui-grid',
    'dataProvider' => $modPegawaiMenyetujui->searchPegawaiMenyetujui(),
    'filter' => $modPegawaiMenyetujui,
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        array(
            'header' => 'Pilih',
            'type' => 'raw',
            'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","",array("class"=>"btn-small", 
                                    "href"=>"",
                                    "id" => "selectObat",
                                    "onClick" => "$(\"#' . CHtml::activeId($modVer, 'peg_verifikasi') . '\").val(\"$data->NamaLengkap\");
                                                  $(\"#dialogPegawai\").dialog(\"close\"); 
                                                  return false;
                                        "))',
        ),
        array(
            'header' => 'NIP',
            'filter' => CHtml::activeTextField($modPegawaiMenyetujui, 'nomorindukpegawai'),
            'value' => '$data->nomorindukpegawai',
        ),
        array(
            'header' => 'Gelar Depan',
            'filter' => CHtml::activeTextField($modPegawaiMenyetujui, 'gelardepan'),
            'value' => '$data->gelardepan',
        ),
        array(
            'header' => 'Nama Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMenyetujui, 'nama_pegawai'),
            'value' => '$data->nama_pegawai',
        ),
        array(
            'header' => 'Gelar Belakang',
            'filter' => CHtml::activeTextField($modPegawaiMenyetujui, 'gelarbelakang_nama'),
            'value' => '$data->gelarbelakang_nama',
        ),
        array(
            'header' => 'Alamat Pegawai',
            'filter' => CHtml::activeTextField($modPegawaiMenyetujui, 'alamat_pegawai'),
            'value' => '$data->alamat_pegawai',
        ),
    ),
    'afterAjaxUpdate' => 'function(id, data){
            jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));
$this->endWidget();
//========= end Pegawai dialog =============================
?>
<script type="text/javascript">
	function changeNoRekening($data)
    {
        var $bank_id = $($data).val();

            $.ajax({
                    type:'POST',
                    url:'<?php echo $this->createUrl('getNoRekening'); ?>',
                    data: {bank_id: $bank_id},//
                    dataType: "json",
                    success:function(data){
                       if(data != null){
							$("#KUBkupengembalianuangmukaT_no_rekening").val(data.norekening);
                       }
                    },
                    error: function (jqXHR, textStatus, errorThrown) { console.log(errorThrown);}
            });
    }
	
	function totalPengembalian(){
		unformatNumberSemua();
        var total_pengembalian = 0;
        var jml_pengembalian = parseInt($('#KUBkupengembalianuangmukaT_jml_pengembalian').val());
        var biaya_administrasi = parseInt($('#KUBkupengembalianuangmukaT_biaya_administrasi').val());
        var biaya_materai = parseInt($('#KUBkupengembalianuangmukaT_biaya_materai').val());
		var diskon = parseInt($('#KUBkupengembalianuangmukaT_diskon').val());
        if(jml_pengembalian !== '' && biaya_administrasi !== '' && biaya_materai !== '' && diskon !== ''){
            total_pengembalian = parseInt(jml_pengembalian) - parseInt(biaya_administrasi) - parseInt(biaya_materai) - parseInt(diskon);
            $('#KUBkupengembalianuangmukaT_total_pengembalian').val(total_pengembalian);
            
//            hitungTotalHarga();
        }
		formatNumberSemua();
    }     
</script>
