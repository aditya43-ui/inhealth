<style>
    
    .tab_header {
        width: 100%;
    }
    
    .tab_header td {
        border: 1px solid black;
        line-height: 32px;
        padding-left: 5px;
        vertical-align: top;
    }
    
    .tab_header .head_cell {
        font-weight: bold;
    }
    
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }
    
    p {
        text-align: justify;
    }
    
    .td_date input {
        float: left !important;
    }
</style>

<?php 
$this->widget('bootstrap.widgets.BootAlert');

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();

echo $this->renderPartial($this->path_view.'_header', array('modProfilRs'=>$modProfilRs)); 

$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'suratpersetujuanumumkeuangan-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); 


?>
<h3 style="text-align: center; font-weight: bold">PERSETUJUAN PERSYARATAN KEUANGAN RAWAT INAP</h3>
<h4 style="text-align: center; font-weight: bold">PASIEN ATAU PENANGGUNG JAWAB/PENJAMIN PASIEN DIMINTA MEMBACA, MEMAHAMI DAN MENGISI INFORMASI BERIKUT</h4>

	<?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model,'pendaftaran_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
 <br/>   

<p>
    I. DATA PENANGGUNG JAWAB/ PENJAMIN PASIEN :
</p>
<div style="padding-left: 20px">
    <table style="width: 100%; border: none;">
        <tr>
            <td width="200px">Nama</td>
            <td>
               : <?php echo $form->textField($model,'tandatangan_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
        <tr>
            <td>Pekerjaan</td>
            <td>
               : <?php echo $form->textField($model,'penanggungjawab_pekerjaan',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            </td>
        </tr>
        <tr>
            <td>Alamat Rumah</td>
            <td>: <?php echo $form->textArea($model,'tandatangan_alamat',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?></td>
        </tr>
        <tr>
            <td>Telepon</td>
            <td>: <?php echo $form->textField($model,'tandatangan_telepon',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?></td>
        </tr>
        <tr>
            <td>No KTP/SIM</td>
            <td>: <?php echo $form->textField($model,'penanggungjawab_noktp',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?></td>
        </tr>
        <tr>
            <td>Hubungan dengan pasien</td>
            <td>: <?php echo $form->dropDownList($model,'tandatangan_hubungan', LookupM::getItems('hubungankeluarga'),array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?></td>
        </tr>
    </table>
</div>
<br/>
<p>
   II. DATA PASIEN RAWAT INAP
</p>
<div style="padding-left: 20px">
    <table style="width: 100%; border: none;">
        <tr>
            <td width="200px">Nama</td>
            <td>: 
                <?php 
                echo $form->textField($model,'pasien_nama',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); 
                echo " ".$form->radioButtonList($model,'pasien_jeniskelamin', LookupM::getItems('jeniskelamin') ,array('template'=>'{input}{label}&nbsp;', 'onkeyup'=>"return $(this).focusNextInputField(event);",'disabled'=>true));
                ?>
            </td>
        </tr>
        <tr>
            <td>No. Rekam Medis</td>
            <td>: <?php echo $form->textField($model,'pasien_no_rekam_medik',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td>Ruangan Perawatan / Kelas</td>
            <td>: 
                <?php echo CHtml::textField('ruangan',$modAdmisi->ruangan->ruangan_nama,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                <?php echo Chtml::textField('kelaspelayanan',$modAdmisi->kelaspelayanan->kelaspelayanan_nama,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
            </td>
        </tr>
        <tr>
            <td>Tempat/ Tanggal Lahir</td>
            <td> : 
                <?php echo CHtml::textField('tempatlahir',$modPasien->tempat_lahir,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
                <?php echo $form->textField($model,'pasien_tanggal_lahir',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?>
            </td>
        </tr>
        <tr>
            <td>Umur</td>
            <td>: <?php echo CHtml::textField('umur_pasien',$modPendaftaran->umur,array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>: <?php echo $form->textArea($model,'pasien_alamat',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'readonly'=>true)); ?></td>
        </tr>
    </table>
</div>
<br/>
<p>III. PERATURAN/KETENTUAN TERKAIT KEUANGAN</p>
<div style="padding-left: 20px">
<?php
    $peraturan = array();
    if(!empty($model->peraturankeuangan)){
        $peraturans = json_decode($model->peraturankeuangan);

        if(!empty($peraturans)){
            foreach($peraturans as $item){
                $peraturan[$item] = true;
            }
        }
    }
?>
<table>
    <tr>
        <td width="2%" valign="top">
            A.
        </td>
        <td width="90%">
            Perhitungan kamar perawatan dihitung mulai pukul 12.00 WIB s/d 12.00 keesokan harinya. Namun jika pasien masuk kedalam kamar perawatan masuk lebih dari 6 jam, maka pada hari yang sama tepat pukul 12.00 WIB pasien akan dihitung 1 (satu) hari penuh.
        </td>
        <td style="text-align: center" valign="top">
            <?php echo CHtml::hiddenField('Peraturankeuangan[0][nama]','A'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[0][iscek]', (!empty($peraturan['A'])?$peraturan['A']:false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            B.
        </td>
        <td>
            Jika pasien pulang lebih dari 6 jam dari pukul 12.00 WIB maka pasien akan dikenakan tambahan biaya kamar 1 hari, kecuali jika ada penundaan jadwal perawatan medis yang disebabkan oleh pihak rumah sakit............
        </td>
        <td valign="top" style="text-align: center">
            <?php echo CHtml::hiddenField('Peraturankeuangan[1][nama]','B'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[1][iscek]',(!empty($peraturan['B'])?$peraturan['B']:false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            C.
        </td>
        <td>
            Pindah ruangan tidak diperkenankan dilakukan pada hari yang sama harus menunggu 24 jam dihitung dari hari masuk ruang perawatan pertama kali. (kurang dari 24 jam, kamar tetap di tarif full)....................................... 
        </td>
        <td valign="top" style="text-align: center">
            <?php echo CHtml::hiddenField('Peraturankeuangan[2][nama]','C'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[2][iscek]',(!empty($peraturan['C'])?$peraturan['C']:false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            D.
        </td>
        <td>
            Pasien diperkenankan masuk ke ruang rawat inap sesuai instruksi Dokter dan diwajibkan membayar deposit 5x harga tarif sewa kamar sesuai ketentuan kelas perawatan yang dipilih pada saat pendaftaran dalam jangka waktu 1x24 jam. 
        </td>
        <td valign="top" style="text-align: center">
            <?php echo CHtml::hiddenField('Peraturankeuangan[3][nama]','D'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[3][iscek]',(!empty($peraturan['D'])?$peraturan['D']:false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            E.
        </td>
        <td>
            Khusus ruang intensif dewasa dan anak (HCU/ICU/PICU/NICU) baik ruang standar maupun isolasi diwajibkan membayar deposit awal sebesar 10x harga sewa kamar sesuai ketentuan kelas perawatan yang dipilih pada saat pendaftaran dalam jangka waktu 1x24 jam. 
        </td>
        <td valign="top" style="text-align: center">
            <?php echo CHtml::hiddenField('Peraturankeuangan[4][nama]','E'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[4][iscek]',(!empty($peraturan['E'])?$peraturan['E']:false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            F.
        </td>
        <td>
            Apabila dalam perawatan ada tindakan operasi yang telah disetujui oleh pasien/ penanggung jawab pasien, maka wajib membayar deposit tambahan sebesar 50% dari yang tercantum dalam formulir perkiraan biaya tindakan/ operasi yang telah disetujui.  
        </td>
        <td valign="top" style="text-align: center">
            <?php echo CHtml::hiddenField('Peraturankeuangan[5][nama]','F'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[5][iscek]',(!empty($peraturan['F'])?$peraturan['F']:false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            G.
        </td>
        <td>
            Apabila biaya layanan rawat inap sudah 80% dari jumlah deposit awal, maka <?php echo $modProfilRs->nama_rumahsakit ?> berhak melakukan penagihan deposit tambahan sebesar 3x harga sewa kamar per 2 hari untuk biaya perawatan kepada pasien / penanggung jawab pasien. 
        </td>
        <td valign="top" style="text-align: center">
            <?php echo CHtml::hiddenField('Peraturankeuangan[6][nama]','G'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[6][iscek]',(!empty($peraturan['G'])?$peraturan['G']:false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            H.
        </td>
        <td>
            Apabila pasien tidak dapat memenuhi ketentuan deposit dan melebihi jangka waktu toleransi pembayaran , maka pihak <?php echo $modProfilRs->nama_rumahsakit ?> berhak untuk memberikan obat-obatan, pemeriksaan atau tindakan medis dengan pembayaran terlebih dahulu oleh pasien / penanggung jawab pasien, terkecuali dalam keadaan kegawat daruratan medis.
        </td>
        <td valign="top" style="text-align: center">
            <?php echo CHtml::hiddenField('Peraturankeuangan[7][nama]','H'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[7][iscek]',(!empty($peraturan['H'])?$peraturan['H']:false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            I.
        </td>
        <td>
            Pasien asuransi bersedia membayar selisih yang tidak dijamin oleh pihak asuransi. 
        </td>
        <td valign="top" style="text-align: center">
            <?php echo CHtml::hiddenField('Peraturankeuangan[8][nama]','I'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[8][iscek]',(!empty($peraturan['I'])?$peraturan['I']:false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            J.
        </td>
        <td>
            Pasien ODS yang akan dirujuk ke rawat inap, seluruh biaya tindakan akan mengikuti tarif biaya kelas rawat inap yang ditempati.
        </td>
        <td valign="top" style="text-align: center">
            <?php echo CHtml::hiddenField('Peraturankeuangan[9][nama]','J'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[9][iscek]',(!empty($peraturan['J'])?$peraturan['J']:false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            K.
        </td>
        <td>
            Biaya administrasi rawat inap adalah 2,5% dari total biaya perawatan pasien umum dan 7,5% untuk pasien asuransi dan perusahaan.  
        </td>
        <td valign="top" style="text-align: center">
            <?php echo CHtml::hiddenField('Peraturankeuangan[10][nama]','K'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[10][iscek]',(!empty($peraturan['K'])?$peraturan['K']:false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            L.
        </td>
        <td>
            Pasien bersedia mengganti semua barang atau peralatan milik <?php echo $modProfilRs->nama_rumahsakit ?> yang rusak/pecah/hilang oleh pasien atau keluarga pasien.
        </td>
        <td valign="top" style="text-align: center">
            <?php echo CHtml::hiddenField('Peraturankeuangan[11][nama]','L'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[11][iscek]',(!empty($peraturan['L'])?$peraturan['L']:false)); ?>
        </td>
    </tr>
    <tr>
        <td valign="top">
            M.
        </td>
        <td>
            Penanggung jawab dan/atau penjamin pasien yang bertanda tangan dibawah ini berkewajiban dan menyanggupi pembayaran seluruh tagihan perawatan yang tercetak dibilling tagihan sesuai ketentuan yang berlaku dan melunasi seluruh biaya sebelum keluar dan apabila kami tidak dapat melaksanakan pembayaran dengan baik, kami bersedia menerima sanksi yang berlaku. 
        </td>
        <td valign="top" style="text-align: center">
            <?php echo CHtml::hiddenField('Peraturankeuangan[12][nama]','M'); ?>
            <?php echo CHtml::checkbox('Peraturankeuangan[12][iscek]',(!empty($peraturan['M'])?$peraturan['M']:false)); ?>
        </td>
    </tr>
</table>
</div>
<br/>
<p>
    Dengan ditandatanginya formulir ini maka penanggung jawab dan/ atau penjamin pasien secara sadar dan tanpa paksaan menyatakan semua data yang diisi adalah benar dan dimengerti, menerima serta bersedia untuk mematuhi seluruh peraturan/ketentuan diatas juga bertanggung jawab dan bersedia untuk dihubungi oleh pihak <?php echo $modProfilRs->nama_rumahsakit ?> untuk segala sesuatu yang berkaitan dengan biaya pengobatan pasien tersebut di atas.
</p>



<table style="width: 100%; border: none;">
    <tr>
        <td colspan="2" class="td_date"> 
            <?php echo $modProfilRs->kabupaten->kabupaten_nama; ?>, 
            <?php   
            $this->widget('MyDateTimePicker',array(
                            'model'=>$model,
                            'attribute'=>'tgl_persetujuan',
                            'mode'=>'datetime',
                            'options'=> array(
                                'dateFormat'=>Params::DATE_FORMAT,
                            ),
                            'htmlOptions'=>array(
                                'readonly'=>true, 'onkeyup'=>"return $(this).focusNextInputField(event)",
                                'style'=>'width: 150px; float-left',
                            ),
            )); ?>
            
            
		</td>
    </tr>
    <tr>
        <td style="text-align: center;" width="50%">
        Penanggung jawab dan/atau penjamin pasien
            <br>
            <br>
            <br>
            <br>
            <br>
			<?php echo $form->textField($model,'penanggungjawab_pasien',array('class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
            
        </td>
        <td width="200" style="text-align: center;" width="50%">
        Petugas Pendaftaran
            <br>
            <br>
            <br>
            <br>
            <br>
			<?php 
            $peg = CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
                'ruangan_id'=>Params::RUANGAN_ID_LOKET_PENDAFTARAN
            )), 'nama_pegawai', 'nama_pegawai');
            echo $form->dropDownList($model,'petugas_admisi', $peg, array('empty'=>'-- Pilih --','class'=>'span3', 'onkeyup'=>"return $(this).focusNextInputField(event);"));
            ?>
            
        </td>
    </tr>
</table>
<br><br><br><br><br>
<table width="100%">
    <tr>
        <td width="35%">Lembar Putih: Status Pasien</td>
        <td width="30%">Lembar Merah: Pendafaran</td>
        <td width="35%">Lembar Kuning: Pasien</td>
    </tr>
</table>

<br>
	<div class="form-actions">
		<?php echo CHtml::htmlButton(
        Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
        array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)')
    ); ?>
		<?php echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'onclick'=>'print();', 'disabled'=>(!empty($_GET['sukses'])?false:true))); ?>
		
		</div>
	</div>
<?php $this->endWidget(); ?>

    
<script>

function print()
{
    window.open('<?php echo $this->createUrl('printKeuangan',array('pendaftaran_id'=>$model->pendaftaran_id)); ?>','printwin','left=100,top=100,width=860,height=480');
}

$("#SuratpersetujuanumumT_tandatangan_nama").blur(function() {
    $("#SuratpersetujuanumumT_penanggungjawab_pasien").val($(this).val());
});

$("#SuratpersetujuanumumT_penanggungjawab_pasien").blur(function() {
    $("#SuratpersetujuanumumT_tandatangan_nama").val($(this).val());
});

</script>