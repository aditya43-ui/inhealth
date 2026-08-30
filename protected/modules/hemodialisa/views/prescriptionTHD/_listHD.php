<table class="table table-striped">
    <tr>
        <th>Tgl.pendaftaran/No.pendaftaran</th>
        <th>Waktu Prescription Dokter</th>
        <th>DPJP</th>
        <th>Prescription Dokter</th>
        <th>Lihat</th>
        <th>Ubah</th>
        <th>Hapus</th>
        <th>Cetak</th>
        <th>Salin</th>
    </tr>
    <?php if(count($loadRiwayat) > 0) : ?>
    <?php foreach ($loadRiwayat as $row) : ?>
    <tr>
        <td><?= $modPendaftaran->tgl_pendaftaran.'/'.$modPendaftaran->no_pendaftaran; ?></td>
        <td><?= MyFormatter::formatDateTimeId($row->waktu_prescription); ?></td>
        <td><?php 
                $peg = PegawaiM::model()->findByPk($row->dpjp_id);
                echo !empty($peg)?$peg->namaLengkap:''; 
        ?></td>
        <td><?php
            if($row->prescription_dokter_akut == true){
                echo "Akut";
            }elseif($row->prescription_dokter_kronis == true){
                echo "Kronis";
            }elseif($row->prescription_dokter_pirrt == true){
                echo "PIRRT";
            }else{
                echo "";
            }
        ?></td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-eye-open'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'prescription_id'=>$row->prescription_hd_id, 'mode'=>'view')); 
			?>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-pencil'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'prescription_id'=>$row->prescription_hd_id)); 
			?>
        </td>
        <td>
            <center><a onclick="hapusPrescription('<?php echo $row->prescription_hd_id; ?>');return false;" rel="tooltip" href="javascript:void(0);" title="Klik untuk menghapus Riwayat Prescription"><i class="entypo-trash"></i></a></center>
        </td>
        <td>
            <?php
                echo CHtml::link(Yii::t('mds', '{icon}', 
                array('{icon}'=>'<i class="icon-print"></i>')), 
                    'javascript:void(0);', array('class'=>'',
                    'onclick'=>"print(".$modPendaftaran->pendaftaran_id.",".$row->prescription_hd_id.");return false"))."&nbsp;";
            ?>
        </td>
        <td>
            <?php
            echo CHtml::link("<i class='icon-pencil'></i>", array($this->id.'/index', 'pendaftaran_id'=>$_GET['pendaftaran_id'], 'prescription_id'=>$row->prescription_hd_id, 'salin_id'=>$row->prescription_hd_id)); 
			?>
        </td>
    </tr>
    <?php endforeach; ?>
    <?php endif; ?>
</table>

<script>
    function hapusPrescription(id){
        myConfirm('Apakah anda akan menghapus data ini ?', 'Perhatian!', function(r){
            if(r){
                $.ajax({
                    url: '<?= $this->createUrl('hapusPrescription') ?>',
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

