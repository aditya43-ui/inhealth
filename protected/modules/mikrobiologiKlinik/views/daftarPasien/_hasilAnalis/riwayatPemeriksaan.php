<style>
    .link_col {
        width: 60px !important;
        text-align: center !important;
    }
</style>

<table class="table table-striped table-bordered table-condensed" style="width: 100%;">
    <thead>
        <tr>
            <td style="width: 15%;">Tanggal Pemeriksaan</td>
            <td style="width: 10%;">No. Lab</td>
            <td style="width: 20%;">Jenis Pemeriksaan</td>
            <td style="width: 15%;">Pemeriksaan</td>
            <td style="width: 10%;">Lihat Detail</td>
            <td style="width: 10%;">Edit</td>
            <td style="width: 10%;">Salin</td>
            <td style="width: 10%;">Hapus</td>
        </tr>
    </thead>
    <tbody>

        <?php $mikro = KelompokpemeriksaanmikroT::model()->findAllByAttributes(array(
            'pasienmasukpenunjang_id'=>$model->pasienmasukpenunjang_id,
        ), array(
            'order'=>'tgl_pemeriksaan asc',
        )); 
        
        if (count($mikro) == 0) {
        ?>
        <tr>
            <td colspan="8">Data tidak ditemukan</td>
        </tr>
        <?php    
        }
        
        foreach ($mikro as $item): 

            $tindakan = TindakanpelayananT::model()->findByPk($item->tindakanpelayanan_id);
            $jns_pemeriksaan = !empty($tindakan) ? $tindakan->daftartindakan->daftartindakan_nama : ' - ';

            $onclick = "return false;";
            $onclickHapus = "return false;";
            $updateLink = "#";
            $copyLink = "#";
            if ($item->is_pemeriksaanpcr) {
                $onclick = "printRiwayatPCR(".$item->pemeriksaanpcr_id."); return false";
                $updateLink = $this->createUrl('pcrCovid', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'] ?? null, 'pasienmasukpenunjang_id' => $item->pasienmasukpenunjang_id, 'daftartindakan_id'=>$tindakan->daftartindakan_id, 'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id, 'pemeriksaanpcr_id'=>$item->pemeriksaanpcr_id));
                $copyLink = $this->createUrl('pcrCovid', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'] ?? null, 'pasienmasukpenunjang_id' => $item->pasienmasukpenunjang_id, 'daftartindakan_id'=>$tindakan->daftartindakan_id, 'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id, 'pemeriksaanpcr_id_copy'=>$item->pemeriksaanpcr_id));
                $onclickHapus = "hapusRiwayatPCR(".$item->pemeriksaanpcr_id.", this); return false";
            }


        ?>
        <tr>
            <td><?php echo MyFormatter::formatDateTimeForUser($item->tgl_pemeriksaan); ?></td>
            <td><?php echo $item->no_lab; ?></td>
            <td><?php echo $jns_pemeriksaan; ?></td>
            <td>
                <center>
                    <div class="btn-group mr-2" role="group" aria-label="Pemeriksaan">
                        <?php echo !$item->is_pemeriksaankultur ? "" : CHtml::link('Kultur', $this->createUrl('pemeriksaanKultur', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id, 'jenispemeriksaanlab_id' => $tindakan->jenispemeriksaanlab_id,  'pemeriksaan' => 'kultur')), array('class' => 'btn btn-grey')); ?>
                        <?php echo !$item->is_pemeriksaanpewarnaan ? "" : CHtml::link('Pewarnaan Langsung', $this->createUrl('pewarnaanLangsung', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id, 'jenispemeriksaanlab_id' => $tindakan->jenispemeriksaanlab_id)), array('class' => 'btn btn-blue')); ?>
                        <?php echo !$item->is_pemeriksaancci ? "" : CHtml::link('CCI', $this->createUrl('cci', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id, 'jenispemeriksaanlab_id' => $tindakan->jenispemeriksaanlab_id)), array('class' => 'btn btn-green')); ?>
                        <?php echo !$item->is_pemeriksaanpcr ? "" : CHtml::link('PCR COVID', $this->createUrl('pcrCovid', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id, 'daftartindakan_id'=>$tindakan->daftartindakan_id, 'tindakanpelayanan_id'=>$tindakan->tindakanpelayanan_id, 'jenispemeriksaanlab_id' => $tindakan->jenispemeriksaanlab_id)), array('class' => 'btn btn-orange')); ?>
                        <?php echo !$item->is_pemeriksaanviralload ? "" : CHtml::link('VIRAL LOAD', $this->createUrl('viralLoad', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id)), array('class' => 'btn btn-red')); ?>
                        <?php echo !$item->is_pemeriksaantbc ? "" : CHtml::link('TBC', $this->createUrl('Tbc', array('penilaian_kelayakan_spesimen_id' => $_GET['penilaian_kelayakan_spesimen_id'], 'pasienmasukpenunjang_id' => $model->pasienmasukpenunjang_id)), array('class' => 'btn btn-blue-rev')); ?>
                    </div>
                </center>
            </td>
            <td class="link_col"><?php echo CHtml::link('<i class="icon-form-print"></i>', '#', array('onclick'=>$onclick)); ?></td>
            <td class="link_col"><?php echo CHtml::link('<i class="icon-form-ubah"></i>', $updateLink, array('rel'=>'tooltip', 'title'=>'Klik untuk mengubah hasil pemeriksaan')); ?></td>
            <td class="link_col"><?php echo CHtml::link('<i class="icon-form-copy"></i>', $copyLink, array('rel'=>'tooltip', 'title'=>'Klik untuk salin/duplikat hasil pemeriksaan')); ?></td>
            <td class="link_col"><?php echo CHtml::link('<i class="icon-form-silang"></i>', '#', array('onclick'=>$onclickHapus, 'rel'=>'tooltip', 'title'=>'Klik untuk hapus hasil pemeriksaan')); ?></td>
        </tr>
        <?php endforeach; ?>

        
    </tbody>
</table>

<script>
    function printRiwayatPCR(id) {
        console.log(id, '<?php echo $this->createUrl('printPcr'); ?>&pemeriksaanpcr_id=' + id);
        window.open(
            '<?php echo $this->createUrl('printPcr'); ?>&pemeriksaanpcr_id=' + id,
            'printwin', 'left=100,top=100,width=640,height=480');
    }

    function hapusRiwayatPCR(id, obj) {
        myConfirm('Anda yakin untuk menghapus hasil pemeriksaan ini ?', 'Peringatan', function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('hapusPcr'); ?>', {id: id}, function(data) {
                    if (data.ok == 1) {
                        $(obj).parents("tr").remove();
                        myAlert(data.msg);
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
</script>