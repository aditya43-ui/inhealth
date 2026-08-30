<?php
if (isset($caraPrint)){
    if($caraPrint=='EXCEL')
        {
             header('Content-Type: application/vnd.ms-excel');
              header('Content-Disposition: attachment;filename="'.$judulLaporan.'-'.date("Y/m/d").'.xls"');
              header('Cache-Control: max-age=0');     
        }
    echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan));     
}
?>
<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 8pt !important;
        height: 24px;
        padding-left:10px;
    }
    body{
        width: 14.7cm;
    }
    .content td{
        height: 28px;
    }
</style>
<table width="60%" border="1">
    <tr>
        <td style="width:15%">Nama Pasien / No. RM</td>
        <td style="width:15%">: <?php echo $modPasien->nama_pasien; ?> / <?php echo $modPasien->no_rekam_medik; ?></td>
        <td style="width:15%">No. Pendaftaran</td>
        <td style="width:15%">: <?php echo $modPendaftaran->no_pendaftaran; ?></td>
    </tr>
</table>
<table width="100%" class="content" style="border: none;">
<?php 
if (!empty($modKesimpulanSaran) || !empty($modSuratStudiLuar)){
?>
    <tr>
        <td colspan="4" align="center"><b>KESIMPULAN DAN SARAN</b></td>
    </tr>
    <?php if (!empty($modKesimpulanSaran)): 
        
        // var_dump($modKesimpulanSaran->attributes);
        ?>
    <tr>
        <td>Jenis Laporan</td>
        <td colspan="3">LAPORAN CHECKUP</td>
    </tr>
    <tr>
        <td>Nomor</td>
        <td><?php echo $modKesimpulanSaran->no_sarandankesimpulan; ?></td>
        <td>Tanggal</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($modKesimpulanSaran->tgl_kesimpulanmcu); ?></td>
    </tr>
    <tr>
        <td>Keperluan</td>
        <td><?php echo $modKesimpulanSaran->keperluan; ?></td>
        <td>Koordinator Checkup</td>
        <td><?php 
        if (!empty($modKesimpulanSaran->kordinator_id)) {
            $peg = PegawaiM::model()->findByPk($modKesimpulanSaran->kordinator_id);
            echo empty($peg) ? "-" : $peg->nama_pegawai;
        } else {
            echo "-";
        } 
        ?></td>
    </tr>
    <tr>
        <td colspan="4" align="center">PEMERIKSAAN FISIK</td>
    </tr>
    <tr>
        <td>Tinggi Badan</td>
        <td><?php echo empty($modKesimpulanSaran->periksaumum_tinggibadan) ? "-" : ($modKesimpulanSaran->periksaumum_tinggibadan." cm"); ?></td>
        <td>Berat Badan</td>
        <td><?php echo empty($modKesimpulanSaran->periksaumum_beratbadan) ? "-" : ($modKesimpulanSaran->periksaumum_beratbadan." Kg"); ?></td>
    </tr>
    <tr>
        <td>Tekanan Darah</td>
        <td><?php 
        if (!empty($modKesimpulanSaran->periksaumum_sistolic) && !empty($modKesimpulanSaran->periksaumum_diastolic)) {
            echo $modKesimpulanSaran->periksaumum_sistolic."/".$modKesimpulanSaran->periksaumum_diastolic;
        } else {
            echo "-";
        }
        
        ?></td>
        <td>Nadi</td>
        <td><?php echo empty($modKesimpulanSaran->periksaumum_nadi) ? "-" : $modKesimpulanSaran->periksaumum_nadi; ?></td>
    </tr>
    <tr>
        <td>Mata</td>
        <td><?php echo $modKesimpulanSaran->mata; ?></td>
        <td>BMI</td>
        <td><?php echo empty($modKesimpulanSaran->periksaumum_nilaibmi) ? "-" : ($modKesimpulanSaran->periksaumum_nilaibmi." - ".$modKesimpulanSaran->periksaumum_bmikategori); ?></td>
    </tr>
    <tr>
        <td colspan="4" align="center">LABORATORIUM</td>
    </tr>
    <tr>
        <td>Hasil Laboratorium</td>
        <td colspan="3"><?php echo $modKesimpulanSaran->pemeriksaan_laboratorium; ?></td>
    </tr>
    <tr>
        <td colspan="4" align="center">RADIOLOGI</td>
    </tr>
    <tr>
        <td>Hasil Radiologi</td>
        <td colspan="3"><?php echo $modKesimpulanSaran->pemeriksaan_radiologi; ?></td>
    </tr>
    <tr>
        <td colspan="4" align="center">PEMERIKSAAN LAIN-LAIN</td>
    </tr>
    <tr>
        <td>Kesimpulan</td>
        <td colspan="3"><?php echo empty($modKesimpulanSaran->kesimpulanperorangan) ? "-" : $modKesimpulanSaran->kesimpulanperorangan; ?></td>
    </tr>
    <tr>
        <td>Saran</td>
        <td colspan="3"><?php echo empty($modKesimpulanSaran->saranperorangan) ? "-" : $modKesimpulanSaran->saranperorangan; ?></td>
    </tr>
    <tr>
        <td>Catatan</td>
        <td colspan="3"><?php echo empty($modKesimpulanSaran->keterangan_kesimpulanmcu) ? "-" : $modKesimpulanSaran->keterangan_kesimpulanmcu; ?></td>
    </tr>
    <?php endif; ?>
    <tr>
        <td colspan="4" style="border-left: 1px solid white; border-right: 1px solid white;">&nbsp;</td>
    </tr>
    <?php if ($modSuratStudiLuar): 
        // var_dump($modSuratStudiLuar->attributes);
        ?>
    <tr>
        <td>Jenis Laporan</td>
        <td colspan="3">LAPORAN CHECKUP STUDY LUAR</td>
    </tr>
    <tr>
        <td>Nomor</td>
        <td><?php echo $modSuratStudiLuar->nomorsurat; ?></td>
        <td>Tanggal</td>
        <td><?php echo MyFormatter::formatDateTimeForUser($modSuratStudiLuar->tgl_pemeriksaan); ?></td>
    </tr>
    <tr>
        <td>Keperluan</td>
        <td><?php echo empty($modSuratStudiLuar->keperluan) ? "-" : $modSuratStudiLuar->keperluan; ?></td>
        <td>Koordinator Checkup</td>
        <td><?php 
        if (!empty($modSuratStudiLuar->pegawai_id)) {
            $peg = PegawaiM::model()->findByPk($modSuratStudiLuar->pegawai_id);
            echo empty($peg) ? "-" : $peg->nama_pegawai;
        } else {
            echo "-";
        } 
        ?></td>
    </tr>
    <tr>
        <td>Negara Tujuan</td>
        <td><?php echo empty($modSuratStudiLuar->negaratujuan) ? "-" : $modSuratStudiLuar->negaratujuan; ?></td>
        <td></td>
        <td></td>
    </tr>
    <tr><td colspan="4" align="center">MEDICAL HISTORY</td></tr>
    <tr>
        <td>A. Heart Desease</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->heartdease_yes ? "Yes" : "";
        echo $modSuratStudiLuar->heartdease_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>B. Hypertension</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->hypertension_yes ? "Yes" : "";
        echo $modSuratStudiLuar->hypertension_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>C. Lung Disease</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->lungdisease_yes ? "Yes" : "";
        echo $modSuratStudiLuar->lungdisease_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>D. Asthma</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->asthma_yes ? "Yes" : "";
        echo $modSuratStudiLuar->asthma_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>E. Liver Disease</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->liverdisease_yes ? "Yes" : "";
        echo $modSuratStudiLuar->liverdisease_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>F. Diabetes</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->diabetes_yes ? "Yes" : "";
        echo $modSuratStudiLuar->diabetes_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>G. Kidney Disease</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->kidneydisease_yes ? "Yes" : "";
        echo $modSuratStudiLuar->kidneydisease_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>H. Leprosy</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->leprosy_yes ? "Yes" : "";
        echo $modSuratStudiLuar->leprosy_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>I. Sexually Transmitted Infections</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->sexsuallytransmiedinfection_yes ? "Yes" : "";
        echo $modSuratStudiLuar->sexsuallytransmiedinfection_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>J. Pshychiatric Illness</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->pyschiatricillnes_yes ? "Yes" : "";
        echo $modSuratStudiLuar->pyschiatricillnes_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>K. Hepatitis</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->hepatitis_yes ? "Yes" : "";
        echo $modSuratStudiLuar->hepatitis_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>L. Drug Use</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->druguse_yes ? "Yes" : "";
        echo $modSuratStudiLuar->druguse_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>M. Epilopsi</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->epilepsi_yes ? "Yes" : "";
        echo $modSuratStudiLuar->epilepsi_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>N. Malaria</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->malaria_yes ? "Yes" : "";
        echo $modSuratStudiLuar->malaria_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>O. Tubercolosis</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->tubercolosis_yes ? "Yes" : "";
        echo $modSuratStudiLuar->tubercolosis_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>P. HIV/AIDS</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->hiv_aids_yes ? "Yes" : "";
        echo $modSuratStudiLuar->hiv_aids_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>Q. Dengue Hemorrhagic Fever</td>
        <td colspan="3">
        <?php    
        echo $modSuratStudiLuar->heartdease_yes ? "Yes" : "";
        echo $modSuratStudiLuar->heartdease_no ? " No" : "";
        ?>
        </td>
    </tr>
    <tr>
        <td>Others</td>
        <td colspan="3">
        <?php    
        if (!$modSuratStudiLuar->otherdisease_yes) {
            echo "No";
        } else {
            echo "Yes, ".(empty($modSuratStudiLuar->otherdisease_keterangan) ? "-" : $modSuratStudiLuar->otherdisease_keterangan);
        }
        ?>
        </td>
    </tr>
    
    
    
    <tr><td colspan="4" align="center">PHYSICAL EXAMINATION</td></tr>
    <tr>
        <td>A. Height</td>
        <td colspan="3"><?php echo empty($modSuratStudiLuar->height) ? "-" : $modSuratStudiLuar->height; ?></td>
    </tr>
    <tr>
        <td>B. Weight</td>
        <td colspan="3"><?php echo empty($modSuratStudiLuar->weight) ? "-" : $modSuratStudiLuar->weight; ?></td>
    </tr>
    <tr>
        <td>C. Blood Pressure</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->sistolic_bloodpressure) || empty($modSuratStudiLuar->diastolic_bloodpressure)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->sistolic_bloodpressure."/".$modSuratStudiLuar->diastolic_bloodpressure;
            }
            ?>
            
        </td>
    </tr>
    <tr>
        <td>D. Pulse</td>
        <td colspan="3"><?php echo empty($modSuratStudiLuar->pulse) ? "-" : $modSuratStudiLuar->pulse; ?></td>
    </tr>
    <tr>
        <td>E. Skin</td>
        <td colspan="3"><?php 
        echo $modSuratStudiLuar->skin_normal ? "Normal" : "";
        echo $modSuratStudiLuar->skin_abnormal ? " Abnormal" : "";
        
        ?></td>
    </tr>
    <tr>
        <td>F. Vision</td>
        <td colspan="3"><?php 
        echo empty($modSuratStudiLuar->vision_left) ? "-" : $modSuratStudiLuar->vision_left;
        echo "/";
        echo empty($modSuratStudiLuar->vision_right) ? "-" : $modSuratStudiLuar->vision_right;
        
        ?></td>
    </tr>
    <tr>
        <td>G. Ears</td>
        <td colspan="3"><?php 
        echo $modSuratStudiLuar->ears_normal ? "Normal" : "";
        echo $modSuratStudiLuar->ears_abnormal ? " Abnormal" : "";
        
        ?></td>
    </tr>
    <tr>
        <td>H. Eyes</td>
        <td colspan="3"><?php 
        echo $modSuratStudiLuar->eyes_normal ? "Normal" : "";
        echo $modSuratStudiLuar->eyes_abnormal ? " Abnormal" : "";
        
        ?></td>
    </tr>
    <tr>
        <td>I. Heart</td>
        <td colspan="3"><?php 
        echo $modSuratStudiLuar->heart_normal ? "Normal" : "";
        echo $modSuratStudiLuar->heart_abnormal ? " Abnormal" : "";
        
        ?></td>
    </tr>
    <tr>
        <td>J. Lung</td>
        <td colspan="3"><?php 
        echo $modSuratStudiLuar->lungs_normal ? "Normal" : "";
        echo $modSuratStudiLuar->lungs_abnormal ? " Abnormal" : "";
        
        ?></td>
    </tr>
    <tr>
        <td>K. Liver</td>
        <td colspan="3"><?php 
        echo $modSuratStudiLuar->liver_normal ? "Normal" : "";
        echo $modSuratStudiLuar->liver_abnormal ? " Abnormal" : "";
        
        ?></td>
    </tr>
    <tr>
        <td>L. Spleen</td>
        <td colspan="3"><?php 
        echo $modSuratStudiLuar->spleen_normal ? "Normal" : "";
        echo $modSuratStudiLuar->spleen_abnormal ? " Abnormal" : "";
        
        ?></td>
    </tr>
    <tr>
        <td>M. Thyroid Gland</td>
        <td colspan="3"><?php 
        echo $modSuratStudiLuar->tyrhoidgland_normal ? "Normal" : "";
        echo $modSuratStudiLuar->tyrhoidgland_abnormal ? " Abnormal" : "";
        
        ?></td>
    </tr>
    <tr>
        <td>N. Lymph Abnormaldes</td>
        <td colspan="3"><?php 
        echo $modSuratStudiLuar->lymphnodes_normal ? "Normal" : "";
        echo $modSuratStudiLuar->lymphnodes_abnormal ? " Abnormal" : "";
        
        ?></td>
    </tr>
    <tr>
        <td>O. External Genitalia</td>
        <td colspan="3"><?php 
        echo $modSuratStudiLuar->ekternalgenitalia_normal ? "Normal" : "";
        echo $modSuratStudiLuar->ekternalgenitalia_abnormal ? " Abnormal" : "";
        
        ?></td>
    </tr>
    <tr>
        <td>P. Hemia</td>
        <td colspan="3"><?php 
        echo $modSuratStudiLuar->hemia_normal ? "Normal" : "";
        echo $modSuratStudiLuar->hemia_abnormal ? " Abnormal" : "";
        
        ?></td>
    </tr>
    <tr>
        <td>Q. Mental</td>
        <td colspan="3"><?php 
        echo $modSuratStudiLuar->mental_normal ? "Normal" : "";
        echo $modSuratStudiLuar->mental_abnormal ? " Abnormal" : "";
        
        ?></td>
    </tr>
    <tr>
        <td>Others</td>
        <td colspan="3">
        <?php    
        if (!$modSuratStudiLuar->otherphyscal_yes) {
            echo "No";
        } else {
            echo "Yes, ".(empty($modSuratStudiLuar->otherphyscal_keterangan) ? "-" : $modSuratStudiLuar->otherphyscal_keterangan);
        }
        ?>
        </td>
    </tr>
    
    
    <tr><td colspan="4" align="center">LABORATORY EXAMINATION</td></tr>
    <tr>
        <td>A. Serological Test for HIV</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->serologicalhiv_positive) && empty($modSuratStudiLuar->serologicalhiv_negative)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->serologicalhiv_positive ? "Positive" : "Negative";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>B. Serological Test for Shyphilis</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->serologicalsyphilis_positive) && empty($modSuratStudiLuar->serologicalsyphilis_negative)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->serologicalsyphilis_positive ? "Positive" : "Negative";
            }
            
            if (!empty($modSuratStudiLuar->serologicalsyphilis_vdrl)) {
                echo " (VDRL)";
            }
            if (!empty($modSuratStudiLuar->serologicalsyphilis_tpha)) {
                echo " (TPHA)";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>C. Hepatitis B Surface Antingen Test</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->hepatitis_b_positive) && empty($modSuratStudiLuar->hepatitis_b_negative)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->hepatitis_b_positive ? "Positive" : "Negative";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>D. Blood Film for Malaria</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->blood_malaria_positive) && empty($modSuratStudiLuar->blood_malaria_negative)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->blood_malaria_positive ? "Positive" : "Negative";
                echo $modSuratStudiLuar->blood_malaria_positive ? ", Species : ".$modSuratStudiLuar->blood_malaria_species : "";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>E. Chest X-Ray for Tuberculosis</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->tuberculosis_positive) && empty($modSuratStudiLuar->tuberculosis_negative)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->tuberculosis_positive ? "Normal" : "Abnormal";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>F. Stool Examination for Parasites</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->stool_parasites_positive) && empty($modSuratStudiLuar->stool_parasites_negative)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->stool_parasites_positive ? "Positive" : "Negative";
                echo $modSuratStudiLuar->stool_parasites_positive ? ", Species : ".$modSuratStudiLuar->stool_parasites_species : "";
                
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>G. Haematology Test</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->haematology_normal) && empty($modSuratStudiLuar->haematology_abnormal)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->haematology_normal ? "Normal" : "Abnormal";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>H. Urinalysis Test</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->urinalysis_normal) && empty($modSuratStudiLuar->urinalysis_abnormal)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->urinalysis_normal ? "Noemal" : "Abnormal";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>I. Pregnancy Test</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->pregnancy_positive) && empty($modSuratStudiLuar->pregnancy_negative)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->pregnancy_positive ? "Positive" : "Negative";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>J. Urine Test for Amphetamine</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->urinetest_amphetamine_positive) && empty($modSuratStudiLuar->urinetest_amphetamine_negative)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->urinetest_amphetamine_positive ? "Positive" : "Negative";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>K. Urine Test for Morphine</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->urinetest_morphine_positive) && empty($modSuratStudiLuar->urinetest_morphine_negative)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->urinetest_morphine_positive ? "Positive" : "Negative";
            }
            ?>
        </td>
    </tr>
    <tr>
        <td>L. Mariyuana</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->mariyuana_positive) && empty($modSuratStudiLuar->mariyuana_negative)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->mariyuana_positive ? "Positive" : "Negative";
            }
            ?>
        </td>
    </tr>
    
    
    <tr><td colspan="4" align="center">OTHERS</td></tr>
    <tr>
        <td>Check Up Leprosy</td>
        <td colspan="3">
            <?php
            if (empty($modSuratStudiLuar->checkup_leprosy_positive) && empty($modSuratStudiLuar->checkup_leprosy_negative)) {
                echo "-";
            } else {
                echo $modSuratStudiLuar->checkup_leprosy_positive ? "Normal" : "Abnormal";
            }
            ?>
            
        </td>
    </tr>
    <tr>
        <td>Conclusion</td>
        <td colspan="3">
            <?php echo empty($modSuratStudiLuar->conclusion) ? "-" : $modSuratStudiLuar->conclusion; ?>
        </td>
    </tr>
    
    <?php endif; ?>
<?php
}else{
?>
    <tr>
        <td colspan="6">* Tidak ada Kesimpulan dan Saran</td>
    </tr> 
<?php } ?>
</table> 