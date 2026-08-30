<tr>
    <td style="text-align:center;">
        <?php 
            echo CHtml::textField('noUrut',1,array('class'=>'span1 noUrut','readonly'=>true,'style'=>'text-align:center;'));
        ?>
    </td>
    <td><?php echo CHtml::activeHiddenField($modUnitDosisDetail, '[0]obatalkes_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php $this->widget('MyJuiAutoComplete',array(
                    'model'=>$modUnitDosisDetail,
                    'attribute'=>'[0]obatalkesNama',
                    'source'=>'js: function(request, response) {
                                   $.ajax({
                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/obatUnitDosis').'",
                                       dataType: "json",
                                       data: {
                                           term: request.term,
                                           idObat: $("#RIUnitdosisdetailT_0_obatalkes_id").val(),
                                       },
                                       success: function (data) {
                                               response(data);
                                       }
                                   })
                                }',
                    'options'=>array(
                       'showAnim'=>'fold',
                       'minLength' =>2,
                       'focus'=> 'js:function( event, ui ) {
                            $(this).val( ui.item.label);
                            return false;
                        }',
                       'select'=>'js:function( event, ui ) {
                            setObat($(this), ui.item);
                            return false;
                        }',

                    ),
                    'tombolDialog'=>array("idDialog"=>'dialogObat','jsFunction'=>"setDialog(this);"),
                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)",),
        )); ?>
        <?php echo CHtml::activeHiddenField($modUnitDosisDetail, '[0]sumberdana_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeHiddenField($modUnitDosisDetail, '[0]satuankecil_id', array('readonly'=>true,'class'=>'inputFormTabel')) ?>
        <?php echo CHtml::activeHiddenField($modUnitDosisDetail, '[0]harganetto', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php echo CHtml::activeHiddenField($modUnitDosisDetail, '[0]hargajual', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
        <?php echo CHtml::activeHiddenField($modUnitDosisDetail, '[0]hargasatuan', array('readonly'=>true,'class'=>'inputFormTabel integer')) ?>
    </td>
    <td>
        <?php
            echo CHtml::activeDropDownList($modUnitDosisDetail,'[0]satuankecil_id',CHtml::listData(SatuankecilM::model()->findAll(),'satuankecil_id','satuankecil_nama'),array('style'=>'width:80px'));
        ?>
    </td>
    <td style='text-align:center'>
        <?php 
            echo CHtml::activeDropDownList($modUnitDosisDetail,'[0]dosis1',  CustomFunction::getDaftarAngka(),array('style'=>'width:35px'));
            echo " X ".CHtml::activeDropDownList($modUnitDosisDetail,'[0]dosis2',CustomFunction::getDaftarAngka(),array('style'=>'width:35px'));

        ?>
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($modUnitDosisDetail,'[0]jmlhari',array('class'=>'span1','readonly'=>false))
        ?>
    </td>
    <td>
        <?php
            echo CHtml::activeTextField($modUnitDosisDetail,'[0]jmlobat',array('class'=>'span1','readonly'=>false))
        ?>
    </td>
    <td><div class="input-append"><?php echo CHtml::activeTextField($modUnitDosisDetail, '[0]tglinsmulai', array('readonly'=>true,'class'=>'span1 tanggal dtPicker2', 'style'=>'float:left;','value'=>date('d M Y'),'style'=>'float:left;width:80px;')); ?><span class="add-on"><i class="entypo-calendar"></i></span></div></td>
    <td><div class="input-append"><?php echo CHtml::activeTextField($modUnitDosisDetail, '[0]jaminsmulai', array('readonly'=>true,'class'=>'span1 jam dtPicker3', 'style'=>'float:left;','value'=>date('00:00:00'),'style'=>'float:left;width:80px;')); ?><span class="add-on"><i class="icon-time"></i></span></div></td>
    <td><div class="input-append"><?php echo CHtml::activeTextField($modUnitDosisDetail, '[0]tglinsstop', array('readonly'=>true,'class'=>'span1 jam dtPicker2', 'style'=>'float:left;','value'=>date('d M Y'),'style'=>'float:left;width:80px;')); ?><span class="add-on"><i class="entypo-calendar"></span></div></td>
    <td><div class="input-append"><?php echo CHtml::activeTextField($modUnitDosisDetail, '[0]jaminsstop', array('readonly'=>true,'class'=>'span1 tanggal dtPicker3', 'style'=>'float:left;','value'=>date('00:00:00'),'style'=>'float:left;width:80px;')); ?><span class="add-on"><i class="icon-time"></i></span></div></td>            
    <td>
        <?php
            echo CHtml::activeDropDownList($modUnitDosisDetail,'[0]etiket',LookupM::getItems('etiket'),array());
        ?>
    </td>
    <td>
        <?php 
            if($removeButton){
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowObat(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah Obat ')); 
                echo "<br><br>";
                echo CHtml::link("<i class='icon-minus'></i>", '#', array('onclick'=>'batalObat(this);return false;','rel'=>'tooltip','title'=>'Klik untuk membatalkan Obat'));
            } else {
                echo CHtml::link("<i class='icon-plus'></i>", '#', array('onclick'=>'addRowObat(this);return false;','rel'=>'tooltip','title'=>'Klik untuk menambah Obat'));
            }
        ?>
    </td>
</tr>