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
/*        font-size: 8pt;*/
    }
    
    p{
        margin-left: 0;
        text-align: justify;
    }
    
    .tab-foot, .tab-foot td {
/*        font-size: 6pt;*/
    }
</style>
<div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
</div>
<div class="content">
        <TABLE ALIGN="CENTER">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <div class="judulcontent"><B><span  SIZE=4><U><?php echo "SURAT KETERANGAN RAWAT INAP"; ?></U></span></B></div>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span  SIZE=4>NO : <?php echo $model->nomorsurat; ?></span></B>
                </td>
            </tr>
        </TABLE>

    </br><br><br><br>
    <div>
    <p align="justify">
        Saya yang bertanda tangan dibawah ini, Dokter <?php echo $data->nama_rumahsakit;?>, dengan ini menerangkan bahwa:
    </p>
    <p align="justify">
        <table width="100%" style="margin-left:50px;">
           <tr>
                <td width="100">Nama</td>
                <td width="10">:</td>
                <td><?php echo $modPasien->nama_pasien ?></td>
            </tr>
            <tr>
                <td>Usia</td>
                <td>:</td>
                <td>
                    <?php 
                    $umur = explode(' ',$modPendaftaran->umur);
                    
                     
                            $jkPR = '';
                            $jkLK = '';
                            if (!empty($modPasien->jeniskelamin)){
                                if ($modPasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                                    $jkPR = 'line-words';
                                }else{
                                    $jkLK = 'line-words';
                                }
                            }
                       
                    echo $umur[0].' Tahun' ?>
                    <?php /*
                    <span class='<?php echo $jkLK ?>'><?php echo Params::JENIS_KELAMIN_LAKI_LAKI; ?></span>
                            /
                        <span class='<?php echo $jkPR ?>'><?php echo Params::JENIS_KELAMIN_PEREMPUAN; ?></span>
                     * 
                     */ ?>
                    
            </tr>
            <tr>
                <td>Pekerjaan</td>
                <td>:</td>
                <td><?php echo !empty($modPasien->pekerjaan_id)?$modPasien->pekerjaan->pekerjaan_nama:'-'; ?> </td>
            </tr>            
            <tr>
                <td>Alamat</td>
                <td>:</td>
                <td><?php echo $modPasien->alamat_pasien ?></td>
            </tr>
            <tr>
                <td>No. RM</td>
                <td>:</td>
                <td><?php echo $modPasien->no_rekam_medik ?></td>
            </tr>
        </table><br>
        <p align="justify">
            Sedang dirawat mulai tanggal <?php echo MyFormatter::formatDateTimeForUser($model->tglistirahat); ?> 
            sampai <?php echo empty($model->istirahat_tgl_sd) ? "Pulang" : MyFormatter::formatDateTimeForUser($model->istirahat_tgl_sd) ?> di ruangan 
            <?php 
            
            $r = RuanganM::model()->findByPk($model->ruanganinap_id);
            if (!empty($r)) {
                echo $r->ruangan_nama;
            } else {
                "-";
            }
            
            ?>.
        </p>
        <p align="justify">
           Demikian surat keterangan dibuat dengan sebenarnya, untuk dipergunakan sebagaimana mestinya.
        </p>
</div><br><br><br><br><br>
<table style="width: 100%; border: none;">
    <tr>
        <td></td>
        <td width="200">
            <?php $date = date('Y-m-d'); ?>
                                <?php echo ucfirst($data->kabupaten->kabupaten_nama) ;?>, <?php echo ucfirst($format->formatDateTimeForUser($date)); ?>
                                <?php //echo strtoupper($data->nama_rumahsakit);?><br>
                                Dokter Pemeriksa
                                <br><br><br><br><br>
                       
                        <?php
                           echo $model->mengetahui_surat;
                        ?>
        </td>
    </tr>
</table>
</div>