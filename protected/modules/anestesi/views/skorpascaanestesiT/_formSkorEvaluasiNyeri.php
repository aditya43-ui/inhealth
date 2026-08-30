<div class="row-fluid" style='overflow-x: scroll;'>
    <div class="col-sm-12">
        <table id="table-anggota" class="table table-striped table-bordered table-condensed" width='100%'>
            <thead>
                <tr>
                    <th colspan="14" style='text-align: center;'>EVALUASI NYERI PASCA ANESTESI / SEDASI</th>
                </tr>
                <tr>
                    <th >Skor Nyeri Pra Anestesi : <?php
                        echo $form->dropDownList($modEvaluasiNyeri, 'skornyeri_praanestesi', CHtml::listData($nilaiEvaluasiNyeri, 'lookup_value', 'lookup_name'), array('class' => 'span2', 'empty' => '-- Pilih--'));
                        ?></th>
                    <th style="text-align:center;">Nilai</th>
                    <th style="text-align:center;">Jam</th>
                    <th style="text-align:center;">0"</th>
                    <th style="text-align:center;">5"</th>
                    <th style="text-align:center;">15"</th>
                    <th style="text-align:center;">30"</th>
                    <th style="text-align:center;">45"</th>
                    <th style="text-align:center;">1'</th>
                    <th style="text-align:center;">2'</th>
                    <th style="text-align:center;">3'</th>
                    <th style="text-align:center;">4'</th>
                    <th style="text-align:center;">Keluar</th>
                </tr>
            </thead>
            <tbody>
                <!-- Baris Sirkulasi-->
                <tr>
                    <td>Nyeri : 
                        <?php
                        echo $form->radioButtonList($modEvaluasiNyeri, 'keluhan_nyeri', array('1' => 'Ada', '2' => 'Tidak Ada'), array(
                            'template' => '{input}&nbsp;&nbsp;{label}&nbsp;&nbsp;&nbsp;',
                            'separator' => '',
                                )
                        );
                        ?></td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">1-10</td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center; width: 170px;">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modEvaluasiNyeri,
                            'attribute' => 'nyeri_jam',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class'=>'span2', 'style' => 'float:left',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modEvaluasiNyeri, 'nyeri_0', CHtml::listData($nilaiEvaluasiNyeri, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modEvaluasiNyeri, 'nyeri_5', CHtml::listData($nilaiEvaluasiNyeri, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modEvaluasiNyeri, 'nyeri_15', CHtml::listData($nilaiEvaluasiNyeri, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modEvaluasiNyeri, 'nyeri_30', CHtml::listData($nilaiEvaluasiNyeri, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modEvaluasiNyeri, 'nyeri_45', CHtml::listData($nilaiEvaluasiNyeri, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modEvaluasiNyeri, 'nyeri_1', CHtml::listData($nilaiEvaluasiNyeri, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modEvaluasiNyeri, 'nyeri_2', CHtml::listData($nilaiEvaluasiNyeri, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modEvaluasiNyeri, 'nyeri_3', CHtml::listData($nilaiEvaluasiNyeri, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modEvaluasiNyeri, 'nyeri_4', CHtml::listData($nilaiEvaluasiNyeri, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modEvaluasiNyeri, 'nyeri_keluar', CHtml::listData($nilaiEvaluasiNyeri, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                </tr>
                <tr>
                    <td>Metode Penilaian Nyeri</td>
                </tr>
                <tr>
                    <td><div class="control-group metode">
                            <div class='controls'>
                                <?php echo $form->checkBox($modEvaluasiNyeri, 'metode_vas', array(($modEvaluasiNyeri->metode_vas != "") ? ' ' : 'checked' => false, 'class' => 'pilih')); ?> <label>Metode VAS</label> 
                                <?php echo $form->checkBox($modEvaluasiNyeri, 'metode_comfortscales', array('class' => '')); ?> <label>Metode Comfortscale</label>                         
                            </div>
                        </div></td>
                </tr>
                <!-- End Baris Sirkulasi-->

            </tbody>
        </table>
    </div>

</div>