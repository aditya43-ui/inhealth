

<div class="acc_rujukan">

<?php
echo CHtml::activeHiddenField($modRujukKeluar, '['.$i.']tindakanpelayanan_id', array('class' => 'rujukkeluar-daftartindakan-id'));
echo CHtml::activeHiddenField($modRujukKeluar, '['.$i.']pasienmasukpenunjang_id', array('class' => 'rujukkeluar-pasienmasukpenunjang-id'));
?>

<table class="tab_header">
    <tr>
        <td>Tgl. Pendaftaran</td>
        <td>:</td>
        <td class="unwrap" id="rujuk_tgl_pendaftaran"></td>
        <td>Tgl. Masuk Penunjang</td>
        <td>:</td>
        <td id="rujuk_tglmasukpenunjang"></td>
    </tr>
    <tr>
        <td>No. Pendaftaran</td>
        <td>:</td>
        <td class="unwrap" id="rujuk_no_pendaftaran"></td>
        <td>No. Masuk Penunjang</td>
        <td>:</td>
        <td id="rujuk_no_masukpenunjang"></td>
    </tr>
    <tr>
        <td>No. Rekam Medik</td>
        <td>:</td>
        <td class="unwrap" id="rujuk_no_rekam_medik"></td>
        <td>Nama Pasien</td>
        <td>:</td>
        <td id="rujuk_nama_pasien"></td>
    </tr>
    <tr>
        <td>Instalasi Asal</td>
        <td>:</td>
        <td class="unwrap" id="rujuk_instalasiasal_nama"></td>
        <td>Ruangan Asal</td>
        <td>:</td>
        <td id="rujuk_ruanganasal_nama"></td>
    </tr>
    <tr>
        <td>Jenis Penjamin</td>
        <td>:</td>
        <td class="unwrap" id="rujuk_carabayar_nama"></td>
        <td>Penjamin</td>
        <td>:</td>
        <td id="rujuk_penjamin_nama"></td>
    </tr>
    <tr>
        <td>Pemeriksaan</td>
        <td>:</td>
        <td colspan="4" class="unwrap" id="rujuk_daftartindakan_nama"></td>
    </tr>
</table>

<hr>

