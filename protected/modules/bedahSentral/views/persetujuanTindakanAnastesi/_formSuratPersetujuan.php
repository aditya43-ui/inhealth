<?php 

$this->widget('bootstrap.widgets.BootAlert'); 

$jenis = ($model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "Persetujuan" : "Penolakan";
$jenis2 = ($model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN) ? "menyetujui" : "menolak";


?>
<style>
    p{
        text-align: justify;
    }
    tr, td {
        padding: 7px;
    }
    table#persetujuan {
        
        text-align: center;
    }
</style>
    <h3><center>SURAT <?php echo $model->jenissurat; ?> TINDAKAN ANASTESI</center></h3>
<br><br>
<p align="justify">
    Setelah mendapat informasi mengenai tindakan anatesi/sedasi, maka yang bertanda tangan di bawah ini :
</p>
<table width="100%" style="width:500px;">
<tr>
    <td>Nama</td>
    <td>:</td>
    <td>
        <?php echo CHtml::activeTextField($model, 'namapenanggungjawab', array('readonly'=>true, 'class'=>'span3','onkeyup'=>'$("#nama_pembuatpernyataan").val($(this).val())'))?>
    </td>
</tr>
<tr>
    <td>Umur</td>
    <td>:</td>
    <td>
        <?php echo CHtml::activeTextField($model, 'umurpenanggungjawab', array('readonly'=>true, 'class'=>'span3','maxlength'=>2))?>
    </td>
</tr>
<tr>
    <td>Jenis Kelamin</td>
    <td>:</td>
    <td>
        <?php echo CHtml::activeTextField($model, 'jeniskelamin_penanggungjawab', array('readonly'=>true, 'class'=>'span3'))?>
    </td>
</tr>
<tr>
    <td>Alamat</td>
    <td>:</td>
    <td>
        <?php echo CHtml::activeTextField($model, 'alamat_penanggungjawab', array('readonly'=>true, 'class'=>'span3'))?>
    </td>
</tr>
<tr>
    <td>No. Kartu Identitas</td>
    <td>:</td>
    <td>
        <?php echo CHtml::activeTextField($model, 'jenisidentitas_penanggungjawab', array('readonly'=>true,'onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span1'))?>
    </td>
</tr>
<tr>
    <td></td>
    <td></td>
    <td>
        <?php echo CHtml::activeTextField($model, 'noidentitas_penanggungjawab', array('readonly'=>true, 'class'=>'span3 numbers-only','maxlength'=>16,'onkeyup'=>'$("#identitas_pembuatpernyataan").val($(this).val())'))?>
    </td>
</tr>
</table>
<br>
<p align="justify">
   Dengan ini menyatakan <?php echo $model->jenissurat; ?> untuk dilakukan tindakan anatesi <?php echo CHtml::textField('surat_jenis_anastesi', '', array('readonly'=>true)) ?>
</p>
<br/>
<p align="justify">
   Terhadap <?php echo CHtml::textField('hubungankeluarga', '', array('readonly'=>true)); ?> Saya :
</p>
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
<br>
<p align="justify">
   Dan saya menyatakan bahwa :
</p>
<p align="justify">
   1. Saya memahami perlunya dan manfaat tindakan anestesi tersebut sebagaimana telah dijelaskan seperti di atas kepada saya, termasuk
   risiko dan komplikasi yang mungkin timbul, apabila tindakan tersebut tidak dilakukan, serta telah diberi kesempatan untuk bertanya
   dan berdiskusi dengan dokter.
</p>
<p align="justify">
   2. Saya juga menyadari bahwa oleh karena ilmu kedokteran adalah bukan ilmu pasti, maka keberhasilan anestesi kedokteran bukanlah 
   keniscayaan, melainkan sangat bergantung pada izin Tuhan Yang Maha Esa.
</p>
<p align="justify">
   3. Saya juga menyadari bahwa pelayanan di rumah sakit ini merupakan kerja sama team (dokter dan perawat anestesi) dan bahwasanya 
   anestesi untuk tindakan operasi ini akan dilakukan dibawah pengawasan Dokter 
       <?php echo CHtml::textField('dokter_anestesi', '', array('readonly'=>true)); ?>
       <?php echo CHtml::activeHiddenField($model, 'dokteranestesi_id', array('class'=>'surat_dokteranestesi_id','readonly'=>true)); ?>
</p>
<p align="justify">
   4. Saya mempunyai kewajiban untuk memberikan informasi kepada dokter mengenai semua penyakit dan obat yang saya/pasien minum seperti aspirin, 
   pengencer darah, kontrasepsi, obat-obat flu, narkotika, marijuana, kokain, dan lain-lain, mengingat hal tersebut dapat menimbulkan komplikasi 
   bagi anestesi maupun pembedahan.
</p>

<p align="justify">
    Berdasrkan hal-hal tersebut di atas, saya menjamin sepenuhnya bahwa tindakan saya untuk <?php echo $jenis2; ?> tindakan anestesi di atas adalah untuk mewakili kepentingan saya/pasien 
    dan keluarga pasien, dan saya bertanggung jawab sepenuhnya apabila terdapat pihak lain yang mengajukan keberatan atas <?php echo $jenis; ?> ini.
</p>
<p align="justify">
    Demikian surat <?php echo $jenis; ?> ini dibuat dengan penuh kesadaran dan tanpa paksaan dari pihak manapun juga.
