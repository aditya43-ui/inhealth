<style>

    .table-isi {
        width: 100%;
        font-size: 20px;
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
        height: 55px;
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
        vertical-align: middle !important;
        width: 170px;
    }



</style>

<table class="table-isi">
    
    <tbody>
        <tr class="row_atas">
                <th>NAMA DOKTER</th>
                <th>SENIN</th>
                <th>SELASA</th>
                <th>RABU</th>
                <th>KAMIS</th>
                <th>JUMAT</th>
                <th>SABTU</th>
        </tr>
        <?php 
        
        foreach ($tabel['ruangan'] as $key => $value) { ?>
            <tr class="row_ruangan">
                <td colspan="7"><?= strtoupper($value['ruangan_nama']) ?></td>
            </tr>
            <?php 
                foreach ($value['det'] as $key2 => $value2) { ?>
                    <tr class="row_detail">
                        <td><div>
                            <?php 
                            if (!empty($value2['url_foto'])) {
                                $url = $value2['url_foto'];
                                echo CHtml::image($url, '', array(
                                    'style'=>'height: 50px; vertical-align: middle; float:left: margin-left: 5px;',
                                ));
                            } else {

                                $url = Yii::app()->getBaseUrl('webroot')."/images/dokter/";
                                if ($value2['jeniskelamin'] == "LAKI-LAKI") {
                                    $url .= "dr_pria.png";
                                } else {
                                    $url .= "dr_wanita.png";
                                }
                                echo CHtml::image($url, '', array(
                                    'style'=>'height: 50px; vertical-align: middle; float:left: margin-left: 5px;',
                                ));
                            }

                            ?>
                            <?= $value2['nama_pegawai'] ?>
                        <div></td>
                        <td class="counter"><div><?= !empty($value2['item_id'][1]['jam']) ? $value2['item_id'][1]['jam'] : '&nbsp'?><div></td>
                        <td class="counter"><div><?= !empty($value2['item_id'][2]['jam']) ? $value2['item_id'][2]['jam'] : '&nbsp'?><div></td>
                        <td class="counter"><div><?= !empty($value2['item_id'][3]['jam']) ? $value2['item_id'][3]['jam'] : '&nbsp'?><div></td>
                        <td class="counter"><div><?= !empty($value2['item_id'][4]['jam']) ? $value2['item_id'][4]['jam'] : '&nbsp'?><div></td>
                        <td class="counter"><div><?= !empty($value2['item_id'][5]['jam']) ? $value2['item_id'][5]['jam'] : '&nbsp'?><div></td>
                        <td class="counter"><div><?= !empty($value2['item_id'][6]['jam']) ? $value2['item_id'][6]['jam'] : '&nbsp'?><div></td>
                    </tr>
                <?php }
            ?>
        <?php } ?>
    </tbody>
</table>