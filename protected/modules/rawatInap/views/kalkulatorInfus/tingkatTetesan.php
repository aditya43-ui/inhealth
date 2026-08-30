<style type="text/css">
    table tr td {
        padding: 5px;
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="fas fa-calculator"></i> Kalkulator Infus Berdasarkan Tingkat Tetesan
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-6">
                <table>
                    <tr>
                        <td>Jumlah Cairan Infus</td>
                        <td>
                            <input name="cairan" id="cairan" value="0" maxlength="5" type="text" class="span2 integer">
                            ml
                        </td>
                    </tr>
                    <tr>
                        <td>Waktu yang dibutuhkan</td>
                        <td>
                            <input name="waktu" id="waktu" value="0" maxlength="2" type="text" class="span2 integer">
                            jam
                        </td>
                    </tr>
                    <tr>
                        <td>Faktor Tetes</td>
                        <td>
                            <?php echo CHtml::dropDownList('faktor', '', LookupM::getItems('faktortetes'), array('class' => 'span3')); ?>
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
        var cairan = parseInt($('#cairan').val());
        var waktu = parseInt($('#waktu').val());
        var faktor = $('#faktor').val();
        var jumlah = 0;
        if (faktor == 'Otsuka') {
            jumlah = Math.round(cairan / (waktu * 4));
        } else if (faktor == 'Terumo') {
            jumlah = Math.round(cairan / (waktu * 3));
        } else {
            jumlah = Math.round(cairan / waktu);
        }
        $('.hasilPerhitungan').html('Tingkat Tetesan Infus <b>' + jumlah + '</b> Tetes / Menit');
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