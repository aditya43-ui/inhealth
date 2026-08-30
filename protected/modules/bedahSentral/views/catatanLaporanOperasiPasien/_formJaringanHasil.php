<?php
$base_model = new SpesimenhasiloperasiT();

$data_jenis = CHtml::listData(JenisspesimenPaM::model()->findAll("jenisspesimen_pa_aktif = true order by jenisspesimen_pa_nama"), "jenisspesimen_pa_id", "jenisspesimen_pa_nama");

$data_teknik = CHtml::listData(TeknikpengambilanspesimenM::model()->findAll("teknikpengambilanspesimen_aktif = true order by teknikpengambilanspesimen_nama"), "teknikpengambilanspesimen_id", "teknikpengambilanspesimen_nama");
?>

<div class="col-sm-12">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Jaringan Hasil Operasi</div>
        </div>
        <div class="panel-body">

            <div id="panel_form_spesimen">
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->label($base_model, 'jenisspesimen_pa_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($base_model, 'jenisspesimen_pa_id', $data_jenis, array(
                                'empty' => '-- Pilih --', 'class' => 'span3 jenisspesimen_pa_id', 'onchange' => 'cekJenisSpesimen();'
                            ));
                            echo "<br/>";
                            echo $form->textField($base_model, 'jenisspesimen_pa_lainnya', array(
                                'class' => 'span3 jenisspesimen_pa_lainnya',
                            ));
                            ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->label($base_model, 'teknikpengambilanspesimen_id', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            echo $form->dropDownList($base_model, 'teknikpengambilanspesimen_id', $data_teknik, array(
                                'empty' => '-- Pilih --', 'class' => 'span3 teknikpengambilanspesimen_id', 'onchange' => 'cekPengambilanSpesimen();'
                            ));
                            echo "<br/>";
                            echo $form->textField($base_model, 'teknikpengambilanspesimen_lainnya', array(
                                'class' => 'span3 teknikpengambilanspesimen_lainnya',
                            ));
                            ?>
                        </div>
                    </div>

                    <?php
                    // echo $form->dropDownListRow($base_model, 'teknikpengambilanspesimen_id', $data_teknik, array(
                    //     'empty' => '-- Pilih --', 'class' => 'span3 teknikpengambilanspesimen_id','onchange' => 'cekPengambilanSpesimen()'
                    // ));
                    echo $form->textFieldRow($base_model, 'lokasipengambilanspesimen', array(
                        'class' => 'span3 lokasipengambilanspesimen',
                    ));
                    echo $form->textFieldRow($base_model, 'volumespesimen', array(
                        'class' => 'span3 volumespesimen',
                    ));
                    ?>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo $form->label($base_model, 'statuskirim_pa', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <div class="radio">
                                <?php
                                echo $form->radioButton($base_model, 'statuskirim_pa', array(
                                    'class' => 'statuskirim_pa',
                                    'value' => 'Tidak',
                                    'uncheckValue' => null
                                ));
                                ?>
                                <label>Tidak</label>
                                <?php echo $form->textField($base_model, 'tujuanpengirimanspesimen_lainnya', array('class' => 'span2')); ?>
                            </div>
                            <div class="radio">
                                <?php
                                echo $form->radioButton($base_model, 'statuskirim_pa', array(
                                    'class' => 'statuskirim_pa',
                                    'value' => 'Ya',
                                    'uncheckValue' => null
                                ));
                                ?>
                                <label>Ya</label>

                            </div>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo $form->label($base_model, 'permintaanPeriksa', array('class' => 'control-label')); ?>
                        <div class="controls">
                            <?php
                            $crPeriksa = new CDbCriteria;
                            $crPeriksa->join = 'join jenispemeriksaanlab_m j on j.jenispemeriksaanlab_id = t.jenispemeriksaanlab_id';
                            $crPeriksa->addCondition("j.jenispemeriksaanlab_kelompok = 'PATOLOGI ANATOMI'");
                            $crPeriksa->order = 'pemeriksaanlab_nama';
                            $periksa = PemeriksaanlabM::model()->findAll($crPeriksa);

                            $option = array();

                            foreach ($periksa as $key => $value) {
                                $option[$value->pemeriksaanlab_id] = array(
                                    'data-nama'=>$value->pemeriksaanlab_nama
                                );
                            }

                            echo $form->checkBoxList($base_model, 'permintaanPeriksa', CHtml::listData($periksa, 'pemeriksaanlab_id', 'pemeriksaanlab_nama'), array(
                                'class'=>'permintaanPeriksa'
                            ));
                            ?>
                        </div>
                    </div>
                    <?php echo $form->dropDownListRow($base_model, 'kualifikasi_operasi', LookupM::getItemsUrutan('kualifikasioperasi'), array(
                        'empty'=>'-- Pilih --', 'class'=>'span3'
                    )); ?>
                    <?php echo $form->dropDownListRow($base_model, 'kualifikasiluka_operasi', LookupM::getItemsUrutan('kualifikasilukaoperasi'), array(
                        'empty'=>'-- Pilih --', 'class'=>'span3'
                    )); ?>
                    <?php echo $form->textAreaRow($base_model, 'indikasi_operasi', array(
                        'class'=>'span3'
                    )); ?>
                </div>
                <div class="clear"></div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <label class="control-label">&nbsp;</label>
                        <div class="controls">
                            <?php
                            echo CHtml::htmlButton('+ Tambah', array(
                                'class' => 'btn btn-success',
                                'onclick' => 'tambahRowSpesimen();'
                            ));
                            ?>
                        </div>
                    </div>

                </div>
                <div class="clear"></div>
            </div>
            <div style="overflow-x: auto;">
                <table class="table table-bordered table-condensed">
                    <thead>
                        <tr>
                            <th>Jenis Spesimen Jaringan</th>
                            <th>Diperoleh dengan Hasil</th>
                            <th>Lokasi Pengambilan</th>
                            <th>Volume</th>
                            <th>Dikirim untuk Pemeriksaan PA</th>
                            <th>Permintaan Pemeriksaan PA</th>
                            <th>Kualifikasi Operasi</th>
                            <th>Kualifikasi Luka Operasi</th>
                            <th>Indikasi Operasi</th>
                            <th>Batal</th>
                        </tr>
                    </thead>
                    <tbody id="tab_jaringan">
                        <?php
                        if (!$model->isNewRecord) {
                            $det = SpesimenhasiloperasiT::model()->findAllByAttributes(array(
                                    'laporanoperasipasien_id'=>$model->laporanoperasipasien_id,
                            ));

                            foreach ($det as $idx => $item) {
                                $item->permintaanPeriksa = CHtml::listData(SpesimenhasiloperasidetT::model()->findAllByAttributes(array(
                                    'spesimenhasiloperasi_id'=>$item->spesimenhasiloperasi_id,
                                )), 'pemeriksaanlab_id', 'pemeriksaanlab_id');

                                echo $this->renderPartial('_rowJaringan', array(
                                    'mod'=>$item, 'idx'=>$idx
                                ));

                            }
                        }

                        ?>
                    </tbody>
                </table>
            </div>

        </div>
    </div>
</div>

<script>

var counter = 1;

function cekJenisSpesimen() {
    if ($(".jenisspesimen_pa_id").val() == 3) {
        $(".jenisspesimen_pa_lainnya").prop("readonly", false);
    } else {
        $(".jenisspesimen_pa_lainnya").prop("readonly", true).val("");
    }
}

function cekPengambilanSpesimen() {
    if ($(".teknikpengambilanspesimen_id").val() == 4) {
        $(".teknikpengambilanspesimen_lainnya").prop("readonly", false);
    } else {
        $(".teknikpengambilanspesimen_lainnya").prop("readonly", true).val("");
    }
}

function cekStatusKirim() {
    var nilai = $(".statuskirim_pa:checked").val();

    if (nilai == "Tidak") {
        $("#SpesimenhasiloperasiT_tujuanpengirimanspesimen_lainnya").prop("readonly", false);
    } else {
        $("#SpesimenhasiloperasiT_tujuanpengirimanspesimen_lainnya").prop("readonly", true).val("");
    }
}

function tambahRowSpesimen() {
    $.post('<?php echo $this->createUrl('loadTambahRow'); ?>', $("#panel_form_spesimen :input").serialize(), function(data) {
        $("#tab_jaringan").append(data);
        $("#panel_form_spesimen input[type='text'], #panel_form_spesimen select").val("");
        $("#panel_form_spesimen input[type='radio'], #panel_form_spesimen input[type='checkbox']").prop("checked", false);
        cekJenisSpesimen();
        cekPengambilanSpesimen();
        cekStatusKirim();
    });
}

function hapusItemJaringan(obj) {
    $(obj).parents("tr").remove();
}

$(document).ready(function() {
    $(".statuskirim_pa").on("click", cekStatusKirim);

        cekJenisSpesimen();
        cekPengambilanSpesimen();
        cekStatusKirim();
});



</script>
