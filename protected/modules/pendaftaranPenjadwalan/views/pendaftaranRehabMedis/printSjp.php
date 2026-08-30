<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td, th{
        font-size: 9pt !important;
    }
    p, span{
        font-size: 9pt !important;
    }
    table { 
    border-spacing: 0;
    border-collapse: collapse;
}
hr {
  border:none;
  border-top:1px dotted #f00;
  color:#fff;
  background-color:#fff;
  height:1px;
  width:50%;
}
 
p.notdot{
    border-bottom:4px solid #fff;
    float:left;
    padding-right:5px;
    display:inline;
    white-space: nowrap;
    margin: 0;
    height:17px;
}

p.dot{
    border-bottom:1px dotted #000;    
    padding-right:5px;    
    margin: 0;
    height:16px;
    font-weight: bold;
}
</style>
<?php echo $this->renderPartial('pendaftaranPenjadwalan.views.pendaftaranRawatJalan._headerPrintSjp'); ?>
<table style="width: 100%; border: none;">
    <tr>
        <td nowrap>&nbsp;</td>
        <td width="100%">&nbsp; </td>
        <td nowrap>Abepura</td>
        <td width="50%" nowrap>: <?php echo date('d / m / Y', strtotime($modPendaftaran->tgl_pendaftaran)); ?></td>
    </tr>
</table>
<br>
<h4 align = "center">SURAT JAMINAN PELAYANAN RAWAT JALAN</h4>
<br>
<table width="100%" cell>
    <tr>
        <td width="3%"><b>I.</b></td>
        <td><b>Kepesertaan</b></td>
    </tr>
    <tr>
        <td></td>
        <td colspan="3" width = "43%"><p class="notdot">No. Kartu KPS : </p> <p class="dot"><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></p></td>        
        <td width = "3%">&nbsp;</td>
        <td colspan="3" width = "43%"><p class="notdot">Nama Pasien : </p> <p class="dot"><?php echo $modPendaftaran->pasien->nama_pasien; ?></p></td>        
    </tr>
   <tr>
        <td></td>
        <td colspan="3"><p class="notdot">Asal Rujukan : </p> <p class="dot"><?php echo isset($modPendaftaran->rujukan->nama_perujuk)?$modPendaftaran->rujukan->nama_perujuk:'';  ?></p></td>        
        <td>&nbsp;</td>
        <td colspan="3"><p class="notdot">TTL : </p><p class="dot"><?php echo $modPendaftaran->pasien->tempat_lahir.", ".date('d - m - Y',strtotime($modPendaftaran->pasien->tanggal_lahir)); ?></p></td>        
    </tr>
    <tr>
        <td></td>
        <td colspan="3"><p class="notdot">Tanggal Rujukan : </p><p class="dot"><?php echo isset($modPendaftaran->rujukan->tanggal_rujukan)?date('d / m / Y',  strtotime($modPendaftaran->rujukan->tanggal_rujukan)):'';  ?></p></td>        
        <td>&nbsp;</td>
        <td colspan = "3"><p class="notdot">Jenis Kelamin : </p><p class="dot"><?php echo $modPendaftaran->pasien->jeniskelamin; ?></p></td>        
    </tr>
    <tr>
        <td></td>
        <td colspan="3"><p class="notdot">Diagnosa Rujukan :</p><p class="dot"><?php echo isset($modPendaftaran->rujukan->kddiagnosa_rujukan)?$modPendaftaran->rujukan->kddiagnosa_rujukan:'';  ?></p></td>        
        <td>&nbsp;</td>
        <td colspan="3"><p class="notdot">Alamat : </p><p class="dot"><?php echo $modPendaftaran->pasien->alamat_pasien; ?></p></td>        
    </tr>
    <tr>
        <td></td>
        <td colspan="3"><p class="notdot">No. RM : </p><p class="dot"><?php echo $modPendaftaran->pasien->no_rekam_medik; ?></p></td>        
        <td>&nbsp;</td>
        <td colspan="3"><p class="notdot">Pekerjaan : </p><p class="dot"><?php echo (!empty($modPendaftaran->pasien->pekerjaan_id)?$modPendaftaran->pasien->pekerjaan->pekerjaan_nama:''); ?></p></td>        
    </tr>
    <tr>
        <td></td>
        <td colspan="3"><p class="notdot">Tgl. SJP : </p><p class="dot"><?php echo date('d / m / Y', strtotime($modPendaftaran->tgl_pendaftaran)); ?></p></td>        
        <td>&nbsp;</td>
        <td colspan="3"><p class="notdot">Petugas Satgas : </p><p class="dot">&nbsp;</p></td>        
    </tr>    
    <tr>
        <td>&nbsp;</td>
    </tr>
    <tr>
        <td width="3%"><b>II.</b></td>
        <td><b>Hasil Pemeriksaan</b></td>
        <td>&nbsp;</td>
        <td>&nbsp;</td>
        <td width="3%"><b>III.</b></td>
        <td colspan="2"><b>Konsul Antar bagian</b></td>
        <td style = "text-align:right;">ICD X</td>
    </tr>
     <tr>
        <td></td>
        <td colspan="2"><p class="notdot">Poliklinik : </p><p class="dot"><?php echo $modPendaftaran->ruangan->ruangan_nama; ?></p></td>        
        <td></td><!--kotak-->
        <td>&nbsp;</td>
        <td colspan = "2"><p class="notdot">Poliklinik : </p><p class="dot">&nbsp;</p></td>        
        <td></td><!--kotak-->
    </tr> 
    <tr>
        <td></td>
        <td colspan="2"><p class="notdot">Diagnosis : </p><p class="dot">&nbsp;</p></td>        
        <td><div style = "border: 1px solid #333;width:40px;height:25px;float:right;"></div></td><!--kotak-->
        <td>&nbsp;</td>
        <td colspan="2"><p class="notdot">Diagnosis :</p><p class="dot">&nbsp;</p> </td>        
        <td><div style = "border: 1px solid #333;width:50px;height:25px;float:right;"></div></td><!--kotak-->
    </tr> 
     <tr>
        <td></td>
        <td colspan="2"><p class="notdot">Pemeriksa :</p><p class="dot">&nbsp;</p></td>        
        <td></div></td><!--kotak-->
        <td>&nbsp;</td>
        <td colspan="2"><p class="notdot">Pemeriksa :</p><p class="dot">&nbsp;</p></td>        
        <td></div></td><!--kotak-->
    </tr> 
    <tr>
        <td></td>
        <td colspan="2"><p class="notdot">Tindakan Medis : </p><p class="dot">&nbsp;</p></td>        
        <td></td><!--kotak-->
        <td>&nbsp;</td>
        <td colspan="2"><p class="notdot">Tindakan Medis : </p><p class="dot">&nbsp;</p></td>        
        <td></td><!--kotak-->
    </tr>
     <tr>
        <td></td>
        <td colspan="2"><p class="notdot">Petugas Poli : </p><p class="dot">&nbsp;</p></td>        
        <td><div style = "border: 1px solid #333;width:40px;height:25px;float:right;"></div></td><!--kotak-->
        <td>&nbsp;</td>
        <td colspan="2"><p class="notdot">Petugas Poli : </p><p class="dot">&nbsp;</p></td>        
        <td><div style = "border: 1px solid #333;width:50px;height:25px;float:right;"></div></td><!--kotak-->
    </tr>    
    <tr>
        <td><b>IV.</b></td>
        <td colspan="2"><p class="notdot"><b>Pem. Lab</b> :</p><p class="dot">&nbsp;</p> </td>        
        <td style="padding-bottom:0px"><div style = "border: 1px solid #333;width:40px;height:25px;float:right;"></div></td><!--kotak-->
        <td></td>
        <td colspan="3" rowspan="5" style = "padding:0px 20px 0px 20px;">
            <div style="border:3px solid #333; height:85px;width:100%">
                <p align = "center">Telah dilakukan verifikasi oleh Satgas<br>
                    KPS RSUD Abepura
                </p>                
                <span style="padding-left:5px;">Tgl:</span><br>
                <p style = "height:15px;padding-left: 15px;float:left;border-bottom:3px solid #fff;">Satgas KPS :  </p> <p style="height:15px;margin:0px 15px 0px 85px;border-bottom:1px dotted #000;"> &nbsp;</p>
            </div>
        </td>
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><p class="notdot">Pem. Rad : </p><p class="dot">&nbsp;</p></td>        
        <td style="padding-top:0px"><div style = "border: 1px solid #333;width:40px;height:25px;float:right;"></div></td><!--kotak-->
    </tr>
    <tr>
        <td></td>
        <td colspan="2"><p class="notdot">Pem. Lain :</p><p class="dot">&nbsp;</p></td>        
    </tr>
    <tr>
        <td>&nbsp;</td>
    </tr>   
