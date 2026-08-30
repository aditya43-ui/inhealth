<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<table width="100%" class="table-condensed" border="1px">
    <tr>
        <td colspan='2'><b>
                <u>CHECK-UP KHUSUS KANDUNGAN</u>
                <br>
                Tgl. Pemeriksaan : <?php echo MyFormatter::formatDateTimeForUser($model->tgl_pemeriksaan); ?><br>
                                Pemeriksa : <?php 
                                $cekPegawai = PegawaiM::model()->findByPk($model->dokterpemeriksa_id);
                                if (!empty($cekPegawai)) {
                                    echo $cekPegawai->namaLengkap;
                                } else {
                                    echo "-";
                                }
                                ?>
                
        </b></td>
    </tr>
    <tr>
        <td style="border-right-color:#fff">
            <table style="width: 100%; border: none;">
                <tr>
                    <td>Anamnesis </td>
                    <td colspan="7">: Apa yang diderita :
                    <?php 
                        if(!empty($model->anamnesis)){ 
                            echo $model->anamnesis;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Bersuami </td>
                    <td>:
                    <?php 
                        if($model->suami_ya == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Ya &nbsp; &nbsp; ";
                        }else if($model->suami_ya == false){
                            echo "<span class='fa fa-square-o'></span> Ya &nbsp; &nbsp; ";
                        }
                        if($model->suami_tidak == true){ 
                            echo "<span class='fa fa-check-square-o'></span> Tidak";
                        }elseif($model->suami_tidak == false){ 
                            echo "<span class='fa fa-square-o'></span> Tidak";
                        }
                        ?>
                    </td> 
                    <td>Berapa lama :
                    <?php 
                        if(!empty($model->lama_pernikahan)){ 
                            echo $model->lama_pernikahan;
                        }else{
                            echo "-";
                        } ?> th.
                    </td>
                    <td>Berapa kali : 
                    <?php 
                        if(!empty($model->berapakali_pernikahan)){ 
                            echo $model->berapakali_pernikahan;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Haid </td>
                    <td colspan="7">:
                    <?php 
                        if(!empty($model->haid)){ 
                            echo $model->haid;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Tgl. haid trakhir </td>
                    <td colspan="7">:
                    <?php 
                        if(!empty($model->tgl_haid_terakhir)){ 
                            echo MyFormatter::formatDateTimeId($model->tgl_haid_terakhir);
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                </tr>
                <tr>
                    <td>Siklus </td>
                    <td>:
                    <?php 
                        if(!empty($model->siklus_haid)){ 
                            echo $model->siklus_haid;
                        }else{
                            echo "-";
                        } ?>
                        hari&nbsp;
                    <?php 
                        if(!empty($model->periode_siklus_haid)){ 
                            echo $model->periode_siklus_haid;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                    <td>Menarehe Umur :
                    <?php 
                        if(!empty($model->menarehe_umur)){ 
                            echo $model->menarehe_umur;
                        }else{
                            echo "-";
                        } ?> tahun.
                    </td>
                </tr>
                <tr>
                    <td>Lamanya haid </td>
                    <td>:
                    <?php 
                        if(!empty($model->lama_haid)){ 
                            echo $model->lama_haid;
                        }else{
                            echo "-";
                        } ?>
                        hari.
                    </td> 
                    <td colspan="3">
                    <?php 
                        if($model->banyak_haid == 'Banyak'){ 
                            echo "<span class='fa fa-check-square-o'></span> Banyak &nbsp; &nbsp;";
                        }else if($model->banyak_haid != 'Banyak'){
                            echo "<span class='fa fa-square-o'></span> Banyak &nbsp; &nbsp; ";
                        }
                        if($model->banyak_haid == 'Sedikit'){ 
                            echo "<span class='fa fa-check-square-o'></span> Sedikit &nbsp; &nbsp;";
                        }else if($model->banyak_haid != 'Sedikit'){
                            echo "<span class='fa fa-square-o'></span> Sedikit &nbsp; &nbsp; ";
                        }
                        if($model->banyak_haid == 'Encer'){ 
                            echo "<span class='fa fa-check-square-o'></span> Encer &nbsp; &nbsp;";
                        }else if($model->banyak_haid != 'Encer'){
                            echo "<span class='fa fa-square-o'></span> Encer &nbsp; &nbsp; ";
                        }
                        if($model->banyak_haid == 'Gumpal'){ 
                            echo "<span class='fa fa-check-square-o'></span> Gumpal";
                        }else if($model->banyak_haid != 'Gumpal'){
                            echo "<span class='fa fa-square-o'></span> Gumpal";
                        }
                        ?>
                </tr>
                <tr>
                    <td>Haid Sakit</td>
                    <td colspan="2">:
                        <?php 
                        if($model->haid_sakit == 'Sebelum'){ 
                            echo "<span class='fa fa-check-square-o'></span> Sebelum &nbsp; &nbsp;";
                        }else if($model->haid_sakit != 'Sebelum'){
                            echo "<span class='fa fa-square-o'></span> Sebelum &nbsp; &nbsp; ";
                        }
                        if($model->haid_sakit == 'Selama'){ 
                            echo "<span class='fa fa-check-square-o'></span> Selama &nbsp; &nbsp;";
                        }else if($model->haid_sakit != 'Selama'){
                            echo "<span class='fa fa-square-o'></span> Selama &nbsp; &nbsp; ";
                        }
                        if($model->haid_sakit == 'Sesudah'){ 
                            echo "<span class='fa fa-check-square-o'></span> Sesudah";
                        }else if($model->haid_sakit != 'Sesudah'){
                            echo "<span class='fa fa-square-o'></span> Sesudah";
                        }
                        ?>
                    
                    </td> 
                    <td>Warna :
                    <?php 
                        if(!empty($model->warna_haid)){ 
                            echo $model->warna_haid;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                    <td>
                        <?php 
                        if($model->bau_haid == 'Berbau'){ 
                            echo "<span class='fa fa-check-square-o'></span> Berbau";
                        }else{
                            echo "<span class='fa fa-square-o'></span> Berbau";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Fluor</td>
                    <td>:
                        <?php 
                        if(!empty($model->fluor)){ 
                            echo $model->fluor;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                    <td>Berapa lama :
                    <?php 
                        if(!empty($model->berapa_lama)){ 
                            echo $model->berapa_lama;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                    <td>Warna :
                    <?php 
                        if(!empty($model->warna_fluor)){ 
                            echo $model->warna_fluor;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                    <td>
                    <?php 
                        if($model->banyak_fluor == 'Banyak'){ 
                            echo "<span class='fa fa-check-square-o'></span> Banyak &nbsp; &nbsp; ";
                        }else if($model->banyak_fluor != 'Banyak'){
                            echo "<span class='fa fa-square-o'></span> Banyak &nbsp; &nbsp; ";
                        }
                        if($model->banyak_fluor == 'Sedikit'){ 
                            echo "<span class='fa fa-check-square-o'></span> Sedikit";
                        }elseif($model->banyak_fluor != 'Sedikit'){ 
                            echo "<span class='fa fa-square-o'></span> Sedikit";
                        }
                        ?>
                    </td>
                    <td>
                        <?php 
                        if($model->bau_fluor == 'Berbau'){ 
                            echo "<span class='fa fa-check-square-o'></span> Berbau";
                        }else{
                            echo "<span class='fa fa-square-o'></span> Berbau";
                        }
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Anak</td>
                    <td>:
                        <?php 
                        if(!empty($model->jumlah_anak)){ 
                            echo $model->jumlah_anak;
                        }else{
                            echo "-";
                        } ?>
                    </td> 
                    <td>Hidup :
                    <?php 
                        if(!empty($model->jumlah_anak_hidup)){ 
                            echo $model->jumlah_anak_hidup;
                        }else{
                            echo "-";
                        } ?> &nbsp;Mati :
                    <?php 
                        if(!empty($model->jumlah_anak_mati)){ 
                            echo $model->jumlah_anak_mati;
                        }else{
                            echo "-";
                        } ?> 
                    </td>
                    <td colspan="2">Yang paling kecil umur :
                    <?php 
                        if(!empty($model->umur_anak_kecil)){ 
                            echo $model->umur_anak_kecil;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="9">Partus y.l (sectio, forceps dll.) :
                        <?php 
                        if(!empty($model->partus)){ 
                            echo $model->partus;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Abortus </td>
                    <td colspan="9">:
                        <?php 
                        if(!empty($model->abortus)){ 
                            echo $model->abortus;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>KB </td>
                    <td colspan="9">:
                        <?php 
                        if($model->kb_positif == true){ 
                            echo "<span class='fa fa-check-square-o'></span> + / ";
                        }else{
                            echo "<span class='fa fa-square-o'></span> + / ";
                        }
                        if($model->kb_negatif == true){ 
                            echo "- <span class='fa fa-check-square-o'></span> ";
                        }else{
                            echo "- <span class='fa fa-square-o'></span> ";
                        }
                        ?>
                        dengan apa : 
                        <?php 
                        if(!empty($model->kb_keterangan)){ 
                            echo $model->kb_keterangan;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="9">Penyakit lama yang diderita :
                        <?php 
                        if(!empty($model->nama_penyakit_lama)){ 
                            echo $model->nama_penyakit_lama;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td colspan="9">Anamnesia keluarga : (tumor dsb.-nya) :
                        <?php 
                        if(!empty($model->anamnesia_keluarga)){ 
                            echo $model->anamnesia_keluarga;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Status Lokalis </td>
                    <td colspan="9">:
                        <?php 
                        if(!empty($model->status_lokalis)){ 
                            echo $model->status_lokalis;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Abdomen </td>
                    <td colspan="9">:
                        <?php 
                        if(!empty($model->abdomen)){ 
                            echo $model->abdomen;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Genitalis </td>
                    <td colspan="9">:
                        <?php 
                        if(!empty($model->genitalis)){ 
                            echo $model->genitalis;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                </tr>
                <tr>
                    <td>Diagnosis </td>
                    <td colspan="9">:
                        <?php 
                        if(!empty($model->diagnosis)){ 
                            echo $model->diagnosis;
                        }else{
                            echo "-";
                        } ?>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
</table>