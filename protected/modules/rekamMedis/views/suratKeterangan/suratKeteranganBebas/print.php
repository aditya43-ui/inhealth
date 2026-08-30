<head>
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
    <link rel="stylesheet" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
</head>
<style>
       @page {
                /*   size: 7in 9.25in;*/
                size:a4;
    }
    @media print {

        html, body {
            size: a4;
        }
    }
    .tab_header {
        width: 100%;
    }
    
    .tab_header td {
        border: 1px solid black;
        line-height: 32px;
        padding-left: 5px;
        vertical-align: top;
    }
    
    .tab_header .head_cell {
        font-weight: bold;
    }
    
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }
    
    .tab_informasi {
        width: 100%;
        position: absolute;
        bottom: 0;
    }
    
    .tab_informasi th, .tab_informasi td {
        /*border: 1px solid black;*/
        padding: 2px;
        /*bottom:0px;*/
    }
    
    .tab_informasi th {
        text-align: center;
    }
    
</style>
<div class="header">
    <?php echo $this->renderPartial('application.views.headerReport.headerDefaultNew'); ?>
</div>
<div>
    <div class="content">
        <TABLE ALIGN="CENTER">
            <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <div class="judulcontent"> <B><span SIZE=4><U><?php echo $model->judulsurat; ?></U></span></B></div>
                </td>
            </tr>
            <tr>
                <td ALIGN=CENTER VALIGN=MIDDLE>
                    <B><span SIZE=4>NO : <?php echo $model->nomorsurat; ?></span></B>
                </td>
            </tr>
        </TABLE>
        <br><br>
    </div>
    <div class="content">
        <table>
            <tr>
                <th>Saya yang bertanda tangan dibawah ini :</th>
            </tr>
            <tr>
                <td>Nama : <?php echo $modPasien->nama_pasien;?></td>
            </tr>
            <tr>
                <td>No RM : <?php echo $modPasien->no_rekam_medik;?></td>
            </tr>
            <tr>
                <td>No. Identitas : <?php echo $modPasien->no_identitas_pasien;?></td>
            </tr>
        </table>
        <table>
            <tr>
                <p><?php echo $model->keterangan;?></p>
            </tr>
        </table>
    </div>
</div>
<table class="tab_informasi">
    <tr>
        <td width="50%">&nbsp;&nbsp;</td>
        <td width="50%" align="center">
            <?php
               $modProfil = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
            ?>
            <p><?=$modProfil->kabupaten->kabupaten_nama ;?> , <?php echo date('d, F, Y');?></p>
            <span style="text-align: left!important;"></span>   
            <br>
            <?php 
            //$hiddenttd = '';
            //if ($model->pegawaittd_image) {
            //    $src = Params::urlResepturDirectory().$model->pegawaittd_image;
            //echo "<img src='$src'>";
            //
            // $hiddenttd = 'hidden';
            //}?>
              <!-- }?> -->
            <?php //if(!$model->pegawaittd_image || empty($model->pegawaittd_image)){?>
              <!--    -->
            <div class="row-fluid" style="margin: auto;">
             <div>
                <!-- <div class="literally images-in-drawing"></div> -->
            <!-- <div class="literally pegawai"></div>
                <a class="tooltip-primary btn "data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk menyimpam file gambar yang sudah dibuat" href="javascript:void(0);" id="ttdpeg" data-rel="reload">Simpan Tanda Tangan</a> 
                <a class="tooltip-primary btn btn-danger" data-toggle="tooltip" data-placement="top" title="" data-original-title="icon ini untuk mengembalikan perubahan bidang gambar ke awal" href="javascript:void(0);" id="clear-lc" data-rel="reload">Ulang</a>   
            </div> -->
            </div>
            <!-- <div id=""></div> -->
            <input type="hidden" name="KUSuratketeranganT_pegawaittd" id="KUSuratketeranganT_pegawaittd">
            <?php //} ?>
            <br />
            <br />
            <br />
            <br />
            <br />
            <br />
            <?php
                $pegawaiList = DokterV::model()->findAll(array(
                    'condition' => 'pegawai_aktif = true AND kelompokpegawai_id = ' . Params::KELOMPOKPEGAWAI_ID_TENAGA_MEDIK,
                    'order' => 'nama_pegawai'
                ));
                $pegawaiOpt = array();
                foreach ($pegawaiList as $item) {
                    $pegawaiOpt[$item->namaLengkap] = array(
                        'data-nama' => $item->namaLengkap,
                        'data-sip' => $item->suratizinpraktek ?? "-",
                        'data-jabatan' => $item->jabatan->jabatan_nama ?? "-",
                        'data-instansi' => 'RSUD Ketet Provinsi Jawa Tengah',
                    );
                }
                echo $model->mengetahui_surat??'-';
            ?>
        </td>
    </tr>
</table>

  