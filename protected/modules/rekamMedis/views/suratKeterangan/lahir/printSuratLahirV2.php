<?php 
/**
* - versi 2 prinout surat keterangan lahir
* 
* @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @website      <piindonesia.co.id>
 *@wiki         <https://piiproject.atlassian.net/wiki/display/MDO> 
*/

Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/datetime.js');

$format = new MyFormatter();
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());

if(!empty($_GET['pendaftaran_id'])){
    $pendaftaran_id = $_GET["pendaftaran_id"];
    $modPendaftaran = PendaftaranT::model()->findByPk($pendaftaran_id);
    $modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
    $model->mengetahui_surat = $modPendaftaran->pegawai->nama_pegawai;
	$modPasien->tanggal_lahir = $format->formatDateTimeForUser($modPasien->tanggal_lahir);
    
}else{
    $model->tglsurat = date('Y-m-d');
}

$model->lahir_tgllahir = (!empty($model->lahir_tgllahir) ? $format->formatDateTimeForUser($model->lahir_tgllahir) : $format->formatDateTimeForUser(date('Y-m-d H:i:s')));

if(!empty($_GET['suratketerangan_id'])){
    $model = SuratketeranganR::model()->findByPk($_GET['suratketerangan_id']);
    
}
?>

<style>
.add-on{
    border: #ddd 1px solid;
    padding: 6px;
    border-radius: 5px;
}

.tabel-surat td {
    vertical-align: top;
}

body {
/*    font-size: 8pt;*/
}

p{
    margin-left: 0;
    text-align: justify;
}

.tab-foot, .tab-foot td {
/*    font-size: 6pt;*/
}
</style>
<div class="allcontent" style="padding: 0;">
<div class="header">
<?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
<div>
    <div class="content">  
<div>
        <TABLE ALIGN="CENTER">
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <div class="judulcontent"><B><span  SIZE=4><U><?php echo "SURAT KETERANGAN LAHIR"; ?></U></span></B></div>
                </td>
            </tr>
             <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span  SIZE=4>NO : <?php echo $model->nomorsurat; ?></span></B>
                </td>
            </tr>
        </TABLE>
</div>
<p>&nbsp;</p>
    <div class="col-sm-12">       
        <p>
                Yang Bertanda Tangan dibawah ini menerangkan bahwa

        </p>

        <p>
                Pada hari ini <?php echo MyFormatter::getDayName(MyFormatter::formatDateTimeForDb($model->lahir_tgllahir)) ?> tanggal <?php echo MyFormatter::formatDateTimeForUser(date('Y-m-d', strtotime($model->lahir_tgllahir))) ?> pukul <?php echo date('H:i:s',strtotime(MyFormatter::formatDateTimeForDb($model->lahir_tgllahir))); ?> WIB, telah lahir bayi :
               
        </p>        
    </div>

