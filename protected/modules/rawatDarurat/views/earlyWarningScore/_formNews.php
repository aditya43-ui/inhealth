<div class="table-responsive" style="overflow-x:auto;">
    <div class='block-tabel'>
        <center>
        <table class="items table table-bordered" id="tblchoise_news" style="width: 80% !important;">
            <thead>
                <tr>
                    <th class="text-center" width="20%">Parameter</th>  
                    <th class="text-center" width="30%">Penilaian</th>
                    <th class="text-center" width="30%">Kriteria Penilaian</th>
               </tr>
             </thead>
             <tbody>
                 <tr class="trSkorNews">
                     <td class="font-bold">Suhu (&#176 C)</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[0]nourut',array('value'=>'0')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[0]hasipenilaian_text'); ?>
                        <?php echo CHtml::activeTextField($modDetail, '[0]hasipenilaian', array('class' => 'float2 skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);",'onkeyup'=>'changeNilaiSuhu();', 'style'=>'width:100%')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[0]skorpenilaian', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'style'=>'width:100%')); ?> </td>
                </tr>
                <tr class="trSkorNews">
                    <td class="font-bold">Pernapasan</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[1]nourut',array('value'=>'1')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[1]hasipenilaian_text'); ?>
                        <?php echo CHtml::activeTextField($modDetail, '[1]hasipenilaian', array('class' => 'float2 skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);",'onkeyup'=>'changeNilaiPernapasan();', 'style'=>'width:100%')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[1]skorpenilaian', array('class' => '', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'style'=>'width:100%')); ?> </td>
                </tr>
                <tr class="trSkorNews">
                    <td class="font-bold">Grunting (Mendengkur)</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[2]nourut',array('value'=>'2')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[2]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[2]hasipenilaian', LookupM::getItems('newborn_ews_grunting'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'newsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[2]skorpenilaian', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'style'=>'width:100%')); ?> </td>
                </tr>
                <tr class="trSkorNews">
                    <td class="font-bold">Nadi</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[3]nourut',array('value'=>'3')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[3]hasipenilaian_text'); ?>
                        <?php echo CHtml::activeTextField($modDetail, '[3]hasipenilaian', array('class' => 'integer2 skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);",'onkeyup'=>'changeNilaiNadi();', 'style'=>'width:100%')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[3]skorpenilaian', array('class' => 'span3 ', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'style'=>'width:100%')); ?> </td>
                </tr>
                <tr class="trSkorNews">
                    <td class="font-bold">Warna (SpO2)*</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[4]nourut',array('value'=>'4')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[4]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[4]hasipenilaian', LookupM::getItems('newborn_ews_warnaspo2'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'newsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[4]skorpenilaian', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'style'=>'width:100%')); ?> </td>
                </tr>
                <tr class="trSkorNews">
                    <td class="font-bold">Glukosa < 2,6 mmols</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[5]nourut',array('value'=>'5')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[5]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[5]hasipenilaian', LookupM::getItems('newborn_ews_glukosa'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'newsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[5]skorpenilaian', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'style'=>'width:100%')); ?> </td>
                </tr>
                <tr class="trSkorNews">
                    <td class="font-bold">Neuologi</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[6]nourut',array('value'=>'6')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[6]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[6]hasipenilaian', LookupM::getItems('newborn_ews_neurologi'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'newsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[6]skorpenilaian', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true, 'style'=>'width:100%')); ?> </td>
                </tr>
                <tr>
                    <td colspan="2" rowspan="3" class="font-bold" valign="middle">Skor</td>
                    <td><div style="float:right;">Hijau&nbsp;<?php echo CHtml::activeTextField($model, 'total_skor_hijau', array('class' => 'span1 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?></div></td>
                </tr>
                <tr>
                    <td><div style="float:right;">Kuning&nbsp;<?php echo CHtml::activeTextField($model, 'total_skor_kuning', array('class' => 'span1 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?></div></td>
                </tr>
                 <tr>
                    <td><div style="float:right;">Merah&nbsp;<?php echo CHtml::activeTextField($model, 'total_skor_merah', array('class' => 'span1 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?></div></td>
                </tr>
                 <tr>
                     <th colspan="3" style="font-weight: bold; background-color: #CCCCCC">
                         Respon Klinis Terhadap Modified Obstetric Early Warning System (MOEWS)
                     </th>
                </tr>
                <tr>
                    <td class="font-bold">Warna / Nilai EWS</td>
                    <td colspan="2"><?php echo CHtml::activeDropDownList($model, 'total_skor', array('Hijau (0)'=>'Hijau (0)','Kuning (1)'=>'Kuning (1)', 'Kuning (≥1)'=>'Kuning (≥1)', 'Merah (≥1)'=>'Merah (≥1)'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange'=>'totalNews();')); ?>  </td>
                </tr>
                <tr>
                    <td class="font-bold">Monnitoring Frekuensi</td>
                    <td colspan="2"><?php echo CHtml::activeTextField($model, 'monitoring_frekuensi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true,'style'=>'width:40%;')); ?> </td>
                </tr>
                <tr>
                    <td class="font-bold">Asuhan yang Diberikan</td>
                    <td colspan="2"><?php echo CHtml::activeTextArea($model, 'tindakan', array('cols'=>5,'rows'=>6,'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true,'style'=>'width:100%;')); ?> </td>
                </tr>
             </tbody>
        </table>
            </center>
    </div>
</div>