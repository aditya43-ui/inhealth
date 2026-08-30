
<?php
$i = 0;
for ($i; $i < $jumlah_termin; $i++) {
    ?>
    <tr>
        <td style="text-align:center">
            <div class="control-group">
                <div class="controls"> 
                    <?php echo CHtml::activeTextField($model, '[' . $i . ']terminke', array('class' => 'span1 terminke', 'readonly' => true)) ?>
                </div>
            </div>
        </td>
        <td style="text-align:center"> 
            <div class="control-group">
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, '[' . $i . ']jumlah_persen', array('onblur' => 'hitungTerminPeriodikal();', 'class' => 'span1 integer-decimal jumlah_persen', 'readonly' => false)) ?>
                    <!--<label> % =</label>-->
                </div>
            </div>
        </td>
        <td style="text-align:center"> 
            <div class="control-group">
                <div class="controls">
                    <?php echo CHtml::activeTextField($model, '[' . $i . ']jumlah_harga', array('class' => 'span2 integer-decimal jumlah_harga', 'readonly' => true)) ?>
                    <?php echo CHtml::activeHiddenField($model, '[' . $i . ']urutan', array('value' => 2, 'class' => 'span3', 'readonly' => true)) ?>
                </div>
            </div>
        </td>
        <td style="text-align:center">
            <div class="control-group">
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => '[' . $i . ']termintanggal_awal',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'changeYear' => true,
                        ),
                        'htmlOptions' => array('class' => 'span2', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true),
                    ));
                    ?>
                </div>
            </div>
        </td>
        <td style="text-align:center">
            <div class="control-group">
                <div class="controls">
                    <?php
                    $this->widget('MyDateTimePicker', array(
                        'model' => $model,
                        'attribute' => '[' . $i . ']termintanggal_akhir',
                        'mode' => 'date',
                        'options' => array(
                            'dateFormat' => Params::DATE_FORMAT,
                            'changeYear' => true,
                        ),
                        'htmlOptions' => array('class' => 'span2 akhir', 'onkeyup' => "return $(this).focusNextInputField(event)", 'readonly' => true),
                    ));
                    ?>
                </div>
            </div>

        </td>
    </tr>   
    <script type="text/javascript">
    $(document).ready(function () {
        generatePicker();
        convert(<?php echo $i+1 ?>);
            
        $('input[name$="SuratperjanjiankerjaterminT[0][termintanggal_awal]"]').val('<?php echo $tanggal_awal; ?>');
        
        var jumlah_termin = $("#ADSuratperjanjiankerjaterminT_jumlah_termin").val();
        console.log('jumlah termin : '+jumlah_termin);
        if(jumlah_termin != 1){
            tanggalPeriodikal(<?php echo $i+1 ?>);
        }else{
            $('input[name$="SuratperjanjiankerjaterminT[0][termintanggal_awal]"]').val('<?php echo $tanggal_awal; ?>');
            $('input[name$="SuratperjanjiankerjaterminT[0][termintanggal_akhir]"]').val('<?php echo $tanggal_akhir; ?>');
        }

    });
    
    /**
     * Generate tanggal periodikal tergantung jumlah inputan
     * @param {type} jumlah
     * @returns {undefined}
     */
    function tanggalPeriodikal(jumlah){
        
        //Set Akhir Tanggal
        var awalnya = $('input[name$="SuratperjanjiankerjaterminT[0][termintanggal_awal]"]').datepicker('getDate');
        var selisihnya = <?php echo $selisih; ?>/<?php echo $jumlah_termin; ?>;
        var dibulatkan = Math.round(selisihnya)-1;
        console.log('dibulatkan : '+dibulatkan);
        
        var digits = jumlah;
        
        for (var i=0; i < digits; i++){    
            if(i == 0){
                var akhirdibaris1 = awalnya.setDate(awalnya.getDate() + dibulatkan);
                var tglbaris1 = new Date(akhirdibaris1);
            }else{
                var akhirdibaris1 = awalnya.setDate((awalnya.getDate() + 1) + dibulatkan);
                var tglbaris1 = new Date(akhirdibaris1);
            }
            var tglbaris1_dijadikanstring = ""+tglbaris1+"";
            var pisahkan = tglbaris1_dijadikanstring.split(" ");
            
            //Tanggal akhir kegitan
            var pokokakhir = new Date('<?php echo $tanggal_akhir ?>');
            var stringpokokakhir = ""+pokokakhir+"";
            var splitpokokakhir = stringpokokakhir.split(" ");
            
            if(tglbaris1.getTime() > pokokakhir.getTime()){
                $("#SuratperjanjiankerjaterminT_<?php echo $i ?>_termintanggal_akhir").val(splitpokokakhir[2]+" "+splitpokokakhir[1]+" "+splitpokokakhir[3]);
            }else{
                $("#SuratperjanjiankerjaterminT_<?php echo $i ?>_termintanggal_akhir").val(pisahkan[2]+" "+pisahkan[1]+" "+pisahkan[3]);
            }
            
            //Set Awal Tanggal
            var akhirnya = $('input[name$="SuratperjanjiankerjaterminT['+i+'][termintanggal_akhir]"]').datepicker('getDate');
            var tgl_awal = akhirnya.setDate(akhirnya.getDate() - dibulatkan);
            var awal = new Date(tgl_awal);
            
            var abc = ""+awal+"";
            var tanggalawal = abc.split(" ");
            console.log('Digits : '+digits);
            console.log('tgl awal : '+awal);
            console.log('tgl akhir : '+tglbaris1);

            $("#SuratperjanjiankerjaterminT_<?php echo $i ?>_termintanggal_awal").val(tanggalawal[2]+" "+tanggalawal[1]+" "+tanggalawal[3]);
            
            var palingakhir = $("#tabel-Periodikal > tbody > tr:last ").find(".akhir").val(splitpokokakhir[2]+" "+splitpokokakhir[1]+" "+splitpokokakhir[3]);
            
        }
        
    }
    
    /**
     * Convert ke romawi
     * @param {type} num
     * @returns {undefined}
     */
    function convert(num) {
        var numeralCodes = [["","I","II","III","IV","V","VI","VII","VIII","IX"],         // Ones
                            ["","X","XX","XXX", "XL", "L", "LX", "LXX", "LXXX", "XC"],   // Tens
                            ["","C","CC","CCC","CD","D","DC","DCC","DCCC","CM"]];        // Hundreds
        var numeral = "";
        var digits = num.toString().split('').reverse();
        for (var i=0; i < digits.length; i++){
            numeral = numeralCodes[i][parseInt(digits[i])] + numeral;
        }
        $("#SuratperjanjiankerjaterminT_<?php echo $i ?>_terminke").val(numeral);
        $("#SuratperjanjiankerjaterminT_<?php echo $i ?>_urutan").val(num);
    }
    
    /**
     * Generate picker
     * @returns {undefined}
     */
    function generatePicker() {
        var jangkawaktu = Math.round((<?php echo $selisih; ?>/<?php echo $jumlah_termin; ?>))-1;
        jQuery('input[name$="SuratperjanjiankerjaterminT[<?php echo $i ?>][termintanggal_awal]"]').datepicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['en-GB'],
                        {

                            'dateFormat': '<?php echo Params::DATE_FORMAT; ?>',
                            'minDate': '<?php echo $tanggal_awal; ?>',
                            'maxDate': '<?php echo $tanggal_akhir; ?>',
                            'timeOnlyTitle': 'Pilih Waktu',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                            'onSelect': function () {
                                var mindate = $(this).datepicker('getDate');
                                if (mindate) { // Not null
                                    mindate.setDate(mindate.getDate() + jangkawaktu);
                                }
                                $('input[name$="SuratperjanjiankerjaterminT[<?php echo $i ?>][termintanggal_akhir]"]').datepicker('option', 'minDate', mindate);
                            }
                        }
                ));
        jQuery('input[name$="SuratperjanjiankerjaterminT[<?php echo $i ?>][termintanggal_akhir]"]').datepicker(
                jQuery.extend(
                        {
                            showMonthAfterYear: false
                        },
                        jQuery.datepicker.regional['en-GB'],
                        {

                            'dateFormat': '<?php echo Params::DATE_FORMAT; ?>',
                            'minDate': '<?php echo $tanggal_awal; ?>',
                            'maxDate': '<?php echo $tanggal_akhir; ?>',
                            'timeOnlyTitle': 'Pilih Waktu',
                            'changeYear': true,
                            'changeMonth': true,
                            'showAnim': 'fold',
                            'onSelect': function () {
                                var mindate = $(this).datepicker('getDate');
                                if (mindate) { // Not null
                                    mindate.setDate(mindate.getDate() + 1);
                                }
                                $('input[name$="SuratperjanjiankerjaterminT[<?php echo $i+1 ?>][termintanggal_awal]"]').datepicker('option', 'minDate', mindate);
                            }
                        }
                ));
    }
    
