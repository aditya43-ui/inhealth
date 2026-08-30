
<table class="table table-striped" id="tbl-awaldialisis">
    <tr>
        <th>Tgl.Pendaftaran/No.Pendaftaran</th>
        <th>Waktu Pemeriksaan</th>
        <th>Dokter Pemeriksa</th>
        <th>Konsultan Nefrologi</th>
        <th>Diagnosis Masuk RS</th>
        <th>Lihat</th>
        <th>Ubah</th>
        <th>Hapus</th>
        <th>Cetak</th>
        <th>Salin</th>
    </tr>
    <?php if(!empty($modAwalDialisis)) : ?>
    <?php
        $module = $this->module->id;
        $umur = explode(" ", $modPendaftaran->umur);
        if((int)$umur[0] <= 18){
            $asesmen = 'asesmenAwalMedisAnakHD';
        }else{
            $asesmen = 'asesmenAwalMedisDewasaHD';
        }
    ?>
    <?php foreach($modAwalDialisis as $row) : ?>
    <tr>
        <td>
            <?= CHtml::hiddenField('data-tanggal', $row->tgl_pemeriksaan, []); ?>
            <?= CHtml::hiddenField('data-nadi', $row->nadi, []); ?>
            <?= CHtml::hiddenField('data-suhu', $row->suhu, []); ?>
            <?= MyFormatter::formatDateTimeId($modPendaftaran->tgl_pendaftaran) ."/".$modPendaftaran->no_pendaftaran ?>
        </td>
        <td>
            <?= MyFormatter::formatDateTimeId($row->tgl_pemeriksaan) ?>
        </td>
        <td>
            <?= !empty($row->dokterpemeriksa_id) ? $row->dokterpemeriksa->nama_pegawai : '' ?>
        </td>
        <td>
            <?= !empty($row->konsultan_nefrologi_id) ? $row->konsultannefrologi->nama_pegawai : '' ?>
        </td>
        <td>
            <?= !empty($row->diagnosa_id) ? $row->diagnosa->diagnosa_nama : '' ?>
        </td>
        <td><center>
            <?php
                $urldetail = $module."/".$asesmen."/index&pendaftaran_id=".$_GET['pendaftaran_id']."&id=".$row->asesmen_awal_medis_id."&mode=view&detail=1&from=asesmenulang";
                echo CHtml::Link("<i class='icon icon-eye-open'></i>","#",array("title" => "Detail", "class"=>"", "onclick"=>"setAsesmen('".$urldetail."')","rel"=>"tooltip",));
             ?>
        </center>
        </td>
        <td>
            <center>
            <?php
                $urlubah = $module."/".$asesmen."/index&pendaftaran_id=".$_GET['pendaftaran_id']."&id=".$row->asesmen_awal_medis_id."&detail=1&from=asesmenulang";
                echo CHtml::Link("<i class='icon icon-pencil'></i>","#",array("title" => "Ubah", "class"=>"", "onclick"=>"setAsesmen('".$urlubah."')","rel"=>"tooltip",));
             ?>
        </center>
        </td>
        <td>
            <center><a onclick="hapusRiwayat('<?php echo $row->asesmen_awal_medis_id; ?>');return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Riwayat Asesmen Awal Dialisis"><i class="entypo-trash"></i></a></center>
        </td>
        <td>
            <?php
                echo CHtml::link(Yii::t('mds', '{icon}', 
                array('{icon}'=>'<i class="icon-print"></i>')), 
                    'javascript:void(0);', array('class'=>'',
                    'onclick'=>"print($row->asesmen_awal_medis_id);return false"))."&nbsp;";
            ?>
        </td>
        <td><center>
             <?php
                $urlsalin = $module."/".$asesmen."/index&pendaftaran_id=".$_GET['pendaftaran_id']."&id=".$row->asesmen_awal_medis_id."&salin_id=1&detail=1&from=asesmenulang";
                echo CHtml::Link("<i class='icon icon-list'></i>","#",array("title" => "Salin", "class"=>"", "onclick"=>"setAsesmen('".$urlsalin."')","rel"=>"tooltip",));
             ?>
        </center>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
</table>