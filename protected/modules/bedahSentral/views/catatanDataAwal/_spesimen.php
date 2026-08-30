<?php

$base_model = new SpesimenhasiloperasiT();

$data_jenis = CHtml::listData(JenisspesimenPaM::model()->findAll("jenisspesimen_pa_aktif = true order by jenisspesimen_pa_nama"), "jenisspesimen_pa_id", "jenisspesimen_pa_nama");

$data_teknik = CHtml::listData(TeknikpengambilanspesimenM::model()->findAll("teknikpengambilanspesimen_aktif = true order by teknikpengambilanspesimen_nama"), "teknikpengambilanspesimen_id", "teknikpengambilanspesimen_nama");

?>
<div id="panel_form_spesimen">
<div class="control-group">
    <?php echo $form->label($base_model, 'jenisspesimen_pa_id', array('class'=>'control-label')); ?>
    <div class="controls">
        <?php echo $form->dropDownList($base_model, 'jenisspesimen_pa_id', $data_jenis, array(
            'empty'=>'-- Pilih --', 'class'=>'span3 jenisspesimen_pa_id', 'onchange'=>'cekJenisSpesimen();'
        ));
        echo "<br>";
        echo $form->textField($base_model, 'jenisspesimen_pa_lainnya', array(
            'class'=>'span3 jenisspesimen_pa_lainnya',
        ));
        ?>
    </div>
</div>

<?php

echo $form->dropDownListRow($base_model, 'teknikpengambilanspesimen_id', $data_teknik, array(
    'empty'=>'-- Pilih --', 'class'=>'span3 teknikpengambilanspesimen_id',
));
echo $form->textFieldRow($base_model, 'lokasipengambilanspesimen', array(
    'class'=>'span3 lokasipengambilanspesimen',
));

?>
</div>
<div class="control-group">
    <label class="control-label"></label>
    <div class="controls">
        <?php echo CHtml::htmlButton('+', array(
            'class' => 'btn btn-danger',
            'onclick'=>'tambahRowSpesimen();'
        )); ?>
    </div>
</div>

<table class="table table-bordered table-consended">
    <thead>
        <tr>
            <th>Jenis Spesimen</th>
            <th>Diperoleh Dari Hasil</th>
            <th>Lokasi Pengambilan</th>
            <th>Batal</th>
        </tr>
    </thead>
    <tbody id="tab_spesimen">
        <?php
        if (!$model->isNewRecord) {
            $det = SpesimenhasiloperasiT::model()->findAllByAttributes(array(
                'pasienmasukpenunjang_id'=>$model->pasienmasukpenunjang_id
            ), array(
                'condition'=>'laporanoperasipasien_id is null'
            ));

            foreach ($det as $idx=>$item) {
                echo $this->renderPartial($this->path_view."_rowSpesimen", array('model'=>$item, 'ii'=>$idx), true);
            }
        }

        ?>
    </tbody>
</table>

<script>

var row = <?php echo CJSON::encode(array('html'=>$this->renderPartial($this->path_view."_rowSpesimen", array(), true))); ?>;

function cekJenisSpesimen() {
    var val = $(".jenisspesimen_pa_id").val();

    if (val == <?php echo Params::JENISSPESIMEN_PA_LAINNYA ?>) {
        $(".jenisspesimen_pa_lainnya").attr("readonly", false);
    } else {
        $(".jenisspesimen_pa_lainnya").attr("readonly", true).val("");
    }
}

function tambahRowSpesimen() {
    var jenis_id = $(".jenisspesimen_pa_id").val();
    var jenis_nama = $(".jenisspesimen_pa_id :selected").html();
    var jenis_lain = $(".jenisspesimen_pa_lainnya").val();
    var teknik = $(".teknikpengambilanspesimen_id").val();
    var teknik_nama = $(".teknikpengambilanspesimen_id :selected").html();
    var lokasi = $(".lokasipengambilanspesimen").val();

    $("#tab_spesimen").append(row.html);
    var last = $("#tab_spesimen tr:last");

    if (jenis_id == <?php echo Params::JENISSPESIMEN_PA_LAINNYA ?>) {
        $(last).find(".label_jenis").html(jenis_lain);
    } else {
        $(last).find(".label_jenis").html(jenis_nama);
    }
    $(last).find(".label_teknik").html(teknik_nama);
    $(last).find(".label_lokasi").html(lokasi);

    $(last).find(".tab_jenisspesimen_pa_id").val(jenis_id);
    $(last).find(".tab_jenisspesimen_pa_lainnya").val(jenis_lain);
    $(last).find(".tab_teknikpengambilanspesimen_id").val(teknik);
    $(last).find(".tab_lokasipengambilanspesimen").val(lokasi);


    // rename
    resetInputSpesimen();
    renameInputSpesimen();
}

function resetInputSpesimen() {
    $("#panel_form_spesimen :input").val("");
    cekJenisSpesimen();
}

function renameInputSpesimen() {
    var cnt = 0;
    $("#tab_spesimen tr").each(function() {
        $(this).find(".tab_jenisspesimen_pa_id").attr("name", "SpesimenhasiloperasiT[detail][" + cnt + "][jenisspesimen_pa_id]");
        $(this).find(".tab_jenisspesimen_pa_lainnya").attr("name", "SpesimenhasiloperasiT[detail][" + cnt + "][jenisspesimen_pa_lainnya]");
        $(this).find(".tab_teknikpengambilanspesimen_id").attr("name", "SpesimenhasiloperasiT[detail][" + cnt + "][teknikpengambilanspesimen_id]");
        $(this).find(".tab_lokasipengambilanspesimen").attr("name", "SpesimenhasiloperasiT[detail][" + cnt + "][lokasipengambilanspesimen]");

        cnt++;
    });
}

$(document).ready(function() {
    cekJenisSpesimen();
});


</script>
