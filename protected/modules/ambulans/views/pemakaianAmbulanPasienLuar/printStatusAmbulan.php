<style>
    .barcode-label{
        margin-top:-20px;
        z-index: 1;
        text-align: center;
        letter-spacing: 10px;
    }
</style>

    <table>
        <tr>
            <td>
                <?php echo $this->renderPartial('application.views.headerReport.headerDefault'); ?>
            </td>
        </tr>
    </table>
    <table class="status">
        <tr>
            <td align="center" valig="middle" colspan="3">
                <b><?php echo $judul_print ?></b>
            </td>
        </tr>
         <tr>
            <td align="center" valig="middle" colspan="3">
                 Data Pasien
            </td>
        </tr>

        <tr>
            <td>Nama Pasien</td>
            <td>:</td>
            <td><?php echo $modPemakaian->namapasien ?></td>
        </tr>
        <tr>
            <td>Tanggal Pemakaian</td>
            <td>:</td>
            <td><?php echo $modPemakaian->tglpemakaianambulans ?></td>
        </tr>
        <tr>
            <td>Paramedis 1</td>
            <td>:</td>
            <td><?php echo isset($modPemakaian->paramedis1->NamaLengkap)? $modPemakaian->paramedis1->NamaLengkap : ""; ?></td>
        </tr>
        <tr>
            <td>Paramedis 2</td>
            <td>:</td>
            <td><?php echo isset($modPemakaian->paramedis2->NamaLengkap)? $modPemakaian->paramedis2->NamaLengkap : ""; ?></td>
        </tr>
        <tr>
            <td>Alamat</td>
            <td>:</td>
            <td><?php echo $modPemakaian->alamattujuan; ?></td>
        </tr>
        <tr>
            <td>Mobil Ambulans</td>
            <td>:</td>
            <td><?php echo $modPemakaian->mobil->mobilambulans_kode ?></td>
        </tr>
        <tr>
            <td>Total Tarif</td>
            <td>:</td>
            <td><?php echo MyFormatter::formatNumberForPrint($modPemakaian->totaltarifambulans); ?></td>
        </tr>        
    </table>
    <div style="border: 0 solid;margin-top: 10px;text-align:center;width:200px;">
        <img style="height: 64px;" src="index.php?r=barcode/myBarcode&code=<?php echo $modPemakaian->pemakaianambulans_id; ?>&is_text=">  
        <div class="barcode-label"><?php echo $modPemakaian->pemakaianambulans_id; ?></div>
    </div>