</table>
<table width="100%" style = "border:1px solid #333;">
    <tr>
        <td width = "40%" style = "vertical-align: top;padding-left:10px;">
            <b>R/</b>
        </td>
        <td width = "7%" style="border:1px solid #333">
            <br><br><br>
        </td>
        <td width = "40%"  style = "vertical-align: top;padding-left:10px;">
             <b>R/</b>
        </td>
        <td width = "7%" style="border:1px solid #333"></td>
    </tr>
    <tr>
        <td style = "vertical-align: top;padding-left:10px;">
            <b>R/</b>
        </td>
        <td style="border:1px solid #333">
            <br><br><br>
        </td>
        <td style = "vertical-align: top;padding-left:10px;">
             <b>R/</b>
        </td>
        <td style="border:1px solid #333"></td>
    </tr>
    <tr>
        <td style = "vertical-align: top;padding-left:10px;">
            <b>R/</b>
        </td>
        <td style="border:1px solid #333">
            <br><br><br>
        </td>
        <td style = "vertical-align: top;padding-left:10px;">
             <b>R/</b>
        </td>
        <td style="border:1px solid #333"></td>
    </tr>
    <tr>
        <td style = "vertical-align: top;padding-left:10px;">
            <b>R/</b>
        </td>
        <td style="border:1px solid #333">
            <br><br><br>
        </td>
        <td style = "vertical-align: top;padding-left:10px;">
             <b>R/</b>
        </td>
        <td style="border:1px solid #333"></td>
    </tr>    
</table>
<table style="width: 100%; border: none;">   
    <tr>
        <td colspan="4">
            <p style="text-align:center;">
                Obat hanya dapat di tebus di Apotik RSUD Abepura<br>
                Berikan obat sesuai dengan formularium RSUD Abepura
            </p>
        </td>
    </tr>
    <tr>
        <td colspan="2" style = "padding:10px">Petugas Penyerahan Obat : ............................................ </td>
        <td colspan="2" style = "padding:10px;text-align: right;">Penerima Obat : .............................................. </td>
    </tr>
</table>
