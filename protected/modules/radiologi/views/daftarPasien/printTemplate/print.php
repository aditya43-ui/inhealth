<?php
//Yii::app()->clientScript->registerCssFile(Yii::app()->baseUrl . '/css/prinout.css');
$data=ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS());
$format = new MyFormatter();
?>
<style>
    #font tr th {
        font-size: 12pt !important;
        font-family: Arial, Helvetica, sans-serif;
        /* padding: 5px; */
        /* margin-left: 10px;
        margin-right: 10px; */

    }

    #font2 {
        border: 1px solid black;
    }

    #font2 tr td p {
        font-size: 20px !important;
        text-align: justify;
        line-height: 2;
    }
    #font3 tr td p {
        font-size: 20px !important;
        text-align: justify;
        line-height: 1;
    }

    #font2 tr th {
        font-size: 20px !important;
    }

    #font2 tr td {
        font-size: 20px !important;
        font-family: Arial, Helvetica, sans-serif;
    }

    #font3 tr th {
        font-size: 20px !important;
    }

    .line {
        border: 1px solid black;
        margin-right: 15px;
        padding: 30px;
    }

    .line2 {
        border: 1px solid black;
        padding: 30px;
        margin-top: 10px;
    }

    .line2 p {
        font-size: 16px;
    }
        table{
            width: 100%;
        }
        .title td{
            font-size: 16px;
            text-align: center;
            font-weight: bold;
            padding: 5px;
            background: #309C5C;
        }
        .sub-judul {
            font-weight: bold;
        }

        table tr, table td {
            vertical-align: top;
        }

</style>
<!-- 
    <div class="grid-container">
        <div class="grid-item">
            TESSS 1
        </div>
        <div class="grid-item">
            KEDUAAA
        </div>
    </div> -->
<?php $res = ListAllOrder::getLoadHasil($nofoto); ?>
<table style="width: 100%; border: none;">
    <thead>
        <tr>
            <td>
                <div class="header">
                    <div style="padding:5px; text-align: center;"><img src="<?php echo Params::urlProfilRSDirectory() . $data->logo_header ?> " style="height: 100%; width: 85%"/></div>
                </div>
            </td>
        </tr>
    </thead>
 
    <tbody>
        <table class="">
            <tr>
                <td >No. Foto</td>
                <td >: <?php echo $res['nofoto'] ?? "-"; ?></td>
            </tr>
          
            <tr>
                <td style="width: 20%;">Nama Pasien</td>
                <td style="width: 30%;">: <?php echo $res['namapasien'] ?? "-"; ?></td>
                <td style="width: 20%;">Tanggal Daftar</td>
                <td style="width: 30%;">: <?php echo $res['daftar'] ?? "-"; ?></td>
            </tr>
            <tr>
                <td>Jenis Kelamin</td>
                <td>: <?php

                    // var_dump($res); die;
                if($res['jk'] == "L"){
                    echo "Laki - Laki(L)";
                }else{
                    echo "Perempuan (P)";
                }?> </td>
                <td>No. Register</td>
                <td >: <?php echo $res['noregister'] ?? "-"; ?></td>
            </tr>
            <tr>
                <td>Usia</td>
                <td>: <?php echo CustomFunction::getUmur($res['tgl_lahir'] ?? $masukpenunjang->tanggal_lahir); ?></td>
                <td>Dokter</td>
                <td >: <?php echo $res['namadokter'] ?? "-"; ?></td>
            </tr>
            <tr>
                <td>Tanggal Lahir</td>
                <td>: <?php echo date('d-m-Y', strtotime($res['tgl_lahir'] ?? $masukpenunjang->tanggal_lahir)); ?></td>
                <td>Ruang</td>
                <td >: <?php  echo $res['asalpasien'] ?? "-"; ?></td>
            </tr>
            <tr>
                <td>Organ Diperiksa</td>
                <td>: <?php echo $res['reques'] ?? "-" ?> </td>
                <td></td>
                <td></td>
            </tr>
            <tr><td></td>
                <td></td>
                <td></td>
                <td></td></tr>
            <tr>
                <td></td>
                <td></td>
                <td></td>
                <td></td>
            </tr>
        </table>
        
        <div class="line2">
          <?php
            
            echo 'Jawaban : <br>';
            // echo 'testes';
            echo $res['jawaban'] ?? "";

          ?>
        </div>
    
        </td>
        </tr>
    </tbody>
    <tfoot>
        <tr>
            <td>
                <div class="footer-space">&nbsp;</div>
            </td>
        </tr>
    </tfoot>
</table>
<!-- <div class="footer">

    <?php //echo $this->renderPartial('application.views.headerReport.footerDefaultNew', array()); ?>

</div> -->
<?php
//echo $this->renderPartial('application.views.headerReport.headerDefault',array('judulLaporan'=>$judulLaporan, 'colspan'=>10));      
?>

<!--<script>
    window.print(); 
</script>-->
