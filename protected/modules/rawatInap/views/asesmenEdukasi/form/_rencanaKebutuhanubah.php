<?php
//Kel-1
$cekAdmisi = '';
if ($_GET['ubah'] == 'kel-1') {
    if ($model->admisi_penjaminan == true || $model->admisi_pemasangangelang == true || $model->admisi_biayapengobatan == true) {
        $cekAdmisi = false;
    } else {
        $cekAdmisi = true;
    }
} else {
    $cekAdmisi = true;
}
//Kel-2
$cekMedis = '';
if ($_GET['ubah'] == 'kel-2') {
    if ($model->medis_diagnosapenyakit == true || $model->medis_hasilpemeriksaan == true || $model->medis_tindakanmedis == true ||
            $model->medis_penjelasankompilasi == true || $model->medis_perkiraanharirawat == true || $model->medis_lainnya == true) {
        $cekMedis = false;
    } else {
        $cekMedis = true;
    }
} else {
    $cekMedis = true;
}
//Kel-3
$cekNyeri = '';
if ($_GET['ubah'] == 'kel-3') {
    if ($model->manajemennyeri_farmakologi == true || $model->manajemennyeri_nonfarmakologi == true || $model->manajemennyeri_lainnya == true) {
        $cekNyeri = false;
    } else {
        $cekNyeri = true;
    }
} else {
    $cekNyeri = true;
}
//Kel-4
$cekKeperawatan = '';
if ($_GET['ubah'] == 'kel-4') {
    if ($model->keperawatan_informasitentang == true || $model->keperawatan_perawatanluka == true || $model->keperawatan_penggunaanalatmedis == true ||
            $model->keperawatan_keamananperawatan == true || $model->keperawatan_cucitangan == true || $model->keperawatan_edukasikhusus == true ||
            $model->keperawatan_postcatherisasi == true || $model->keperawatan_lainnya == true
    ) {
        $cekKeperawatan = false;
    } else {
        $cekKeperawatan = true;
    }
} else {
    $cekKeperawatan = true;
}
//Kel-5
$cekPengobatan = '';
if ($_GET['ubah'] == 'kel-5') {
    if ($model->pengobatan_namakegunaanobat == true || $model->pengobatan_aturanpakaiobat == true || $model->pengobatan_jumlahobatdiberikan == true ||
            $model->pengobatan_carapenyimpanan == true || $model->pengobatan_efeksamping == true || $model->pengobatan_kontraindikasi == true ||
            $model->pengobatan_lainnya == true
    ) {
        $cekPengobatan = false;
    } else {
        $cekPengobatan = true;
    }
} else {
    $cekPengobatan = true;
}
//Kel-6
$cekRehabmedis = '';
if ($_GET['ubah'] == 'kel-6') {
    if ($model->rehabmedis_fisioterapi == true || $model->rehabmedis_okupasiterapi == true || $model->rehabmedis_terapiwicara == true || $model->rehabmedis_ortotikprostetik == true) {
        $cekRehabmedis = false;
    } else {
        $cekRehabmedis = true;
    }
} else {
    $cekRehabmedis = true;
}
//Kel-7
$cekDiet = '';
if ($_GET['ubah'] == 'kel-7') {
    if ($model->dietnutrisi_dietnutrisi == true || $model->dietnutrisi_lainnya == true) {
        $cekDiet = false;
    } else {
        $cekDiet = true;
    }
} else {
    $cekDiet = true;
}
//Kel-8
$cekRohani = '';
if ($_GET['ubah'] == 'kel-8') {
    if ($model->pelrohani_bimbinganrohani == true || $model->pelrohani_konselingrohani == true) {
        $cekRohani = false;
    } else {
        $cekRohani = true;
    }
} else {
    $cekRohani = true;
}
//Kel-9
$cekPenunjang = '';
if ($_GET['ubah'] == 'kel-9') {
    if ($model->penunjang_patologiklinik == true || $model->penunjang_patologianatomi == true || $model->penunjang_mikrobiologi == true || $model->penunjang_radiodiagnostik == true) {
        $cekPenunjang = false;
    } else {
        $cekPenunjang = true;
    }
} else {
    $cekPenunjang = true;
}
//Kel-10
$cekRadioterapi = '';
if ($_GET['ubah'] == 'kel-10') {
    if ($model->radioterapi == true) {
        $cekRadioterapi = false;
    } else {
        $cekRadioterapi = true;
    }
} else {
    $cekRadioterapi = true;
}
//Kel-11
$cekITD = '';
if ($_GET['ubah'] == 'kel-11') {
    if ($model->itd_pelbotomi == true || $model->itd_lainnya == true) {
        $cekITD = false;
    } else {
        $cekITD = true;
    }
} else {
    $cekITD = true;
}
?>
<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Rencana Kebutuhan Edukasi
        </div>
    </div>
    <div class="panel-body">
        <p>&nbsp;</p>
        <div class="panel panel-darkk">
            <span class="group-title">
                Topik Edukasi
            </span>
            <div class="panel-body" id="rencanaEdukasi"> 
                <div class="col-sm-6">

                    <div id="kel-1" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Admisi</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'admisi_penjaminan', array('disabled' => $cekAdmisi, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Penjaminan</label>
                            </div>        
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'admisi_pemasangangelang', array('disabled' => $cekAdmisi, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Pemasangan Gelangan</label>
                            </div>  
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'admisi_biayapengobatan', array('disabled' => $cekAdmisi, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Biaya</label>
                            </div>                               
                        </div>
                    </div>

                    <div id="kel-2" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Medis</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'medis_diagnosapenyakit', array('disabled' => $cekMedis, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Diagnosa penyakit, penyebab tanda dan gejala, prognosa</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'medis_hasilpemeriksaan', array('disabled' => $cekMedis, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Hasil Pemeriksaan</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'medis_tindakanmedis', array('disabled' => $cekMedis, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Tindakan Medis</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'medis_penjelasankompilasi', array('disabled' => $cekMedis, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Penjelasan komplikasi yang mungkin terjadi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'medis_perkiraanharirawat', array('disabled' => $cekMedis, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Perkiraan hari rawat</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'medis_lainnya', array('disabled' => $cekMedis, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Lainnya</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->textField($model, 'medis_lainnya_ket', array('class' => 'span3 lainnya', 'placeholder' => 'lainnya', 'disabled' => $cekMedis, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> 
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-3" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Manajemen Nyeri</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'manajemennyeri_farmakologi', array('disabled' => $cekNyeri, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Farmakologi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'manajemennyeri_nonfarmakologi', array('disabled' => $cekNyeri, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Non-farmakologi</label>
                            </div>                                
                        </div>

                           <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'manajemennyeri_lainnya', array('disabled' => $cekNyeri, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Lainnya</label>
                          <br>
                                <?php echo $form->textField($model, 'manajemennyeri_lainnya_ket', array('class' => 'span3 lainnya', 'placeholder' => 'lainnya', 'disabled' => $cekNyeri, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> 
                                                                <i class="entypo-plus plus-lain" onclick="tambahBaris(this);" style="cursor: pointer; color: red; font-size: 20px;"></i>
                            </div>                                
                        </div>
                    </div>  

                    <div id="kel-4" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Keperawatan</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'keperawatan_informasitentang', array('disabled' => $cekKeperawatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Informasi Tentang : </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Hak dan Kewajiban </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; - Tata tertib dan berkunjung </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'keperawatan_perawatanluka', array('disabled' => $cekKeperawatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Perawatan Luka </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'keperawatan_penggunaanalatmedis', array('disabled' => $cekKeperawatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Penggunaan alat medis </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; Secara efektif dan aman </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'keperawatan_keamananperawatan', array('disabled' => $cekKeperawatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Keamanan lingkungan perawatan </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dan alat yang perlu disiapkan dirumah </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'keperawatan_cucitangan', array('disabled' => $cekKeperawatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Cuci Tangan </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'keperawatan_edukasikhusus', array('disabled' => $cekKeperawatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Edukasi khusus disharge planning pasien : </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <label>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; DM, stroke, kemotrapi dan jantung </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'keperawatan_postcatherisasi', array('disabled' => $cekKeperawatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Perawatan post catheterisasi  </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'keperawatan_lainnya', array('disabled' => $cekKeperawatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Lainnya</label>
                                <br>
                                <?php echo $form->textField($model, 'keperawatan_lainnya_ket', array('class' => 'span3 lainnya', 'placeholder' => 'lainnya', 'disabled' => $cekKeperawatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> 
                                <i class="entypo-plus plus-lain" onclick="tambahBaris(this);" style="cursor: pointer; color: red; font-size: 20px;"></i>
                            </div>                                
                        </div>

                    </div>
                </div>

                <div class="col-sm-6">
                    <div id="kel-5" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Pengobatan</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_namakegunaanobat', array('disabled' => $cekPengobatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Nama obat dan kegunaanya </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_aturanpakaiobat', array('disabled' => $cekPengobatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Aturan pemakaian dan dosis obat </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_jumlahobatdiberikan', array('disabled' => $cekPengobatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Jumlah obat yang diberikan </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_carapenyimpanan', array('disabled' => $cekPengobatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Cara penyimpanan obat </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_efeksamping', array('disabled' => $cekPengobatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Efek samping obat </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_kontraindikasi', array('disabled' => $cekPengobatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Kontra indikasi obat </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_lainnya', array('disabled' => $cekPengobatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Lain-lain</label><br>
                                <?php echo $form->textField($model, 'pengobatan_lainnya_ket', array('class' => 'span3 lainnya', 'placeholder' => 'lainnya',  'disabled' => $cekPengobatan, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> 
                                <i class="entypo-plus plus-lain" onclick="tambahBaris(this);" style="cursor: pointer; color: red; font-size: 20px;"></i>
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-6" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Rehabilitasi Medis</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'rehabmedis_fisioterapi', array('disabled' => $cekRehabmedis, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Fisioterapi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'rehabmedis_okupasiterapi', array('disabled' => $cekRehabmedis, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Okupasi Terapi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'rehabmedis_terapiwicara', array('disabled' => $cekRehabmedis, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Terapi Wicara</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'rehabmedis_ortotikprostetik', array('disabled' => $cekRehabmedis, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Ortotik Prostotik</label>
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-7" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Diet dan Nutrisi</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'dietnutrisi_dietnutrisi', array('disabled' => $cekDiet, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Diet dan Nutrisi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'dietnutrisi_lainnya', array('disabled' => $cekDiet, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Lain-lain</label><br>
                                <?php echo $form->textField($model, 'dietnutrisi_lainnya_ket', array('class' => 'span3 lainnya', 'placeholder' => 'lainnya', 'disabled' => $cekDiet, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> 
                                <i class="entypo-plus plus-lain" onclick="tambahBaris(this);" style="cursor: pointer; color: red; font-size: 20px;"></i>
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-8" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Pelayanan Kerohanian</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pelrohani_bimbinganrohani', array('disabled' => $cekRohani, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Bimbingan Rohani</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pelrohani_konselingrohani', array('disabled' => $cekRohani, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Konseling Rohani</label>
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-9" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Penunjang</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'penunjang_patologiklinik', array('disabled' => $cekPenunjang, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Patologi Klinik</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'penunjang_patologianatomi', array('disabled' => $cekPenunjang, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Patologi Anatomi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'penunjang_mikrobiologi', array('disabled' => $cekPenunjang, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Mikrobiologi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'penunjang_radiodiagnostik', array('disabled' => $cekPenunjang, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Radiodiagnostik</label>
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-10" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Radioterapi</label>                                
                            <div class="controls">
                                <?php echo $form->textField($model, 'radioterapi', array('disabled' => $cekRadioterapi, 'class' => 'span3', 'placeholder' => 'radioterapi', 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> 
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-11" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">ITD</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'itd_pelbotomi', array('disabled' => $cekITD, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Peltobomi</label>
                            </div>                                
                        </div>                    

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'itd_lainnya', array('disabled' => $cekITD, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> <label>Lain-lain</label><br>
                                <?php echo $form->textField($model, 'itd_lainnya_ket', array('class' => 'span3 lainnya', 'placeholder' => 'lain-lain', 'disabled' => $cekITD, 'onkeypress' => "return $(this).focusNextInputField(event);")); ?> 
                                <i class="entypo-plus plus-lain" onclick="tambahBaris(this);" style="cursor: pointer; color: red; font-size: 20px;"></i>

                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p>&nbsp;</p>
        <?php
        echo $this->renderPartial($this->path_view . 'form/_ubah_hasilEvaluasiVerifikasi', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'form' => $form,
            'getDet2' => $getDet2
                ), true);
        ?>
    </div>
</div>