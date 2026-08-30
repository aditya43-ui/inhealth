<div class="table-responsive" style="overflow-x:auto;">
    <div class='block-tabel'>
        <center>
        <table class="items table table-bordered" id="tblchoise_ews" style="width: 80% !important;">
            <thead>
                <tr>
                    <th class="text-center" width="200px">Parameter</th>  
                    <th class="text-center">Penilaian</th>
                    <th class="text-center" width="50px">Skor</th>
               </tr>
             </thead>
             <tbody>
                 <tr class="trSkorEws">
                     <td class="font-bold">Pernapasan (kali/ per menit)</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[0]nourut',array('value'=>'0')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[0]hasipenilaian_text'); ?>
                        <?php echo CHtml::activeDropDownList($modDetail, '[0]hasipenilaian', LookupM::getItemstoName2('ews_pernafasan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'ewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[0]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorEws">
                    <td class="font-bold">Nadi</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[1]nourut',array('value'=>'1')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[1]hasipenilaian_text'); ?>
                        
                     <?php echo CHtml::activeDropDownList($modDetail, '[1]hasipenilaian', LookupM::getItemstoName2('ews_nadi'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'ewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[1]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorEws">
                    <td class="font-bold">Oksigen Tambahan</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[2]nourut',array('value'=>'2')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[2]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[2]hasipenilaian', LookupM::getItemstoName2('ews_alatbantuo2'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'ewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[2]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorEws">
                    <td class="font-bold">Suhu (&#176 C)</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[3]nourut',array('value'=>'3')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[3]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[3]hasipenilaian', LookupM::getItemstoName2('ews_suhu'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'ewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[3]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorEws">
                    <td class="font-bold">Denyut Jantung</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[4]nourut',array('value'=>'4')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[4]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[4]hasipenilaian', LookupM::getItemstoName2('ews_denyutjantung'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'ewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[4]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorEws">
                    <td class="font-bold">Tekanan Darah Sistolik</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[5]nourut',array('value'=>'5')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[5]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[5]hasipenilaian', LookupM::getItemstoName2('ews_td_sistolik'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'ewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[5]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorEws">
                    <td class="font-bold">Kesadaran</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[6]nourut',array('value'=>'6')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[6]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[6]hasipenilaian', LookupM::getItemstoName2('ews_kesadaran'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'ewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[6]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr>
                    <td colspan="2" class="font-bold">Total Skor</td>
                    <td><?php echo CHtml::activeTextField($model, 'total_skor', array('class' => 'span1 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                 <tr>
                     <th colspan="3" style="font-weight: bold; background-color: #CCCCCC">
                         Respon Klinis Terhadap National Early Warning System (NEWS)
                     </th>
                </tr>
                <tr>
                    <td class="font-bold">Klasifikasi</td>
                    <td colspan="2"><?php echo CHtml::activeTextField($model, 'klasifikasi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true,'style'=>'width:40%;')); ?> </td>
                </tr>
                <tr>
                    <td class="font-bold">Respon Klinis</td>
                    <td colspan="2"><?php echo CHtml::activeTextArea($model, 'monitoring_frekuensi', array('cols'=>5,'rows'=>3,'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true,'style'=>'width:100%;')); ?> </td>
                </tr>
                <tr>
                    <td class="font-bold">Tindakan</td>
                    <td colspan="2"><?php echo CHtml::activeTextArea($model, 'tindakan', array('cols'=>5,'rows'=>6,'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true,'style'=>'width:100%;')); ?> </td>
                </tr>
                <tr>
                     <th colspan="3" style="font-weight: bold; background-color: #CCCCCC">
                        Nilai Kritik
                     </th>
                </tr>
                <tr>
                    <td class="font-bold">Laboratorium</td>
                    <td colspan="2"><?php echo CHtml::activeTextField($model, 'nilaikritik_laboratorium', array('onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => false,'style'=>'width:40%;')); ?> </td>
                </tr>
                <tr>
                    <td class="font-bold">Radiologi</td>
                    <td colspan="2"><?php echo CHtml::activeTextField($model, 'nilaikritik_radiologi', array('onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => false,'style'=>'width:40%;')); ?> </td>
                </tr>
             </tbody>
        </table>
            </center>
    </div>
</div>