<div class="col-sm-6">
    <div class="control-group">
        <?php //echo $form->labelEx($modRujukKeluar, '['.$i.']pemeriksaankeluar_tgl', array('class' => 'control-label')) ?>
        <?php echo CHtml::label("Tanggal", 'pemeriksaankeluar_tgl', array('class'=>'control-label')) ?>
        <div class="controls">
            <?php
            $this->widget('MyDateTimePicker', array(
                'model' => $modRujukKeluar,
                'attribute' => '['.$i.']pemeriksaankeluar_tgl',
                'mode' => 'date',
                'options' => array(
                    'dateFormat' => Params::DATE_FORMAT,
                    'maxDate' => 'd',		
                ),
                'htmlOptions' => array(
                    'readonly' => true, 'class' => 'dtPicker2 txt_pemeriksaankeluar_tgl', 'onkeypress' => "return $(this).focusNextInputField(event)", 'style' => 'width:150px;'
                ),
            ));
            ?>
        </div>
    </div>
    
    <div class="control-group">
        <?php echo CHtml::label("Klinik Rujukan",'labklinikrujukan_id', array('class' => 'control-label')); ?>
        <div class="controls">
        <?php 
            $modRujukKeluar->labklinikrujukan_id = trim($modRujukKeluar->labklinikrujukan_id);
            //echo $form->dropDownListRow($modRujukKeluar, '['.$i.']labklinikrujukan_id', CHtml::listData($modRujukKeluar->LabKlinikRujukanItems, 'labklinikrujukan_id', 'labklinikrujukan_nama'), array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event)",
            //	'empty' => '-- Pilih --'));
            echo CHtml::activeDropDownList($modRujukKeluar, '['.$i.']labklinikrujukan_id', CHtml::listData($modRujukKeluar->LabKlinikRujukanItems, 'labklinikrujukan_id', 'labklinikrujukan_nama'), array('class' => 'span2 txt_klinikrujukan', 'onkeypress' => "return $(this).focusNextInputField(event)",
                'empty' => '-- Pilih --'));
        ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label("Dokter Pengiriman",'', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($modRujukKeluar,'['.$i.']dokterpengirim_id', CHtml::listData(ROPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id,'userlogin'), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 txt_dokterpengirim')); ?>
            <?php //echo $form->dropDownListRow($modRujukKeluar,'['.$i.']dokterpengirim_id', CHtml::listData(ROPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id,'userlogin'), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
        </div>
    </div>

    

    <div class="control-group">
        <?php echo CHtml::label("Perawat",'', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($modRujukKeluar,'['.$i.']perawat_id', PegawaiV::model()->getPerawatItems() ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 txt_perawat')); ?>
            <?php //echo $form->dropDownListRow($modRujukKeluar,'['.$i.']dokterpengirim_id', CHtml::listData(ROPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id,'userlogin'), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
        </div>
    </div>
    <div class="control-group">
        <?php echo CHtml::label("Sopir",'', array('class' => 'control-label')); ?>
        <div class="controls">
            <?php echo CHtml::activeDropDownList($modRujukKeluar,'['.$i.']supir_id', PegawaiV::model()->getPegawaiJabatanItems(array(Params::JABATAN_ID_DRIVER, Params::JABATAN_ID_LAUNDRY, Params::JABATAN_ID_KESLING, Params::JABATAN_ID_SECURITY)) ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3 txt_sopir')); ?>
            <?php //echo $form->dropDownListRow($modRujukKeluar,'['.$i.']dokterpengirim_id', CHtml::listData(ROPendaftaranT::model()->getDokterItems($modPasienMasukPenunjang->ruangan_id,'userlogin'), 'pegawai_id', 'nama_pegawai') ,array('empty'=>'-- Pilih --','onkeyup'=>"return $(this).focusNextInputField(event)", 'class'=>'span3')); ?>
        </div>
    </div>
    
</div>	
<div class="col-sm-6">
    <div class="control-group">
        <?php echo CHtml::label("Alasan Dirujuk",'',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php //echo $form->dropDownListRow($modRujukKeluar, '['.$i.']pemeriksaankeluar_alasan', LookupM::getItems('alasanrad_dirujuk'),array('maxlength'=>200,'rows' => 6, 'cols' => 50, 'class' => 'span3 autogrow', 'onkeyup' => "return $(this).focusNextInputField(event);",'empty' => '-- Pilih --')); ?>
            <?php echo CHtml::activeDropDownList($modRujukKeluar, '['.$i.']pemeriksaankeluar_alasan', LookupM::getItems('alasanrad_dirujuk'),array('maxlength'=>200,'rows' => 6, 'cols' => 50, 'class' => 'span3 autogrow alasanrujuk', 'onkeyup' => "return $(this).focusNextInputField(event);",'empty' => '-- Pilih --')); ?>
        </div>
    </div>

    <div class="control-group">
        <?php echo CHtml::label("Keterangan",'',array('class'=>'control-label')); ?>
        <div class="controls">
            <?php //echo $form->textAreaRow($modRujukKeluar, '['.$i.']pemeriksaankeluar_ket', array('rows' => 6, 'cols' => 50, 'class' => 'span3 autogrow')); ?>
            <?php echo CHtml::activeTextArea($modRujukKeluar, '['.$i.']pemeriksaankeluar_ket', array('rows' => 6, 'cols' => 50, 'class' => 'span3 autogrow')); ?>
        </div>
    </div>

</div>
<div class="clear"></div>
    
<?php 

echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="'.MyIcon::getIcons('simpan').'"></i>')), array('class' => 'btn btn-danger', 'type' => 'button', 'onkeypress' => 'formSubmit(this,event);', 'onclick'=>'simpanRujukanKeluar();'));

?>

</div>

    

    
