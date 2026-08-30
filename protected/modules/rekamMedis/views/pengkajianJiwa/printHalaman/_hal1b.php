
<?php
$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';
?>


<div class="panel_main">
    <div class="panel_judul">
        III. FAKTOR PREDISPOSISI
    </div>
    <div class="panel_body">
        <strong>1. Biologik</strong>
        <table class="tab_info">
            <tbody>
                <tr>
                    <td>a. Riwayat Kesehatan Sebelummnya</td>
                    <td>:</td>
                    <td><?php echo $model->riwayatpenyakit_sebelumnya; ?></td>
                </tr>
                <tr>
                    <td>b. Genetik. Adakah anggota keluarga yang mengalami gangguan jiwa ?</td>
                    <td>:</td>
                    <td>
                        <span><?php echo $model->isadakeluarga_gangguanjiwa == "Ya" ? $ceklis : $unceklis ?> Ya </span>
                        <span><?php echo!$model->isadakeluarga_gangguanjiwa == "Tidak" ? $ceklis : $unceklis ?> Tidak </span>
                        <?php if ($model->isadakeluarga_gangguanjiwa == "Ya"): ?>
                            <table class="tab_detail">
                                <thead>
                                    <tr>
                                        <th>No.</th>
                                        <th>Hubungan Keluarga</th>
                                        <th>Gejala</th>
                                        <th>Riwayat Pengobatan</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    <?php
                                    $det = DaftarkeluargaGangguangjiwaT::model()->findAllByAttributes(array(
                                        'askepkesehatanjiwa_id' => $model->askepkesehatanjiwa_id,
                                    ));

                                    foreach ($det as $idx => $item):
                                        ?>
                                        <tr>
                                            <td><?php echo $idx + 1; ?></td>
                                            <td><?php echo $item->hubungankeluarga; ?></td>
                                            <td><?php echo $item->gejala; ?></td>
                                            <td><?php echo $item->riwayatpengobatan; ?></td>
                                        </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        <?php endif; ?>
                    </td>
                </tr>
            </tbody>
        </table>
        <strong>2. Psikososial</strong>
        <table class="tab_info">
            <tbody>
                <tr>
                    <td>a. Pengalaman Masa Lalu yang tidak menyenangkan</td>
                    <td>:</td>
                    <td>
                        <?php echo $model->pengalamantdk_menyenangkan ?>
                        <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwaPrint", array(
                            'diagnosa'=>$diagnosa,
                            'label_diagnosa'=>'Diagnosa Gangguan',
                            'jenisdiagnosa'=>'diagnosa_gangguan',
                            'kelompokdiagnosa'=>'pengalamantidak_menyenangkan',
                        )); ?>
                    </td>
                </tr>
                <tr>
                    <td>b. Riwayat Penganiayaan</td>
                    <td>:</td>
                    <td>
                        <?php
                        echo $this->renderPartial($this->path_view."detailView._detailRiwayatAniayaPrint", array(
                            'model'=>$model, 'attribute_aniaya'=>'isriwayataniaya_fisik', 'label_aniaya'=>'Aniaya Fisik', 'jenisaniaya'=>'aniaya_fisik', 
                        ), true);
                        echo $this->renderPartial($this->path_view."detailView._detailRiwayatAniayaPrint", array(
                            'model'=>$model, 'attribute_aniaya'=>'isriwayataniaya_seksual', 'label_aniaya'=>'Aniaya Seksual', 'jenisaniaya'=>'aniaya_seksual', 
                        ), true);
                        echo $this->renderPartial($this->path_view."detailView._detailRiwayatAniayaPrint", array(
                            'model'=>$model, 'attribute_aniaya'=>'isriwayataniaya_penolakan', 'label_aniaya'=>'Penolakan', 'jenisaniaya'=>'aniaya_penolakan', 
                        ), true);
                        echo $this->renderPartial($this->path_view."detailView._detailRiwayatAniayaPrint", array(
                            'model'=>$model, 'attribute_aniaya'=>'isriwayataniaya_kekerasandlmkeluarga', 'label_aniaya'=>'Kekerasan dalam Keluarga', 'jenisaniaya'=>'aniaya_kekerasandlmkeluarga', 
                        ), true);
                        echo $this->renderPartial($this->path_view."detailView._detailRiwayatAniayaPrint", array(
                            'model'=>$model, 'attribute_aniaya'=>'isriwayataniaya_tindakkriminal', 'label_aniaya'=>'Tindak Kriminal', 'jenisaniaya'=>'aniaya_tindakkriminal', 
                        ), true);
                        ?>
                        <br/>
                        Jelaskan : <?php echo $model->riwayataniaya_penjelasan; ?>
                    </td>
                </tr>
                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwaPrint", array(
                    'diagnosa'=>$diagnosa,
                    'label_diagnosa'=>'Diagnosa Gangguan',
                    'jenisdiagnosa'=>'diagnosa_gangguan',
                    'kelompokdiagnosa'=>'riwayatpenganiayaan',
                )); ?>
                <tr>
                    
                </tr>
            </tbody>
        </table>
    </div>
</div>