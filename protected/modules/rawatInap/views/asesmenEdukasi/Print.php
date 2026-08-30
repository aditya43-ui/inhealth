<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>

<style>
    #headerset{
        width:80px !important;
        max-width :75px !important;
        margin-top:2% !important;

    }
    #headerset2{
        width:100px !important;
        max-width :100px !important;
        margin-top:-5% !important;

    }
    

    @media print {
    .page-break { padding-top: 30px; display: block; page-break-before: always; }
    }
    @page {
        margin-top: 0mm;
         margin-bottom: 0mm;
/*        margin: 0cm 0cm 0cm 0cm;*/
    }
    @media print {
        html, body {
            padding-top:30px;
            font-family: Arial !important;
            font-size: 8pt !important;
            width: 210mm;
            height: 330mm;
            color-adjust: exact;

        }
         #pageFooter:after {
                    counter-increment: page;
                    content: counter(page);
                }
        .footer{
            width: 100%;
                    position: fixed;
                    bottom: 0;
        }
        .footer, .footer-space {
                    height: 40mm;
                }
        div.footer {
            position: fixed;
            bottom: 0;
            float:left;
        }
        .headrtd{
            background-color:#afdc7e !important;


        }
        .header-space{
            height:40mm;
        }
        #headerset{
            width:80px !important;
            max-width :75px !important;
            margin-top:7% !important;

        }
        #headerset2{
            width:100px !important;
            max-width :100px !important;
            margin-top:-5% !important;
        }


    }
    table.footer {
        position: fixed;
        bottom: 0;

    }


</style>


<?php
if (!empty($caraprint) && $caraprint == "pdf") {
    ?>
    <style>
        .tabletd tr td{
            border: 1px solid;
            border-collapse: collapse;
        }
        .tabletd tr th{
            border: 1px solid;
            border-collapse: collapse;
        }
        .tabletd {
            border-collapse: collapse;
        }

        .tabletd  table tr td{
            border: 0px;
        }
        #tablekematian tr td{
            border: 1px solid;
            border-collapse: collapse;
        }
        #tablekematian tr th{
            border: 1px solid;
            border-collapse: collapse;
        }
        #tablekematian {
            border-collapse: collapse;
        }

        #headerlaporan{
            border-collapse: collapse;
        }
        #headerlaporan tr td{
            border: 0px;
        }
        

    </style>
    <?php
}
?>


<table width="100%">
    <thead>
        <tr>
            <td>
                <div class="">
                        &nbsp;
                </div>
                   
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content"><?php
                    $this->renderPartial($this->path_view.'Print_table', array(
                        'modPendaftaran'=>$modPendaftaran,
                        'modPasien'=>$modPasien,
                        'model'=>$model,
                        'modDet'=>$modDet,));
                    ?>
                  
                </div>
                
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">
                    
                </div>
            </td>
        </tr>
    </tfoot>
</table>
    <div class="footer">
            <table width="100%">
                <tr>
                    <td HEIGHT=2 style="border-bottom: 2px solid #000000" width="100%" colspan="4"> </td>
                </tr>
                <tr>
                    <td style="text-align: left;">Revisi : 17/01/17</td>
                    <td style="text-align: right;"><div id="pageFooter">Hal </div></td>
                
                </tr>
            </table>
        </div>
     <div class="page-break"></div>
 <table width="100%">
    <thead>
        <tr>
            <td>
                <div class="header">
                   
            </td>
        </tr>
    </thead>
    <tbody>
        <tr>
            <td>
                <div class="content">
                    <table width="100%" style="">
          <tr>
              <td rowspan="3" style="width:70%"><?php echo $this->renderPartial('application.views.headerReport._headerPrint'); ?><hr style="border:1px solid black"></td>
              <td style="width:30%"></td>
          </tr>


      </table>
      <br>

      <table width="100%" border="1">
          <thead>
              <tr style="background-color:#afdc7e">
                  <td  colspan='7'>Diisi oleh Dokter / Keperawatan / Keterapian Fisik / Tenaga Gizi / Apoteker / Tenaga Kesehatan Lain (sesuai topik edukasi)</td>
              </tr>
              <tr>
                  <td colspan="7" align="center" style="font-weight: bold">CATATAN INFORMASI DAN EDUKASI TERINTEGRASI</td>
              </tr>
              <tr>
                  <th>Tgl/Jam</th>
                  <th>Materi Edukasi</th>
                  <th>Metode Edukasi</th>
                  <th>Durasi Waktu</th>
                  <th>Hasil Evaluasi/Verifikasi</th>
                  <th>Nama & TTD Pembiri Informasi / Edukasi</th>
                  <th>Nama & TTD Penerima Edukasi</th>

              </tr>
          </thead>
          <tbody>
              <?php
              if (!empty($modDet)) {
                  foreach ($modDet as $key => $value) {
                      echo "
                        <tr>
                            <td>" . $value->tglpemeriksaan . "</td>
                             <td>" . $value->materiedukasi . "</td>
                            <td>" . $value->metodeedukasi . "</td>
                            <td>" . $value->durasi . "</td>
                            <td>" . $value->hasilevaluasi . "</td>
                            <td>" . $value->pemberiedukasi->namaLengkap . "</td>
                            <td>" . $value->namapenerima_edukasi . "</td>
                        </tr>
                        ";
                  }
              }
              ?>

          </tbody>
      </table>
      <br>
      <table width="100%" border="1">
          <tbody>
              <tr>
                  <td>Metode Edukasi</td>
                  <td>W</td>
                  <td>Wawancara</td>
                  <td>DK</td>
                  <td>Diskusi Kelompok</td>
                  <td>C</td>
                  <td>Ceramah</td>
                  <td>D</td>
                  <td>Demontrasi</td>
              </tr>
              <tr>
                  <td>Durasi Waktu</td>
                  <td>i</td>
                  <td><15 menit</td>
                  <td>2</td>
                  <td>15-30 menit</td>
                  <td>3</td>
                  <td>>30-60 menit</td>
                  <td>4</td>
                  <td>>60 menit</td>
              </tr>
              <tr>
                  <td>Hasil Evaluasi/Verifikasi</td>
                  <td>i</td>
                  <td >sudah memahami
                      (tidak perlu tindak lanjut)</td>
                  <td>2</td>
                  <td>Cukup memahami (boleh/tidak ditindak lanjut)</td>
                  <td>3</td>
                  <td colspan="3">kurang memahami (wajib di tindak lanjut)</td>

              </tr>

      </table>
                  
                </div>
                
            </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <table width="100%" class="footer" >
                    
                </table>
            </td>
        </tr>
    </tfoot>
</table>
     
      



