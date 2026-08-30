<table class="table table-striped">
    <tr>
        <th>Tgl.pendaftaran/No.pendaftaran</th>
        <th>Tgl. Informed to Consent</th>
        <th>Jenis Inform To Consent</th>
        <th>Dokter</th>
        <th>Ubah</th>
        <th>Lihat</th>
        <th>Hapus</th>
        <th>Cetak</th>
        <th>Salin</th>
    </tr>
    <?php 
    if(count($loadRiwayat) > 0) :
        foreach($loadRiwayat as $row) : 
    ?>
    <tr>
        <td>
            <?= $modPendaftaran->tgl_pendaftaran.'/'.$modPendaftaran->no_pendaftaran; ?>
        </td>
        <td>
            <?= MyFormatter::formatDateTimeId($row->waktu); ?>
        </td>
        <td>
            <?= ($row->f_hd == true) ? "<span class='required'>Akut</span>" : "Reguler"; ?>
        </td>
        <td>
            <?php
                $dokter = PegawaiM::model()->findByPk($row->dokteri_id);
                echo $dokter->nama_pegawai;
            ?>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-eye-open'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'informtoconsent_hd_id'=>$row->informtoconsent_hd_id)); 
			?>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='fa fa-copy'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'informtoconsent_hd_id'=>$row->informtoconsent_hd_id, 'mode'=>'view')); 
			?>
        </td>
        <td>
            <center><a onclick="hapusInformed('<?php echo $row->informtoconsent_hd_id; ?>');return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Riwayat Informed to Consent"><i class="entypo-trash"></i></a></center>
        </td>
        <td>
            <?php
                echo CHtml::link(Yii::t('mds', '{icon}', 
                array('{icon}'=>'<i class="icon-print"></i>')), 
                    'javascript:void(0);', array('class'=>'',
                    'onclick'=>"print(".$modPendaftaran->pendaftaran_id.",".$row->informtoconsent_hd_id.");return false"))."&nbsp;";
            ?>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-eye-open'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'informtoconsent_hd_id'=>$row->informtoconsent_hd_id, 'salin'=>'salin')); 
			?>
        </td>
    </tr>
    <?php 
        endforeach;
    endif; 
    ?>
</table>
<script>
    function hapusInformed(id){
        myConfirm('Apakah anda yakin akan menghapus data ini ?', 'Perhatian!', function(r){
            if(r){
                $.ajax({
                    url: '<?= $this->createUrl('hapusInformed') ?>',
                    dataType: 'json',
                    type: 'post',
                    data: {id:id},
                    success: function(data){
                        if(data.sukses == 1){
                            toastr.success(data.pesan,"Perhatian");
                            location.href = "<?= $this->createUrl('index&pendaftaran_id=').$_GET['pendaftaran_id'] ?>";
                        }else{
                            toastr.error(data.pesan,"Perhatian");
                        }
                    },
                    error: function(jqXHR, textStatus, errorThrown){
                        
                    }
                })
            }
        })
    }
</script>
