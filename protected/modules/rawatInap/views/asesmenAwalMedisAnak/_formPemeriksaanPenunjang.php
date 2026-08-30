<div class="row-fluid">
    <div class="col-sm-12">
        <label>Pemeriksaan Radiologi</label>
        <table class="table table-striped">
            <tr>
                <th>Nama Pemeriksaan</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Hasil</th>
            </tr>
            <?php if(!empty($loadHasilPemeriksaanRad)) : ?>
            <?php foreach($loadHasilPemeriksaanRad as $row) : ?>
            <tr>
                <td><?= $row->daftartindakan_nama; ?></td>
                <td><?= $row->tglpemeriksaanrad; ?></td>
                <td>
                    <?= CHtml::link(
                        "<span style='font-size:15px;'><i class=\"icon-form-lihat\"></i></span>",
                        Yii::app()->createUrl("radiologi/lihatHasil/HasilPeriksa", array("pendaftaran_id"=>$_GET['pendaftaran_id'],"pasien_id"=>'',"pasienmasukpenunjang_id"=>$row->pasienmasukpenunjang_id)),
                        array("rel"=>"tooltip",
                            "title"=>"Klik untuk melihat hasil",
                            "target"=>"iframeLihatHasil",
                            "onclick"=>"$(\"#dialogLihatHasil\").dialog(\"open\");",
                        )
                    ); ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </table>
        <br><br>
        
        <label>Pemeriksaan Laboratorium</label>
        <table class="table table-striped">
            <tr>
                <th>Nama Pemeriksaan</th>
                <th>Tanggal Pemeriksaan</th>
                <th>Hasil</th>
            </tr>
            <?php if(!empty($loadHasilPemeriksaanLab)) : ?>
            <?php foreach($loadHasilPemeriksaanLab as $row) : ?>
            <tr>
                <td><?= $row->daftartindakan_nama; ?></td>
                <td><?= $row->tglhasilpemeriksaanlab; ?></td>
                <td>
                    <?php echo CHtml::Link("<span style='font-size:15px;'><i class=\"icon-form-lihat\"></i></span>", Yii::app()->createUrl("laboratorium/pencatatanHasilPemeriksaan/print", array("pasienmasukpenunjang_id" => $row->pasienmasukpenunjang_id, "frame" => 1, "popup" => "true")), array("class" => "",
                                                            "target" => "iframeLihatHasil",
                                                            "onclick" => "$(\"#dialogLihatHasil\").dialog(\"open\");",
                                                            "rel" => "tooltip",
                                                            "title" => "Klik untuk melihat hasil pemeriksaan",
                                                )); ?>
                </td>
            </tr>
            <?php endforeach; ?>
            <?php endif; ?>
        </table>
    </div>
</div>

<div class="row-fluid">
    <div class="col-sm-12">
        <label>Pemeriksaan Lab dari Luar</label>
<?=
    $this->renderPartial($this->path_view.'form/_form_hasil_lab_eks',['model'=>$modAsesmenAwalMedis],true);
?>
    </div>
</div>
<?php
    // Dialog untuk Lihat Hasil =========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(
        'id' => 'dialogLihatHasil',
        'options' => array(
            'title' => 'Hasil Pemeriksaan Laboratorium',
            'autoOpen' => false,
            'modal' => true,
            'minWidth' => 980,
            'minHeight' => 450,
            'resizable' => true,
        ),
    ));
    ?>
<iframe src="" name="iframeLihatHasil" width="100%" height="500">
</iframe>

<?php
$this->endWidget();
//========= end Lihat Hasil =============================
?>

<script>
    function setLabdariluar(){
        if($('#labdariluar').is(":checked")){
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_hb').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_k').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_bun').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_na').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_sk').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_p').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_ca').attr('disabled', false);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_cl').attr('disabled', false);
        }else{
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_hb').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_hb').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_k').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_k').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_bun').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_bun').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_na').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_na').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_sk').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_sk').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_p').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_p').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_ca').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_ca').val('');
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_cl').attr('disabled', true);
            $('#RIAsesmenAwalMedisT_pemeriksaanlab_cl').val('');
        }
    }
</script>