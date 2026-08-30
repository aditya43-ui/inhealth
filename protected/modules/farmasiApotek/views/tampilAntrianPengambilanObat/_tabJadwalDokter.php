<style>

    .table-isi {
        width: 100%;
        font-size: 17px;
        border: none;
        color: #060;
        background-color: #ddd;
    }

    .table-isi td {
        padding: 4px;
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
        padding: 10px;
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
<br> <br>
<table class="table-isi">
    
    <tbody>
        <tr class="row_atas">
                <th>NOMOR ANTRIAN</th>
                <th>NAMA PASIEN<br/>NO RM/TGL LAHIR</th>
                <th>DOKTER</th>
                <th>POLIKLINIK</th>
                <th>STATUS</th>
        </tr>
        <?php 
        if(isset($tabel['pasien_id']) && !empty($tabel['pasien_id'])) {
        foreach ($tabel['pasien_id'] as $key => $value) { ?>
            <?php 
                // foreach ($tabel['det'] as $key2 => $value2) { ?>
                    <tr class="row_detail">
                      
                        <?php
        if(($value['statusobat']='SUDAH')){
                        ?>
                        <?php
        // if(($value['tglpenyerahan']=date("d/m/Y",strtotime($value['tglpenyerahan'])))){
                        ?>
                        <td class="counter"><div>
                        <?php if($value['tgl_pendaftaran'] != null) {
                            echo $value['tgl_pendaftaran']; 
                             } else { ""; } ?><br/>
                        <?php echo $value['racikan_singkatan'] ?> - 
                        <?php echo $value['noantrian'] ?>
                            <div></td>
                        <td class="counter"><div>
                          <?= $value['nama_pasien'] ?><br/>
                            <?= $value['no_rekam_medik'] ?> /
                            <?= date("d/m/Y",strtotime($value['tanggal_lahir'])) ?>
                            <?php //$value['ketpenyerahan'] ?> 
                            <?php //date("d/m/Y",strtotime($value['tglpenyerahan'])) ?>

                        <div></td>
                        <!-- <td class="counter"><div><?php //date("d/m/Y",strtotime($value['tanggal_lahir'])) ?><div></td> -->
                        <td class="counter"><div>
                            <?php 
                            echo $value['gelardepan']." ".$value['nama_pegawai']." ".$value['gelarbelakang_nama'];
                            ?>
                        <div></td>
                        <td class="counter"><div>
                            <?php
                                echo $value['ruanganasal_nama'];
                            ?>
                        <div></td>
                        <td class="counter"><div>
                            <?php
                             if ($value['jumlah_dipanggil'] == 0){
                                 echo "BELUM DIPANGGIL";
                             }else if ($value['jumlah_dipanggil'] != 0 ){
                                 if ( $value['jumlah_dipanggil'] > 1){
                                echo "SUDAH DIPANGGIL".$value['jumlah_dipanggil']."X";
                                 }else{
                                    echo "BELUM DIPANGGIL";
                                 } 
                          } else {
                                echo " ";                                
                                
                             }
                            
                            ?>
                            <div></td>
                        <?php } ?>
                        <?php } ?>
                    </tr>
                <?php }
            ?>
        <?php //} ?>
    </tbody>
</table>