
<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'pasienpulang-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)',), //'onSubmit'=>'return cekValidasi()'
    'focus' => '#',
        ));
?>

<table width="100%" >
    <tr>
        <td width="70%" style='padding-left:20%; text-align:center'>
            <h3 >PERNYATAAN PEMBERIAN INFORMASI<br>
        DAN PERSETUJUAN TINDAKAN SEDASI & ANESTESI</h3>
        </td>
        <td width="20%" align="right"><h4>RM 08j K</h4></td>
    </tr>
</table>
<table width="100%" class="table-condensed" >
   
        <tr>
            <td class="" style="border:1px solid black; background-color:#afdc7e" ><b>Diisi oleh Dokter/ Perawat</b></td>
        </tr>
        <tr>
            <td style="border:1px solid black;">
                <table >
                    <tr>
                        <td>Ruangan / Poli :</td>
                        <td><?php echo $modEvaluasi->ruangan_nama ?></td>
                    </tr>
                </table>
            </td>
        </tr>
         
   
        <tr>
            <td style="border:1px solid black; padding:0.5cm !important;">
                <table width="100%">
                    <tr>
                        <td style="text-align:center">
                            <h3><span >INFORMASI TINDAKAN SEDASI & ANESTESI</span></h3>
                        </td>
                    </tr>
                </table>
                <table width="100%">
                    <tr>
                        <td>
                            <span align="left">
                                Untuk tindakan diagnostik atau invasif dan operasi dibutuhkan tindakan sedasi dan anestesia. Sedasi dapat 
                                diberikan ringan, sedang atau berat. Sedangkan pembiusan dapat dilakukan dengan cara umum atau anestesia regional
                                (blok spinal, Epidural, dan Periferal).  Semua tindakan anestesia dan sedasi memerlukan persiapan umum berupa :
                            </span>
                        </td>
                    </tr>
                </table>
                
                
                <table width="100%">
                    <tr>
                        
                        <td align="justify" colspan="2">1. Untuk dilakukan sedasi dan anestesia serta operasi berencana pasien harus berpuasa. Puasa ini penting ditaati oleh
                    pasien karena lambung pasien harus kosong untuk menghindari keluarnya isi lambung ke rongga mulut pada waktu pembiusan
                    dan isi lambung dapat masuk kedalam jalan napas dan menyebabkan sumbatan jalan napas yang fatal.<br>
                    Berikut ini adalah rekomendasi lamanya puasa sebelum anestesia dilakukan pada pasien sehat(tidak ada penyerta sepert :
                    Obesitas, DM/Diabetes Mellitus, gangguan pencernaan, ibu hamil dll).</td>
                    </tr>
                    <tr>
                        
                        <td colspan="2">
                            <table style="border:1px; solid" id="jenismakanan" width="100%">
                            <thead>
                                <tr>
                                    <td style="text-align:center;font-size:10pt"><span><b>Jenis Makanan/Minuman</b></span></td>
                                    <td style="text-align:center;font-size:10pt"><span><b>Minimal Waktu Puasa</b></span></td>
                                    <td style="text-align:center;font-size:10pt"><span><b>Keterangan</b></span></td>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td>Cairan jernih</td>
                                    <td>2 jam</td>
                                    <td>Cairan jernih adalah air putih, sari buah(saring), minuman bersoda dan teh</td>
                                </tr>
                                <tr>
                                    <td>Air susu ibu</td>
                                    <td>4 jam</td>
                                    <td></td>
                                </tr>
                                <tr>
                                    <td>Susu formola untuk bayi atau susu segar hewani</td>
                                    <td>6 jam</td>
                                    <td>Susu yang bukan asi akan mengalami pencernaan seperti makanan ringan</td>
                                </tr>
                                <tr>
                                    <td>Makanan ringan</td>
                                    <td>6 jam</td>
                                    <td rowspan="2">Makanan ringan yang dimaksud seperi roti atau kue, sedangkan makanan berat dipuasakan sesuai jenis dan jumlahnya</td>
                                </tr>
                                <tr>
                                    <td>Makanan berat</td>
                                    <td>6 - 8 jam</td>
                                </tr>
                            </tbody>
                        </table>
                        </td>
                    </tr>
                    
                    <tr>
                       >
                       <td align="justify" colspan="2">
                            Rekomendasi puasa ini berlaku untuk semua kegiatan anestesia yang direncanakan kecuali untuk operasi emergency
                    /darurat. Pada pasien dengan penyakit penyerta(obesitas, DM, gangguan pencernaan, ibu hamil, dll) anjuran diataa tidak menjamin kosong nya lambung.
                        </td>
                       
                    </tr>
                    <tr>
                        
                        <td align="justify" colspan="2">
                           2. Evaluasi oleh dokter spesialis anestesiologi & reanimasi dan konsultasi ke bidang bila diperlukan.
                        </td>
                       
                    </tr>
                    <tr>
                        
                        <td align="justify" colspan="2">
                          3. Pemeriksaan penunjang seperti laboratorium/radiologi dan Elektrokardiogram(EKG) sesuai indikasi.
                        </td>
                       
                    </tr>
                    <tr>
                       
                        <td align="justify" colspan="2">
                          4. Semua make-up(lipstik/pewarna kuku) harus dibersihkan agar warna kulit dapat dimonitor selama pembiusan.
                        </td>
                       
                    </tr>
                    <tr>
                       
                        <td  align="justify" colspan="2">
                           5. Perhiasan dan gigi palsu harus dilepas.
                        </td>
                       
                    </tr>
                    <tr>
                        
                        <td align="justify" colspan="2">
                          6. Pasien menyetujui dan menandata tangani Surat Persetujuan Anestesia.
                        </td>
                       
                    </tr>
                    <tr>
                        <td colspan="2" align="justify">
                            
                                <b>SEDASI RINGAN, RINGAN DAN BERAT</b>
                           
                                <br>
                                Keadaan yang dihasilkan oleh efek pemberian obat yang membuat pasien dapat mentoleransi keadaan/kondisi maupun
                                prosedur yang tidak menyenangkan. Pemberian sedasi ringan adalah pemberian obat sedasi yang menyebabkan pasien
                                tenang dan masih memberikan respon terhadap rangsangan verbal. Fungsi kognitif mungkin berkuran tetapi refleks
                                perlindungan jalan nafas tetap utuh, fungsi pernafasan dan kardiovaskuler normal. Kondisi pasien bila sedasi sedang
                                masih dapat dibangunkan dengan verbal dan sentuhan, disertai stabilitas pada nafas dan kardiovaskular. Sedangkan pada
                                kondisi sedasi berat pasien sudah tertidur sulit dibangunkan. Dan kemungkinan mempertahankan jalan nafas dan fungsi
                                nafas dapat terganggu.
                           
                        </td>
                    </tr>
                  
                </table>
            </td>
        </tr>    
        
                    
</table>

        

<?php $this->endWidget(); ?>