</script>
    <?php
}
?>
<script type="text/javascript">
    $(document).ready(function () {
        unformatNumberSemua();
        var jumlah_termin = $("#ADSuratperjanjiankerjaterminT_jumlah_termin").val();
        var jumlah_persen = 100/jumlah_termin;
        $(".jumlah_persen").val(jumlah_persen);
        
        
        var total_pembulatan = parseFloat($('#SuratperjanjiankerjaT_total_pembulatan').val()); 
        var jumlah_harga = total_pembulatan/jumlah_termin;
        $(".jumlah_harga").val(jumlah_harga.toFixed(2));
        
        
        var pokokakhir = new Date('<?php echo $tanggal_akhir ?>');
        var stringpokokakhir = ""+pokokakhir+"";
        var splitpokokakhir = stringpokokakhir.split(" ");
        
        var ada = 0;
        $("#tabel-Periodikal > tbody > tr").each(function () {
            
            var cekakhir = $(this).find('.akhir').datepicker('getDate');
            
            console.log('ak : '+cekakhir.getTime());
            console.log('akhir : '+pokokakhir.getTime());
            if (cekakhir.getTime() == pokokakhir.getTime()) {
                ada++;
            }
        });
        formatNumberSemua();
        if(ada > 1){
//            $("#periksatermin").val('Mohon periksa kembali tanggal termin');
        }
    });
    

</script>