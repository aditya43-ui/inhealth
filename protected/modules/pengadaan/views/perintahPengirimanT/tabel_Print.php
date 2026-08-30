<?php echo $this->renderPartial('application.views.headerReport.headerBeritaAcara');?>
                    <br>
<div class="row-fluid">
        <table width="100%">
            <tr>
                <td width="90%" style="vertical-align:top; text-align: justify"><?php echo !empty($model->dasar) ? $model->dasar : "";?></td>
            </tr>
        </table>
    </div>
<br>
    <div class="row-fluid" >
        <table width="100%" class="ttd">
            <tr>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center" style="font-size: 16px !important;">Menerima dan menyetujui</td>
                        </tr>
                        <tr>
                            <td align="center" style="font-size: 16px !important;"> <b> Penyedia Barang / Jasa</b> <br><?php echo $model->supplier->supplier_nama ?></td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr >
                            <td align="center" style="font-size: 16px !important;">
                                <b><u> <?php echo $model->supplier->direktursupplier ?> </u></b> <br> 
                                Direktur
                            </td>
                        </tr>
                    </table>
                </td>
                <td width="50%" align="center">
                    <table>
                        <tr>
                            <td align="center" style="font-size: 16px !important;">Surabaya, <?php echo date('d ', strtotime(date("Y-m-d"))) . MyFormatter::getMonthId(date('m', strtotime(date("Y-m-d")))) . date(' Y', strtotime(date("Y-m-d"))) ?></td>
                        </tr>
                        <tr>
                            <td align="center" style="font-size: 16px !important;"> <b> Pejabat Pembuat Komitmen </b> <br><?php echo "RSUD Dr. SOETOMO Surabaya" ?></td>
                        </tr>
                        <tr>
                            <td height="85px"> </td>
                        </tr>
                        <tr>
                            <td align="center" style="font-size: 16px !important;"> 
                                <b><u> <?php echo $model->pegppk->namaLengkap ?> </u></b><br>
                                NIP. <?php echo $model->pegppk->nomorindukpegawai; ?>
                            </td>
                        </tr>
                    </table>
                </td>
            </tr>
        </table>
    </div>