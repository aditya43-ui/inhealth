<style>

    .table-isi {
        width: 100%;
        font-size: 17px;
        border: none;
        color: #060;
        background-color: #ddd;
    }

    .table-isi td {
        padding: 2px;
        background-color: #ddd !important;
        vertical-align: top !important;
    }

    .table-isi .row_detail td > div {
        padding: 4px;
        background-color: white !important;
        height: auto;
        min-height: 50px;
        border-radius: 4px;
        font-weight: bold;
    }

    .table-isi th {
        padding: 5px;
        color: white;
        background-color: #060 !important;
        vertical-align: top !important;
    }

    .table-isi .row_ruangan td {
        background-color: #060 !important;
        color: white;
        text-align: left;
        font-weight: bold;
        font-style: italic;
        font-size: 17px;
        padding: 5px;
    }

    .table-isi .row_atas th {
        font-size: 20px;
        text-align: center;
        background-color: white;
        position: -webkit-sticky;
        position: sticky;
        top: 0;
        z-index: 2;
    }

    .counter {
        text-align: center;
        width: 140px;
    }
    .counter2 {
        text-align: center;
        width: 240px;
        clear: both;
    }



</style>

<table class="table-isi">
    
    <tbody>
        <tr class="row_atas">
                <th>NAMA PASIEN<br/>NO RM/TGL LAHIR</th>
                <th>JENIS RESEP</th>
                <th>NAMA OBAT</th>
                <th>STATUS</th>
        </tr>
        <?php 
        if(isset($tabel['pasien_id']) && !empty($tabel['pasien_id'])) {
        foreach ($tabel['pasien_id'] as $key => $value) { ?>
            <?php 
                // foreach ($tabel['det'] as $key2 => $value2) { ?>
                    <tr class="row_detail">
                        <?php

        if(($value['statusobat']!='SUDAH')){
                        ?>
                        <td class="counter"><div>
                            <?= $value['nama_pasien'] ?><br/>
                            <?= $value['no_rekam_medik'] ?> /
                            <?= date("d/m/Y",strtotime($value['tanggal_lahir'])) ?>

                        <div></td>
                        <!-- <td class="counter"><div><?php //date("d/m/Y",strtotime($value['tanggal_lahir'])) ?><div></td> -->
                        <td class="counter"><div><?= $value['racikan_nama'] ?>
                        <?php 
                        foreach($value['obat'] as $item) {
                            echo '<br/>';
                        } ?>
                        <div></td>
                        <td class="counter2"><div>
                            <?php
                            $no = '1';
                            foreach($value['obat'] as $item) {
                                echo $no.'. ' .$item['obatalkes_nama'].' ('.$item['qty_oa'].') '.$item['signa_oa']."<br/>";
                            
                                $no++;
                            }

                            ?>
                        <div></td>
                        <td class="counter"><div>
                            <?php
                                echo $value['statusobat'];
                            // foreach($value['obat'] as $item) {
                            //     echo $item['statusobat']."<br/>";
                            // }

                            ?>
                        <?php 
                        foreach($value['obat'] as $item) {
                            echo '<br/>';
                        } ?>
                            <div></td>
                        <?php } ?>
                    </tr>
                <?php }
            ?>
        <?php } ?>
    </tbody>
</table>