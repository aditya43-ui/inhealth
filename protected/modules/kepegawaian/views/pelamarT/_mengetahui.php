<?php 
$sukses = null;
if(isset($_GET['sukses'])){
	$sukses = $_GET['sukses'];
}
if($sukses > 0){
	Yii::app()->user->setFlash('success',"Status Mengetahui berhasil disimpan!");
}
$this->widget('bootstrap.widgets.BootAlert'); 
?>

<style>
.line-separator{

height:1px;

width: 350px;
background:#717171;

border-bottom:1px solid #313030;

}

</style>
<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
    {
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
        header('Cache-Control: max-age=0');   
        $table = 'ext.bootstrap.widgets.BootExcelGridView';
    }
    $template = "{items}";
}

?>
<?php
if(!$model){
    echo "Data tidak ditemukan."; exit;
}
$format = new MyFormatter;
if (!isset($_GET['frame'])){
    echo $this->renderPartial('_headerPrint'); 
}
?>
<table width="100%" border="1" style="font-size: 12;">
    <tr><td colspan="7" align="center"><h3>Data Pelamar<h3></td></tr>
    <tr><td colspan="7">&nbsp;</td></tr>
    <tr>
        <td width="15%">Tanggal Lowongan</td>
        <td width="1%">:</td>
        <td width="30%"><?php echo $model->tgllowongan; ?></td>
        <td width="10%">&nbsp;</td>
        <td width="15%"></td>
        <td width="1%"></td>
        <td width="20%"></td>
    </tr>
 
    <tr>
        <td>Jenis Identitas</td>
        <td>:</td>
        <td><?php echo $model->jenisidentitas."&nbsp;&nbsp;&nbsp;&nbsp;No. Identitas :".$model->noidentitas; ?></td>
        <td></td>
        <td>Pendidikan</td>
        <td>:</td>
        <td><?php 
                if(isset($model->pendidikan_id)){
                    $pendidikan = PendidikanM::model()->findByPk($model->pendidikan_id); echo $pendidikan->pendidikan_nama; 
                }else{
                    echo"";
                }
        ?></td>
    </tr>
    <tr>
        <td>Nama Pelamar </td>
        <td>:</td>
        <td><?php echo $model->nama_pelamar; ?></td>
        <td></td>
         <td>Occupation</td>
        <td>:</td>
        <td><?php //$occupation = OccupationM::model()->findByPk($model->occupation_id); echo $occupation->occupation_nama; ?></td>
    </tr>
    <tr>
        <td>Nama Keluarga</td>
        <td>:</td>
        <td><?php echo $model->nama_keluarga; ?></td>
        <td></td>
        <td>Minat Pekerjaan</td>
        <td>:</td>
        <td><?php echo $model->minatpekerjaan; ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin</td>
        <td>:</td>
        <td><?php echo $model->jeniskelamin; ?></td>
        <td></td>
        <td>Warga Negara</td>
        <td>:</td>
        <td><?php echo $model->warganegara_pelamar; ?></td>
    </tr>
    <tr>
        <td>Agama</td>
        <td>:</td>
        <td><?php echo $model->agama; ?></td>
        <td></td>
        <td>Suku</td>
        <td>:</td>
        <td><?php
                if(isset($model->suku_id)){
                    $suku = SukuM::model()->findByPk($model->suku_id); echo $suku->suku_nama; 
                }else{
                    echo"";
                }
        ?></td>
    </tr>
    <tr>
        <td>Tempat Lahir</td>
        <td>:</td>
        <td><?php echo $model->tempatlahir_pelamar; ?></td>
        <td></td>
        <td>Gaji Yang Diharapkan</td>
        <td>:</td>
        <td><?php echo $model->gajiygdiharapkan; ?></td>
    </tr>
    <tr>
        <td>Tanggal Lahir</td>
        <td>:</td>
        <td><?php echo $model->tgl_lahirpelamar; ?></td>
        <td></td>
        <td>Tanggal Mulai Bekerja</td>
        <td>:</td>
        <td><?php echo $model->tglmulaibekerja; ?></td>
    </tr>
    <tr>
        <td>Status Perkawinan</td>
        <td>:</td>
        <td><?php echo $model->statusperkawinan; ?></td>
        <td></td>
        <td>Profile Perusahaan</td>
        <td>:</td>
        <td><?php $profilePerusahaan = ProfilrumahsakitM::model()->findByPk($model->profilrs_id); echo $profilePerusahaan->nama_rumahsakit; ?></td>        
    </tr>
    <tr>
        <td>Jumlah Anak</td>
        <td>:</td>
        <td><?php echo $model->jmlanak; ?></td>
        <td></td>
        <td rowspan="3" valign="top">Keterangan</td>
        <td rowspan="3" valign="top">:</td>
        <td rowspan="3" valign="top"><?php echo $model->keterangan_pelamar; ?></td>
    </tr>
    <tr>
        <td>No. Telepon</td>
        <td>:</td>
        <td><?php echo "Rumah&nbsp;&nbsp;".$model->notelp_pelamar."Mobile&nbsp;&nbsp;".$model->nomobile_pelamar; ?></td>
        <td></td>
    </tr>
    <tr>
        <td>Alamat Email</td>
        <td>:</td>
        <td><?php echo $model->alamatemail; ?></td>
        <td></td>
    </tr>
    <tr>
        <td valign="top">Alamat Pelamar</td>
        <td valign="top">:</td>
        <td valign="top"><?php echo $model->alamat_pelamar;?></td>
        <td></td>
        <td valign="top">Tunjangan Yang Diinginkan</td>
        <td valign="top">:</td>
        <td valign="top"><?php echo $model->ingintunjangan; ?></td>
    </tr>
    
