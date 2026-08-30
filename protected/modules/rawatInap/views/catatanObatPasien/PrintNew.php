<style>
    .judul{
        text-align:center;
        font-sixe : 15px;
    }

</style>

<?php 
$table = 'ext.bootstrap.widgets.BootGridView';
$template = "{summary}\n{items}\n{pager}";
if (isset($caraPrint)){
	$template = "{items}";
	if($caraPrint=='EXCEL'){
		header('Content-Type: application/vnd.ms-excel');
		header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
		header('Cache-Control: max-age=0');   
		$table = 'ext.bootstrap.widgets.BootExcelGridView';
	}
}

echo $this->renderPartial($this->path_view.'_headerSurat',array('judulLaporan'=>$judulLaporan, 'colspan'=>'','modPasien'=>$modPasien,'modPendaftaran'=>$modPendaftaran));  
?>
<br><br>
<h1 align="center"><?php echo $judulLaporan;?></h1>
<table width="100%" border="2px">
    <tr>
        <td rowspan="2" style="width:500px;">
            <div>Kamar &nbsp;&nbsp;&nbsp;&nbsp; : <?php echo $modAdmisi->kamarruangan->kamarruangan_nokamar;?></div><br>
            <div>Dokter &nbsp;&nbsp;&nbsp;&nbsp; : <?php
                    $pegawaiNamaDpjp = "";
                    $pegawaiId = $modPendaftaran->pegawai_id;

                    if(!empty($pegawaiId)){
                      $modPeg = PegawaiM::model()->findByPk($pegawaiId);
                      $pegawaiNamaDpjp = (isset($modPeg)? $modPeg->namaLengkap:"");
                    }
                        echo $pegawaiNamaDpjp; ?>
            </div><br>
            <div>Diagnosa : <?php echo $modDiagnosa->diagnosa->diagnosa_nama;?></div>
        </td>
        <td style="font-size:20px;" align="center" colspan=3>Waktu Pemberian Obat</td>
    </tr>
    <tr>
        
            <?php
            $criteria2 = new CDbCriteria;
            $criteria2->compare('LOWER(lookup_type)', 'waktupemberian',true);
            $criteria2->order = "lookup_urutan ASC";            
            $waktuPemberian = LookupM::model()->findAll($criteria2);
            $no = 1;            
            foreach ($waktuPemberian as $waktu){
                if ($no == 1 || $no == 4 || $no == 7 ){?>
                    <td>
                <?php }
                echo $no.' '.$waktu->lookup_name."<br>";
                $no++;
                if ($no == 1 || $no == 4 || $no == 7 ){?>
                    </td>
                <?php }
            }
            ?>
    </tr>
