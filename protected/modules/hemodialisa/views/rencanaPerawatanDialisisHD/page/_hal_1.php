<?php
$titik = new CustomFunction;
echo $this->renderPartial('application.views.headerReport._default_emr_pdf',['data'=>$data,'pemprov_logo'=>true]); 

?>


    <table class='w100 prinout grid' autosize="1">
        <tr class="green" >
            <td class="green" colspan="2">
                Diisi oleh Dokter,Keperawatandan Tenaga Kesehatan Lain
            </td>
        </tr>
        <tr>
            <td colspan="2">
                <table class="w100 prinout no-grid" autosize="0">
                    <tr>
                        <td colspan="3">Tanggal Pengisian : 
                        <?= $titik->defaulttitik(20, date('d M', strtotime($model->create_time)) ) ?>, Jam : <?= $titik->defaulttitik(10, date('H:i:s', strtotime($model->create_time))) ?> WIB</td>
                    </tr>
                    <tr>
                        <td width="23%">Tanggal dialisis pertama</td>
                        <td width="1%">:</td>
                        <td><?= $titik->defaulttitik(85, !empty($model->waktu_dialisis_pertama)?MyFormatter::formatDateTimeForUser($model->waktu_dialisis_pertama,'long'):'') ?></td>
                    </tr>
                    <tr>
                        <td>Masalah yang ditemukan</td>
                        <td width="1%">:</td>
                        <td height="100px;"><?= $titik->defaulttitik(300, $model->masalah_yang_ditemukan) ?></td>
                    </tr>
                    <tr>
                        <td><?= ucwords(strtolower($model->profesi)) ?></td>
                        <td width="1%">:</td>
                        <td><?= $titik->defaulttitik(300, !empty($model->pegawai->namaLengkap)?$model->pegawai->namaLengkap:null) ?></td>
                    </tr>
                </table>
            </td>
        </tr>
        <tr>
            <td align="center" width="50%">KONSULTAN NEFROLOGI</td>
            <td align="center" width="50%">KEPERAWATAN DAN TENAGA KESEHATAN LAIN</td>
        </tr>
        <tr style="height:52em"  height="52em">
            <td height="60em">
                <span style="font-size:13px;height:100%">
                    Rencana dan tatalaksana medis/tindakan medik, pemberian cairan/nutrisi/elektrolit, diagnosa laboratorium dan radiologi lebih lanjut, edukasi, konsultasi dan observasi.<br/>
                    Ditulis dengan : <b>P</b>= Perencanaan, <b>I</b>= Instruksi
                </span>
                
                <?php
                    echo '<br/>';
                    echo '<span style="font-size:13px;height:100%">';
                    if (strtolower($model->profesi) == 'konsultan nefrologi'){      
                        echo '<br/>';
                        if (!empty($model->perencanaan)){
                            echo '<b>P</b> : '. strip_tags($model->perencanaan).'<br/>';
                        }
                        echo '<br/>';
                        if (!empty($model->instruksi)){
                            echo '<b>I</b> : '.strip_tags($model->instruksi);
                        }
                    }
                    echo '</span>';
                
                ?>
            </td>
            <td>
                <span style="font-size:13px;">
                    Rencana dan tatalaksana keperawatan dan tenaga kesehatan lain,rencana edukasi dan observasi.<br/>
                    Ditulis dengan : <b>P</b>= Perencanaan, <b>I</b>= Intervensi - Implementasi
                </span>
                
                 <?php
                    echo '<br/>';
                    if (strtolower($model->profesi) != 'konsultan nefrologi'){                        
                        echo '<br/>';
                        if (!empty($model->perencanaan)){
                            echo '<b>P :</b> '. strip_tags($model->perencanaan);
                        }
                        echo '<br/>';
                        if (!empty($model->instruksi)){
                            echo '<b>I :</b> '.strip_tags($model->instruksi);
                        }
                    }
                
                ?>
            </td>
        </tr>        
    </table>
    <table class="prinout w100 no-grid">
        <tr>
            <td>Revisi : 17/01/17</td>
            <td align="right">Hal 1 dari 2</td>
        </tr>
    </table>
 <?php
    echo '<div style=" page-break-after:always;"></div>';
 ?>