<?php 
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 */
?>
<table class="table table-bordered table-striped table-condensed">
    <thead>
        <tr>
            <th> No. </th>
            <th> Penyedia </th>
            <th> Alamat </th>
            <th> Nama Direktur</th>
            <th> Contact Person </th>
            <th> Nomor Telepon </th>
            <th> Email </th>
        </tr>
    </thead>
    <tbody>
        <?php 
            $no = 1;
            $modPenyedia = PenawaranpenyediaT::model()->findAllByAttributes(array('persiapanpengadaan_id' => $_GET['id'])); 
            foreach ($modPenyedia as $i => $penyedia){ 
        ?>
        <tr>
            <td> <?php echo $no++; ?></td>
            <td> <?php echo $penyedia->penyedia->penyedia_nama;?></td>
            <td> <?php echo $penyedia->penyedia->penyedia_alamat;?></td>
            <td> <?php echo $penyedia->penyedia->penyedia_direktur;?></td>
            <td> <?php echo $penyedia->penyedia->penyedia_cp;?></td>
            <td> <?php echo $penyedia->penyedia->penyedia_telepon;?></td>
            <td> <?php echo $penyedia->penyedia->penyedia_email;?></td>
        </tr>
        <?php } ?>
    </tbody>
</table>