<div class="row">   
    <div class="col-md-12" style="padding-left: 50px;">
        <label   class="font-13px">
            <table class="tabel-surat">
                <tr>
                    <td>Jenis kelamin</td>
                    <td> : </td>
                    <td> 
                        <?php 
                            
                     
                            $jkPR = Params::JENIS_KELAMIN_PEREMPUAN;
                            $jkLK = Params::JENIS_KELAMIN_LAKI_LAKI;
                            
                            $kelamin = empty($modKelahiran->jeniskelamin) ? $modPasien->jeniskelamin : $modKelahiran->jeniskelamin;
                            
                            if (!empty($modKelahiran->jeniskelamin)){
                                if ($modKelahiran->jeniskelamin == Params::JENIS_KELAMIN_LAKI_LAKI){
                                    $jkPR = '<span style="text-decoration: line-through;">'.$jkPR.'</span>';
                                }else{
                                    $jkLK = '<span style="text-decoration: line-through;">'.$jkLK.'</span>';
                                }
                            }
                       
                    ?>
                    <span><?php echo $jkLK; ?></span>
                            /
                        <span><?php echo $jkPR; ?></span> *
                    </td>
                </tr>
                <tr>
                    <td>Jenis kelahiran</td>
                    <td> : </td>
                    <td> 
                        <?php
                            $lahir1 = Params::JENIS_KELAHIRAN_TUNGGAL;
                            $lahir2 = Params::JENIS_KELAHIRAN_KEMBAR2;
                            $lahir3 = Params::JENIS_KELAHIRAN_KEMBAR3;
                            $lahir4 = Params::JENIS_KELAHIRAN_LAINNYA;
                            if (!empty($model->lahir_jeniskelahiran)){
                                if ($model->lahir_jeniskelahiran == Params::JENIS_KELAHIRAN_TUNGGAL){
                                    $lahir2 = '<span style="text-decoration: line-through;">'.$lahir2.'</span>';
                                    $lahir3 = '<span style="text-decoration: line-through;">'.$lahir3.'</span>';
                                    $lahir4 = '<span style="text-decoration: line-through;">'.$lahir4.'</span>';
                                }elseif ($model->lahir_jeniskelahiran == Params::JENIS_KELAHIRAN_KEMBAR2){
                                    $lahir1 = '<span style="text-decoration: line-through;">'.$lahir1.'</span>';
                                    $lahir3 = '<span style="text-decoration: line-through;">'.$lahir2.'</span>';
                                    $lahir4 = '<span style="text-decoration: line-through;">'.$lahir4.'</span>';
                                }elseif ($model->lahir_jeniskelahiran == Params::JENIS_KELAHIRAN_KEMBAR3){
                                    $lahir1 = '<span style="text-decoration: line-through;">'.$lahir1.'</span>';
                                    $lahir2 = '<span style="text-decoration: line-through;">'.$lahir2.'</span>';
                                    $lahir4 = '<span style="text-decoration: line-through;">'.$lahir4.'</span>';
                                }elseif ($model->lahir_jeniskelahiran == Params::JENIS_KELAHIRAN_LAINNYA){
                                    $lahir1 = '<span style="text-decoration: line-through;">'.$lahir1.'</span>';
                                    $lahir2 = '<span style="text-decoration: line-through;">'.$lahir2.'</span>';
                                    $lahir3 = '<span style="text-decoration: line-through;">'.$lahir3.'</span>';
                                }
                            }
                            
                        ?>
                        <span id='jnsLahir1' ><?php echo $lahir1; ?></span> / 
                        <span id='jnsLahir2' ><?php echo $lahir2; ?></span> / 
                        <span id='jnsLahir3' ><?php echo $lahir3; ?></span> / 
                        <span id='jnsLahir4' ><?php echo $lahir4; ?></span>*
                        
                    </td>
                </tr>                
                <tr>
                    <td>Persalinan ke</td>
                    <td> : </td>
                    <td> <?php echo $model->lahir_persalinan_ke ?> </td>
                </tr>
                <tr>
                    <td>Berat lahir</td>
                    <td> : </td>
                    <td> <?php echo $model->lahir_beratbadan_gram ?> Cm</td>                    
                </tr>
                <tr>
                    <td>Panjang badan</td>
                    <td> : </td>                    
                    <td> <?php echo $model->lahir_panjangbadan_cm ?> Gram</td>
                </tr>
                <tr>
                    <td>Tempat lahir</td>
                    <td> : </td>
                    <td> 
                        <?php echo $data->nama_rumahsakit; ?><br> 
                        <?php echo $data->alamatlokasi_rumahsakit.' '.(!empty($data->kabupaten_id)?$data->kabupaten->kabupaten_nama:''); ?>                        
                    </td>
                </tr>
                <tr>
                    <td>Nama Bayi</td>
                    <td> : </td>
                    <td> <?php echo $modPasien->nama_pasien ?></td>                    
                </tr>
                <tr>
                    <td>Dari Orang Tua</td>                    
                </tr>
                <tr>
                    <td>Nama Ibu</td>
                    <td> : </td>
                    <td> 
                        <?php echo $model->lahir_namaibu ?>
                        &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                        Usia <?php echo $model->lahir_ibu_umur ?> Tahun
                    </td>
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td> : </td>
                    <td> <?php echo $model->lahir_pekerjaan_ibu ?></td>                    
                </tr>
                <tr>
                    <td>No. Identitas</td>
                    <td> : </td>
                    <td> <?php echo $model->lahir_ktp_ibu ?></td>                    
                </tr>
                <tr>
                    <td>Nama ayah</td>
                    <td> : </td>
                    <td> <?php echo $model->lahir_namaayah ?>
                    &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; &nbsp; 
                        Usia <?php echo $model->lahir_ayah_umur ?> Tahun</td>                       
                </tr>
                <tr>
                    <td>Pekerjaan</td>
                    <td> : </td>
                    <td> <?php echo $model->lahir_pekerjaan_ayah ?></td>                      
                </tr>
                <tr>
                    <td>No Identitas</td>
                    <td> : </td>
                    <td> <?php echo $model->no_ktp_ayah ?></td>                       
                </tr>
                <tr>
                    <td>Alamat</td>
                    <td> : </td>
                    <td> <?php echo $model->lahir_alamat ?></td>                       
                </tr>
                <tr>
                    <td>Propinsi</td>
                    <td> : </td>
                    <td> <?php echo $model->lahir_propinsi ?></td>                       
                </tr>
                <tr>
                    <td>Kab/Kota</td>
                    <td> : </td>
                    <td> <?php echo $model->lahir_kabupaten ?></td>                        
                </tr>
                <tr>
                    <td>Kecamatan</td>
                    <td> : </td>
                    <td> <?php echo $model->lahir_kecamatan ?></td>                        
                </tr>
                
            </table>
      </label>
    </div>
</div>
<br>
<table style="width: 100%; border: none;">
    <tr>
        <td></td>
        <td width="200">                        
                    <?php $date = date('Y-m-d'); ?>
                    <?php echo strtoupper($data->kabupaten->kabupaten_nama) ;?>, <?php echo strtoupper($format->formatDateTimeForUser($date)); ?><br>
                    <?php //echo strtoupper($data->nama_rumahsakit);?>
                    Penolong Persalinan
                    <br><br><br><br><br>

            <?php
                    $dok = PegawaiM::model()->findByPk($model->dokter_persalinan_id);
                                    
                    echo (!empty($dok)?$dok->namaLengkap:'________________________')
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