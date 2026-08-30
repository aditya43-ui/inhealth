<style type="text/css">
    table tr td {
        padding: 5px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-calculator"></i> Kalkulator Infus Dosis Obat
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <table>
                    <tr>
                        <td>Berat obat</td>
                        <td>
                            <input name="obat" id="obat" value="0" maxlength="5" type="text" class="span2 integer">
                            mg
                        </td>
                    </tr>
                    <tr>
                        <td>D5%</td>
                        <td>
                            <input name="d5" id="d5" value="0" maxlength="3" type="text" class="span2 integer">
                            cc
                        </td>
                    </tr>
                    <tr>
                        <td>Dosis</td>
                        <td>
                            <input name="dosis" id="dosis" value="0" maxlength="5" type="text" class="span2 integer">
                            mcg
                        </td>
                    </tr>
                    <tr>
                        <td>Berat Badan</td>
                        <td>
                            <input name="badan" id="badan" value="<?php echo $bb; ?>" maxlength="3" type="text" class="span2 numbersOnly">
                            kg
                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <?php echo CHtml::radioButtonList('micro', 'Micro', array('Micro' => 'Micro Drip', 'Infus' => 'Infus Pump'), array('class' => '')); ?>
                            <?php // echo CHtml::radioButtonList('infus', '', array('Infus'=>'Infus Pump'), array('class'=>'')); 
                            ?>

                        </td>
                    </tr>
                    <tr>
                        <td></td>
                        <td>
                            <span style="color:red">
                                <div class="hasilPerhitungan"></div>
                            </span>
                        </td>
                    </tr>
                </table>

                <div class="form-actions">
                    <button class="btn btn-primary" type="button" onclick="hitungCairanInfus();" name="yt1">Hitung</button>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="text/javascript">
    function hitungCairanInfus() {
        unformatNumberSemua();
        var dosis = parseInt($('#dosis').val());
        var badan = parseInt($('#badan').val());
        var obat = parseInt($('#obat').val());
        var d5 = parseInt($('#d5').val());

        var Micro = $("#micro_0").is(":checked");
        var jumlah_mcg = 0;
        var jumlah = 0;
        var satuan = '';
        if (Micro == true) {
            jumlah_mcg = Math.round((obat / d5) * 1000);
            jumlah = Math.round((dosis * badan * 60) / jumlah_mcg);
            satuan = ' Tetes/Menit';
        } else {
            jumlah_mcg = Math.round((obat / d5) * 1000);
            jumlah = Math.round((dosis * badan * 60) / jumlah_mcg);
            satuan = ' cc/Jam';
        }
        $('.hasilPerhitungan').html('Tingkat Tetesan Infus <b>' + jumlah + '</b> ' + satuan);
        formatNumberSemua();
    }

    /**
     * class integer di unformat 
     * @returns {undefined}
     */
    function unformatNumberSemua() {
        $(".integer").each(function() {
            $(this).val(parseInt(unformatNumber($(this).val())));
        });
    }
    /**
     * class integer di format kembali
     * @returns {undefined}
     */
    function formatNumberSemua() {
        $(".integer").each(function() {
            $(this).val(formatInteger($(this).val()));
        });
    }
</script>