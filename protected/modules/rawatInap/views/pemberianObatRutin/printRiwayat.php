<style type="text/css">
    body{
        width: 100%;
        font-family: 'Arial Narrow';
    }
    @page {
        margin-top: 12mm;
        size:landscape;
    }
	@media print {
        thead tbody {
            size:landscape;
			width:100%;
        }
    }
    .text td{
        background-color:#D3D3DC !important;
    }
</style>
<?php 
if($caraPrint=='EXCEL')
{
    header('Content-Type: application/vnd.ms-excel');
    header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
    header('Cache-Control: max-age=0');     
}

$style = 'margin-left:auto; margin-right:auto;';
if (isset($caraPrint)){
    if ($caraPrint == "EXCEL")
        $style = "cellpadding='10',cellspasing='6', width='100%'";
//            $td = "width='100%'";
} else{
    $style = "style='margin-left:auto; margin-right:auto;'";
//        $td ='';
}
echo $this->renderPartial('application.views.headerReport.headerDefault',array()); 
?>
<p style="font-size:16pt; font-weight:bold; font-family:Arial Narrow; text-align:center; margin-top:0;"><?php echo $judulLaporan;?></p>
<p style="font-size:12pt; font-weight:bold; font-family:Arial Narrow;"><b>Bissmillahirrahmanirrahim<b></p>

<table width="100%" <?php echo $style; ?> >
    <tr>
        <td width="5%">Nama</td>
        <td> : <?php echo $modPasien->nama_pasien?></td>
    </tr>
    <tr>
        <td width="10%">Tgl. Lahir</td>
        <td> : <?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir)?></td>
    </tr>
    <tr>
        <td>No RM</td>
        <td> : <?php echo $modPasien->no_rekam_medik?></td>
    </tr>
    <tr>
        <td>NIK</td>
        <td> : <?php echo $modPasien->no_identitas_pasien?></td>
    </tr>
    <tr>
        <td>Ruangan</td>
        <td> : <?php echo $kunjungan->ruangan->ruangan_nama?></td>
    </tr>
    <tr>
        <?php $dokter = DokterV::model()->findAllByAttributes(array('pegawai_id'=>$modAdmisi->pegawai_id));?>
        <td>DPJP</td>
        <td> : <?php echo $dokter[0]->namaLengkap?></td>
    </tr>
</table>
<br>
    <table id="tblListPemeriksaanLab" class="table table-bordered table-condensed" border="1">
        <thead>
            <tr>
                <th>Status</th>
                <th>Tgl Pemberian</th>
                <th>Jam Pemberian</th>
                <th>Nama Obat</th>
                <th>Penggunaan</th>
                <th>Cara Pemberian</th>
                <th>Petugas</th>
            </tr>
        </thead>
        <tbody>
            <?php 
            foreach ($modPemberianObatRutin2 as $data){?>
                <?php if($data->penerimaan_status == 'Diterima'){?>
                    <tr class='text'>
                        <td><span class="<?php echo (($data->tanda != null)?"fa fa-check-square-o":"fa fa-square-o"); ?>"></span></td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($data->tanggal_pemberian);?></td>
                        <td align="center"><?php echo $data->jadwal;?></td>
                        <td><?php echo $data->obatalkes_nama;?></td>
                        <td><?php echo $data->aturanpakaiobat;?></td>
                        <td><?php echo $data->carapemberian;?></td>
                        <td><?php echo $data->initial;?></td>
                    </tr>
                <?php }else{?>
                    <tr>
                        <td><span class="<?php echo (($data->tanda != null)?"fa fa-check-square-o":"fa fa-square-o"); ?>"></span></td>
                        <td><?php echo MyFormatter::formatDateTimeForUser($data->tanggal_pemberian);?></td>
                        <td align="center"><?php echo $data->jadwal;?></td>
                        <td><?php echo $data->obatalkes_nama;?></td>
                        <td><?php echo $data->aturanpakaiobat;?></td>
                        <td><?php echo $data->carapemberian;?></td>
                        <td><?php echo $data->initial;?></td>
                    </tr>
                <?php }?>
            <?php }?>
        </tbody>
        <tbody>
        
        </tbody>
    </table>