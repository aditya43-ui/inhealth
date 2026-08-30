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
    
    .coret {
        text-decoration: line-through;
    }
    
</style>

<?php 

$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
$modAnamnesa = AnamnesaT::model()->findByAttributes(array(
    'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
), array(
    'order'=>'anamesa_id desc',
));

if (empty($modAnamnesa)) {
    $modAnamnesa = new AnamnesaT;
}

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();


$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'suratpersetujuanumum-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); 


?>

<table style="width: 100%; border: none;">
    <thead>
        <tr>
             <td>
                <div class="header">
                  
                        <div class="judulcontent"><h3 style="text-align: center;">GENERAL CONCENT</h3></div>

	<?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model,'pendaftaran_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

    <table class="tab_header">
        <tr>
            <td rowspan="2" colspan="2" width="50%" align="center"><img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit_2 ?> " style="height: 60px;"/></td>
            <td width="20%" class="head_cell">No. RM</td>
            <td><?php echo $modPasien->no_rekam_medik." / ".substr($modPasien->jeniskelamin, 0, 1); ?></td>
        </tr>
        <tr>
            <td class="head_cell">Nama</td>
            <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td width="20%" class="head_cell">Riwayat Alergi</td>
            <td><?php echo $modAnamnesa->riwayatalergiobat; ?></td>
            <td class="head_cell">Tgl. Lahir</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>
        </tr>
        <tr>
            <td class="head_cell">Riwayat Penyakit Terdahulu</td>
            <td><?php echo $modAnamnesa->riwayatpenyakitterdahulu; ?></td>
            <td class="head_cell">Alamat</td>
            <td><?php echo $modPasien->alamat_pasien; ?></td>
        </tr>
    </table>
                    </div>  
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
			
                    
    
<p>
    Saya yang bertanda tangan dibawah ini :
</p>

<table style="width: 100%; border: none;">
    <tr>
        <td width="100">Nama</td>
        <td>: 
            <?php 
            echo $model->tandatangan_nama; 
            echo "(".$model->tandatangan_jeniskelamin.")";
            ?>
        </td>
    </tr>
    <tr>
        <td>Tgl. Lahir</td>
        <td>: 
            <?php echo $model->tandatangan_tanggal_lahir; ?>
        </td>
    </tr>
    <tr>
        <td>Alamat</td>
        <td>: <?php echo $model->tandatangan_alamat; ?></td>
    </tr>
    <tr>
        <td>Telepon</td>
        <td>: <?php echo $model->tandatangan_telepon; ?></td>
	</tr>
</table>

<p>
    Menyatakan dengan sesungguhnya Dari Saya Sendiri sebagai 
    <?php echo $model->tandatangan_hubungan; ?>
    dari pasien :
</p>
<table style="width: 100%; border: none;">
    <tr>
        <td width="100">Nama</td>
        <td>: 
            <?php 
            echo $model->pasien_nama; 
            echo " (".$model->pasien_jeniskelamin.")";
            ?>
        </td>
    </tr>
    <tr>
        <td>Tgl. Lahir</td>
        <td>: 
            <?php echo $model->pasien_tanggal_lahir; ?>
        </td>
    </tr>
    <tr>
        <td>No. RM</td>
        <td>: <?php echo $model->pasien_no_rekam_medik; ?></td>
	</tr>
    <tr>
        <td>Alamat</td>
        <td>: <?php echo $model->pasien_alamat; ?></td>
    </tr>
</table>

<p>Dengan ini menyatakan telah mendapat informasi dan menyatakan persetujuan tentang : </p>
<h5>A. PERAWATAN dan PENGOBATAN : </h5>
<p>
    
    Saya menyetujui untuk dirawat di PRISCILLA MEDICAL CENTER  sesuai kebutuhan medis. Saya mengetahui
bahwa hubungan dokter pasien adalah hubungan profesional di bidang kesehatan atas dasar kepercayaan
untuk upaya pengobatan terhadap pasien berupa upaya pemeliharaan kesehatan, pencegahan penyakit serta 
peningkatan kesehatan dan pemulihan kesehatan. Hubungan profesional ini merupakan upaya maksimal
pengabdian profesi kedokteran sesuai standar pelayanan, standar profesi, standar prosedur operasional dan
kebutuhan medis pasien sesuai UU Praktek Kedokteran No. 29/2004, UU Kesehatan No. 36/2009 dan UU
Rumah Sakit No. 44/2009
Saya memahami bahwa dalam proses pengobatan dan perawatan semua tindakan medis mempunyai resiko
yang ringan, sedang, sampai berat yang dapat mengancam jiwa / meninggal sesuai yang tertera dalam
INFORMED CONCENT. Jika saya memutuskan untuk menghentikan perawatan medis maka saya memahami
dan menyadari bahwa PRISCILLA MEDICAL CENTER  termasuk Dokter dan Paramedisnya tidak bertanggung jawab
atas hasil yang merugikan pasien.

    
</p>
<h5>B. PELEPASAN INFORMASI</h5>

