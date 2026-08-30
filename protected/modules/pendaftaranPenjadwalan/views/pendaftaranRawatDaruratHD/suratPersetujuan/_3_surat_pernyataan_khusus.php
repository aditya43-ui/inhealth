
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
                                <?= $this->renderPartial($this->path_viewRD2 . '/suratPersetujuan/_0_defaultSurat', ['judulLaporan' => $judulLaporan, 'modPenanggungJawab' => $modPenanggungJawab, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran]) ?>
                            </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td colspan="2"> Saya bersedia membayar biaya yang timbul apabila <b> <u>Atas Permintaan Sendiri</u></b>: </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td colspan="2"> 

                                <table width="100%" id="tabelKhusus">
                                    <?php
                                    $i = 1;
                                    if (!empty($loadData)) {
                                        foreach ($loadData as $key => $det) {
                                            ?>
                                            <tr>
                                                <td> <?= $i++ ?>. </td>
                                                <td> 
                                                    <?= !empty($det['formpernyataankhusus_nama']) ? $det['formpernyataankhusus_nama'] : $det['lainlain'] ?> 
                                                </td>
                                                <td> 
                                                    <?php if($det['suratpernyataankhusus_checklist'] == 1) { ?>
                                                    <span class="fa fa-check-square-o"> &#10003; </span> 
                                                    <?php } else { ?>
                                                    <span class="fa fa-square-o"></span> &#9634;
                                                        
                                                    <?php } ?>
                                                </td>
                                            </tr>
                                            <?php
                                        }
                                    }
                                    ?>
                                </table>
                            </td>
                        </tr>
                        <tr>
                            <td> </td>
                            <td colspan='2'> 
                                <table style="" width='100%'>
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
