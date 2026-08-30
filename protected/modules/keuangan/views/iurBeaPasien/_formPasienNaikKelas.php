<style>
    .horizon span {
        color: black;
    }
</style>
<div class="row-fluid form_naik_kelas" data-tipe=''>
    <div class="col-sm-12">
        <div class="control-group form_naikkelas_a form_naikkelas_b form_naikkelas_c">
            <label class="control-label">Total Biaya Rumah Sakit</label>
            <div class="controls">
                <?= $form->textField($model, 'totalbiayarumahsakit', ['class' => 'span3 integer-decimal totalbiayarumahsakit', 'readonly'=>true]) ?>
            </div>
        </div>
        <div class="control-group form_naikkelas_a form_naikkelas_c">
            <label class="control-label label_inacbg_kelasperawatan">Inacbgs Kelas yang Ditempati</label>
            <div class="controls">
                <?= $form->textField($model, 'inacbg_kelasperawatan', ['class' => 'span3 integer-decimal inacbg_kelasperawatan input_naikkelas_manual']) ?>
            </div>
        </div>
        <div class="control-group form_naikkelas_a form_naikkelas_b form_naikkelas_c">
            <label class="control-label label_inacbg_kelastanggungan">Inacbgs Sesuai Hak Kelas</label>
            <div class="controls">
                <?= $form->textField($model, 'inacbg_kelastanggungan', ['class' => 'span3 integer-decimal inacbg_kelastanggungan input_naikkelas_manual']) ?>

                <?php echo CHtml::htmlButton('Hitung', array(
                    'class'=>'btn btn-success form_naikkelas_a btn_hitung', 'onclick'=>'hitungKelas2Ke1();',
                    'id'=>'btn_naikkelas_hitung_2_1',
                    //'rel'=>'tooltip',
                )); ?>
            </div>
        </div>
        <div class="control-group form_naikkelas_c">
            <label class="control-label label_totalselisihkelastanggunganperawatan">Inacbgs Selisih Kelas yang ditempati dan Sesuai Hak Kelas</label>
            <div class="controls">
                <?= $form->textField($model, 'totalselisihkelastanggunganperawatan', ['class' => 'span3 integer-decimal totalselisihkelastanggunganperawatan input_naikkelas_manual', 'readonly'=>true]) ?>
            </div>
        </div>
        <div class="control-group form_naikkelas_b form_naikkelas_c">
            <label class="control-label">Iur Bea Max. 75%</label>
            <div class="controls">
                <?= $form->textField($model, 'iurbeatujuhpuluhpersen', ['class' => 'span3 integer-decimal iurbeatujuhpuluhpersen input_naikkelas_manual', 'readonly'=>true]) ?>

                <?php echo CHtml::htmlButton('Hitung', array(
                    'class'=>'btn btn-success form_naikkelas_b form_naikkelas_c btn_hitung', 'onclick'=>'hitungBea75();',
                    'id'=>'btn_naikkelas_hitung_75',
                    //'rel'=>'tooltip',
                )); ?>
            </div>
        </div>
        <div class="control-group form_naikkelas_b form_naikkelas_c">
            <label class="control-label">Parameter Hitung Bea</label>
            <div class="controls">
                <?= CHtml::textField('parameterhitungbea', '0,00', ['class' => 'span3 integer-decimal parameterhitungbea input_naikkelas_manual', 'readonly'=>true]) ?>
            </div>
        </div>
        <div class="control-group form_naikkelas_c">
            <label class="control-label">Selisih Biaya RS dan Inacbgs Kelas 2</label>
            <div class="controls">
                <?= CHtml::textField('selisihbiayakelas2', '0,00', ['class' => 'span3 integer-decimal selisihbiayakelas2 input_naikkelas_manual', 'readonly'=>true]) ?>
            </div>
        </div>
        <div class="control-group form_naikkelas_a form_naikkelas_b form_naikkelas_c">
            <label class="control-label">Iur Bayar Pasien</label>
            <div class="controls">
                <?= $form->textField($model, 'totalinacbg_naikkelasperawatan', ['class' => 'span3 integer-decimal totalinacbg_naikkelasperawatan', 'readonly'=>true]) ?> 
                <br/>
                <label class="label_keterangan" style="color: red; width:300px;"></label>
            </div>
        </div>
    </div>
