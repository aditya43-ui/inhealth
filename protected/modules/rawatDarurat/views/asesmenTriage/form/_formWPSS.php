<table class="table border" id="wpss">
    <thead>
        <tr>
            <th>Tanda Vital</th>
            <th>Hasil Pemeriksaan</th>
            <th>Skor</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $pemeriksaan = PemeriksaantriageM::model()->findAllByAttributes(array(
            'isaktif' => true,
        ));

        $modDet = AsesmentriagewpssdetT::model()->findAllByAttributes(array('asesmentriagewpss_id' => $modAsesTriase->asesmentriagewpss_id));
        if(!empty($pemeriksaan)) {

            if (empty($modDet)) {
                foreach ($pemeriksaan as $key => $value) {
                    ?>
                    <tr>
                        <td>
                            <?php
                            // echo 'id det '.CHtml::activeTextField($modAsesTriaseDet, 'asesmentriagewpssdet_id[' . $key . ']', array('readonly' => false));
                            // $a = strval($modDet[intval($key)]->detailpemeriksaantriage_id);
                            // echo is_array($modDet[0]->pendaftaran_id);
                            // echo $a; 
                            // echo '<br>';
                            // $modAsesTriaseDet[$key]->pendaftaran_id
                            echo $value->nama_pemeriksaan;
                            echo CHtml::activeHiddenField($modAsesTriaseDet, 'pemeriksaantriage_id[' . $key . ']', array('readonly' => true, 'value' => $value->pemeriksaantriage_id));
                            echo CHtml::activeHiddenField($modAsesTriaseDet, 'pasien_id[' . $key . ']', array('readonly' => true));
                            echo CHtml::activeHiddenField($modAsesTriaseDet, 'pendaftaran_id[' . $key . ']', array('readonly' => true));
                            ?>
                        </td>
                        <td>
                            <?php
                                echo CHtml::activeDropDownList(
                                    $modAsesTriaseDet,
                                    'detailpemeriksaantriage_id[' . $key . ']',
                                    CHtml::listData(DetailpemeriksaantriageM::model()->findAllByAttributes(array(
                                                'pemeriksaantriage_id' => $value->pemeriksaantriage_id,
                                                'isaktif' => true,
                                            )), 'detailpemeriksaantriage_id', 'detailpemeriksaantriage_nama'),
                                    array(
                                        'empty' => '-- Pilih --',
                                        'class' => 'span3 required tes',
                                        'onChange' => 'loadSkor(this)',
                                        'a' => $modAsesTriaseDet->detailpemeriksaantriage_id
                                    )
                            );
                            ?>
                        </td>
                        <td>
                            <?php
                            echo $form->textField($modAsesTriaseDet, 'skor[' . $key . ']', array('readonly' => true, 'class' => 'skor required', 'skor' => $modAsesTriaseDet->skor));
                            ?>
                        </td>
                    </tr>
                <?php
                }
    
            } else {

                foreach ($modDet as $key => $value) {
                    ?>
                    <tr>
                        <td>
                            <?php
                            $a = strval($value->detailpemeriksaantriage_id);
                            // echo is_array($modDet[0]->pendaftaran_id);
                            // echo $a; 
                            // echo '<br>';
                            // $modAsesTriaseDet[$key]->pendaftaran_id
                            echo $value->pemeriksaantriage->nama_pemeriksaan;
                            echo CHtml::activeHiddenField($modAsesTriaseDet, 'asesmentriagewpssdet_id[' . $key . ']', array('readonly' => false, 'value' => $value->asesmentriagewpssdet_id));
                            echo CHtml::activeHiddenField($modAsesTriaseDet, 'pemeriksaantriage_id[' . $key . ']', array('readonly' => true, 'value' => $value->pemeriksaantriage_id));
                            echo CHtml::activeHiddenField($modAsesTriaseDet, 'pasien_id[' . $key . ']', array('readonly' => true));
                            echo CHtml::activeHiddenField($modAsesTriaseDet, 'pendaftaran_id[' . $key . ']', array('readonly' => true));
                            ?>
                        </td>
                        <td>
                            <?php
                                echo CHtml::activeDropDownList(
                                    $modAsesTriaseDet,
                                    'detailpemeriksaantriage_id[' . $key . ']',
                                    CHtml::listData(DetailpemeriksaantriageM::model()->findAllByAttributes(array(
                                                'pemeriksaantriage_id' => $value->pemeriksaantriage_id,
                                                'isaktif' => true,
                                            )), 'detailpemeriksaantriage_id', 'detailpemeriksaantriage_nama'),
                                    array(
                                        'empty' => '-- Pilih --',
                                        'class' => 'span3 required tes',
                                        'onChange' => 'loadSkor(this)',
                                        'a' => $value->detailpemeriksaantriage_id
                                    )
                            );
                            ?>
                        </td>
                        <td>
                            <?php
                            // echo $value->skor;
                            echo $form->textField($modAsesTriaseDet, 'skor[' . $key . ']', array('readonly' => true, 'class' => 'skor required', 'skor' => $value->skor));
                            ?>
                        </td>
                    </tr>
                <?php
                }

            }
    
        } else {
            echo '<tr><td colspan="3">Tidak ditemukan list master pemeriksaan triage</td></tr>';
        }
        ?>
    </tbody>
    <tfoot>
        <tr>
            <td></td>
            <td>Total Skor</td>
            <td>
                <?php
                echo $form->textField($modAsesTriase, 'totalskor', array('readonly' => true, 'class' => 'required'));
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td>Warna Triage</td>
            <td>
                <?php
                echo $form->textField($modAsesTriase, 'warnatriage', array('readonly' => true, 'class' => 'required'));
                ?>
            </td>
        </tr>
        <tr>
            <td></td>
            <td></td>
            <td>
                <?php

