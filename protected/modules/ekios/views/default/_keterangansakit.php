<?php
$data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$format = new MyFormatter();
?>
<style>
    body {
        /*        font-size: 8pt;*/
    }

    p{
        margin-left: 0px;
        text-align: justify;
    }

    .tab-foot, .tab-foot td {
        /*        font-size: 6pt;*/
    }
    table td{
        text-align:left;
        font-size:10px;
    }
    p{
        font-size:10px;

    }
</style>

<div>
<div class="header">
<?php if(isset($caraPrint)) {?>
                <?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?>
            
                <?php }else{?>
                  <?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?>

                <?php } ?>
            <div class="content">
    <div>

        <TABLE ALIGN="CENTER">
             <TR>
                 <TD ALIGN=CENTER VALIGN=MIDDLE style="text-align:center">
                    <B><FONT SIZE=4><U>SURAT KETERANGAN SAKIT</U></FONT></B>
                </TD>
            </TR>
             <TR>
                <TD ALIGN=CENTER VALIGN=MIDDLE style="text-align:center">
                   <B><FONT  SIZE=4>NO : <?php echo $model->nomorsurat; ?></FONT></B>
                </TD>
            </TR>
        </TABLE>
    </div>
    </br><br><br><br>
    <div>        
    <p align="justify">
        Yang bertanda tangan dibawah ini menerangkan bahwa :
    </p>
    <p align="justify">
    <table style="margin-left:50px;">
            <tr>
                <td width="100">Nama</td>
                <td width="10">:</td>
                <td><?php echo $modPasien->nama_pasien ?></td>
            </tr>
            <tr>
                <td>Umur</td>
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
        Berdasarkan hasi pemeriksaan kesehatan pasien tersebut perlu mendapatkan istirahat karena sakit selama <?php echo $model->lamaistirahat." (".$this->terbilang($model->lamaistirahat).")"; ?> hari 
            dari tanggal <?php echo $format->formatDateTimeForUser($model->tglsurat); ?> s/d tanggal <?php echo $format->formatDateTimeForUser($model->istirahat_tgl_sd); ?>
        </p>
        <p align="justify">
        Demikian surat ini kami buat untuk dapat dipergunakan sebagaimana mestinya.
        </p>
</div>

<table width="100%">
    <tr>
        <td width="200">                        
                   <?php $date = date('Y-m-d'); ?>
                    <?php echo strtoupper($data->kabupaten->kabupaten_nama) ;?>, <?php echo strtoupper($format->formatDateTimeForUser($date)); ?><br>
                    <?php //echo strtoupper($data->nama_rumahsakit);?>
                    
                    <br><br><br><br><br>

            <?php
                   echo (!empty($model->mengetahui_surat) ? "".$model->mengetahui_surat."" : " _________________ " ) ;
                ?><br>
                SIP. <?php echo $model->sip($model->pegawai_id); ?>

        </td>
        <td></td>
        
    </tr>
    <!--tr style="padding:10px;">
        <td colspan="2">
            <b>*Coret Salah Satu</b>
        </td>
    </tr-->
</table>
</div>
        </div>
        <?php
        if (empty($caraPrint)) {
            if (!empty($model->suratketerangan_id)) {
                $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/PrintKeteranganSakit&suratketerangan_id=' . $model->suratketerangan_id);
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-primary', 'disabled' => false, 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
            } else {
                $urlPrint = '';
                echo CHtml::htmlButton(Yii::t('mds', '{icon} Cetak', array('{icon}' => '<i class="' . MyIcon::getIcons('cetak') . '"></i>')), array('class' => 'btn btn-primary', 'disabled' => true, 'type' => 'button', 'onclick' => 'print(\'PDF\')')) . "&nbsp&nbsp";
            }
            ?>
            <script>
                function print(caraPrint)
                {
                    window.open("<?php echo $urlPrint ?>&caraPrint=" + caraPrint, "", 'location=_new, width=980px');
                }
            </script>
            <?php
        }
        ?>
        