</div>

<script>
    function hitungKelas2Ke1() {
        unformatNumberSemua();

        var inacbg_kelasperawatan = parseFloat($(".form_naik_kelas .inacbg_kelasperawatan").val());
        var inacbg_kelastanggungan = parseFloat($(".form_naik_kelas .inacbg_kelastanggungan").val());

        var selisih = Math.abs(inacbg_kelasperawatan - inacbg_kelastanggungan);

        $(".form_naik_kelas .totalinacbg_naikkelasperawatan").val(selisih);

        formatNumberSemua();
    }

    function hitungBea75() {
        unformatNumberSemua();

        var tipe = $(".form_naik_kelas").data('tipe');
        var totalbiayarumahsakit = parseFloat($(".form_naik_kelas .totalbiayarumahsakit").val()); 
        var inacbg_kelasperawatan = parseFloat($(".form_naik_kelas .inacbg_kelasperawatan").val());
        var inacbg_kelastanggungan = parseFloat($(".form_naik_kelas .inacbg_kelastanggungan").val());
        var bea75 = 0;
        var selisihBea = 0;
        
        if (tipe == "b") {
            bea75 = inacbg_kelastanggungan * 0.75;
            selisihPertamaBea = totalbiayarumahsakit - inacbg_kelastanggungan;

            if (selisihPertamaBea < 0) {
                selisihPertamaBea = 0;
            }

            console.log("HITUNG B", totalbiayarumahsakit, bea75);

            if (selisihPertamaBea > bea75) {
                selisihBea = bea75;
            } else {
                selisihBea = selisihPertamaBea;
            }

            if (selisihBea < 0) {
                selisihBea = 0;
            }

            /*
            if (selisihPertamaBea > totalbiayarumahsakit) {
                selisihBea = 0;
            } else if (selisihPertamaBea == totalbiayarumahsakit) {
                selisihBea = bea75;
            } else {
                if ((totalbiayarumahsakit - selisihPertamaBea) > bea75) { //inacbg_kelastanggungan) {
                    selisihBea = bea75 + inacbg_kelastanggungan;
                } else {
                    selisihBea = totalbiayarumahsakit - selisihPertamaBea; //inacbg_kelastanggungan;
                }
            }
            */

            $(".form_naik_kelas .iurbeatujuhpuluhpersen").val(bea75);
            $(".form_naik_kelas .parameterhitungbea").val(selisihPertamaBea);
            $(".form_naik_kelas .totalinacbg_naikkelasperawatan").val(selisihBea);
        } else if (tipe == "c") {
            var selisihPertama = Math.abs(inacbg_kelasperawatan - inacbg_kelastanggungan); // Selisih InaCBGS Kelas I dan InaCBGS Kelas II
            var selisihbiayakelas2 = Math.abs(totalbiayarumahsakit - inacbg_kelastanggungan); // Selisih Biaya RS dan Inacbgs Kelas 2
            var selisihPertamaBea = 0;

            bea75 = inacbg_kelasperawatan * 0.75;
            selisihPertamaBea = selisihPertama + bea75; // parameter perhitunan iur bea

            if (totalbiayarumahsakit <= inacbg_kelastanggungan) {
                selisihBea = 0;
            } else {

                if (selisihPertamaBea > selisihbiayakelas2) {
                    selisihBea = totalbiayarumahsakit - inacbg_kelastanggungan;
                } else {
                    selisihBea = selisihPertama + bea75;
                }
            }

            if (selisihBea < 0) {
                selisihBea = 0;
            }

            $(".form_naik_kelas .totalselisihkelastanggunganperawatan").val(selisihPertama);
            $(".form_naik_kelas .iurbeatujuhpuluhpersen").val(bea75);
            $(".form_naik_kelas .selisihbiayakelas2").val(selisihbiayakelas2);
            $(".form_naik_kelas .parameterhitungbea").val(selisihPertamaBea);
            $(".form_naik_kelas .totalinacbg_naikkelasperawatan").val(selisihBea);
        }
        


        formatNumberSemua();

    }
</script>