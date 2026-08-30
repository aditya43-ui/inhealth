<style>
hr {
    border: 1pt solid grey;
    text-align: center;
    width: 95%;
}

.judul {
    text-align: center;
    font-weight: bold;
    font-style: "Arial Narrow", Arial, sans-serif;
}

.judul2 {
    font-weight: bold;
    font-style: "Arial Narrow", Arial, sans-serif;
}

.content-judul2 {
    margin-left: 100px;
    font-style: "Arial Narrow", Arial, sans-serif;
}

#tbl-ttd tr, #tbl-ttd td {
    line-height: 25px;
}

</style>

<div>
    <div class="header">
        <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNewKabRS'); ?>
    </div>
</div>
<br>
<center>
    <hr>
</center><br>
<p>
<h3 class="judul"><u>HASIL PEMERIKSAAN MIKROBIOLOGI KLINIK</u></h3>
</p>
<table style="width: 85%; margin-left: 100px; margin-top: 50px;">
    <tr>
        <td style="width: 20%;">Nomor Lab</td>
        <td>: <?= $kultur->no_lab ?></td>
        <td>&emsp;</td>
        <td style="width: 20%;">Tanggal Terima Spesimen</td>
        <td>: <?= MyFormatter::formatDateTimeForUser($kultur->tgl_pemeriksaan) ?></td>
    </tr>
    <tr>
        <td>Nomor Rekam Medik</td>
        <td>: <?= $modPasien->no_rekam_medik ?></td>
        <td>&emsp;</td>
        <td>Nama Dokter Pengirim</td>
        <td>: <?= $kultur->pegawai->namaLengkap ?></td>
    </tr>
    <tr>
        <td>Nama Pasien</td>
        <td>: <?= $modPasien->nama_pasien ?></td>
        <td>&emsp;</td>
        <td>Diagnosa</td>
        <td>: <?= '' ?></td>
    </tr>
    <tr>
        <td>Umur Pasien</td>
        <td>: <?= $modPasien->umurTahun . ' Tahun' ?></td>
        <td>&emsp;</td>
        <td>Spesimen</td>
        <td>: <?= '' ?></td>
    </tr>
    <tr>
        <td>Jenis Kelamin Pasien</td>
        <td>: <?= $modPasien->jeniskelamin ?></td>
        <td>&emsp;</td>
        <td>Asal Ruangan/RS</td>
        <td>: <?= '' ?></td>
    </tr>
</table>
<br>
<center>
    <hr>
</center><br>
<div class="content-judul2">
    <div class="judul2">A.&emsp;Sediaan Langsung&nbsp;&nbsp;:<br></div>
    <div>&emsp;&emsp;1. &emsp;Pewarnaan Garam<br>
        <div>
            <tabel style="width: 100%;">
                <tbody>
                    <tr>
                        <td style="width: 30%;">&emsp;&emsp;&emsp;&emsp;&bull;&emsp;Sel Epitel</td>
                        <td>&emsp;&emsp;&emsp;&emsp;&emsp;&emsp;:&emsp;<?= $kultur->sel_epitel_kultur ?><br></td>
                    </tr>
                    <tr>
                        <td>&emsp;&emsp;&emsp;&emsp;&bull;&emsp;Sel Radang</td>
                        <td>&emsp;&emsp;&emsp;&emsp;&emsp;:&emsp;<?= $kultur->sel_radang_kultur ?><br></td>
                    </tr>
                    <tr>
                        <td>&emsp;&emsp;&emsp;&emsp;&bull;&emsp;Sel Mikroorganisme</td>
                        <td>&nbsp;&nbsp;&emsp;:&emsp;<?= $kultur->mikroorganisme ?></td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>
    <div>
        <table style="margin-left: 25px;">
            <tr>
                <td style="width: 25px;">2.</td>
                <td>Pewarnaan Ziehl Nielsen</td>
                <td style="text-align: right; width: 50px;">:</td>
                <td>&emsp;<?= $kultur->ziehlnielsen_kultur ?></td>
            </tr>
            <tr>
                <td style="">3.</td>
                <td>Pewarnaan KOH</td>
                <td style="text-align: right; ">:</td>
                <td>&emsp;<?= $kultur->koh_kultur ?></td>
            </tr>
            <tr>
                <td style="">4.</td>
                <td>Pewarnaan Neisser</td>
                <td style="text-align: right; ">:</td>
                <td>&emsp;<?= $kultur->niesser_kultur ?></td>
            </tr>
            <tr>
                <td style="">5.</td>
                <td>Pewarnaan Negatif</td>
                <td style="text-align: right; ">:</td>
                <td>&emsp;<?= $kultur->negatif_kultur ?></td>
            </tr>
            <tr>
                <td style="">6.</td>
                <td>Pewarnaan Spora</td>
                <td style="text-align: right; ">:</td>
                <td>&emsp;<?= $kultur->spora_kultur ?></td>
            </tr>
            <tr>
                <td style="">7.</td>
                <td>Pewarnaan Giemsa</td>
                <td style="text-align: right; ">:</td>
                <td>&emsp;<?= $kultur->giemsa_kultur ?></td>
            </tr>
        </table>
    </div>