// echo '<pre>'; var_dump($modAsesTriase->attributes); die;


                if(isset($_GET['display']) || isset($_GET['sukses']) || !empty($_GET['pendaftaran_id'])){
                    $query = PrioritastriageM::model()->findByAttributes(array('prioritas_nama' => $modAsesTriase->warnatriage));

                    if($modAsesTriase->warnatriage == 'Hijau'){
                        echo $form->textField($modAsesTriase, 'code', array('readonly' => true,'style' => 'background-color: green;'));
                    } else if($modAsesTriase->warnatriage == 'Kuning'){
                        echo $form->textField($modAsesTriase, 'code', array('readonly' => true,'style' => 'background-color: yellow;'));
                    } else if($modAsesTriase->warnatriage == 'Merah'){
                        echo $form->textField($modAsesTriase, 'code', array('readonly' => true,'style' => 'background-color: red;'));
                    }
                } else {
                    echo $form->textField($modAsesTriase, 'code', array('readonly' => true));
                }
                echo $form->hiddenField($modAsesTriase, 'prioritastriage_id', array('class' => 'prioritastriage_id'));
                ?>
            </td>
        </tr>
    </tfoot>
</table>
<div>
    <div class="control-group">
        <div class="controls">
            <?= CHtml::activeRadioButton($modAsesTriase, 'ruang', array('class' => 'btn-check', 'value' => 'Death on Arrival', 'uncheckValue' => null)); ?>
            <label>Ruang P-0</label>
            <?= CHtml::activeRadioButton($modAsesTriase, 'ruang', array('class' => 'p1', 'value' => 'Ruang P-1', 'uncheckValue' => null)); ?><label style="color:  red">Ruang P-1(Resusitasi)</label>
            <?= CHtml::activeRadioButton($modAsesTriase, 'ruang', array('class' => 'p2', 'value' => 'Ruang P-2', 'uncheckValue' => null)); ?><label style="color:  #d8da26">Ruang P-2</label>
            <?= CHtml::activeRadioButton($modAsesTriase, 'ruang', array('class' => 'p3', 'value' => 'Ruang P-3', 'uncheckValue' => null)); ?><label style="color:  green">Ruang P-3</label>
            <?= CHtml::activeRadioButton($modAsesTriase, 'ruang', array('class' => 'screening', 'value' => 'Screening', 'uncheckValue' => null)); ?><label style="color:  #ff85ed">Screening</label>
            <?= CHtml::activeRadioButton($modAsesTriase, 'ruang', array('class' => 'aps', 'value' => 'APS', 'uncheckValue' => null)); ?><label style="color:  #78a7ff">APS</label>
        </div>
    </div>
    <div class="control-group">
            <?php echo $form->labelEx($modAsesTriase, 'keputusan', array('class' => 'control-label')) ?>
        <div class="controls">
            <?php
            echo $form->textArea($modAsesTriase, 'keputusan', array('class' => 'autogrow required'));
            ?>
        </div>
    </div>
</div>
<script>
    changeLabelColor();
    function changeLabelColor(obj) {
        var id = $(obj).find(":selected").val();
        var label = $("input[type='radio'][name='RDAsesmentriagewpssT[ruang]']").parent('label').text();
        console.log(label);
    }
    function loadSkor(obj) {
        var id = $(obj).find(":selected").val();

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getSkor'); ?>',
            data: {id: id},
            dataType: "json",
            success: function (data) {
                $(obj).parents('tr').find('.skor').val(data.skor);
                hitung();
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    function hitung() {
        var sum = 0;
        var p = $(".warna").css("background-color", "white");
        $(".skor").each(function () {
            if ($(this).val() != "") {
                sum += parseInt($(this).val());
            }
        });
        $("#RDAsesmentriagewpssT_totalskor").val(sum);

        if (sum >= 0 && sum <= 1) {
            $('.p3').prop('checked', true);
            var warna = 'Hijau';
            $('#RDAsesmentriagewpssT_code').attr('style', 'background-color: green');
        } else if (sum >= 2 && sum <= 4) {
            $('.p2').prop('checked', true);
            var warna = 'Kuning';
            $('#RDAsesmentriagewpssT_code').attr('style', 'background-color: yellow');
        } else if (sum >= 5) {
            $('.p1').prop('checked', true);
            var warna = 'Merah';
            $('#RDAsesmentriagewpssT_code').attr('style', 'background-color: red');
      
        }

        $.ajax({
            type: 'POST',
            url: '<?php echo $this->createUrl('getColor'); ?>',
            data: {
                warna: warna
            },
            dataType: "json",
            success: function (data) {
                $('#RDAsesmentriagewpssT_prioritastriage_id').val(data.prioritastriage_id);
                $('#RDAsesmentriagewpssT_warnatriage').val(data.warna);
                $('#RDAsesmentriagewpssT_code').css({'background-color': data.code});
            },
            error: function (jqXHR, textStatus, errorThrown) {
                console.log(errorThrown);
            }
        });
    }

    $(document).ready(function() {
        $(".tes").each(function() {
            var val = $(this).attr('a');
            $(this).val(val);
            var skor = $(this).closest('tr').find('.skor').attr('skor');
            $(this).closest('tr').find('.skor').val(skor);

        });
    });
</script>