</table>
<table width="100%" border="2px">
    <tr>
        <td class="judul" rowspan="2">No</td>
        <td class="judul" rowspan="2">Obat Non Injeksi</td>
        <td class="judul" rowspan="2">Cara</td>
        <td class="judul" rowspan="2">Dosis</td>
        <td class="judul" rowspan="2">Waktu Pemberian</td>
        <?php
            $criteria2 = new CDbCriteria;
            $criteria2->select = 'DISTINCT tgl_pemberian';
            $criteria2->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
            $criteria2->order = "tgl_pemberian ASC";
            $tanggal = CatatanobatpasienT::model()->findAll($criteria2);      
        foreach($tanggal as $cObat){?>
            <td class="judul" colspan="4"><?php echo $cObat->tgl_pemberian;?></td>
        
        <?php }?> 
        <td class="judul" rowspan="2">Keterangan</td>
    </tr>
    <tr>
        <?php
            $criteria2 = new CDbCriteria;
            $criteria2->select = 'DISTINCT tgl_pemberian';
            $criteria2->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
            $criteria2->order = "tgl_pemberian ASC";
            $tanggal = CatatanobatpasienT::model()->findAll($criteria2);      
        foreach($tanggal as $cObat){?>
            <td class="judul" colspan="4">Jam</td>
        
        <?php }?> 
    </tr>
        
        <?php $no = 1;
        foreach($modelInjeksi as $cObat){?>
            <tr>
            <td><?php echo $no;?></td>
            <td><?php echo $cObat->obatalkes->obatalkes_nama;?></td>
            <td><?php echo $cObat->cara;?></td>
            <td><?php echo $cObat->dosis;?></td>
            <td><?php echo $cObat->waktupemberian;?></td>
            <?php
            $criteria2 = new CDbCriteria;
            $criteria2->select = 'DISTINCT tgl_pemberian';
            $criteria2->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
            $criteria2->order = "tgl_pemberian ASC";
            $tanggal = CatatanobatpasienT::model()->findAll($criteria2);      
            foreach($tanggal as $ctgl){
                    $criteria3 = new CDbCriteria;
                    $criteria3->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
                    $criteria3->addCondition("tgl_pemberian = '".$ctgl->tgl_pemberian." '");
                    $criteria3->order = "jam_pemberian ASC";
                    $criteria3->limit = 4;
                    $jam = CatatanobatpasienT::model()->findAll($criteria3);
                    $c = count($jam);
                    foreach($jam as $cjam){
                        ?>
                        
                        <td style="width:50px;"><?php echo $cjam->jam_pemberian;?></td>
                    <?php } ?>
                     <?php if ($c == 1){?>
                        <td style="width:50px;"></td>
                        <td style="width:50px;"></td>
                        <td style="width:50px;"></td>
                    <?php }else if ($c == 2){ ?>
                        <td style="width:50px;"></td>
                        <td style="width:50px;"></td>
                    <?php }else if ($c == 3){ ?>
                        <td style="width:50px;"></td>
                    <?php }
            }?> 
            
            <td></td>
            </tr>
        <?php $no++; }?>
        
    
    