</div><br>
<div class="content-judul2">
    <div class="judul2">B.&emsp;Biakan Kultur (Aerob / Anaerob)&nbsp;&nbsp;:<br></div>
    <div>
        &emsp;&emsp;<?= $kultur->biakan_kultur ?><br><p> &emsp;&emsp;<?= $kultur->biakan_kultur_ket ?></p>
    </div>
</div><br>
<div class="content-judul2">
    <div class="judul2">C.&emsp; Tes Kepekaan Antibiotika: (S: Sensitif ; I : Intermediate ; R: Resisten)&nbsp;&nbsp;:<br></div>
    <div>
       <table style="width: 100%; margin: 10px;" border="1">
            <tbody>
                <tr>
                    <td style="text-align: center; font-weight: bold;">JENIS OBAT</td>
                    <td style="text-align: center; font-weight: bold;">&emsp;1&emsp;</td>
                    <td style="text-align: center; font-weight: bold;">&emsp;2&emsp;</td>
                    <td style="text-align: center; font-weight: bold;">JENIS OBAT</td>
                    <td style="text-align: center; font-weight: bold;">&emsp;1&emsp;</td>
                    <td style="text-align: center; font-weight: bold;">&emsp;2&emsp;</td>
                    <td style="text-align: center; font-weight: bold;">JENIS OBAT</td>
                    <td style="text-align: center; font-weight: bold;">&emsp;1&emsp;</td>
                    <td style="text-align: center; font-weight: bold;">&emsp;2&emsp;</td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">&nbsp;A.&emsp;PENICILLIN & DERIVATNYA</td>
                    <td style="text-align: center; font-weight: bold;"></td>
                    <td style="text-align: center; font-weight: bold;"></td>
                    <td style="font-weight: bold;">&nbsp;F.&emsp;CEPHALOSPHORIN</td>
                    <td style="text-align: center; font-weight: bold;"></td>
                    <td style="text-align: center; font-weight: bold;"></td>
                    <td style="font-weight: bold;">&nbsp;I.&emsp;MACROLIDES</td>
                    <td style="text-align: center; font-weight: bold;"></td>
                    <td style="text-align: center; font-weight: bold;"></td>
                </tr>
                <tr>
                    <td style="">&nbsp;1.&emsp;Amoxycillin</td>
                    <?php $amoxycilin = $kultur->amoxycilin !== "" ? explode(" / ", $kultur->amoxycilin) : ["-", "-"] ?>
                    <td style="text-align: center;"><?php echo $amoxycilin[0] ?></td>
                    <td style="text-align: center;"><?php echo $amoxycilin[1] ?></td>
                    <?php $cefepime = $kultur->cefepime !== "" ? explode(" / ", $kultur->cefepime) : ["-", "-"] ?>
                    <td style="">&nbsp;1.&emsp;Cefepime</td>
                    <td style="text-align: center;"><?php echo $cefepime[0] ?></td>
                    <td style="text-align: center;"><?php echo $cefepime[1] ?></td>
                    <?php $erythromycin = $kultur->erythromycin !== "" ? explode(" / ", $kultur->erythromycin) : ["-", "-"] ?>
                    <td style="">&nbsp;1.&emsp;Erythromycin</td>
                    <td style="text-align: center;"><?php echo $erythromycin[0] ?></td>
                    <td style="text-align: center;"><?php echo $erythromycin[1] ?></td>
                </tr>
                <tr>
                    <?php $clavulanic = $kultur->clavulanic !== "" ? explode(" / ", $kultur->clavulanic) : ["-", "-"] ?>
                    <td style="">&nbsp;2.&emsp;Amoxycillin & Clavulanic Acid</td>
                    <td style="text-align: center;"><?php echo $clavulanic[0] ?></td>
                    <td style="text-align: center;"><?php echo $clavulanic[1] ?></td>
                    <?php $cefpirome = $kultur->cefpirome !== "" ? explode(" / ", $kultur->cefpirome) : ["-", "-"] ?>
                    <td style="">&nbsp;2.&emsp;Cefpirome</td>
                    <td style="text-align: center;"><?php echo $cefpirome[0] ?></td>
                    <td style="text-align: center;"><?php echo $cefpirome[1] ?></td>
                    <?php $lincomycin = $kultur->lincomycin !== "" ? explode(" / ", $kultur->lincomycin) : ["-", "-"] ?>
                    <td style="">&nbsp;2.&emsp;Lincomycin</td>
                    <td style="text-align: center;"><?php echo $lincomycin[0] ?></td>
                    <td style="text-align: center;"><?php echo $lincomycin[1] ?></td>
                </tr>
                <tr>
                    <?php $ampicillin = $kultur->ampicillin !== "" ? explode(" / ", $kultur->ampicillin) : ["-", "-"] ?>
                    <td style="">&nbsp;3.&emsp;Ampicillin</td>
                    <td style="text-align: center;"><?php echo $ampicillin[0] ?></td>
                    <td style="text-align: center;"><?php echo $ampicillin[1] ?></td>
                    <?php $cefoperazone = $kultur->cefoperazone !== "" ? explode(" / ", $kultur->cefoperazone) : ["-", "-"] ?>
                    <td style="">&nbsp;3.&emsp;Cefoperazone</td>
                    <td style="text-align: center;"><?php echo $cefoperazone[0] ?></td>
                    <td style="text-align: center;"><?php echo $cefoperazone[1] ?></td>
                    <?php $clindamycin = $kultur->clindamycin !== "" ? explode(" / ", $kultur->clindamycin) : ["-", "-"] ?>
                    <td style="">&nbsp;3.&emsp;Clindamycin</td>
                    <td style="text-align: center;"><?php echo $clindamycin[0] ?></td>
                    <td style="text-align: center;"><?php echo $clindamycin[1] ?></td>
                </tr>
                <tr>
                    <?php $sulbactam = $kultur->sulbactam !== "" ? explode(" / ", $kultur->sulbactam) : ["-", "-"] ?>
                    <td style="">&nbsp;4.&emsp;Ampicillin/Sulbactam</td>
                    <td style="text-align: center;"><?php echo $sulbactam[0] ?></td>
                    <td style="text-align: center;"><?php echo $sulbactam[1] ?></td>
                    <?php $cefoperazone = $kultur->cefoperazone !== "" ? explode(" / ", $kultur->cefoperazone) : ["-", "-"] ?>
                    <td style="">&nbsp;4.&emsp;Cefoperazone/sulbactam</td>
                    <td style="text-align: center;"><?php echo $cefoperazone[0] ?></td>
                    <td style="text-align: center;"><?php echo $cefoperazone[1] ?></td>
                    <?php $czithromycin = $kultur->czithromycin !== "" ? explode(" / ", $kultur->czithromycin) : ["-", "-"] ?>
                    <td style="">&nbsp;4.&emsp;Azithromycin</td>
                    <td style="text-align: center;"><?php echo $czithromycin[0] ?></td>
                    <td style="text-align: center;"><?php echo $czithromycin[1] ?></td>
                </tr>
                <tr>
                    <?php $benzylpenicillin = $kultur->benzylpenicillin !== "" ? explode(" / ", $kultur->benzylpenicillin) : ["-", "-"] ?>
                    <td style="">&nbsp;5.&emsp;Benzylpenicillin</td>
                    <td style="text-align: center;"><?php echo $benzylpenicillin[0] ?></td>
                    <td style="text-align: center;"><?php echo $benzylpenicillin[1] ?></td>
                    <?php $cefditoren = $kultur->cefditoren !== "" ? explode(" / ", $kultur->cefditoren) : ["-", "-"] ?>
                    <td style="">&nbsp;5.&emsp;Cefditoren</td>
                    <td style="text-align: center;"><?php echo $cefditoren[0] ?></td>
                    <td style="text-align: center;"><?php echo $cefditoren[1] ?></td>
                    <?php $clarithromycin = $kultur->clarithromycin !== "" ? explode(" / ", $kultur->clarithromycin) : ["-", "-"] ?>
                    <td style="">&nbsp;5.&emsp;Clarithromycin</td>
                    <td style="text-align: center;"><?php echo $clarithromycin[0] ?></td>
                    <td style="text-align: center;"><?php echo $clarithromycin[1] ?></td>
                </tr>
                <tr>
                    <?php $piperacillin = $kultur->piperacillin !== "" ? explode(" / ", $kultur->piperacillin) : ["-", "-"] ?>
                    <td style="">&nbsp;6.&emsp;Piperacillin/Tazobactam</td>
                    <td style="text-align: center;"><?php echo $piperacillin[0] ?></td>
                    <td style="text-align: center;"><?php echo $piperacillin[1] ?></td>
                    <?php $cefadroxil = $kultur->cefadroxil !== "" ? explode(" / ", $kultur->cefadroxil) : ["-", "-"] ?>
                    <td style="">&nbsp;6.&emsp;Cefadroxil</td>
                    <td style="text-align: center;"><?php echo $cefadroxil[0] ?></td>
                    <td style="text-align: center;"><?php echo $cefadroxil[1] ?></td>
                    <?php $tobramycin = $kultur->tobramycin !== "" ? explode(" / ", $kultur->tobramycin) : ["-", "-"] ?>
                    <td style="">&nbsp;6.&emsp;Tobramycin</td>
                    <td style="text-align: center;"><?php echo $tobramycin[0] ?></td>
                    <td style="text-align: center;"><?php echo $tobramycin[1] ?></td>
                </tr>
                <tr>
                    <?php $cloxacillin = $kultur->cloxacillin !== "" ? explode(" / ", $kultur->cloxacillin) : ["-", "-"] ?>
                    <td style="">&nbsp;7.&emsp;Cloxacillin</td>
                    <td style="text-align: center;"><?php echo $cloxacillin[0] ?></td>
                    <td style="text-align: center;"><?php echo $cloxacillin[1] ?></td>
                    <?php $cefotaxim = $kultur->cefotaxim !== "" ? explode(" / ", $kultur->cefotaxim) : ["-", "-"] ?>
                    <td style="">&nbsp;7.&emsp;Cefotaxim</td>
                    <td style="text-align: center;"><?php echo $cefotaxim[0] ?></td>
                    <td style="text-align: center;"><?php echo $cefotaxim[1] ?></td>
                    <td style="font-weight: bold;">&nbsp;J.&emsp;LAIN – LAIN</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                </tr>
                <tr>
                    <td style="">&nbsp;&emsp;</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <?php $ceftriaxone = $kultur->ceftriaxone !== "" ? explode(" / ", $kultur->ceftriaxone) : ["-", "-"] ?>
                    <td style="">&nbsp;8.&emsp;Ceftriaxone</td>
                    <td style="text-align: center;"><?php echo $ceftriaxone[0] ?></td>
                    <td style="text-align: center;"><?php echo $ceftriaxone[1] ?></td>
                    <?php $chloramphenicol = $kultur->chloramphenicol !== "" ? explode(" / ", $kultur->chloramphenicol) : ["-", "-"] ?>
                    <td style="">&nbsp;1.&emsp;Chloramphenicol</td>
                    <td style="text-align: center;"><?php echo $chloramphenicol[0] ?></td>
                    <td style="text-align: center;"><?php echo $chloramphenicol[1] ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">&nbsp;B.&emsp;FOSFOMYCIN</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <?php $cefuroxime = $kultur->cefuroxime !== "" ? explode(" / ", $kultur->cefuroxime) : ["-", "-"] ?>
                    <td style="">&nbsp;9.&emsp;Cefuroxime</td>
                    <td style="text-align: center;"><?php echo $cefuroxime[0] ?></td>
                    <td style="text-align: center;"><?php echo $cefuroxime[1] ?></td>
                    <?php $nalidixid = $kultur->nalidixid !== "" ? explode(" / ", $kultur->nalidixid) : ["-", "-"] ?>
                    <td style="">&nbsp;2.&emsp;Nalidixid Acid</td>
                    <td style="text-align: center;"><?php echo $nalidixid[0] ?></td>
                    <td style="text-align: center;"><?php echo $nalidixid[1] ?></td>
                </tr>
                <tr>
                    <td style="">&nbsp;&emsp;</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <?php $cefradine = $kultur->cefradine !== "" ? explode(" / ", $kultur->cefradine) : ["-", "-"] ?>
                    <td style="">&nbsp;10.&emsp;Cefradine</td>
                    <td style="text-align: center;"><?php echo $cefradine[0] ?></td>
                    <td style="text-align: center;"><?php echo $cefradine[1] ?></td>
                    <?php $nitrofurantoin = $kultur->nitrofurantoin !== "" ? explode(" / ", $kultur->nitrofurantoin) : ["-", "-"] ?>
                    <td style="">&nbsp;3.&emsp;Nitrofurantoin</td>
                    <td style="text-align: center;"><?php echo $nitrofurantoin[0] ?></td>
                    <td style="text-align: center;"><?php echo $nitrofurantoin[1] ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">&nbsp;C.&emsp;AMINOGLYCOSIDES</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <?php $cefalexin = $kultur->cefalexin !== "" ? explode(" / ", $kultur->cefalexin) : ["-", "-"] ?>
                    <td style="">&nbsp;11.&emsp;Cefalexin</td>
                    <td style="text-align: center;"><?php echo $cefalexin[0] ?></td>
                    <td style="text-align: center;"><?php echo $cefalexin[1] ?></td>
                    <?php $colistine = $kultur->colistine !== "" ? explode(" / ", $kultur->colistine) : ["-", "-"] ?>
                    <td style="">&nbsp;4.&emsp;Colistine</td>
                    <td style="text-align: center;"><?php echo $colistine[0] ?></td>
                    <td style="text-align: center;"><?php echo $colistine[1] ?></td>
                </tr>
                <tr>
                    <?php $gentamicin = $kultur->gentamicin !== "" ? explode(" / ", $kultur->gentamicin) : ["-", "-"] ?>
                    <td style="">&nbsp;1.&emsp;Gentamicin</td>
                    <td style="text-align: center;"><?php echo $gentamicin[0] ?></td>
                    <td style="text-align: center;"><?php echo $gentamicin[1] ?></td>
                    <?php $cefazoline = $kultur->cefazoline !== "" ? explode(" / ", $kultur->cefazoline) : ["-", "-"] ?>
                    <td style="">&nbsp;12.&emsp;Cefazoline</td>
                    <td style="text-align: center;"><?php echo $cefazoline[0] ?></td>
                    <td style="text-align: center;"><?php echo $cefazoline[1] ?></td>
                    <?php $trimoxazole = $kultur->trimoxazole !== "" ? explode(" / ", $kultur->trimoxazole) : ["-", "-"] ?>
                    <td style="">&nbsp;5.&emsp;Co-trimoxazole</td>
                    <td style="text-align: center;"><?php echo $trimoxazole[0] ?></td>
                    <td style="text-align: center;"><?php echo $trimoxazole[1] ?></td>
                </tr>
                <tr>
                    <?php $amikacin = $kultur->amikacin !== "" ? explode(" / ", $kultur->amikacin) : ["-", "-"] ?>
                    <td style="">&nbsp;3.&emsp;Amikacin</td>
                    <td style="text-align: center;"><?php echo $amikacin[0] ?></td>
                    <td style="text-align: center;"><?php echo $amikacin[1] ?></td>
                    <?php $ceftazidime = $kultur->ceftazidime !== "" ? explode(" / ", $kultur->ceftazidime) : ["-", "-"] ?>
                    <td style="">&nbsp;13.&emsp;Ceftazidime</td>
                    <td style="text-align: center;"><?php echo $ceftazidime[0] ?></td>
                    <td style="text-align: center;"><?php echo $ceftazidime[1] ?></td>
                    <?php $linezolid = $kultur->linezolid !== "" ? explode(" / ", $kultur->linezolid) : ["-", "-"] ?>
                    <td style="">&nbsp;7.&emsp;Linezolid</td>
                    <td style="text-align: center;"><?php echo $linezolid[0] ?></td>
                    <td style="text-align: center;"><?php echo $linezolid[1] ?></td>
                </tr>
                <tr>
                    <td style="">&nbsp;&emsp;</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <?php $ceftizoxime = $kultur->ceftizoxime !== "" ? explode(" / ", $kultur->ceftizoxime) : ["-", "-"] ?>
                    <td style="">&nbsp;14.&emsp;Ceftizoxime</td>
                    <td style="text-align: center;"><?php echo $ceftizoxime[0] ?></td>
                    <td style="text-align: center;"><?php echo $ceftizoxime[1] ?></td>
                    <?php $tigecycline = $kultur->tigecycline !== "" ? explode(" / ", $kultur->tigecycline) : ["-", "-"] ?>
                    <td style="">&nbsp;8.&emsp;Tigecycline</td>
                    <td style="text-align: center;"><?php echo $tigecycline[0] ?></td>
                    <td style="text-align: center;"><?php echo $tigecycline[1] ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">&nbsp;D.&emsp;FLUOROQUINOLON</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <td style="font-weight: bold;">&nbsp;G.&emsp;CARBAPENEM</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <?php $rifampicin = $kultur->rifampicin !== "" ? explode(" / ", $kultur->rifampicin) : ["-", "-"] ?>
                    <td style="">&nbsp;9.&emsp;Rifampicin</td>
                    <td style="text-align: center;"><?php echo $rifampicin[0] ?></td>
                    <td style="text-align: center;"><?php echo $rifampicin[1] ?></td>
                </tr>
                <tr>
                    <?php $ciprofloxacin = $kultur->ciprofloxacin !== "" ? explode(" / ", $kultur->ciprofloxacin) : ["-", "-"] ?>
                    <td style="">&nbsp;1.&emsp;Ciprofloxacin</td>
                    <td style="text-align: center;"><?php echo $ciprofloxacin[0] ?></td>
                    <td style="text-align: center;"><?php echo $ciprofloxacin[1] ?></td>
                    <?php $meropenem = $kultur->meropenem !== "" ? explode(" / ", $kultur->meropenem) : ["-", "-"] ?>
                    <td style="">&nbsp;1.&emsp;Meropenem</td>
                    <td style="text-align: center;"><?php echo $meropenem[0] ?></td>
                    <td style="text-align: center;"><?php echo $meropenem[1] ?></td>
                    <td style="font-weight: bold;">&nbsp;K.&emsp;ANTIFUNGAL</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                </tr>
                <tr>
                    <?php $ofloxacin = $kultur->ofloxacin !== "" ? explode(" / ", $kultur->ofloxacin) : ["-", "-"]  ?>
                    <td style="">&nbsp;2.&emsp;Ofloxacin</td>
                    <td style="text-align: center;"><?php echo $ofloxacin[0] ?></td>
                    <td style="text-align: center;"><?php echo $ofloxacin[1] ?></td>
                    <?php $imipenem = $kultur->imipenem !== "" ? explode(" / ", $kultur->imipenem) : ["-", "-"] ?>
                    <td style="">&nbsp;2.&emsp;Imipenem</td>
                    <td style="text-align: center;"><?php echo $imipenem[0] ?></td>
                    <td style="text-align: center;"><?php echo $imipenem[1] ?></td>
                    <?php $fluconazole = $kultur->fluconazole !== "" ? explode(" / ", $kultur->fluconazole) : ["-", "-"] ?>
                    <td style="">&nbsp;1.&emsp;Fluconazole</td>
                    <td style="text-align: center;"><?php echo $fluconazole[0] ?></td>
                    <td style="text-align: center;"><?php echo $fluconazole[1] ?></td>
                </tr>
                <tr>
                <?php $levofloxacin = $kultur->levofloxacin !== "" ? explode(" / ", $kultur->levofloxacin) : ["-", "-"]  ?>
                    <td style="">&nbsp;3.&emsp;Levofloxacin</td>
                    <td style="text-align: center;"><?php echo $levofloxacin[0] ?></td>
                    <td style="text-align: center;"><?php echo $levofloxacin[1] ?></td>
                    <?php $nitrofurantoin = $kultur->nitrofurantoin !== "" ? explode(" / ", $kultur->nitrofurantoin) : ["-", "-"] ?>
                    <td style="">&nbsp;3.&emsp;Doripenem</td>
                    <td style="text-align: center;"><?php echo $levofloxacin[0] ?></td>
                    <td style="text-align: center;"><?php echo $levofloxacin[1] ?></td>
                    <?php $voriconazole = $kultur->voriconazole !== "" ? explode(" / ", $kultur->voriconazole) : ["-", "-"] ?>
                    <td style="">&nbsp;2.&emsp;Voriconazole</td>
                    <td style="text-align: center;"><?php echo $voriconazole[0] ?></td>
                    <td style="text-align: center;"><?php echo $voriconazole[1] ?></td>
                </tr>
                <tr>
                    <?php $moxifloxacin = $kultur->moxifloxacin !== "" ? explode(" / ", $kultur->moxifloxacin) : ["-", "-"]  ?>
                    <td style="">&nbsp;4.&emsp;Moxifloxacin</td>
                    <td style="text-align: center;"><?php echo $moxifloxacin[0] ?></td>
                    <td style="text-align: center;"><?php echo $moxifloxacin[1] ?></td>
                    <?php $ertapenem = $kultur->ertapenem !== "" ? explode(" / ", $kultur->ertapenem) : ["-", "-"] ?>
                    <td style="">&nbsp;4.&emsp;Ertapenem</td>
                    <td style="text-align: center;"><?php echo $ertapenem[0] ?></td>
                    <td style="text-align: center;"><?php echo $ertapenem[1] ?></td>
                    <?php $micafungin = $kultur->micafungin !== "" ? explode(" / ", $kultur->micafungin) : ["-", "-"] ?>
                    <td style="">&nbsp;3.&emsp;Micafungin</td>
                    <td style="text-align: center;"><?php echo $micafungin[0] ?></td>
                    <td style="text-align: center;"><?php echo $micafungin[1] ?></td>
                </tr>
                <tr>
                    <td style="font-weight: bold;">&nbsp;E.&emsp;TETRACYLINE</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <td style="">&nbsp;&emsp;</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <?php $amphothericin = $kultur->amphothericin !== "" ? explode(" / ", $kultur->amphothericin) : ["-", "-"] ?>
                    <td style="">&nbsp;4.&emsp;Amphothericin B</td>
                    <td style="text-align: center;"><?php echo $amphothericin[0] ?></td>
                    <td style="text-align: center;"><?php echo $amphothericin[1] ?></td>
                </tr>
                <tr>
                    <?php $tetracycline = $kultur->tetracycline !== "" ? explode(" / ", $kultur->tetracycline) : ["-", "-"]  ?>
                    <td style="">&nbsp;1.&emsp;Tetracycline</td>
                    <td style="text-align: center;"><?php echo $tetracycline[0] ?></td>
                    <td style="text-align: center;"><?php echo $tetracycline[1] ?></td>
                    <td style="font-weight: bold;">&nbsp;H.&emsp;METRONIDAZOLE</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <?php $caspofungin = $kultur->caspofungin !== "" ? explode(" / ", $kultur->caspofungin) : ["-", "-"] ?>
                    <td style="">&nbsp;5.&emsp;Caspofungin</td>
                    <td style="text-align: center;"><?php echo $caspofungin[0] ?></td>
                    <td style="text-align: center;"><?php echo $caspofungin[1] ?></td>
                </tr>
                <tr>
                    <?php $doxycycline = $kultur->doxycycline !== "" ? explode(" / ", $kultur->doxycycline) : ["-", "-"]  ?>
                    <td style="">&nbsp;2.&emsp;Doxycycline</td>
                    <td style="text-align: center;"><?php echo $doxycycline[0] ?></td>
                    <td style="text-align: center;"><?php echo $doxycycline[1] ?></td>
                    <td style="">&nbsp;&emsp;</td>
                    <td style="text-align: center;"></td>
                    <td style="text-align: center;"></td>
                    <?php $flucytosine = $kultur->flucytosine !== "" ? explode(" / ", $kultur->flucytosine) : ["-", "-"] ?>
                    <td style="">&nbsp;6.&emsp;F]lucytosine</td>
                    <td style="text-align: center;"><?php echo $flucytosine[0] ?></td>
                    <td style="text-align: center;"><?php echo $flucytosine[1] ?></td>
                </tr>
            </tbody>
        </table>
    </div>
