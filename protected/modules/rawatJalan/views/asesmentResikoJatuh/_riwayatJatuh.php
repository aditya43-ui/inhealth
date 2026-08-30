<?php 
/**
 * @author Aida Rahmawati <aidarahmawati@.com>
 * Halaman ini digunakan untuk menampilkan riwayat jatuh 
 */
?>
<table class="items table table-bordered table-striped table-condensed" id="tblListKonsul">
        <thead>
        <tr>
            <th>No.</th>
            <th>Tangal Pemeriksaan </th>
            <th>Skor Jatuh</th>
            <th> Keterangan </th>
            <th>Detail </th>
            <th>Petugas</th>
           
        </tr>
    </thead>
    <tbody> 
    <?php $no = 1; ?>
    <?php foreach ($modResikoJatuh as $i => $modJatuh) { ?>   
        <?php $pegawai_id = isset($modAsesmen['pegawai_id']) ? $modAsesmen['pegawai_id'] : ''; 
        
        if(isset($pegawai_id)) {
            $modPegawai = PegawaiM::model()->findByPk($pegawai_id);
        }
        
        ?>
        <tr>
            <td><?php echo $no++; ?></td>
            <td><?php echo MyFormatter::formatDateTimeForUser($modJatuh['tgl_skoring']); ?></td>
            <td><?php echo $modJatuh['totalskor']; ?></td>
            SKOR : 0 - 24 Tidak ada Resiko (TR), 25 - 44 Resiko Rendah (RR), >= 45 Resiko Tinggi
            <?php if ($modJatuh['totalskor'] >= 0 && $modJatuh['totalskor'] <= 24) { ?>
                <td><?php echo "Tidak Ada Resiko"?></td>
            <?php } else if ($modJatuh['totalskor'] >= 25 && $modJatuh['totalskor'] <= 44) { ?>
                <td><?php echo "Resiko Rendah"?></td>
            <?php } else { ?>
                <td><?php echo "Resiko Tinggi"?></td>
            <?php } ?>
                <td>
                    <?php echo CHtml::link('<i class=entypo-eye></i>',
                                Yii::app()->controller->createUrl("/rawatJalan/AsesmentResikoJatuh/detail",
                                        array("id" => $modJatuh->skoringresikojatuh_id)),
                                array(
                                    'class' => '',
                                    'target' =>'iframeDetail',
                                    'onclick'=>"{
                                        $(\"#dialogLihat\").dialog(\"open\");
                                    }"
                                ));
                        ?>
                </td>
            <td><?php echo isset($modJatuh->pegawai->namaLengkap) ? $modJatuh->pegawai->namaLengkap :" "; ?></td>
            
        </tr>
    <?php } ?>
    </tbody>
</table>

<?php
        // ===========================Dialog Resiko Jatuh =========================================
        $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
                'id'=>'dialogLihat',
                // additional javascript options for the dialog plugin
                'options'=>array(
                'title'=>'Detail Resiko Jatuh',
                'autoOpen'=>false,
                'modal'=>true,
                'width'=>1000,
                'height'=>500,
                'resizable'=>true,
                'scroll'=>false    
                 ),
        ));
        ?>
        <iframe name='iframeDetail' id='iframeDetail' style="width: 100%; height: 100%; border: none;"></iframe>
        <?php    
        $this->endWidget('zii.widgets.jui.CJuiDialog');