<p>
    Saya memahami informasi tentang pasien, termasuk diagnosa, hasil tes diagnostik, hasil laboratorium yang akan
digunakan untuk perawatan medis dijamin kerahasiannya oleh pihak PRISCILLA MEDICAL CENTER, dan saya
memberikan wewenang kepada pihak PRISCILLA MEDICAL CENTER untuk memberikan informasi tentang diagnosa
hasil tes diagnosa, hasil laboratorium, hasil pengobatan dan perawatan saya bila diperlukan untuk memproses
klaim asuransi / perusahaan atau untuk penegakan hukum. Saya memberikan wewenang kepada pihak
PRISCILLA MEDICAL CENTER  untuk memberikan informasi tentang diagnosa, hasil tes diagnosa, hasil laboratorium
hasil pengobatan dan perawatan saya kepada anggota keluarga / kerabat saya sebagai berikut :<br>
<ol>
    <?php foreach ($model->pelepasan_informasi as $item): ?>
    <li>
        <?php echo $item; ?>
    </li>
    <?php endforeach; ?>
</ol>

</p>

<h5>C. HAK dan TANGGUNG JAWAB PASIEN</h5>

<p>
    
    Saya memahami bahwa harus ada saling pengertian tentang Hak dan Kewajiban pasien dan Dokter serta 
menyadari bahwa upaya pengobatan oleh dokter dapat masuk dalam ranah Hukum Khusus ( Lex Specialist )
Saya sebagai pasien mempunyai hak untuk mengambil bagian dalam keputusan pengelolaan penyakitnya dan
dalam hal perawatan medis serta rencana pengobatan  atau wali saya  ( untuk pasien yang tidak cakap hukum )
Saya telah mendapatkan informasi tentang Hak dan Tangung jawab pasien di PRISCILLA MEDICAL CENTER melalui
leaflet dan banner yang disediakan oleh petugas. Saya memahami bahwa PRISCILLA MEDICAL CENTER  tidak ber-
tanggun jawab atas kehilangan barang pribadi dan berharga yang dibawa pasien. Saya ikut bertangung jawab
atas ketertiban, kebersihan, ketenangan dan kenyamanan di PRISCILLA MEDICAL CENTER
Saya dan keluarga bersedia mematuhi tata tertib, termasuk jam berkunjung, kawasan dilarang merokok serta 
keluarga yang menunggu wajib memakai tanda pengenal khusus yang disediakan, keluarga atau siapapun
yang mengunjungi diluar jam berkunjung bersedia untuk diminta / diperiksa identitasnya

    
</p>
<h5>D. PRIVASI dan INFORMASI BIAYA</h5>

<?php echo $form->hiddenField($model,'ijin_mengunjungi', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
<?php echo $form->hiddenField($model,'ingin_privasi', array('onkeyup'=>"return $(this).focusNextInputField(event);")); ?>
<p>
    Saya <span class="pilihan_ijin <?php echo $model->ijin_mengunjungi ? "" : "coret"; ?>" data-ya="1">mengijinkan</span> / <span class="pilihan_ijin <?php echo $model->ijin_mengunjungi ? "coret" : ""; ?>" data-ya="0">tidak mengijinkan</span> keluarga / orang lain untuk mengunjungi / menemui saya.
</p>
<p>
    Saya <span class="pilihan_privasi <?php echo $model->ingin_privasi ? "" : "coret"; ?>" data-ya="1">menginginkan</span> / <span class="pilihan_privasi <?php echo $model->ingin_privasi ? "coret" : ""; ?>" data-ya="0">tidak menginginkan</span> privasi khusus : 
    <b><?php echo $model->privasi_khusus ?></b>
</p>

<p>
    Saya memahami sepenuhnya  tentang informasi biaya pengobatan dan perawatan serta biaya tindakan medis 
yang telah dijelaskan oleh petugas PRISCILLA MEDICAL CENTER

</p>
<p>
    Saya yang bertanda tangan dibawah ini menyatakan telah membaca dan memahami isi  Persetujuan Umum
atau General Concent ini.

</p>


<table style="width: 100%; border: none;">
    <tr>
        <td colspan="2"></td>
        <td style="text-align: left;">
            <?php echo Yii::app()->user->getState('kabupaten_nama').", ".$model->tgl_persetujuan; ?>  
		</td>
    </tr>
    <tr>
        <td width="200" style="text-align: center;">
            Petugas Admisi
            <br>
            <br>
            <br>
            <br>
            <br>
			<?php 
            echo $model->petugas_admisi;
            ?>
            
        </td>
        <td style="text-align: center;">
            Penanggung Jawan / Pasien
            <br>
            <br>
            <br>
            <br>
            <br>
			<?php echo $model->penanggungjawab_pasien; ?>
        </td>
        <td width="200" style="text-align: center;">
            Saksi Pasien
            <br>
            <br>
            <br>
            <br>
            <br>
			<?php echo $model->saksi_pasien; ?>
        </td>
    </tr>
</table>

<br>
		</div>		
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>

<?php $this->endWidget(); ?>