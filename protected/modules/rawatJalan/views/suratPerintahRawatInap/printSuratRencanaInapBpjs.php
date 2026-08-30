<?php $data = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); ?>
<link rel="stylesheet" type="text/css" href="https://fonts.googleapis.com/css?family=Arial">

<style>     
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
    td{
        font-size: 11pt !important;
    }
    body{
        width: 21.7cm;     
        font-family: "Arial" !important;     
    }

    td.header
    {
        padding-left:30px;
    }

    td
    {
        font-size: 12pt !important;
        vertical-align: top;
    }

    .qr_data img {
        max-width: none;
        width: 80px;
        padding-left: 10px;
    }
</style>
<table width="100%" border = "0" style = "text-align:left; color: black;">
    <thead>
        <tr>
            <th style="vertical-align:top" rowspan="2" width = "25%"><img src="<?php echo Yii::app()->getBaseUrl('webroot') . '/images/logo_bpjs.png'; ?>" width="200px"></th>
            <th rowspan="2" style="padding-top:10px;vertical-align:top;font-weight:bold; text-align: left;"><span style="font-size:17px;"><?php echo $judul_print; ?><br><?php echo $data->nama_rumahsakit; //." (".Yii::app()->user->getState('ppkpelayanan').")"; ?></span></th>        
            <th  class="qr_data"  align='right' width="30%" style="text-align:center;padding-top:10px;font-weight:bold;"><span style="font-size:17px;">No. <?php  echo $model->nomorspri_bpjs; ?></span>
                <?php
                    // $this->widget('ext.qrcode.QRCodeGenerator', array(
                    //     'data' => $model->nomorspri_bpjs,
                    //     'subfolderVar' => false,
                    //     'displayImage' => true, // default to true, if set to false display a URL path
                    //     'errorCorrectionLevel' => 'L', // available parameter is L,M,Q,H
                    //     'matrixPointSize' => 10, // 1 to 10 only
                    // ))
                ?>
            </th>   
        </tr>        
    </thead>
</table>
<table width="100%" border = "0" style = "text-align:left;">
<tbody>
    <td colspan = "4">
        <table border = "0"  style = "text-align:left; color:black"> 
            <tr>
                <td colspan="3">Mohon Pemeriksaan dan Penanganan Lebih Lanjut :</td>
            </tr>
            <tr>
                <td width="30%">No. Kartu</td>
                <td width="3%">:</td>
                <td><?php echo $model->nokartubpjs; ?> </td>                
            </tr>
            <tr>
                <td>Nama Peserta</td>
                <td>:</td>
                <td><?php echo $modPasien->nama_pasien.' ('.$modPasien->jeniskelamin.')'; ?></td>                
            </tr>
            <tr>
                <td>Tgl. Lahir</td>
                <td>:</td>
                <td><?php echo MyFormatter::formatDateTimeId($modPasien->tanggal_lahir); ?> </td>               
            </tr>
            <tr>
                <td>Diagnosa</td>
                <td>:</td>
                <td>
                    <?php 
                        if(!empty($modResume)) {
                            $modDiagnosa = ResumemedisMorbiditasR::model()->findByAttributes(['resumemedis_id' => $modResume->resumemedis_id, 'kelompokdiagnosa_id' => Params::KELOMPOKDIAGNOSA_UTAMA]);
    
                            if(!empty($modDiagnosa->diagnosa)) {
                                echo $modDiagnosa->diagnosa->diagnosa_nama;
                            } else {
                                echo '-';
                            }
                        } else {
                            echo '-';
                        }

                        // !empty($modMorbiditas)?$modMorbiditas->diagnosa->diagnosa_nama:'-'
                    ?>
                </td>
            </tr>
            <tr>
                <td>Rencana Inap</td>
                <td>:</td>
                <td><?php echo MyFormatter::formatDateTimeId($model->tgl_rencanaranap); ?></td>
            </tr>
            <tr>
                <td colspan="3" style="padding-top:5px;">Demikian atas bantuannya diucapkan banyak terima kasih</td>                                
            </tr>           
        </table>
    </td>
</tbody>
</table>

<table width="100%" border = "0" style = "text-align:left; color: black;">
    <thead>
        <tr>
            <th style="vertical-align:top" rowspan="2" width = "25%">&nbsp;</th>
            <th rowspan="2" style="padding-top:10px;vertical-align:top;font-weight:normal; text-align: left;">&nbsp;</th>        
            <th  class="qr_data"  align='right' width="30%" style="text-align:center;padding-top:10px;font-weight:normal;"><span style="font-size:17px;">Mengetahui DPJP</span>
               
            </th>   
        </tr>        
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>  
        <tr>
            <th style="vertical-align:top" rowspan="2" width = "25%">&nbsp;</th>
            <th rowspan="2" style="padding-top:10px;vertical-align:top;text-align: left;font-weight: normal;">&nbsp;</th>        
            <th  class="qr_data"  align='right' width="30%" style="text-align:center;padding-top:10px;font-weight: normal;"><span style="font-size:17px;"><?= !empty($model->dpjp)?$model->dpjp->namaLengkap:'' ?></span></span>
               
            </th>   
        </tr>
    </thead>
</table>
