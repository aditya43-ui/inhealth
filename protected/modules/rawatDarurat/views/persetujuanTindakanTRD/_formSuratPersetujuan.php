<?php 
$this->widget('bootstrap.widgets.BootAlert'); 

$jenis = ($modSuratPersetujuan->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "Persetujuan" : "Penolakan";
$jenis2 = ($modSuratPersetujuan->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "menyetujui" : "menolak";

?>
<style>
    p{
        text-align: justify;
    }
    tr, td {
        padding: 7px;
    }
    #radio-sesuai > label.radio{            
        width:80px;
        display:inline-block;
    }
</style>
	<h3><center><?php echo strtoupper($modSuratPersetujuan->jenissurat); ?> TINDAKAN MEDIS</center></h3>
    <br><br>
    <p align="justify">
        Setelah mendapatkan informasi mengenai tindakan dokter, maka Saya yang bertanda tangan di bawah ini :
    </p>
    <p align="justify">
        <table width="100%">
            <tr>
                <td>Nama <span class="required">*</span></td>
                <td>:</td>
                <td><?php echo $form->textField($modSuratPersetujuan,'nama_menyetujui', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?></td>
            </tr>
            <tr>
                <td>Umur</td>
                <td>:</td>
                <td><?php echo $form->textField($modSuratPersetujuan,'umur_menyetujui', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?php echo $form->textField($modSuratPersetujuan,'jeniskelamin_menyetujui', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?></td>

            </tr>
            <tr>
                <td>Alamat </td>
                <td>:</td>
                <td><?php echo $form->textField($modSuratPersetujuan,'alamat_menyetujui', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?></td>
            </tr>
            <tr>
                <td>No. <span class="required">*</span></td>
                <td>:</td>
                <td>
                    <?php echo $form->textField($modSuratPersetujuan,'jenisidentitas_menyetujui', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'span2', 'readonly'=>true)); ?>
                    <?php echo $form->textField($modSuratPersetujuan,'noktp_menyetujui', array('readonly'=>false,
                            'onkeypress'=>"return $(this).focusNextInputField(event)",'readonly'=>true)); ?>
                </td>
            </tr>
        </table>
    
        <p align="justify">Menyatakan dengan sesungguhnya telah memberi <?php echo $jenis ?> untuk dilakukan tindakan <?php echo CHtml::textField('persetujuan_daftartindakan_nama', '', array('readonly'=>true)); ?></p>
        <p align="justify">Terhadap <?php echo CHtml::textField('hubungankeluarga', '', array('readonly'=>true)); ?> Saya :</p>
        
        <table cellpadding="10">
            <tr>
                <td>Nama</td>
                <td>:</td>
                <td><?=$modPasien->nama_pasien?></td>
            </tr>
            <tr>
                <td>No. Rekam Medis</td>
                <td>:</td>
                <td><?=$modPasien->no_rekam_medik?></td>
            </tr>
            <tr>
                <td>Umur</td>
                <td>:</td>
                <td><?php
                $umur = explode(" ", $modPendaftaran->umur);

                echo $umur[0] ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>:</td>
                <td><?=$modPasien->jeniskelamin ?></td>
            </tr>
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?=$modPasien->alamat_pasien ?></td>
            </tr>
        </table>
        <br/>
        <p>Dan saya menyatakan bahwa: </p>
        <div class="text_pernyataan" id="text_pernyataan_dokter">
            <p>
                Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan seperti di atas kepada saya, termasuk risiko dan 
                komplikasi yang mungkin timbul, disamping itu jika terjadi kecelakaan seperti tertusuknya jarum atau alat tajam pada petugas medis 
                selama berlangsungnya operasi, saya tidak memberikan izin untuk mengambil darah pasien untuk test HIV dan penyakit lainnya yang 
                penularannya adalah melalui darah
            </p>
        </div>
        <div class="text_pernyataan" id="text_pernyataan_resiko_n_transfusi">
            <p>
                <ul>
                    <li>
                        Saya memahami perlunya dan manfaat tindakan tersebut sebagaimana telah dijelaskan seperti di atas kepada saya, termasuk risiko 
                        dan komplikasi yang mungkin timbul.
                    </li>
                    <li>
                        Saya juga menyadari bahwa oleh karena ilmu kedokteran adalah bulan ilmu pasti, maka keberhasilan tindakan kedokteran bukanlah 
                        keniscayaan, melainkan sangat bergnatung pada izi Tuhan Yang Maha Esa.
                    </li>
                </ul>
            </p>
        </div>
        <p>
            Berdasarkan hal-hal tersebut diatas, saya menjamin sepenuhnya bahwa tindakan saya untuk <?php echo $jenis2 ?> tindakan kedokteran di atas adalah 
            untuk mewakili kepentingan saya/pasien dan keluarga pasien dan saya bertanggung jawab sepenuhnya apabila terdpat pihak lain yang 
            mengajukan keberatan atas <?php echo $jenis ?> ini.
            
        </p>
        <p>
            Demikian <?php echo $jenis; ?> ini saya buat dengan penuh kesadaran dan tanpa paksaan pihak manapun.
        </p>
        
        
	<br><br><br><br><br>
	<table width='100%'>
        <tr>
            <td align="center" width='30%'><?php echo Yii::app()->user->getState('kabupaten_nama').", ".$format->formatDateTimeId(date('Y-m-d'))." Jam ".date("H:i:s"); ?></td>
            <td width='35%'></td>
			<td width='35%'></td>
        </tr>
        <tr height='100px'>
            <td align="center" width='30%'>Yang Membuat Pernyataan<span class="required">*</span></td>
            <td>&nbsp;</td>
            <td align="center" width='35%'>Dokter<span class="required">*</span></td>
        </tr>
        <tr>
            <td align="center" width='30%'><?php echo CHtml::activeTextField($modSuratPersetujuan,'nama_yangmenyetujui',array('required'=>true,'class'=>'span3', 'readonly'=>true)); ?></td>
            <td>&nbsp;</td>
            <td align="center" width='35%'><?php echo CHtml::activeDropDownList($modSuratPersetujuan,'dokter_id', CHtml::listData(DokterV::model()->findAllByAttributes(array(
                'ruangan_id'=>Yii::app()->user->getState('ruangan_id')
            )), 'pegawai_id', 'nama_pegawai'), array('required'=>true,'empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
        </tr>
		<tr height='100px'>
            <td align="center" width='30%'>Saksi Pihak Keluarga</td>
            <td align="center" width='35%'></td>
            <td align="center" width='35%'>Saksi Pihak RS</td>
        </tr>
		<tr>
            <td align="center" width='35%'><?php echo CHtml::activeTextField($modSuratPersetujuan,'nama_saksi2',array('class'=>'span3')); ?></td>
            <td align="center" width='35%'></td>
            <td align="center" width='35%'><?php echo CHtml::activeDropDownList($modSuratPersetujuan,'pegawaisaksi1_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array(
                'ruangan_id'=>Yii::app()->user->getState('ruangan_id')
            )), 'pegawai_id', 'nama_pegawai'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)")); ?></td>
        </tr>
        <tr>
            <td align="center" width='35%'>No. KTP/SIM <?php echo CHtml::activeTextField($modSuratPersetujuan,'noidentitas_saksi2',array('class'=>'span3')); ?></td>
            <td></td>
            <td></td>
        </tr>
    </table>