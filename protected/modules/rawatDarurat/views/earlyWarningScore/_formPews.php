<div class="table-responsive" style="overflow-x:auto;">
    <div class='block-tabel'>
        <center>
        <table class="items table table-bordered" id="tblchoise_pews" style="width: 80% !important;">
            <thead>
                <tr>
                    <th class="text-center" width="250px">Parameter</th>  
                    <th class="text-center">Penilaian</th>
                    <th class="text-center" width="50px">Skor</th>
               </tr>
             </thead>
             <tbody>
                 <tr class="trSkorPews">
                     <td class="font-bold">Perilaku</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[0]nourut',array('value'=>'0')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[0]hasipenilaian_text'); ?>
                        <?php echo CHtml::activeDropDownList($modDetail, '[0]hasipenilaian', LookupM::getItems('pews_perilaku'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'pewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[0]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorPews">
                    <td class="font-bold">Kardiovaskular</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[1]nourut',array('value'=>'1')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[1]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[1]hasipenilaian', LookupM::getItems('pews_kardiovaskuler'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'pewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[1]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr class="trSkorPews">
                    <td class="font-bold">Respirasi</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[2]nourut',array('value'=>'2')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[2]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[2]hasipenilaian', LookupM::getItems('pews_respirasi'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'pewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[2]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr>
                     <th colspan="3" style="font-weight: bold; background-color: #CCCCCC">
                         2 Skor Tambahan (Kondisional)
                     </th>
                </tr>
                <tr class="trSkorPews">
                    <td class="font-bold">1/4 jam nebulasi (terus menerus) atau muntah persisten setelah operasi</td>
                    <td> 
                        <?php echo CHtml::activeHiddenField($modDetail, '[3]nourut',array('value'=>'3')); ?>
                        <?php echo CHtml::activeHiddenField($modDetail, '[3]hasipenilaian_text'); ?>
                     <?php echo CHtml::activeDropDownList($modDetail, '[3]hasipenilaian', LookupM::getItems('pews_skortambahan'), array('empty' => '-- Pilih --', 'class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);",'onchange' => 'pewsNilai(this)','style'=>'width:100%;')); ?> 
                    </td>      
                    <td><?php echo CHtml::activeTextField($modDetail, '[3]skorpenilaian', array('class' => 'span1 integer numbersOnly skorpenilaian', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                <tr>
                    <td colspan="2" class="font-bold">Total Skor</td>
                    <td><?php echo CHtml::activeTextField($model, 'total_skor', array('class' => 'span1 integer numbersOnly', 'onkeypress' => "return $(this).focusNextInputField(event);", 'maxlength' => 10, 'readonly' => true)); ?> </td>
                </tr>
                 <tr>
                     <th colspan="3" style="font-weight: bold; background-color: #CCCCCC">
                         Respon Klinis Terhadap Pediatric Early Warning System (PEWS)
                     </th>
                </tr>
                <tr>
                    <td class="font-bold">Monitoring</td>
                    <td colspan="2"><?php echo CHtml::activeTextField($model, 'monitoring_frekuensi', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true,'style'=>'width:40%;')); ?> </td>
                </tr>
                <tr>
                    <td class="font-bold">Petugas</td>
                    <td colspan="2"><?php echo CHtml::activeTextField($model, 'monitoring_petugas', array('class' => 'span3', 'onkeypress' => "return $(this).focusNextInputField(event);", 'readonly' => true,'style'=>'width:60%;')); ?> </td>
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