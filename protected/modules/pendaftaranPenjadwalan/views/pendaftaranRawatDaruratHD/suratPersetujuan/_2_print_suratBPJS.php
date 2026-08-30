
<style>

    table {
        table-layout: fixed;
        overflow-wrap: break-word;
        word-wrap: break-word; /* IE */
    }

    @page {
        font-size: 11pt !important;
        margin:0;
    }
    @media print {
        html, body {
            margin: 1cm;
            font-family: "Arial";
            font-size:11pt;
            /*            width:  21cm;
                        height: 33cm;*/
        }
        div.footer {
            position: fixed;
            bottom: 0;
        }
    }
</style>

<?php
$modCaraBayar = CarabayarM::model()->findByPk($modPendaftaran->carabayar_id);
$modPenjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
?>

<table width='100%'>
    <tr>
        <td>
            <?= $this->renderPartial('application.views.headerReport._headerPernyataanRI', ['judulLaporan' => $judulLaporan, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran]) ?>
        </td>
    </tr>
</table>

<table class="tabelSurat" width="100%" style="border: 2px black solid">
    <tr>
        <td> 
            <table width='100%'>

                <tr>
                    <td>
                        <table width="100%">
                            <tr>
                                <td> </td>
                                <td colspan="2"> Yang bertanda tangan di bawah ini </td>
                            </tr>
                            <tr>
                                <td colspan="3"> <br> </td>
                            </tr>
                            <tr>
                                <td>
                                    <?= $this->renderPartial($this->path_view_rj_dari_rj_rd . '/suratPernyataanRI/_0_defaultSurat', ['judulLaporan' => $judulLaporan, 'modPenanggungJawab' => $modPenanggungJawab, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran]) ?>
                                </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td colspan="2"> <b> Dengan ini menyatakan bahwa sebelum mendapat pelayanan kesehatan di Rumah Sakit William Booth </b> </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td colspan='2'> 
                                    <table style="" width='100%'>

                                        <tr>
                                            <td width="10%"> I. </td>
                                            <td width="90%" colspan="2">  
                                                Saya bersedia mentaati peraturan rawat inap di Rumah Sakit William Booth Surabaya
                                                sesuai dengan ketentuan berlaku. 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> II. </td>
                                            <td colspan="2"> Saya bersedia membayar biaya yang timbul apabila Atas Permintaan Sendiri </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td colspan="2"> a. Memilih kelas perawatan yang lebih tinggi </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td colspan="2"> b. Memilih dokter di luar ketentuan yang berlaku di Rumah Sakit William Booth </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td colspan="2"> c. Memilih obat di luar ketentuan dan standart yang ditetapkan oleh BPJS </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td colspan="2"> d. Memilih pemeriksaan penunjang seperti laboratorium, radiologi, rehab medis, dll, di luar advis dokter</td>
                                        </tr>
                                        <tr>
                                            <td style="vertical-align: top"> III. </td>
                                            <td colspan="2"> Saya bersedia tidak membawa barang-barang berharga (seperti : perhiasan, elektronik, dll) 
                                                ke Rumah Sakit WILLIAM BOOTH Surabaya, tetapi jika saya membawanya, maka saya tidak menuntut Pihak Rumah Sakit WILLIAM BOOTH
                                                Surabaya untuk <b> <i> bertanggung jawab  </i> </b>terhadap kehilangan, kerusakan atau pencurian. 
                                            </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td colspan="2"> Demikian surat pernyataan ini saya buat dengan sebenarnya, dan saya tanda tangani 
                                                dengan penuh kesadaran dan tanggung jawab.  </td>
                                        </tr>
                                        <tr>
                                            <td colspan="3"> <br> </td>
                                        </tr>

                                        <tr>
                                            <td> </td>
                                            <td colspan="2"> 
                                                Surabaya  <br>
                                                <?php
                                                echo date('d/m/Y H:i:s', strtotime($modSurat->tgl_pernyataan));
                                                $modSurat->tgl_pernyataan = date('d/m/Y H:i:s');
                                                ?>

                                            </td>
                                        </tr>
                                        <tr>
                                            <td> </td>
                                            <td width='90%' colspan="2">
                                                <table width='100%'>
                                                    <tr>
                                                        <td style="text-align: center"> Mengetahui </td>
                                                        <td> </td>
                                                        <td> </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center"> Petugas Rumah Sakit </td>
                                                        <td style="text-align: center"> Saksi Pihak Keluarga </td>
                                                        <td style="text-align: center"> Yang membuat pernyataan </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td style="text-align: center"> <?= $modSurat->petugas->namaLengkap ?> </td>
                                                        <td style="text-align: center"> <?= $modSurat->saksi_pihakkeluarga ?> </td>
                                                        <td style="text-align: center"> <?= $modSurat->pihak_buatpernyataan ?> </td>
                                                    </tr>
                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>

                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>

    </tr>
</table>
