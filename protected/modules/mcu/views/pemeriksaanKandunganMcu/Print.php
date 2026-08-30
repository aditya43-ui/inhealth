<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
    @page {
       size: 7in 9.25in;
       font-family: Arial, sans-serif;
       font-size: 11px !important;
       padding-top: 30px;
       margin-top: 0;
       margin-bottom: 0;
    }
    @media print {
      html, body {
        padding-top: 30px;
        padding-left: 10px;
        width: 210mm;
        height: 297mm;
      }
      div.footer {
            position: fixed;
            bottom: 0;
        }
    }
    table.footer {
        position: fixed;
        bottom: 0;
    }
    @media all {
    .page-break { display: none; }
    }

    @media print {
    .page-break { display: block; page-break-before: always; }
    }
</style>

<table width="100%" border="1px">
    <tr>
        <td rowspan="3" style="width:65%"><?php echo $this->renderPartial('mcu.views.pemeriksaanKandunganMcu._headerPrint'); ?></td>
        <td style="width:15%" border-top="1px">Nama Lengkap</td>
        <td style="width:30%"><?php echo $modPasien->nama_pasien; ?></td>
    </tr>
    <tr>
        <td style="width:15%">Tgl. Lahir </td>
        <td style="width:30%"><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?></td>
    </tr>
    <tr>
        <td style="width:15%">No. Rekam Medik</td>
        <td style="width:30%"><?php echo $modPasien->no_rekam_medik; ?></td>
    </tr>
</table>
<div style="padding-top: 10px; padding-bottom: 10px; text-align:center; font-weight:bold">
    <h4>KARTU CHECK-UP KHUSUS KANDUNGAN</h4>
</div>
<table width="100%" class="table-condensed" border="1px">
    <tr>
        <td colspan='2'><b>CHECK-UP KHUSUS KANDUNGAN</b></td>
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
<table style="width: 100%; border: none;">
    <tr>
        <td width="65%">&nbsp;</td>
        <td width="35%" style="text-align: center;">    
            <br>
            <?php echo date('d ', strtotime($model->tgl_pemeriksaan)).MyFormatter::getMonthId(date('m', strtotime($model->tgl_pemeriksaan))).date(' Y', strtotime($model->tgl_pemeriksaan));  
                  echo date(' H:i', strtotime($model->tgl_pemeriksaan)).' WIB' ?><br>
            Pemeriksa
            <br><br><br><br><br><br>

            <?php 
            $cekPegawai = PegawaiM::model()->findByPk($model->dokterpemeriksa_id);
            echo $cekPegawai->namaLengkap;
            echo '<br>NIP. '.$cekPegawai->nomorindukpegawai;  ?>

        </td>
    </tr>
</table>