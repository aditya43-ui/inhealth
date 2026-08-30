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
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<style>
    p{
        text-indent: 50px;
        text-align: justify;
    }
    
    .add-on{
    border: #ddd 1px solid;
    padding: 6px;
    border-radius: 5px;
}
</style>

<TABLE>
<div>
    <?php echo $this->renderPartial('application.views.headerReport.headerDefaultSuratLogoOnly'); ?>
        <TABLE ALIGN="CENTER">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4><U><?php echo "SURAT KETERANGAN DOKTER"; ?></U></span></B>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span FACE="Liberation Serif" SIZE=4>NO :  <?php echo $model->nomorsurat; ?></span></B>
                    
                    <?php
                        echo CHtml::activeHiddenField($model,'suratketerangan_id',array()); 
                    ?>
                </td>
            </tr>
        </TABLE>
    </div>
    </br><br><br><br>
    <p align="justify">
       Yang bertanda tangan dibawah ini menerangkan bahwa :
    </p>
    <p align="justify">
        <table width="100%" style="margin-left:80px;">
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
            Berdasarkan pemeriksaan kami, memerlukan istirahat selama <?php echo $model->lamaistirahat ?> (<span id='hariterbilang'><?php echo trim(MyFormatter::kataTerbilang($model->lamaistirahat)) ?></span>) hari
                            </p>
                            <p align="justify">
                            terhitung mulai tanggal
                          <?php echo MyFormatter::formatDateTimeForUser($model->tglistirahat)?>
                                sampai 
                                
                                <?php echo MyFormatter::formatDateTimeForUser($model->istirahat_tgl_sd)?>                               
                          
            <br>
        </p>
        <p align="justify">
            Demikian surat keterangan dibuat dengan sebenarnya, untuk dipergunakan sebagaimana mestinya.
        </p>
        
</div><br><br><br><br><br>
</TABLE>
<div class="row">
    <div class="col-sm-12">
        <label class="font-13px"  style="width:100%">
            <table class="tabel-surat">
                <tr style="text-align: center;">
                    <td width="100%">
                        
                    </td>
                    <td nowrap>                        
                                <?php $date = date('Y-m-d'); ?>
                                <?php echo strtoupper($data->kabupaten->kabupaten_nama) ;?>, <?php echo strtoupper($format->formatDateTimeForUser($date)); ?><br>
                                <?php //echo strtoupper($data->nama_rumahsakit);?>,
                                Dokter Pemeriksa
                                <br><br><br><br><br>
                       
                        <?php
                               echo $model->mengetahui_surat;
                            ?>
                        
                    </td>
                </tr>
                <tr>
                    <td width="80%" hidden>
                        <b>*Coret Salah Satu</b>
                    </td>
                </tr>
            </table>
      </label>
    </div>
</div>