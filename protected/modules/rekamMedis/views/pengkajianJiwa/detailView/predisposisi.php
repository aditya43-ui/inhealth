<?php

$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';

?>

<div class="panel panel-success panel_detail" id='panel_3'>
    <div class="panel-heading">
        <div class="panel-title">Faktor Predisposisi</div>
    </div>
    <div class="panel-body">
        1. Biologik<br/>
        <div class="align_d">
            <div class="label_l">a. Riwayat Kesehatan Sebelummnya</div>
            <div class="kolon_d">:</div>
            <div class="body_d"><?php echo $model->riwayatpenyakit_sebelumnya; ?></div>
        </div>
        <div class="align_d">
            <div class="label_l">b. Genetik. Adakah anggota keluarga yang mengalami gangguan jiwa ?</div>
            <div class="kolon_d">:</div>
            <div class="body_d">
                <span><?php echo $model->isadakeluarga_gangguanjiwa == "Ya" ? $ceklis : $unceklis?> Ya </span>
                <span><?php echo !$model->isadakeluarga_gangguanjiwa == "Tidak" ? $ceklis : $unceklis?> Tidak </span>
                <?php if ($model->isadakeluarga_gangguanjiwa == "Ya"): ?>
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Hubungan Keluarga</th>
                            <th>Gejala</th>
                            <th>Riwayat Pengobatan</th>
                        </tr>
                    </thead>
                    <tbody>
                        <?php $det = DaftarkeluargaGangguangjiwaT::model()->findAllByAttributes(array(
                            'askepkesehatanjiwa_id'=>$model->askepkesehatanjiwa_id,
                        ));
                        
                        foreach ($det as $idx => $item): ?>
                        <tr>
                            <td><?php echo $idx+1; ?></td>
                            <td><?php echo $item->hubungankeluarga; ?></td>
                            <td><?php echo $item->gejala; ?></td>
                            <td><?php echo $item->riwayatpengobatan; ?></td>
                        </tr>
                        <?php endforeach; ?>
                    </tbody>
                </table>
                <?php endif; ?>
            </div>
        </div>
        <br/>
        2. Psikososial<br/>
        <div class="align_d">
            <div class="label_l">a. Pengalaman Masa Lalu yang tidak menyenangkan</div>
            <div class="kolon_d">:</div>
            <div class="body_d">
                <?php echo $model->pengalamantdk_menyenangkan ?>
                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                    'diagnosa'=>$diagnosa,
                    'label_diagnosa'=>'Diagnosa Gangguan',
                    'jenisdiagnosa'=>'diagnosa_gangguan',
                    'kelompokdiagnosa'=>'pengalamantidak_menyenangkan',
                )); ?>
            </div>
        </div>
        <div class="align_d">
            <div class="label_l">b. Riwayat Penganiayaan</div>
            <div class="kolon_d">:</div>
            <div class="body_d">
                <?php
                echo $this->renderPartial($this->path_view."detailView._detailRiwayatAniaya", array(
                    'model'=>$model, 'attribute_aniaya'=>'isriwayataniaya_fisik', 'label_aniaya'=>'Aniaya Fisik', 'jenisaniaya'=>'aniaya_fisik', 
                ), true);
                echo $this->renderPartial($this->path_view."detailView._detailRiwayatAniaya", array(
                    'model'=>$model, 'attribute_aniaya'=>'isriwayataniaya_seksual', 'label_aniaya'=>'Aniaya Seksual', 'jenisaniaya'=>'aniaya_seksual', 
                ), true);
                echo $this->renderPartial($this->path_view."detailView._detailRiwayatAniaya", array(
                    'model'=>$model, 'attribute_aniaya'=>'isriwayataniaya_penolakan', 'label_aniaya'=>'Penolakan', 'jenisaniaya'=>'aniaya_penolakan', 
                ), true);
                echo $this->renderPartial($this->path_view."detailView._detailRiwayatAniaya", array(
                    'model'=>$model, 'attribute_aniaya'=>'isriwayataniaya_kekerasandlmkeluarga', 'label_aniaya'=>'Kekerasan dalam Keluarga', 'jenisaniaya'=>'aniaya_kekerasandlmkeluarga', 
                ), true);
                echo $this->renderPartial($this->path_view."detailView._detailRiwayatAniaya", array(
                    'model'=>$model, 'attribute_aniaya'=>'isriwayataniaya_tindakkriminal', 'label_aniaya'=>'Tindak Kriminal', 'jenisaniaya'=>'aniaya_tindakkriminal', 
                ), true);
                ?>
                <br/>
                <div>
                    <div class="label_d">Jelaskan</div>
                    <div class="kolon_d">:</div>
                    <div class="body_d"><?php echo $model->riwayataniaya_penjelasan; ?></div>
                </div>
                <?php echo $this->renderPartial($this->path_view."detailView._checkBoxDiagnosaJiwa", array(
                    'diagnosa'=>$diagnosa,
                    'label_diagnosa'=>'Diagnosa Gangguan',
                    'jenisdiagnosa'=>'diagnosa_gangguan',
                    'kelompokdiagnosa'=>'riwayatpenganiayaan',
                )); ?>
            </div>
        </div>
        <div class="align_d">
            <div class="label_l">c. Genogram</div>
            <div class="kolon_d">:</div>
            <div class="body_d" style="border: 1px solid black;">
                <?php 
                if (!empty($model->genogram_gambar)) {
                    $data = CJSON::decode($model->genogram_gambar);
                    echo $data['svgout'];
                }
                
                ?>
            </div>
        </div>
        <br/>
        3. Pengambilan Keputusan : <?php echo $model->pengambilankeputusan ?><br/>
        <br/>
        4. Pola Komunikasi : <?php echo $model->polakomunikasi ?><br/>
        <br/>
    </div>
</div>