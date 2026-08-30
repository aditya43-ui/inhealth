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
                                <?php echo $form->checkBox($model, 'admisi_penjaminan', array()); ?> <label>Penjaminan</label>
                            </div>        
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'admisi_pemasangangelang', array()); ?> <label>Pemasangan Gelangan</label>
                            </div>  
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'admisi_biayapengobatan', array()); ?> <label>Biaya</label>
                            </div>                               
                        </div>
                    </div>

                    <div id="kel-2" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Medis</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'medis_diagnosapenyakit', array()); ?> <label>Diagnosa penyakit, penyebab tanda dan gejala, prognosa</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'medis_hasilpemeriksaan', array()); ?> <label>Hasil Pemeriksaan</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'medis_tindakanmedis', array()); ?> <label>Tindakan Medis</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'medis_penjelasankompilasi', array()); ?> <label>Penjelasan komplikasi yang mungkin terjadi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'medis_perkiraanharirawat', array()); ?> <label>Perkiraan hari rawat</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'medis_lainnya', array()); ?>
                                <label>Lainnya</label><br>
                                <?php echo $form->textField($model, 'medis_lainnya_ket', array('class' => 'span3 lainnya', 'placeholder' => 'lainnya')); ?> 
                                <i class="entypo-plus plus-lain" onclick="tambahBaris(this);" style="cursor: pointer; color: red; font-size: 20px;"></i>
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-3" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Manajemen Nyeri</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'manajemennyeri_farmakologi', array()); ?> <label>Farmakologi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'manajemennyeri_nonfarmakologi', array()); ?> <label>Non-farmakologi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'manajemennyeri_lainnya', array()); ?> <label>Lainnya</label>
                          <br>
                                <?php echo $form->textField($model, 'manajemennyeri_lainnya_ket', array('class' => 'span3 lainnya', 'placeholder' => 'lainnya')); ?> 
                                                                <i class="entypo-plus plus-lain" onclick="tambahBaris(this);" style="cursor: pointer; color: red; font-size: 20px;"></i>
                            </div>                                
                        </div>
                    </div>  

                    <div id="kel-4" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Keperawatan</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'keperawatan_informasitentang', array()); ?> <label>Informasi Tentang : </label>
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
                                <?php echo $form->checkBox($model, 'keperawatan_perawatanluka', array()); ?> <label>Perawatan Luka </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'keperawatan_penggunaanalatmedis', array()); ?> <label>Penggunaan alat medis </label>
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
                                <?php echo $form->checkBox($model, 'keperawatan_keamananperawatan', array()); ?> <label>Keamanan lingkungan perawatan </label>
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
                                <?php echo $form->checkBox($model, 'keperawatan_cucitangan', array()); ?> <label>Cuci Tangan </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'keperawatan_edukasikhusus', array()); ?> <label>Edukasi khusus disharge planning pasien : </label>
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
                                <?php echo $form->checkBox($model, 'keperawatan_postcatherisasi', array()); ?> <label>Perawatan post catheterisasi  </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'keperawatan_lainnya', array()); ?> <label>Lainnya</label>
                                <br>
                                <?php echo $form->textField($model, 'keperawatan_lainnya_ket', array('class' => 'span3 lainnya', 'placeholder' => 'lainnya')); ?> 
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
                                <?php echo $form->checkBox($model, 'pengobatan_namakegunaanobat', array()); ?> <label>Nama obat dan kegunaanya </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_aturanpakaiobat', array()); ?> <label>Aturan pemakaian dan dosis obat </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_jumlahobatdiberikan', array()); ?> <label>Jumlah obat yang diberikan </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_carapenyimpanan', array()); ?> <label>Cara penyimpanan obat </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_efeksamping', array()); ?> <label>Efek samping obat </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_kontraindikasi', array()); ?> <label>Kontra indikasi obat </label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pengobatan_lainnya', array()); ?> <label>Lain-lain</label><br>
                                <?php echo $form->textField($model, 'pengobatan_lainnya_ket', array('class' => 'span3 lainnya', 'placeholder' => 'lainnya')); ?> 
                                <i class="entypo-plus plus-lain" onclick="tambahBaris(this);" style="cursor: pointer; color: red; font-size: 20px;"></i>
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-6" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Rehabilitasi Medis</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'rehabmedis_fisioterapi', array()); ?> <label>Fisioterapi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'rehabmedis_okupasiterapi', array()); ?> <label>Okupasi Terapi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'rehabmedis_terapiwicara', array()); ?> <label>Terapi Wicara</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'rehabmedis_ortotikprostetik', array()); ?> <label>Ortotik Prostotik</label>
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-7" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Diet dan Nutrisi</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'dietnutrisi_dietnutrisi', array()); ?> <label>Diet dan Nutrisi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'dietnutrisi_lainnya', array()); ?> <label>Lain-lain</label><br>
                                <?php echo $form->textField($model, 'dietnutrisi_lainnya_ket', array('class' => 'span3 lainnya', 'placeholder' => 'lainnya')); ?> 
                                <i class="entypo-plus plus-lain" onclick="tambahBaris(this);" style="cursor: pointer; color: red; font-size: 20px;"></i>
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-8" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Pelayanan Kerohanian</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pelrohani_bimbinganrohani', array()); ?> <label>Bimbingan Rohani</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'pelrohani_konselingrohani', array()); ?> <label>Konseling Rohani</label>
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-9" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Penunjang</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'penunjang_patologiklinik', array()); ?> <label>Patologi Klinik</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'penunjang_patologianatomi', array()); ?> <label>Patologi Anatomi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'penunjang_mikrobiologi', array()); ?> <label>Mikrobiologi</label>
                            </div>                                
                        </div>

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'penunjang_radiodiagnostik', array()); ?> <label>Radiodiagnostik</label>
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-10" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">Radioterapi</label>                                
                            <div class="controls">
                                <?php echo $form->textField($model, 'radioterapi', array('class' => 'span3', 'placeholder' => 'radioterapi')); ?> 
                            </div>                                
                        </div>
                    </div>

                    <div id="kel-11" class="parent-data">
                        <div class="control-group">    
                            <label class="control-label">ITD</label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'itd_pelbotomi', array()); ?> <label>Peltobomi</label>
                            </div>                                
                        </div>                    

                        <div class="control-group">    
                            <label class="control-label"></label>                                
                            <div class="controls">
                                <?php echo $form->checkBox($model, 'itd_lainnya', array()); ?> <label>Lain-lain</label><br>
                                <?php echo $form->textField($model, 'itd_lainnya_ket', array('class' => 'span3 lainnya', 'placeholder' => 'lain-lain')); ?> 
                                <i class="entypo-plus plus-lain" onclick="tambahBaris(this);" style="cursor: pointer; color: red; font-size: 20px;"></i>

                            </div>                                
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <p>&nbsp;</p>
        <?php
        echo $this->renderPartial($this->path_view . 'form/_hasilEvaluasiVerifikasi', array(
            'modPendaftaran' => $modPendaftaran,
            'modPasien' => $modPasien,
            'model' => $model,
            'form' => $form,
            'getDet' => $getDet
                ), true);
        ?>
    </div>
</div>