</table>
<br>
<br>


<br><br>
<?php if(isset($modSims)) { ?>
<table>
    <tr>
        <td widht="20%">
            <h3><i>Data SIM Pelamar</i></h3>
            <div class="line-separator"></div>
            <br>
            <table border="1" width="350px;">
                <thead>
                        <th>No.</th>
                        <th>Jenis SIM</th>
                        <th>No. SIM</th>
                        <th>Berlaku Sampai</th>
                    </thead>
                <?php
               foreach ($modSims as $i => $modSim) {
                    $no = $i+1;
                    ?>
                    <tr>
                        <td><?php echo $no;?></td>
                        <td><?php echo $modSim->jenissim_l ?></td>
                        <td><?php echo $modSim->nosim; ?></td>
                        <td><?php echo $modSim->berlakus_sd; ?></td>
                    <tr>
                    <?php
                } ?>
            </table>
        </td>
        <td widht="20%">
            <h3><i>Data Kendaraan Pelamar</i></h3>
            <div class="line-separator"></div>
            <br>
            <table border="1">
                <thead>
                    <th>No.</th>
                    <th>Jenis Kendaraan</th>
                    <th>Nama Kendaraan</th>
                    <th>Tahun Kendaraan</th>
                    <th>CC Kendaraan</th>
                    <th>Keterangan</th>
                </thead>
                <?php foreach ($modKendaraans as $i => $modKendaraan) {
                 $no=$i+1;
                ?> <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $modKendaraan->jeniskendaraan; ?></td>
                    <td><?php echo $modKendaraan->namakendaraan; ?></td>
                    <td><?php echo $modKendaraan->tahunkendaraan; ?></td>
                    <td><?php echo $modKendaraan->cckendaraan; ?></td>
                    <td><?php echo $modKendaraan->keterangan; ?></td>

                </tr>
            <?php }?>
            </table>
<?php } ?>
        </td>
    </tr>
    
    <tr>
        <td widht="20%">&nbsp;</td>
        <td widht="20%">&nbsp;</td>
    </tr>
	<tr>
		<?php if(count((array)$modKemampuanPelamars)>0){ ?>
        <td widht="20%">
            <h3><i>Data Kemampuan / Skill Pelamar</i></h3>
            <div class="line-separator"></div>
            <br>
            <table border="1">
                <thead>
                    <th>No.</th>
                    <th>Bahasa</th>
                    <th>Mengerti</th>
                </thead>
                <?php
				foreach ($modKemampuanPelamars as $i => $modKemampuanPelamar) {
                 $no=$i+1;
                ?> <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $modKemampuanPelamar->kemampuan_nama; ?></td>
                    <td><?php echo $modKemampuanPelamar->kemampuan_tingkat; ?></td>

                </tr>
				<?php } ?>
            </table>
        </td>
		<?php } ?>
        <td widht="20%">
            <h3><i>Data Kemampuan Bahasa Pelamar</i></h3>
            <div class="line-separator"></div>
            <br>
            <table border="1">
                <thead>
                    <th>No.</th>
                    <th>Bahasa</th>
                    <th>Mengerti</th>
                    <th>Berbicara</th>
                    <th>Menulis</th>
                </thead>
                <?php foreach ($modBahasas as $i => $modBahasa) {
                 $no=$i+1;
                ?> <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $modBahasa->bahasa; ?></td>
                    <td><?php echo $modBahasa->mengerti; ?></td>
                    <td><?php echo $modBahasa->berbicara; ?></td>
                    <td><?php echo $modBahasa->menulis; ?></td>

                </tr>
            <?php }?>
            </table>
        </td>
        <td widht="20%">
            <h3><i>Data Lingkungan Kerja Pelamar</i></h3>
            <div class="line-separator"></div>
            <br>
            <table border="1">
                <thead>
                    <th>No.</th>
                    <th>Dengan Lingkungan</th>
                    <th>Keterangan</th>
                </thead>
                <?php foreach ($modLingkunganKerjas as $i => $modLingkunganKerja) {
                 $no=$i+1;
                ?> <tr>
                    <td><?php echo $no; ?></td>
                    <td><?php echo $modLingkunganKerja->dgnlingkungan; ?></td>
                    <td><?php echo $modLingkunganKerja->keterangan; ?></td>

                </tr>
            <?php }?>
            </table>
        </td>
    </tr>