</p>


<table width=100% id="persetujuan"> 
    <tr>
        <td></td>
        <td><?= Yii::app()->user->getState('kabupaten_nama'); ?>, <?= date(' d M Y')." pukul ".date('H:i:s'); ?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td>Yang membuat pernyataan,</td>
        <td></td>
        <td></td>
        <td>Dokter,</td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo CHtml::textField('nama_pembuatpernyataan','',array('class'=>'span3','placeholder'=>'Nama', 'readonly'=>true))?></td>
        <td></td>
        <td></td>
        <td><?php echo CHtml::activeDropDownList($model, 'doktermenyetujui_id', CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id'=>Yii::app()->user->getState('ruangan_id'),'pegawai_aktif'=>true), array('order'=>'pegawai_id')), 'pegawai_id','namaLengkap'), array('class'=>'span3'))?></td>
    </tr>
    <tr>
        <td></td>
        <td>Saksi Pihak Keluarga,</td>
        <td></td>
        <td></td>
        <td>Saksi Pihak RS,</td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo CHtml::activeTextField($model, 'nama_pihakkeluarga',array('class'=>'span3','placeholder'=>'Nama'))?></td>
        <td></td>
        <td></td>
        <td>
            <?php // echo CHtml::activeDropDownList($model, 'saksipihakrs_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Params::RUANGAN_ID_ANASTESI,'pegawai_aktif'=>true), array('order'=>'pegawai_id')), 'pegawai_id','namaLengkap'), array('class'=>'span3'))?>
            <?php 
            $clist = new CDbCriteria();
            $clist->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
            $clist->addCondition('pegawai_aktif = true');
            $clist->order = 'nama_pegawai';
            
            echo CHtml::activeDropDownList($model, 'saksipihakrs_id', CHtml::listData(PegawairuanganV::model()->findAll($clist), 'pegawai_id','namaLengkap'), array('class'=>'span3', 'empty' => '--- Pilih --- '))?>
        </td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo CHtml::activeTextField($model, 'noidentitas',array('class'=>'span3','placeholder'=>'No. KTP/SIM','maxlength'=>16))?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    
    
    


</table>
<?php /*
<table width="100%" id="persetujuan">
    
    <tr>
        <td></td>
        <td>Yang membuat pernyataan,</td>
        <td></td>
        <td></td>
        <td>Saksi Pihak Keluarga,</td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo CHtml::activeDropDownList($model, 'hubungan_pembuatpernyataan', LookupM::getItems('hubungankeluarga'), array('empty'=>'Hubungan Keluarga','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span3'))?></td>
        <td></td>
        <td></td>
        <td></td>
    </tr>
    <tr>
        <td></td>
        <td><?php echo CHtml::textField('nama_pembuatpernyataan','',array('class'=>'span3','placeholder'=>'Nama'))?></td>
        <td></td>
        <td></td>
        <td><?php echo CHtml::activeTextField($model, 'nama_pihakkeluarga',array('class'=>'span3','placeholder'=>'Nama'))?></td>
    </tr>
    <tr>
        <td style="text-align: right">No. KTP/SIM</td>
        <td><?php echo CHtml::textField('identitas_pembuatpernyataan','',array('class'=>'span3','placeholder'=>'No. KTP/SIM','maxlength'=>16))?></td>
        <td></td>
        <td style="text-align: right">No. KTP/SIM</td>
        <td><?php echo CHtml::activeTextField($model, 'noidentitas',array('class'=>'span3','placeholder'=>'No. KTP/SIM','maxlength'=>16))?></td>
    </tr>
    <tr>
        <td></td>
        <td>Dokter,</td>
        <td></td>
        <td></td>
        <td>Saksi Pihak RS,</td>
    </tr>
    <tr>
        <td></td>
        <td>
            <?php // echo CHtml::activeDropDownList($model, 'dokteranestesi_id', CHtml::listData(DokterV::model()->findAllByAttributes(array('ruangan_id'=>Params::RUANGAN_ID_ANASTESI,'pegawai_aktif'=>true), array('order'=>'pegawai_id')), 'pegawai_id','namaLengkap'), array('class'=>'span3'))?>
            
        </td>
        <td></td>
        <td></td>
        <td>
            <?php // echo CHtml::activeDropDownList($model, 'saksipihakrs_id', CHtml::listData(PegawairuanganV::model()->findAllByAttributes(array('ruangan_id'=>Params::RUANGAN_ID_ANASTESI,'pegawai_aktif'=>true), array('order'=>'pegawai_id')), 'pegawai_id','namaLengkap'), array('class'=>'span3'))?>
            <?php 
            $clist = new CDbCriteria();
            $clist->compare('instalasi_id', array(Params::INSTALASI_ID_IBS, Params::INSTALASI_ID_RI, Params::INSTALASI_ID_RJ, Params::INSTALASI_ID_RD, Params::INSTALASI_ID_ICU));
            $clist->addCondition('pegawai_aktif = true');
            $clist->order = 'nama_pegawai';
            
            echo CHtml::activeDropDownList($model, 'saksipihakrs_id', CHtml::listData(PegawairuanganV::model()->findAll($clist), 'pegawai_id','namaLengkap'), array('class'=>'span3'))?>
        </td>
    </tr>
</table>
 * 
 */ ?>