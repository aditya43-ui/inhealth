<style>
    #tab_norton td,
    #tab_norton th {
        border: 1px solid black;
        padding: 2px;
    }

    #tab_norton th {
        font-weight: bold;
        text-align: center;
    }

    #tab_norton .skor,
    #tab_norton .total_skor {
        text-align: right;
    }
</style>

<div class="panel panel-success panel_cgsews">
    <div class="panel-heading">
        <div class="panel-title"><?php echo $form->checkBox($modIntegumen, 'integumen', array('class' => 'cek_ews', 'uncheckValue' => null)); ?>
            <i class="far fa-file-alt"></i> Integumen
        </div>
    </div>
    <div class="panel-body">
        <div class="control-group">
            <?php
            //var_dump($modPemeriksaanFisik->attributes); die;
            echo $form->label($modIntegumen, 'warna', array('class' => 'control-label', 'label' => "Warna")); ?>
            <div class="controls">
                <?php echo '<label class="radio-inline">' . $form->radioButton($modIntegumen, 'warna[val]', array('value' => 'Normal', 'uncheckValue' => null)) . " " . CHtml::label('Normal', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modIntegumen, 'warna[val]', array('value' => 'Pucat', 'uncheckValue' => null)) . " " . CHtml::label('Pucat', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modIntegumen, 'warna[val]', array('value' => 'Kemerahan', 'uncheckValue' => null)) . " " . CHtml::label('Kemerahan', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modIntegumen, 'warna[val]', array('value' => 'Lain2', 'uncheckValue' => null))
                    . " " . $form->textField($modIntegumen, 'warna[lain2]', array('class' => 'span3')) . '</label>'; ?>
            </div>
        </div>
        <?php echo $form->radioButtonListRow($modIntegumen, 'tugor', array('Baik' => 'Baik', 'Sedang' => 'Sedang', 'Buruk' => 'Buruk'), array('template' => '<label class="radio-inline">{input}{label}</label>')); ?>
        <div class="control-group">
            <?php
            //var_dump($modPemeriksaanFisik->attributes); die;
            echo $form->label($modIntegumen, 'integritas', array('class' => 'control-label', 'label' => "Integritas")); ?>
            <div class="controls">
                <?php echo '<label class="radio-inline">' . $form->radioButton($modIntegumen, 'integritas[val]', array('value' => 'Normal', 'uncheckValue' => null)) . " " . CHtml::label('Normal', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modIntegumen, 'integritas[val]', array('value' => 'Luka', 'uncheckValue' => null)) . " " . CHtml::label('Luka', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modIntegumen, 'integritas[val]', array('value' => 'Kemerahan', 'uncheckValue' => null)) . " " . CHtml::label('Kemerahan', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modIntegumen, 'integritas[val]', array('value' => 'Bula', 'uncheckValue' => null)) . " " . CHtml::label('Bula', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modIntegumen, 'integritas[val]', array('value' => 'Ptekie', 'uncheckValue' => null)) . " " . CHtml::label('Ptekie', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modIntegumen, 'integritas[val]', array('value' => 'Memar', 'uncheckValue' => null)) . " " . CHtml::label('Memar', '') . '</label>'; ?>
                <?php echo '<label class="radio-inline">' . $form->radioButton($modIntegumen, 'integritas[val]', array('value' => 'Lain2', 'uncheckValue' => null))
                    . " " . $form->textField($modIntegumen, 'integritas[lain2]', array('class' => 'span3')) . '</label>'; ?>
            </div>
        </div>

        <h4 style="text-align: center;">SKALA NORTON</h4>
        <table width="100%" id="tab_norton">
            <thead>
                <tr>
                    <th>Kategori</th>
                    <th>4</th>
                    <th>3</th>
                    <th>2</th>
                    <th>1</th>
                    <th>Skor</th>
                </tr>
            </thead>
            <tbody>
                <tr>
                    <td>Kondisi Fisik</td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_kondisifisik', array('value' => 4, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Baik', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_kondisifisik', array('value' => 3, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Sedang', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_kondisifisik', array('value' => 2, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Buruk', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_kondisifisik', array('value' => 1, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Sangat Buruk', '') ?></label></td>
                    <td><?php echo CHtml::textField('skor', 0, array('class' => 'skor span1', 'readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td>Status Mental</td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_statusmental', array('value' => 4, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Sadar', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_statusmental', array('value' => 3, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Apatis', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_statusmental', array('value' => 2, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Bingung', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_statusmental', array('value' => 1, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Stupor', '') ?></label></td>
                    <td><?php echo CHtml::textField('skor', 0, array('class' => 'skor span1', 'readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td>Aktifitas</td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_aktifitas', array('value' => 4, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Jalan Sendiri', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_aktifitas', array('value' => 3, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Jalan dengan Bantuan', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_aktifitas', array('value' => 2, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Kursi Roda', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_aktifitas', array('value' => 1, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Ditempat Tidur', '') ?></label></td>
                    <td><?php echo CHtml::textField('skor', 0, array('class' => 'skor span1', 'readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td>Mobilitas</td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_mobilitas', array('value' => 4, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Bebas Bergerak', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_mobilitas', array('value' => 3, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Agak Terbatas', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_mobilitas', array('value' => 2, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Sangat Terbatas', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_mobilitas', array('value' => 1, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Tidak Mampu Bergerak', '') ?></label></td>
                    <td><?php echo CHtml::textField('skor', 0, array('class' => 'skor span1', 'readonly' => true)); ?></td>
                </tr>
                <tr>
                    <td>Inkontinesia</td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_inkontinesia', array('value' => 4, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Kontinen', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_inkontinesia', array('value' => 3, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Kadang Inkontinensia Uri', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_inkontinesia', array('value' => 2, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Selalu Inkontinensia Uri', '') ?></label></td>
                    <td><label class="radio-inline"><?php echo $form->radioButton($modIntegumen, 'norton_inkontinesia', array('value' => 1, 'uncheckValue' => null, 'class' => 'norton_input')) . CHtml::label('Inkontinensia Uri & Alfi', '') ?></label></td>
                    <td><?php echo CHtml::textField('skor', 0, array('class' => 'skor span1', 'readonly' => true)); ?></td>
                </tr>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="5" style="text-align: right;">Total Skor</td>
                    <td><?php echo $form->textField($modIntegumen, 'norton_totalskor', array('readonly' => true, 'class' => 'span1 total_skor')); ?></td>
                </tr>
            </tfoot>
        </table>
        <br>
        <div class="col-sm-6">
            Keterangan :<br>
            <ul>
                <li>16 - 20 : Tidak ada Resiko Terjadi Dekubitus</li>
                <li>12 - 15 : Resiko Sedang (Rentang Terjadi Dekubitus)</li>
                <li>
                    < 12 : Resiko Tinggi Terjadi Dekubitus</li>
            </ul>
        </div>
        <div class="col-sm-6">
            <?php echo $form->textAreaRow($modIntegumen, 'kesimpulan'); ?>
        </div>

    </div>
    </div>

    <script>
        function hitungSkorNorton() {
            var total = 0;
            $("#tab_norton tbody tr").each(function() {
                var nilai = $(this).find(".norton_input:checked").val();
                if (nilai == null) {
                    nilai = 0;
                }
                total += parseInt(nilai);
                $(this).find(".skor").val(nilai);
            });

            $("#tab_norton .total_skor").val(total);
        }

        $(document).ready(function() {
            $("#tab_norton .norton_input").on('click', hitungSkorNorton);

            hitungSkorNorton();
        });

        function ceklisCGSEWS() {
            $(".cek_ews").each(function() {
                $(this).parents(".panel_cgsews")
                    .find(".panel-body").hide()
                    .find(":input").prop("disabled", true);
                if ($(this).is(":checked")) {
                    $(this).parents(".panel_cgsews")
                        .find(".panel-body").show()
                        .find(":input").prop("disabled", false);

                }
            });
        }

        $(document).ready(function() {
            $(".cek_ews").on("click", ceklisCGSEWS);
            ceklisCGSEWS();
        });
    </script>