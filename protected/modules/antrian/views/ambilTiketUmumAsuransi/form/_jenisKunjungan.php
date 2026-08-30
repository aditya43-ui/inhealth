<?php
    $jeniskunjungan = LookupM::getItemsUrutan('jeniskunjunganantrian');
    if (!empty($jeniskunjungan)) {
        $i = 1;
        echo "<div data-form-jenis-kunjungan='utama' class='flex-set'>";
            foreach ($jeniskunjungan as $key => $loket) {
                $input_even = "#fff";
                $input_odd = "#fff";
                                
                if ($i % 2 == 0) {
                    $card_color = $input_even;
                } else {
                    $card_color = $input_odd;
                }
                ?>

                <div class="item-c">
                    <div class="tombol2 radius2" onclick="cekJenisKunjungan('<?php echo strtolower($key); ?>')" style="background-color:#448074;">
                        <div class="tombolbody2">
                            <!-- <hr> -->
                            <div class="labeltiket4" style="color:#fff;">
                                <?php echo strtoupper($key); ?>
                            </div>
                        </div>
                    </div>
                    <?php
                    $i++;
                    ?>
                </div>
        <?php
            }
        echo '</div>';
    ?>

        <div data-form-jenis-kunjungan='reservasi' class="form-horizontal" style="margin-top: 9vw;text-align:center;">
            <h2 align="left" style="font-size: 4vw;">PEMESANAN ANTRIAN POLIKLINIK</h2>
            <br/>
            <div class="control-group" style="margin-left:25%;">
                <label class="controls" style="font-size:2.5vw;">Tanggal</label>
                <div class="controls">
                    <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $model,
                            'attribute' => 'tglakandilayani',
                            'mode' => 'date',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'yearRange' => "-150:+0",
                            ),
                            'htmlOptions' => array(
                                'id' => 'tglakandilayani',
                                'readonly'=>true,
                                'placeholder' => '00/00/0000', 'class' => 'tanggalreservasi required span2 dtPicker2', 'onkeyup' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                    ?>
                </div>
            </div>
            
            <div class="control-group">
                <?= CHtml::htmlButton("Simpan",['style'=>'font-size:2vw;font-weigh:bold;height:3vw;','class'=>'btn btn-info','onclick'=>'setReservasi();']) ?>
            </div>
        </div>
        
        <div data-form-jenis-kunjungan='fast track' class="form-horizontal">
            <h3 align="left" style="font-size: 2.5vw;">FORM FAST TRACK</h3>
            <br/>
            <table width="100%">
                <tr>
                    <td style="font-size:2vw;">Penanggung Jawab<span style='color:red !important'>*</span></td>
                    <td><?= CHtml::activeTextField($model,'nama_pj',['class'=>'required input-form-control']) ?></td>
                </tr>
                <tr>
                    <td style="font-size:2vw;">No Rekam Medik</td>
                    <td><?php 
                            $this->widget('MyJuiAutoComplete', array(
                                'model' => $model,
                                'attribute' => 'no_rekam_medik',                                
                                'source' => 'js: function(request, response) {
                                    $.ajax({
                                        url: "' . $this->createUrl('/actionAutoComplete/pasienInformasi') . '",
                                        dataType: "json",
                                        data: {
                                            no_rekam_medik: request.term,
                                        },
                                        success: function (data) {
                                        console.log(data);
                                                response(data);
                                        }
                                    })
                                 }',
                                'options' => array(
                                    'minLength' => 3,
                                    'focus' => 'js:function( event, ui ) {
                                        $(this).val( "");
                                        return false;
                                    }',
                                    'select' => 'js:function( event, ui ) {                                                                                                        
                                        setPasienLama(ui.item);
                                        return false;
                                    }',
                                ),
                                'tombolDialog' => [
                                    'idDialog' => 'dialogPasien',
                                    'jsFunction' => '$("#dialogPasien").dialog("open");refreshGridPasien();'
                                ],
                                'htmlOptions' => array(
                                    'placeholder' => 'No. Rekam Medik', 'rel' => 'tooltip', 'title' => 'No. RM untuk mencari pasien',
                                    'class' => 'span3 no_rm_fasttrack input-form-control', 
                                    'style'=>'height:2vw;float:left;'
                                ),
                            ));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td style="font-size:2vw;">Nama Pasien</td>
                    <td><?= CHtml::activeTextField($model,'nama_pasien',['class'=>'input-form-control']) ?></td>
                </tr>
                <tr>
                    <td style="font-size:2vw;">Alasan Fasttrack <span style='color:red !important'>*</span></td>
                    <td><?= CHtml::activeTextArea($model,'alasan_fasttrack',['rows'=>20,'class'=>'required input-form-control']) ?></td>
                </tr>
            </table>           
                       
            <div class="control-group">
                <?= CHtml::htmlButton("Simpan",['style'=>'font-size:2vw;height:2vw;','class'=>'btn btn-info','onclick'=>'setFasttrack();']) ?>
            </div>
        </div>
<?php
    } else {
        echo '<p class="maaf">Maaf, belum ada jenis kunjungan.</p>';
    }
    ?>