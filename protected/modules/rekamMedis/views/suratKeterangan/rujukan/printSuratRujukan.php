<?php 
if(isset($_POST["EXCEL"]))
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'."Surat Keterangan".'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
} 
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$format = new MyFormatter();
?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    body {
        font-size: 8pt;
    }
    
    p{
        margin-left: 0;
        text-align: justify;
    }
    
    .tab-foot, .tab-foot td {
        font-size: 6pt;
    }
</style>
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
<div>
    <div class="content">
    <div>
        <TABLE ALIGN="CENTER">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <div class="judulcontent"><B><span  SIZE=4><U><?php echo "SURAT KETERANGAN RUJUKAN"; ?></U></span></B></div>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span  SIZE=4>NO : <?php echo $model->nomorsurat; ?></span></B>
                </td>
            </tr>
        </TABLE>
    </div>
    
    <div>
    <p align="justify">
        Kepada		
    </p>
	<p align="justify">
        Yth. <?php echo $model->rujukan_yth; ?>
    </p>
	<br>
	<p align="justify">
        Bersama ini kami merujuk pasien :
    </p>
    <p align="justify">
        <table width="100%" style="margin-left:50px;">
            <tr>
                <td width="150">Nama</td>
                <td width="10">:</td>
                <td><?php echo $modPasien->nama_pasien; ?></td>
            </tr>
             <tr>
                <td>Usia</td>
                <td>:</td>
                <td>
                   <?php 
                    $umur = explode(' ',$modPendaftaran->umur);
                    
                     
                            $jkPR = Params::JENIS_KELAMIN_PEREMPUAN;
                            $jkLK = Params::JENIS_KELAMIN_LAKI_LAKI;
                            if (!empty($modPasien->jeniskelamin)){
                                if ($modPasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                                    $jkPR = '<span style="text-decoration: line-through;">'.$jkPR.'</span>';
                                }else{
                                    $jkLK = '<span style="text-decoration: line-through;">'.$jkLK.'</span>';
                                }
                            }
                       
                    echo $umur[0].' Tahun,' ?>
                    <span><?php echo $jkLK; ?></span>
                            /
                        <span><?php echo $jkPR; ?></span> *
                    
            </tr>                  
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo $modPasien->alamat_pasien; ?></td>
            </tr>
            <tr>
                <td>Diagnosa</td>
                <td>:</td>
                <td><?php echo $modPendaftaran->jeniskasuspenyakit->jeniskasuspenyakit_nama; ?></td>
            </tr>
			<tr>
                <td>Dokter yang merawat</td>
                <td>:</td>
                <td><?php echo $modPendaftaran->pegawai->namaLengkap; ?></td>
            </tr>
			<tr>
				<td colspan="3">Anamnesis :</td>
			</tr>
			<tr>
				<td colspan="3"><?php echo $model->rujukan_anamnesis; ?><br><br></td>
			</tr>
			<tr>
				<td colspan="3">Pemeriksaan Fisik :</td>
			</tr>
			<tr>
				<td colspan="3"><?php echo $model->rujukan_fisik; ?><br><br></td>
			</tr>
			<tr>
				<td colspan="3">Terapi :</td>
			</tr>
			<tr>
				<td colspan="3"><?php echo $model->rujukan_terapi; ?><br><br></td>
			</tr>
			<tr>
				<td colspan="3">Pemeriksaan Penunjang :</td>
			</tr>
			<tr>
				<td colspan="3"><?php echo $model->rujukan_penunjang; ?><br><br></td>
			</tr>
			<tr>
				<td colspan="3">Observasi terakhir penderita :</td>
			</tr>
			<tr>
				<td colspan="3"><?php echo $model->rujukan_observasiakhir; ?><br><br></td>
			</tr>
        </table>       
        <p align="justify">
           Atas bantuan dan kerjasamanya kami ucapkan terimakasih
        </p>
</div><br><br><br>

<table style="width: 100%; border: none;">
    <tr>
        <td></td>
        <td width="200">                        
                    <?php $date = date('Y-m-d'); ?>
                    <?php echo strtoupper($data->kabupaten->kabupaten_nama) ;?>, <?php echo strtoupper($format->formatDateTimeForUser($date)); ?><br>
                    <?php //echo strtoupper($data->nama_rumahsakit);?>
                    Dokter Pemeriksa
                    
                    <br><br><br><br><br>

            <?php
                   echo $model->mengetahui_surat;
                ?>

        </td>
    </tr>
    <!--tr style="padding:10px;">
        <td colspan="2">
            <b>*Coret Salah Satu</b>
        </td>
    </tr-->
</table>
</div>