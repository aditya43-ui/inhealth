<?php echo CHtml::css('#table-detailbarang thead tr th{vertical-align:middle;}'); ?>

<table class="table table-bordered table-striped table-condensed" id="table-detailbarang">
    <thead>
        <tr>           
             <th style="text-align: center;">No.</br>
                <?php  CHtml::checkBox('check_semua', true, array('rel' => 'tooltip', 'title' => 'Pilih semua', 'onkeypress' => "return $(this).focusNextInputField(event)", 'class' => 'checkbox-column', 'onclick' => 'checkAll()', 'checked' => 'checked')) ?>
            </th>
            <th>Spesimen ID</th>  
            <th>Nama Pasien</th>
            <th>No. Rekam Medik</th>
            <th>Ruangan Asal</th>       
            <th>Jenis Spesimen</th>
            <th>Jenis Pemeriksaan</th>
            <th>No Pengiriman</th>     
            <th>Waktu Pengiriman</th>     
            <th>Petugas Pengirim</th>  
            <th>Batal</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $no = 1;
        $nama_lengkap = '';
        $no_formulir = '';
        $jeniskantong_nama = '';
        $no_utama = '';
        $no_sampel = '';
        $i = 0;

        $row_arr = array();
        ?>
        <?php
        if (count($modKirimSpesimendetail) > 0) {

            foreach ($modKirimSpesimendetail as $data) {

                $no_utama = '';
                $no_sampel = '';
                $modSpesimen = SpesimenT::model()->findByPk($data->spesimen_id);
                $modTerimaSpesimenDet->spesimen_id = $data->spesimen_id;

                if (isset($modSpesimen)) {
                    $cekSample = SamplelabM::model()->findByPk($modSpesimen->samplelab_id);
                    if (!empty($cekSample)) {
                        $jenisspesimen_nama = $cekSample->samplelab_nama;
                    } else {
                        $jenisspesimen_nama = '-';
                    }
                    $row_arr[$modSpesimen->spesimen_id] = array(
                        'pengirimanspesimendet_id' => $data->pengirimanspesimendet_id,
                        'pasien_id' => $data->pasien_id,
                        'tindakanpelayanan_id' => $data->tindakanpelayanan_id,
                        'samplelab_id' => $data->samplelab_id,
                        'spesimen_id' => $modSpesimen->spesimen_id,
                        'no_spesimen' => $modSpesimen->no_spesimen,
                        'nama_pasien' => $modSpesimen->penilaianKelayakanSpesimen->pasienmasukpenunjang->pasien->nama_pasien,
                        'no_rekam_medik' => $modSpesimen->penilaianKelayakanSpesimen->pasienmasukpenunjang->pasien->no_rekam_medik,
                        'waktu_pengambilan_spesimen' => $modSpesimen->waktu_pengambilan_spesimen,
                        'jenisspesimen_nama' => $jenisspesimen_nama,
                        'daftartindakan_nama' => $modSpesimen->tindakanpelayanan->daftartindakan->daftartindakan_nama,
                        'status' => $modSpesimen->status,
                        'ruangan_nama' => $modSpesimen->penilaianKelayakanSpesimen->pasienmasukpenunjang->ruanganasal->ruangan_nama,
                        'no_kirimspesimen' => $data->pengirimanspesimen->no_kirimspesimen,
                        'tglkirimspesimen' => $data->pengirimanspesimen->tglkirimspesimen,
                        'nama_pegawai' => $data->pengirimanspesimen->petugaskirim->nama_pegawai,
                    );
                }
            }

            foreach ($row_arr as $no_sampel => $item) :
                ?>
                <tr>  
                    <td style="text-align: center;"><?php echo CHtml::activeCheckBox($modTerimaSpesimenDet, 'detail[' . $no_sampel . '][checklist]', array('checked' => true, 'class' => 'checklist', 'onclick' => 'setNol(this);')); ?></td>
                    
                    <td><?php echo $item['no_spesimen']; ?></td>
                    <td><?php echo $item['nama_pasien']; ?></td>
                    <td><?php echo $item['no_rekam_medik']; ?></td>
                    <td><?php echo $item['ruangan_nama']; ?></td>
                    <td><?php echo $item['jenisspesimen_nama']; ?></td>
                    <td><?php echo $item['daftartindakan_nama']; ?></td>
                    <td><?php echo $item['no_kirimspesimen']; ?></td>      
                    <td><?php echo MyFormatter::formatDateTimeId($item['tglkirimspesimen']); ?></td>
                    <td><?php echo $item['nama_pegawai']; ?>
                        <?php
                        echo CHtml::activeHiddenField($modTerimaSpesimenDet, 'detail[' . $no_sampel . '][detail][' . $item['spesimen_id'] . '][pengirimanspesimendet_id]', array('value' => $item['pengirimanspesimendet_id'], 'readonly' => true));
                        echo CHtml::activeHiddenField($modTerimaSpesimenDet, 'detail[' . $no_sampel . '][detail][' . $item['spesimen_id'] . '][pasien_id]', array('value' => $item['pasien_id'], 'readonly' => true));
                        echo CHtml::activeHiddenField($modTerimaSpesimenDet, 'detail[' . $no_sampel . '][detail][' . $item['spesimen_id'] . '][tindakanpelayanan_id]', array('value' => $item['tindakanpelayanan_id'], 'readonly' => true));
                        echo CHtml::activeHiddenField($modTerimaSpesimenDet, 'detail[' . $no_sampel . '][detail][' . $item['spesimen_id'] . '][samplelab_id]', array('value' => $item['samplelab_id'], 'readonly' => true));
                        echo CHtml::activeHiddenField($modTerimaSpesimenDet, 'detail[' . $no_sampel . '][detail][' . $item['spesimen_id'] . '][no_spesimen]', array('value' => $item['no_spesimen'], 'readonly' => true));
                        echo CHtml::activeHiddenField($modTerimaSpesimenDet, 'detail[' . $no_sampel . '][detail][' . $item['spesimen_id'] . '][spesimen_id]', array('value' => $item['spesimen_id'], 'readonly' => true));
                        ?>
                    </td>
                    <td></td>
                </tr>

                <?php
            endforeach;
        }
        ?>
    </tbody>
</table>