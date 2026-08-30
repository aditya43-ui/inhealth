<div class="row-fluid" style='overflow-x: scroll;'>
    <div class="col-sm-12">
        <table id="table-anggota" class="table table-striped table-bordered table-condensed" width='100%'>
            <thead>
                <tr>
                    <th colspan="14" style='text-align: center;'>SKOR BROMAGE PASCA ANESTESI / SEDASI</th>
                </tr>
                <tr>
                    <th >Skor Bromage</th>
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
                    <td rowspan="3">
                        <img src="<?php echo Params::urlPhotoAnatomiTubuh() . $modGambarTubuh->GambarSkorBromage; ?>"/> 
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">0-3</td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center; width: 170px;">
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'model' => $modBromage,
                            'attribute' => 'jam',
                            'mode' => 'time',
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                            ),
                            'htmlOptions' => array('readonly' => true, 'class' => 'span2', 'style' => 'float:left',
                                'onkeypress' => "return $(this).focusNextInputField(event)"),
                        ));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modBromage, 'bromage_0', CHtml::listData($nilaiBromage, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modBromage, 'bromage_5', CHtml::listData($nilaiBromage, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modBromage, 'bromage_15', CHtml::listData($nilaiBromage, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modBromage, 'bromage_30', CHtml::listData($nilaiBromage, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modBromage, 'bromage_45', CHtml::listData($nilaiBromage, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modBromage, 'bromage_1', CHtml::listData($nilaiBromage, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modBromage, 'bromage_2', CHtml::listData($nilaiBromage, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modBromage, 'bromage_3', CHtml::listData($nilaiBromage, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modBromage, 'bromage_4', CHtml::listData($nilaiBromage, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                    <td rowspan="3" style="vertical-align: middle;text-align: center;">
                        <?php
                        echo $form->dropDownList($modBromage, 'bromage_keluar', CHtml::listData($nilaiBromage, 'lookup_value', 'lookup_name'), array('class' => 'span1', 'empty' => '-- Pilih--'));
                        ?>
                    </td>
                </tr>
                <!-- End Baris Sirkulasi-->

            </tbody>
        </table>
    </div>

</div>