</div><br>
<div class="content-judul2">
    <div class="judul2">D.&emsp;Saran/ Komentar:&nbsp;&nbsp;<br></div>
    <div>
        &emsp;&emsp;<?php echo strip_tags($kultur->saran_kultur) ?>
    </div>
</div><br>
<table style="width: 100%; margin: 0 100px;" id="tbl-ttd">
    <tbody>
        <tr>
            <td style="text-align: center;"></td>
            <td style="text-align: center; width: 50%;"></td>
            <td style="text-align: center;">Malang, <?php echo date('d/m/Y', strtotime($kultur->tgl_pemeriksaan))?></td>
        </tr>
        <tr>
            <td style="text-align: center;">ATLM</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">DPJP</td>
        </tr>
        <tr>
            <td style="text-align: center;">&emsp;</td>
            <td style="text-align: center;">&emsp;</td>
            <td style="text-align: center;">&emsp;</td>
        </tr>
        <tr>
            <td style="text-align: center;">&emsp;</td>
            <td style="text-align: center;">&emsp;</td>
            <td style="text-align: center;">&emsp;</td>
        </tr>
        <tr>
            <td style="text-align: center;">Ttd. elektronik</td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;">Ttd. elektronik</td>
        </tr>
        <tr>
            <td style="text-align: center;"><?php echo $kultur->perawat->namaLengkap ?? '' ?></td>
            <td style="text-align: center;"></td>
            <td style="text-align: center;"><?php echo $kultur->pegawai->namaLengkap ?></td>
        </tr>
    </tbody>
</table>
