<div class="span12" style="border-top: 1px solid black;">
    <table id="tblDaftarAnamnesa" width="100%">
        <tr>
            <td colspan="2"><b>Kepala Leher <?php echo !empty($modPemeriksaanFisik->is_pilih) ? "(".$modPemeriksaanFisik->is_pilih.")" : "" ?></b></td>
        </tr>
        <tr>
            <td width="30%">Conjuctiva</td>
            <td><?php 
            
            echo !empty($modPemeriksaanFisik->leher_anemia) ? "Anemia" : ""; 
            echo !empty($modPemeriksaanFisik->leher_leterus) ? "Leterus" : ""; 
            echo !empty($modPemeriksaanFisik->leher_cyanosis) ? "Cyanosis" : ""; 
            echo !empty($modPemeriksaanFisik->leher_dyspneu) ? "Dyspneu" : ""; 
            
            ?></td>
        </tr>
        <tr>
            <td width="30%">Reflek Pupil</td>
            <td><?php echo (!empty($modPemeriksaanFisik->leher_reflekpupil) && $modPemeriksaanFisik->leher_reflekpupil == 1) ? "Positif" : "Negatif";?></td>
        </tr>
        <tr>
            <td>Pupil</td>
            <td><?php echo !empty($modPemeriksaanFisik->leher_pupil) ? $modPemeriksaanFisik->leher_pupil : "-"; ?></td>
        </tr>
        <tr>
            <td>Nasal</td>
            <td><?php echo !empty($modPemeriksaanFisik->leher_nasal) ? $modPemeriksaanFisik->leher_nasal : "-"; ?></td>
        </tr>
        <tr>
            <td>Orofans</td>
            <td><?php echo !empty($modPemeriksaanFisik->leher_orofans) ? $modPemeriksaanFisik->leher_orofans : "-"; ?></td>
        </tr>
        <tr>
            <td>Pembesaran KGB</td>
            <td><?php 
                echo (!empty($modPemeriksaanFisik->leher_kelgetahbening_teraba) && $modPemeriksaanFisik->leher_kelgetahbening_teraba == 1) ? "Positif" : "Negatif";

            
            
            ?></td>
        </tr>
        <tr>
            <td>Pembesaran Kelenjar Thyroid</td>
            <td><?php 
                echo (!empty($modPemeriksaanFisik->leher_kelenjartiroid_teraba) && $modPemeriksaanFisik->leher_kelenjartiroid_teraba == 1) ? "Positif" : "Negatif";
 
            
            ?></td>
        </tr>
        <tr>
            <td>JVP</td>
            <td><?php 
                echo (!empty($modPemeriksaanFisik->leher_jvp) && $modPemeriksaanFisik->leher_jvp == 1) ? "Meningkat" : "Tidak Meningkat";

            ?></td>
        </tr>
        <tr>
            <td>Lain-Lain</td>
            <td><?php echo !empty($modPemeriksaanFisik->leher_lainlain) ? $modPemeriksaanFisik->leher_lainlain : "-"; ?></td>
        </tr>
    </table>
</div>
