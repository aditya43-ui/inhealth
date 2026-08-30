<style>
    .border_c{
        border:1px solid;
    }

    .spasi{
        height:10px;
    }

    .table_isi, tr, td{
        padding:5px;
    }
</style>

<b>FRM/123/RSBM</b>
<?php echo $this->renderPartial($this->path_view.'_headerPrint', array('model'=>$model, 'modPendaftaran'=>$modPendaftaran,
                'modPasien'=>$modPasien,
                'judul'=>$judul)); ?>


<table border="1px" width="100%">
    <tr>
        <td>
           
            <div style="min-height:700px; margin-left:30px;">
                <br>Formulir ini adalah perintah dokter penanggungjawab pasien (DPJP) kepada seluruh staf klinis rumah sakit agar tidak
				melakukan resusitasi terhadap pasien ini bila terjadi henti jantung (bila tidak ada denyut nadi) dan henti nafas ( tidak ada
				pernapasan spontan).
				Formulir ini juga memberikan perintah kepada staf medis untuk tetap melakukan intervensi, pegobatan, atau tatalaksana
				lainya sebelum terjadinya henti jantung atau henti nafas.</p>
                <br>
                <div style="margin-left:30px;">
                <table width="100%" class="table_isi">
                        <tr>
                            <td width="15%">Nama pasien</td>
                            <td width="2%"> </td>
                            <td width="40%" class="border_c"><?= isset($modPasien->nama_pasien) ? $modPasien->nama_pasien : '-';?></td>
                            <td></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td>Tanggal Lahir</td>
                            <td> </td>
                            <td class="border_c"><?= isset($modPasien->tanggal_lahir) ? MyFormatter::formatdatetimeforuser($modPasien->tanggal_lahir) : '-';?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        
                        <tr>
                            <td>Nomor RM</td>
                            <td> </td>
                            <td class="border_c"><?= isset($modPasien->no_rekam_medik) ? $modPasien->no_rekam_medik : '-';?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                        <tr>
                            <td>Alamat</td>
                            <td> </td>
                            <td class="border_c"><?= $modPasien->alamat_pasien;?></td>
                        </tr>
                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>

                        <tr>
                            <td colspan="4" class="spasi"></td>
                        </tr>
                       
                    </table>
                </div>
                <br>
                <p>Saya dokter ang bertanggungjawab di bawah ini menginstruksikan kepada seluruh staf medis dan staf klinik lainnya untuk 
                melakukan hal-hal tertulis dibawah ini :</p>
                <br>
                <div style="margin-left:20px;">
                    <p>- Usaha komprehensif untuk mencegah henti jantung atau henti nafas tanpa melakukan intubasi. Jangan melakukan tindakan resusitasi jantung paru (RJP) jika
                    terjadi henti nafas atau henti jantung.</p>
                    <p>- Usaha suportif sebelum terjadi henti nafas atau henti jantung yang meliputi pembukaan jalan nafas non invasi, mengontrol pendarahan, memposisikan pasien 
                    dengan nyaman, pemberian obat-obatan anti nyeri. Jangan melakukan tindakan resusitasi jantung paru (RJP) jika terjadi henti nafas atau henti jantung.</p>
                </div>    
                <br>
                
                <p>Saya dokter yang bertanda tangan di bawah menyatakan bahwa keputusan DNR diatas diambil setelah pasien diberikan penjelasan
                dan informed consent diperoleh dari salah satu :</->
                <br>
                <div style="margin-left:20px;">     
                
                    <p>- Pasien </p>
                    <p>- Tenaga kesehatan yang ditunjuk pasien</p>
                    <p>- Wali yang sah pasien (termasuk yang ditunjuk oleh pengadilan)</p>
                    <p>- Anggota keluarga pasien</p>
                    <p>- Jika yang diatas tidak dimungkinkan maka dokter yang bertanda tangan dibawah ini memberikan perintah DNR berdasarkan pada intruksi sebelumnya</p>
                </div>    

                <br><br>
                <p>Keputusan dua orang dokter yang menyatakan bahwa Resusitasi Jantung Paru akan mendatangkan hasil yang tidak efektif.</p>
                       


                <br><br>
                <div style="margin-right:30px;">
                    <table width="100%" border="1px;">
                        <tr>
                            <td width="50%" style="vertical-align:top">
                                <table width="100%">
                                    <tr>
                                        <td width="30%">Nama Lengkap Dokter</td>
                                        <td>:</td>
                                        <td><?= $model->nama_dokter;?></td>
                                    </tr>
                                    <tr>
                                        <td>NIP</td>
                                        <td>:</td>
                                        <td><?= $model->nip;?></td>
                                    </tr>
                                    <tr>
                                        <td>Nomor Telepon</td>
                                        <td>:</td>
                                        <td><?= $model->no_tlp;?></td>
                                    </tr>
                                </table>
                            
                            </td>
                            <td width="50%" style="vertical-align:top">
                                <table width="100%">
                                    <tr>
                                        <td width="25%">Tanggal</td>
                                        <td width="10">:</td>
                                        <td><?= MyFormatter::formatdatetimeforuser($model->tanggal_pengisian);?></td>
                                    </tr>
                                    <tr>
                                        <td>Nama & Tanda Tangan Dokter</td>
                                        <td></td>
                                        <td></td>
                                    </tr>
                                    
                                </table>
                                <div style="height:70px;"></div>
                            </td>
                        </tr>
                    </table>
                </div>
                
                </table>
            </div>
            
        
        </td>
    </tr>

</table>

