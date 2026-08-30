<style>

    .table {
        border-collapse: collapse;
    }

    .table td, .table th {
        border: 1px solid black !important;
        text-align: center;
        vertical-align: middle;
    }
    
    .table td {
        color: black;
    }
    
    @media all {
        .page-break { display: none;}
    }

    @media print {
        .page-break { display: block;page-break-before: always;}
    }
</style>
<?php
if (!empty($tabel)) {
    foreach ($tabel as $det) {
        ?>
        <?php
        if (!empty($det['init'])) {
            foreach ($det['init'] as $key => $det2) {
                ?>
                <h3 style="text-align: center"> <?= strtoupper(MyFormatter::getDayName($det['tanggal']) . ", " . MyFormatter::formatDateTimeId($det['tanggal'])) ?> </h3>
                <?php
                if ($key == 1 || $key == 2) {
                    $modShift = ShiftHdM::model()->findByPk(Params::SHIFT_HD_PAGI);
                } else {
                    $modShift = ShiftHdM::model()->findByPk(Params::SHIFT_HD_SIANG);
                }
                echo "<b> Shift " . $modShift->shift_hd_nama . " </b> ";
                ?>
                <table width="100%" class="lapdpaunit table table-bordered">
                    <thead> 
                        <tr> 
                            <th rowspan="2"> No. </th>
                            <th rowspan="2"> RM</th>
                            <th rowspan="2"> TTL</th>
                            <th rowspan="2"> Nama </th>
                            <th rowspan="2"> L/P</th>
                            <th colspan="3"> Jaminan</th>
                            <th colspan="6"> Virus</th>
                        </tr>
                        <tr> 
                            <th> BPJS</th>
                            <th> Umum </th>
                            <th> Jamkesda</th>
                            <th> B</th>
                            <th> C</th>
                            <th> HIV</th>
                            <th> HCV</th>
                            <th> HBsAG</th>
                            <th> Covid</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php
                        if (!empty($det2['detail'])) {
                            $i = 1;
                            foreach($det2['detail'] as $det3) {
                                if (!empty($det3['jadwalhemodialisa_id'])) { ?>
                        <tr>
                            <td> <?= $i++; ?></td>
                            <td> <?= $det3['no_rekam_medik'] ?></td>
                            <td> <?= $det3['tanggal_lahir'] ?></td>
                            <td style="text-align: left"> <?= $det3['nama_pasien'] ?></td>
                            <td> <?= $det3['jeniskelamin'] ?></td>
                            <td> <?= $det3['bpjs'] ?></td>
                            <td> <?= $det3['umum'] ?></td>
                            <td> <?= $det3['jamkesda'] ?></td>
                            <td> <?= $det3['b'] ?></td>
                            <td> <?= $det3['c'] ?></td>
                            <td> <?= $det3['hiv'] ?></td>
                            <td> <?= $det3['hcv'] ?></td>
                            <td> <?= $det3['hbsag'] ?></td>
                            <td> <?= $det3['covid'] ?></td>
                        </tr>
                                <?php }
                            }
                        }
                        ?>
                    </tbody>
                </table>
                <div class="page-break "> </div>
                <?php
            }
        }
    }
}
?>