<div class="table-responsive" style="overflow-x:auto;">
    <div class='block-tabel'>
        <center>
        <table class="items table table-bordered" id="tblchoise_moews" style="width: 80% !important;">
            <thead>
                <tr>
                    <th class="text-center" width="200px">Parameter</th>  
                    <th class="text-center">Penilaian</th>
                    <th class="text-center" width="50px">Skor</th>
               </tr>
             </thead>
             <tbody>
                 <tr class="trSkorMoews">
                     <td class="font-bold">Respirasi</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[0]nourut',array('value'=>'0')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[0]hasipenilaian_text'); ?>
                        <?php echo CHtml::activeDropDownList($modDetail, '[0]hasipenilaian', LookupM::getItems('meows_respirasi'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'moewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[0]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorMoews">
                    <td class="font-bold">Saturasi O2</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[1]nourut',array('value'=>'1')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[1]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[1]hasipenilaian', LookupM::getItems('meows_saturasioksigen'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'moewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[1]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorMoews">
                    <td class="font-bold">Penggunaan O2</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[2]nourut',array('value'=>'2')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[2]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[2]hasipenilaian', LookupM::getItems('meows_alatbantuo2'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'moewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[2]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorMoews">
                    <td class="font-bold">Suhu (&#176 C)</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[3]nourut',array('value'=>'3')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[3]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[3]hasipenilaian', LookupM::getItems('meows_suhu'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'moewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[3]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorMoews">
                    <td class="font-bold">Tekanan Darah Sistolik</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[4]nourut',array('value'=>'4')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[4]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[4]hasipenilaian', LookupM::getItems('meows_td_sistolik'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'moewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[4]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorMoews">
                    <td class="font-bold">Tekanan Darah Diastolik</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[5]nourut',array('value'=>'5')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[5]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[5]hasipenilaian', LookupM::getItems('meows_td_diastolik'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'moewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[5]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorMoews">
                    <td class="font-bold">Nadi</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[6]nourut',array('value'=>'6')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[6]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[6]hasipenilaian', LookupM::getItems('meows_nadi'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'moewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[6]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorMoews">
                    <td class="font-bold">Tingkat Kesadaran</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[7]nourut',array('value'=>'7')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[7]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[7]hasipenilaian', LookupM::getItems('meows_tingkatkesadaran'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'moewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[7]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorMoews">
                    <td class="font-bold">Nyeri</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[8]nourut',array('value'=>'8')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[8]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[8]hasipenilaian', LookupM::getItems('meows_nyeri'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'moewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[8]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorMoews">
                    <td class="font-bold">Pengeluaran / Lochea</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[9]nourut',array('value'=>'9')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[9]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[9]hasipenilaian', LookupM::getItems('meows_lochea'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'moewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[9]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorMoews">
                    <td class="font-bold">Protein Urin</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[10]nourut',array('value'=>'10')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[10]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[10]hasipenilaian', LookupM::getItems('meows_proteinurin'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'moewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[10]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr>
                    <td colspan="2" class="font-bold">Total Skor</td>
                    <td><?php echo CHtml::activeTextField($model, 'total_skor', array('class' => 'span1 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr>
                    <td colspan="2" class="font-bold">Keterangan Skor</td>
                    <td><?php echo CHtml::activeTextField($model, 'klasifikasi', array('class' => 'span2', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true)); ?> </td>
                </tr>
                 <tr>
                     <th colspan="3" style="font-weight: bold; background-color: #CCCCCC">
                         Respon Klinis Terhadap Modified Obstetric Early Warning System (MOEWS)
                     </th>
                </tr>
                <tr>
                    <td class="font-bold">Monitoring Frekuensi</td>
                    <td colspan="2"><?php echo CHtml::activeTextField($model, 'monitoring_frekuensi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true,'style'=>'width:40%;')); ?> </td>
                </tr>
                <tr>
                    <td class="font-bold">Petugas</td>
                    <td colspan="2"><?php echo CHtml::activeTextField($model, 'monitoring_petugas', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true,'style'=>'width:50%;')); ?> </td>
                </tr>
                <tr>
                    <td class="font-bold">Tindakan</td>
                    <td colspan="2"><?php echo CHtml::activeTextArea($model, 'tindakan', array('cols'=>5,'rows'=>6,'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true,'style'=>'width:100%;')); ?> </td>
                </tr>
             </tbody>
        </table>
            </center>
    </div>
</div>