</table>
<br>
<br>
<br>
<div class="row">
    <div class="col-sm-6" style="text-align:center;">
        <?php
        if (isset($_GET['sukses'])) {
            echo "<div class='control-group' style='margin-bottom: 57.5px;margin-top: 10px;'>";
            echo "Mengetahui,";
        } else {
            echo "<div class='<div class='control-group' style='margin-bottom: 50px;'>";
            if($model->mengetahui_id == Yii::app()->user->getState('pegawai_id')){
                echo CHtml::link(Yii::t('mds', ' Mengetahui'), $this->createUrl($this->id . '/index'), array('class' => 'btn btn-danger',
                    'onclick' => 'myConfirm("Apakah Anda yakin akan Mengetahui Pelamar ini?","Perhatian!",
					function(r) {if(r) window.location = "' . $this->createUrl('ApproveMengetahui', array('pelamar_id' => $model->pelamar_id, 'approve' => true)) . '";} ); return false;'));
            }
            else{
                echo CHtml::link(Yii::t('mds',' Mengetahui'), 
                                    $this->createUrl($this->id.'/index'), 
                                    array('class' => 'btn btn-danger',
                                            'onclick'=>'myAlert("Maaf, Anda tidak berhak approve Mengetahui Pelamar ini?"); return false;'));  
            }
            
        }
        ?>
    </div>	
    <div class="control-group">
        ( <?php echo $model->pegawaiMengetahui->NamaLengkap; ?> )
    </div>	
</div>
<div class="col-sm-6" style="text-align:center;">
    <div class="control-group" style="margin-bottom: 57.5px;margin-top: 10px;">
        Menyetujui,
    </div>
    <div class="control-group">
        ( <?php echo $model->pegawaiMenyetujui->NamaLengkap; ?> )
    </div>
</div>

