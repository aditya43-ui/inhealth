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

.table-isi .row_detail td>div {
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
            <th>NAMA PASIEN<br />NO RM/TGL LAHIR</th>
            <th>JENIS RESEP</th>
            <th>STATUS</th>
        </tr>
        <?php 
        if(isset($tabel['pasien_id']) && !empty($tabel['pasien_id'])) {
        foreach ($tabel['pasien_id'] as $key => $value) { ?>

        <?php
            
            $antrianresep = [];
            $rowspan = 1;

            $antrian_id = $value['antrianfarmasi_id'];

            if($antrian_id != '') {
                $anres = Antrianreseptur::model()->findAll("antrianfarmasi_id = $antrian_id");

                if(!empty($anres)) {
                    $rowspan = count($anres);
                    
                    foreach($anres as $ar) {
                        array_push($antrianresep, $ar->reseptur_id);
                    }
                }
            }     
            
            ?>

        <?php if(count($antrianresep) < 1) {?>

        <tr class="row_detail">
            <?php

                    if(($value['statusobat']!='SUDAH')){
                    
                                    ?>
            <td class="counter" rowspan="<?= $rowspan ?>">
                <div>
                    <?= $value['nama_pasien'] ?><br />
                    <?= $value['no_rekam_medik'] ?> /
                    <?= date("d/m/Y",strtotime($value['tanggal_lahir'])) ?><br />
                </div>
            </td>
            <!-- <td class="counter"><div><?php //date("d/m/Y",strtotime($value['tanggal_lahir'])) ?><div></td> -->
            <td class="counter">
                <div><?= $value['racikan_nama'] ?>
                    <?php 
                                    foreach($value['obat'] as $item) {
                                        // echo '<br/>';
                                    } ?>
                </div>
            </td>
            
            <td class="counter">
                <div>
                    <?php
                                            echo $value['statusobat'];
                                        // foreach($value['obat'] as $item) {
                                        //     echo $item['statusobat']."<br/>";
                                        // }
                                        
                                        ?>
                    <?php 
                                    foreach($value['obat'] as $item) {
                                        // echo '<br/>';
                                    } ?>
                </div>
            </td>
            <?php } ?>
        </tr>

        <?php } else { ?>

        <?php

        if(($value['statusobat']!='SUDAH')){

                        ?>
        <tr class="row_detail">

            <td class="counter" rowspan="<?= $rowspan ?>">
                <div>
                    <?= $value['nama_pasien'] ?><br />
                    <?= $value['no_rekam_medik'] ?> /
                    <?= date("d/m/Y",strtotime($value['tanggal_lahir'])) ?><br />
                </div>
            </td>

            <?php foreach($antrianresep as $i => $ar):?>

                <?php

                    $crit = new CDbCriteria();
                    $crit->select = 'r.reseptur_id, t.obatalkespasien_id, t.penjualanresep_id, t.racikan_id,
                                     p.statusobat, rc.racikan_nama, o.obatalkes_nama, t.qty_oa, t.signa_oa';
                    $crit->join = ' join penjualanresep_t p on p.penjualanresep_id = t.penjualanresep_id
                                    join reseptur_t r on r.reseptur_id = p.reseptur_id 
                                    join racikan_m rc on rc.racikan_id = t.racikan_id 
                                    join obatalkes_m o on o.obatalkes_id = t.obatalkes_id';
                    $crit->group = $crit->select;
                    $crit->addCondition("r.reseptur_id = $ar");

        
                    $resp = FAObatalkesPasienT::model()->findAll($crit);

                    
                ?>


                <?php if($i == 0):?>
                    <td class="counter">
                <div>
                <?= !empty($resp) ? $resp[0]->racikan_nama : '-' ?>
                </div>
            </td>
            
            <td class="counter2">
                <div>
                    <?= !empty($resp) ? $resp[0]->statusobat : '-' ?>
                </div>
            </td>
        </tr>
                <?php else:?>
                    <tr class="row_detail">
                    <td class="counter">
                <div>
                    <?= !empty($resp) ? $resp[0]->racikan_nama : '-' ?>
                </div>
            </td>
            <td class="counter2">
                <div>
                <?= !empty($resp) ? $resp[0]->statusobat : '-' ?>
                </div>
            </td>
        </tr>

                <?php endif;?>
            <?php endforeach;?>
        <?php } ?>

        <?php } ?>



        <?php }
            ?>
        <?php } ?>
    </tbody>
</table>