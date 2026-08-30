<?php

    $dok_1 = ['KTP', 'Kode ICD', 'Kepala List', 'Form Cairan', 'Diagnosa Tindakan', 'Nama Dokter Operasi', 'Tanda Tangan Dokter', 'Nama Pasien',
             'Tanda Tangan Pasien', 'Nama Saksi 1', 'Tanda Tangan Saksi 1', 'Nama Saksi 2', 'Tanda Tangan Saksi 2'];
    $attr_1 = [$model->ktp, $model->kodeicd, $model->kepalalist, $model->formcairan, $model->diagnosatindakan, $model->namadokteroperasi, $model->tandatangandokter,
                 $model->namapasien, $model->tandatanganpasien, $model->namasaksi1, $model->tandatangansaksi1, $model->namasaksi2, $model->tandatangansaksi2];

    $dok_2 = ['Discharge Sum', 'Form Operasi', 'Form Anestesi', 'Form Transfusi', 'Form Kematian', 'Form ASKEP', 'General Consent', 'Form IC'];
    $attr_2 = [$model->dischargesum, $model->formoperasi, $model->formanastesi, $model->formtransfusi, $model->formkematian, $model->formaskep, $model->generalconsent, $model->formic];

?>

<style>
.outer tr,
.outer td {
    border: 1px solid black;
}

.inner tr,
.inner td {
    border: 1px solid white;
    line-height: 30px;

}

.judul-hd {
    margin: 5px;
}

table tr,
table td {
    vertical-align: top;
}
</style>



<table style="width: 100%; margin: 5px; border: 1px solid black;" class="outer">
    <tr>
        <td style="font-size: 14pt;" colspan="">
            <p class="judul-hd">Kelengkapan Data Pasien Pulang</p>
        </td>
    </tr>
    <tr>
        <td style="width: 100%;">
            <p style="margin: 20px;">Tanggal Setor Dokumen RM&emsp;&emsp;&emsp;&emsp;&emsp;<?=$model->create_time?></p>
            <table style="width: 100%;" class="inner">
                <tr>
                    <td style="width: 50%;">
                        <table class="items table" style="width: 70%; margin: 20px; margin-top: 0px;">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No. </th>
                                    <th style="width: 60%;">Dokumen</th>
                                    <th>Checklist</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dok_1 as $i => $d1):?>
                                <tr>
                                    <td><?= $i + 1 ?></td>
                                    <td><?= $d1 ?></td>
                                    <td style="text-align: center;"><?=$attr_1[$i]?>
                                    </td>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </td>
                    <td>
                        <table class="items table" style="width: 70%; margin: 20px; margin-top: 0px;">
                            <thead>
                                <tr>
                                    <th style="width: 10%;">No. </th>
                                    <th style="width: 60%;">Dokumen</th>
                                    <th>Kelengkapan</th>
                                </tr>
                            </thead>
                            <tbody>
                                <?php foreach($dok_2 as $j => $d2):?>
                                <tr>
                                    <td><?= $j + 1 ?></td>
                                    <td><?= $d2 ?></td>
                                    <td style="text-align: center;"><?=$attr_2[$j]?>
                                </tr>
                                <?php endforeach;?>
                            </tbody>
                        </table>
                    </td>
                </tr>
            </table>
            <?php $this->renderPartial($this->path_view . '_checklistBerkas._dokumen_2Print', array('modPendaftaran' => $modPendaftaran, 'model' => $model));?>
        </td>
    </tr>
</table>