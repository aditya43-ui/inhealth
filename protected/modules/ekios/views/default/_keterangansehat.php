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
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array('judulLaporan' =>''));
                    ?>
            
                <?php }else{?>
                  <?php
                    echo $this->renderPartial('application.views.headerReport.headerDefaultNew', array());
                    ?>

                <?php } ?>
        <div>
            <div class="content">
                <div>

                    <TABLE ALIGN="CENTER">
                        <TR>
                            <TD ALIGN=CENTER VALIGN=MIDDLE>
                                <div class=""> <B><FONT  SIZE=4><U><?php echo "SURAT KETERANGAN SEHAT"; ?></U></FONT></B></div>
                            </TD>
                        </TR>
                        <TR>
                            <TD ALIGN=CENTER VALIGN=MIDDLE>
                                <B><FONT  SIZE=4>NO : <?php echo $model->nomorsurat; ?></FONT></B>
                            </TD>
                        </TR>
                    </TABLE>
                </div>
                </br><br><br><br>
                <p align="justify">
                    Yang bertanda tangan dibawah ini menerangkan bahwa :
                </p>
                <table width="100%">
                    <tr>
                        <td width="160">Nama</td>
                        <td width="10">:</td>
                        <td><?php echo $modPasien->nama_pasien ?></td>
                    </tr>
                    <tr>
                        <td>Usia</td>
                        <td>:</td>
                        <td>                     
                            <?php
                            $umur = explode(' ', $modPendaftaran->umur);


                            $jkPR = Params::JENIS_KELAMIN_PEREMPUAN;
                            $jkLK = Params::JENIS_KELAMIN_LAKI_LAKI;
                            if (!empty($modPasien->jeniskelamin)) {
                                if ($modPasien->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI) {
                                    $jkPR = '<s>' . $jkPR . '</s>';
                                } else {
                                    $jkLK = '<s>' . $jkLK . '</s>';
                                }
                            }

                            echo $umur[0] . ' Tahun,'
                            ?>
                            <span><?php echo $jkLK; ?></span>
                            /
                            <span><?php echo $jkPR; ?></span> *

                    </tr>
                    <tr>
                        <td>Pekerjaan</td>
                        <td>:</td>
                        <td><?php echo!empty($modPasien->pekerjaan_id) ? $modPasien->pekerjaan->pekerjaan_nama : '-'; ?> </td>
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
                </table><br/>
                <p align="justify">
                    Berdasarkan hasil pemeriksaan saat ini dalam keadaan :
                </p>  
                <table width="100%">
                    <tr>
                        <td>Fisik</td>
                        <td>:</td>
                        <td><?php
                            $fisikSehat = Params::SURAT_KETERANGAN_FISIK_SEHAT;
                            $fisikTidak = Params::SURAT_KETERANGAN_FISIK_TIDAK_SEHAT;
                            if (!empty($model->status_fisik)) {
                                if ($model->status_fisik == Params::SURAT_KETERANGAN_FISIK_SEHAT) {
                                    $fisikTidak = '<s>' . $fisikTidak . '</s>';
                                } elseif ($model->status_fisik == Params::SURAT_KETERANGAN_FISIK_TIDAK_SEHAT) {
                                    $fisikSehat = '<s>' . $fisikSehat . '</s>';
                                }
                            }
                            ?>
                            <span><?php echo $fisikSehat; ?></span>
                            /
                            <span><?php echo $fisikTidak; ?></span> *
                        </td>
                    </tr>
                    <tr>
                        <td>Mental</td>
                        <td>:</td>
                        <td>                        
                            <?php echo $model->status_mental; ?>
                    </tr>
                    <tr>
                        <td>Tes Buta Warna</td>
                        <td>:</td>
                        <td><?php echo $model->butawarna; ?></td>
                    </tr>            
                    <tr>
                        <td width="160">Kelayakan dengan pekerjaan</td>
                        <td width="10">:</td>
                        <td><?php
                            $layakKerja = Params::SURAT_KETERANGAN_KELAYAKAN_KERJA_LAYAK;
                            $layakTidak = Params::SURAT_KETERANGAN_KELAYAKAN_KERJA_TIDAK;
                            if (!empty($model->kelayakan_pekerjaan)) {
                                if ($model->kelayakan_pekerjaan == Params::SURAT_KETERANGAN_KELAYAKAN_KERJA_LAYAK) {
                                    $layakTidak = '<s>' . $layakTidak . '</s>';
                                } elseif ($model->kelayakan_pekerjaan == Params::SURAT_KETERANGAN_KELAYAKAN_KERJA_TIDAK) {
                                    $layakKerja = '<s>' . $layakKerja . '</s>';
                                }
                            }
                            ?>
                            <span><?php echo $layakKerja; ?></span>
                            /
                            <span><?php echo $layakTidak; ?></span> *

                        </td>
                    </tr>
                </table>
                    
                <p align="justify">
                    Demikian surat keterangan dibuat dengan sebenarnya, untuk dipergunakan sebagaimana mestinya.
                </p>
                <table width="100%">
                    <tr>
                        <td></td>
                        <td width="200" style="text-align: center">                        
                            <?php $date = date('Y-m-d'); ?>
                            <?php echo strtoupper($data->kabupaten->kabupaten_nama); ?>, <?php echo strtoupper($format->formatDateTimeForUser($date)); ?><br>
                            <?php //echo strtoupper($data->nama_rumahsakit); ?>
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
        </div>
        <?php
        if (empty($caraPrint)) {
            if (!empty($model->suratketerangan_id)) {
                $urlPrint = Yii::app()->createAbsoluteUrl($this->module->id . '/' . $this->id . '/PrintSuratKeteranganSehat&suratketerangan_id=' . $model->suratketerangan_id);
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
        
