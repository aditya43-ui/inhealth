<table class="table table-bordered table-condensed" id="pilih-kantong">
    <thead>
        <tr>
            <th>No.</th>
            <th>Jenis Kantong Darah</th>
            <th>No. Kantong Darah</th>
            <th>Tanggal Pembuatan </th>
            <th>Petugas Pencatatan</th>
            <th>Batal</th>
        </tr>
    </thead>
    <?php 
        $modKantong = KantongdarahT::model()->findByAttributes(array('pendonor_id' => $modPendonor->pendonor_id, 'daftarpendonor_id' => $_GET['daftardonasi_id']));
        if(!empty($modKantong)) { ?>
    <tbody>
        <tr>
            <td> <?php echo 1; ?></td>
            <td> <?php echo $modKantong->jeniskantongdarah->nama_jenis ?></td>
            <td> <?php echo $modKantong->no_kantongdarah ?></td>            
            <td> <?php echo MyFormatter::formatDateTimeForUser($modKantong->tglpencatatan); ?> </td>
            <td> <?php echo $modKantong->petugaspencatat->namaLengkap; ?> </td>
            <td> <?php  echo CHtml::link('<span style="font-size:30px;color:red;"><i class="entypo-cancel"></i></span>', 'javascript:;', array(
            'onclick'=>'hapusKantong(this);'
        )); ?> </td>
        </tr>
    </tbody>
    <?php
        }
    ?>
</table>