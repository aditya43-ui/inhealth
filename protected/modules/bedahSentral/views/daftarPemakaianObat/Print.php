
<style>

    body{
        color: black !important;
    }
    h5{
        color: black !important;
    }
    label{
        color: black !important;
    }
    .tab_header {
        width: 100%;
    }
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }

    p {
        text-align: justify;
    }
    .borderclass {
        border: 1px solid black;
    }
    .bordertopclass {
        border-top: 1px solid black;
    }
    .borderrightclass {
        border-right: 1px solid black;
    }
    .borderleftclass {
        border-left: 1px solid black;
    }
    .borderbottomclass {
        border-bottom: 1px solid black !important;
    }

    .tab_header {
        width: 100%;
    }

    .tab_header td {
        vertical-align: top;
    }

    .tab_oa {
        width: 100%;
        border-collapse: collapse;
    }

    .tab_oa th, .tab_oa td {
        border: 1px solid black;
        padding: 2px;
    }

    .tab_layout td {
        vertical-align: top;
    }

    .tab_detail {
        border-collapse: collapse;
        border: 1px solid black !important;
    }

    .tab_detail td, .tab_detail th {
        border: 1px solid black;
        padding: 5px;
    }

    /* .borderclass {
       border: 1px solid black;
   }
   .bordertopclass {
       border-top: 1px solid black;
   }
   .borderrightclass {
       border-right: 1px solid black;
   }
   .borderleftclass {
       border-left: 1px solid black;
   }
   .borderbottomclass {
       border-bottom: 1px solid black !important;
   } */
    .text-center{
        text-align: center !important;
    }
    .border tbody td, .border thead th{
        border: 2px solid black !important;
    }

</style>
<div style="text-align: right; font-weight: bold;">FRM/03.2 Rev 2/RSBM</div>
<?php echo $this->renderPartial('application.views.headerReport.headerDefault', array('modPendaftaran' => $modPendaftaran, 'modPasien' => $modPasien)); ?>
<br/>
<h2 align="center">
    CATATAN PERKEMBANGAN PASIEN TERINTEGRASI (CPPT)
</h2>
<p>
   

    <?php if (!empty($res->ruangan_id) && is_array($res->ruangan_id) && count($res->ruangan_id) > 0): ?>    
        Ruangan : <?php
        $ru = array();
        foreach ($res->ruangan_id as $item) {
            $r = RuanganM::model()->findByPk($item);
            $ru[] = $r->ruangan_nama;
        }

        echo implode(", ", $ru);
    endif;
    
    ?></p>

<p>Kode Profesional Asuhan (PPA): (1) Dokter Spesialis/DPJP, (2) Dokter Umum, (3) Perawat/ Bidan, (4) Apoteker, (5) Ahli Gizi, (6) Fisiotherapis, (7) Lainnya</p>
<table class="tab_detail">
    <thead>
        <tr>
            <th>Tanggal Pendaftaran</th>
            <th>Ruangan</th>
            <th>Tanggal/ Jam</th>
            <th>Kode PPA</th>
            <th>Profesional Pemberi Asuhan (PPA)</th>
            <th>Hasil Pemeriksaan, analisa dan Tindak Lanjut <br /> Subjective, Objective, Assesment, Planning (SOAP)/ ADIME <br /> Tulis, Baca, Konfirmasi (TBak) <br />(dituliskan dengan format SOAP, disertai dengan sasaran/ target yang <br />terukur, evaluasi hasil tata laksana dituliskan dalam assesmen, <br />harap bubuhkan nama dan paraf pada setiap akhir catatan)</th>
            <th><b>Instruksi Tenaga<br /> Kesehatan <br /> termasuk Pasca Bedah/ <br /> Prosedur</b> <br /> (Instruksi dituliskan dengan rincian & jelas)</th>
            <th><b>Review dan Verifikasi DPJP</b><br />(Bubuhkan Nama, Paraf, Tgl, Jam)<br/> (DPJP) harus membaca seluruh rencana asuhan</th>
        </tr>
    </thead>
    <tbody>
        <?php
        if (count($model) > 0) {
            foreach ($model as $dataModel) {
                $p = PendaftaranT::model()->findByPk($dataModel->pendaftaran_id);
                ?>
                <tr>
                    <td>
                        <?php echo MyFormatter::formatDateTimeForUser($p->tgl_pendaftaran); ?>
                    </td>
                    <td>
                        <?php echo $dataModel->ruangan->ruangan_nama; ?>
                    </td>
                    <td>
                        <?php echo MyFormatter::formatDateTimeForUser($dataModel->tanggal_cppt); ?>
                    </td>  
                    <td>
                        <center><?php echo $dataModel->ppa_jenis; ?></center>
                    </td>
                    <td>
                        <?php echo $dataModel->ppa_namajenis . ' - ' . $dataModel->pegawaippa->namaLengkap; ?>
                    </td>  
                    <td>
                        <?php
                        $values = "";

                        if ($dataModel->ppa_jenis != 5) {
                            $values .= "<p><b>S</b> : " . preg_replace('#</?p.*?>#is', '', $dataModel->soap_subjective) . '</p>';
                            $values .= "<p><b>O</b> : " . preg_replace('#</?p.*?>#is', '', $dataModel->soap_objective) . '</p>';
                            $values .= "<p><b>A</b> : " . preg_replace('#</?p.*?>#is', '', $dataModel->soap_asesmen) . '</p>';
                            $values .= "<p><b>P</b> : " . preg_replace('#</?p.*?>#is', '', $dataModel->soap_planning) . '</p>';
                        } else {
                            $values .= "<p><b>A</b> : " . preg_replace('#</?p.*?>#is', '', $dataModel->soapgizi_asesmen) . '</p>';
                            $values .= "<p><b>D</b> : " . preg_replace('#</?p.*?>#is', '', $dataModel->soapgizi_diagnosagizi) . '</p>';
                            $values .= "<p><b>I</b> : " . preg_replace('#</?p.*?>#is', '', $dataModel->soapgizi_intervensi) . '</p>';
                            $values .= "<p><b>M</b> : " . preg_replace('#</?p.*?>#is', '', $dataModel->soapgizi_monitoring) . '</p>';
                            $values .= "<p><b>E</b> : " . preg_replace('#</?p.*?>#is', '', $dataModel->soapgizi_evaluasi) . '</p>';
                        }
                        echo $values;
                        ?>
                    </td>
                    <td>
                        <?php echo $dataModel->instruksi; ?>
                    </td>
                    <td>
                        <?php
                        $valueReview = "Belum Diverifikasi";
                        if ($dataModel->isverifikasidpjp == true) {
                            $valueReview = "Sudah diverifikasi oleh : <br />" . (isset($dataModel->dpjp_id) ? $dataModel->dpjp->namaLengkap : "-") . '<br /> Tgl : <br />' . MyFormatter::formatDateTimeForUser($dataModel->verifikasidpjp_tanggal);
                        }
                        echo $valueReview;
                        ?>
                    </td>
                </tr>
                <?php
            }
        }
        ?>
    </tbody>
</table>
<!-- <p style="font-weight: bold; float: right">2019-2021</p> -->