</table>
<?php if (!empty($modelNon)){?>
<table width="100%" border="2px">
    <tr>
        <td class="judul" rowspan="2">No</td>
        <td class="judul" rowspan="2">Obat Non Injeksi</td>
        <td class="judul" rowspan="2">Cara</td>
        <td class="judul" rowspan="2">Dosis</td>
        <td class="judul" rowspan="2">Waktu Pemberian</td>
        <?php
            $criteria2 = new CDbCriteria;
            $criteria2->select = 'DISTINCT tgl_pemberian';
            $criteria2->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
            $criteria2->order = "tgl_pemberian ASC";
            $tanggal = CatatanobatpasienT::model()->findAll($criteria2);      
        foreach($tanggal as $cObat){?>
            <td class="judul" colspan="4"><?php echo $cObat->tgl_pemberian;?></td>
        
        <?php }?> 
        <td class="judul" rowspan="2">Keterangan</td>
    </tr>
    <tr>
        <?php
            $criteria2 = new CDbCriteria;
            $criteria2->select = 'DISTINCT tgl_pemberian';
            $criteria2->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
            $criteria2->order = "tgl_pemberian ASC";
            $tanggal = CatatanobatpasienT::model()->findAll($criteria2);      
        foreach($tanggal as $cObat){?>
            <td class="judul" colspan="4">Jam</td>
        
        <?php }?> 
    </tr>
        
        <?php $no = 1;
        foreach($modelNon as $cObat){?>
            <tr>
            <td><?php echo $no;?></td>
            <td><?php echo $cObat->obatalkes->obatalkes_nama;?></td>
            <td><?php echo $cObat->cara;?></td>
            <td><?php echo $cObat->dosis;?></td>
            <td><?php echo $cObat->waktupemberian;?></td>
            <?php
            $criteria2 = new CDbCriteria;
            $criteria2->select = 'DISTINCT tgl_pemberian';
            $criteria2->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
            $criteria2->order = "tgl_pemberian ASC";
            $tanggal = CatatanobatpasienT::model()->findAll($criteria2);      
            foreach($tanggal as $ctgl){
                    $criteria3 = new CDbCriteria;
                    $criteria3->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
                    $criteria3->addCondition("tgl_pemberian = '".$ctgl->tgl_pemberian." '");
                    $criteria3->order = "jam_pemberian ASC";
                    $criteria3->limit = 4;
                    $jam = CatatanobatpasienT::model()->findAll($criteria3);
                    $c = count($jam);
                    foreach($jam as $cjam){
                        ?>
                        
                        <td style="width:50px;"><?php echo $cjam->jam_pemberian;?></td>
                    <?php } ?>
                     <?php if ($c == 1){?>
                        <td style="width:50px;"></td>
                        <td style="width:50px;"></td>
                        <td style="width:50px;"></td>
                    <?php }else if ($c == 2){ ?>
                        <td style="width:50px;"></td>
                        <td style="width:50px;"></td>
                    <?php }else if ($c == 3){ ?>
                        <td style="width:50px;"></td>
                    <?php }
            }?> 
            
            <td></td>
            </tr>
        <?php $no++; }?>

</table>
<?php } ?>
<?php if (!empty($modelSup)){?>
<table width="100%" border="2px">
    <tr>
        <td class="judul" rowspan="2">No</td>
        <td class="judul" rowspan="2">Obat Non Injeksi</td>
        <td class="judul" rowspan="2">Cara</td>
        <td class="judul" rowspan="2">Dosis</td>
        <td class="judul" rowspan="2">Waktu Pemberian</td>
        <?php
            $criteria2 = new CDbCriteria;
            $criteria2->select = 'DISTINCT tgl_pemberian';
            $criteria2->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
            $criteria2->order = "tgl_pemberian ASC";
            $tanggal = CatatanobatpasienT::model()->findAll($criteria2);      
        foreach($tanggal as $cObat){?>
            <td class="judul" colspan="4"><?php echo $cObat->tgl_pemberian;?></td>
        
        <?php }?> 
        <td class="judul" rowspan="2">Keterangan</td>
    </tr>
    <tr>
        <?php
            $criteria2 = new CDbCriteria;
            $criteria2->select = 'DISTINCT tgl_pemberian';
            $criteria2->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
            $criteria2->order = "tgl_pemberian ASC";
            $tanggal = CatatanobatpasienT::model()->findAll($criteria2);      
        foreach($tanggal as $cObat){?>
            <td class="judul" colspan="4">Jam</td>
        
        <?php }?> 
    </tr>
        
        <?php $no = 1;
        foreach($modelSup as $cObat){?>
            <tr>
            <td><?php echo $no;?></td>
            <td><?php echo $cObat->obatalkes->obatalkes_nama;?></td>
            <td><?php echo $cObat->cara;?></td>
            <td><?php echo $cObat->dosis;?></td>
            <td><?php echo $cObat->waktupemberian;?></td>
            <?php
            $criteria2 = new CDbCriteria;
            $criteria2->select = 'DISTINCT tgl_pemberian';
            $criteria2->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
            $criteria2->order = "tgl_pemberian ASC";
            $tanggal = CatatanobatpasienT::model()->findAll($criteria2);      
            foreach($tanggal as $ctgl){
                    $criteria3 = new CDbCriteria;
                    $criteria3->addCondition('pendaftaran_id = '.$modPendaftaran->pendaftaran_id);
                    $criteria3->addCondition("tgl_pemberian = '".$ctgl->tgl_pemberian." '");
                    $criteria3->order = "jam_pemberian ASC";
                    $criteria3->limit = 4;
                    $jam = CatatanobatpasienT::model()->findAll($criteria3);
                    $c = count($jam);
                    foreach($jam as $cjam){
                        ?>
                        
                        <td style="width:50px;"><?php echo $cjam->jam_pemberian;?></td>
                    <?php } ?>
                     <?php if ($c == 1){?>
                        <td style="width:50px;"></td>
                        <td style="width:50px;"></td>
                        <td style="width:50px;"></td>
                    <?php }else if ($c == 2){ ?>
                        <td style="width:50px;"></td>
                        <td style="width:50px;"></td>
                    <?php }else if ($c == 3){ ?>
                        <td style="width:50px;"></td>
                    <?php }
            }?> 
            
            <td></td>
            </tr>
        <?php $no++; }?>

</table>
<?php } ?>