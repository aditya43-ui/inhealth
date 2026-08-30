<?php
$this->widget('application.extensions.moneymask.MMask', array(
    'element' => '.currency',
    'currency' => 'PHP',
    'config' => array(
        'symbol' => 'Rp ',
        //        'showSymbol'=>true,
        //        'symbolStay'=>true,
        'defaultZero' => true,
        'allowZero' => true,
        'precision' => 0,
    )
));
?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Data <b>Menu Makanan</b>
        </div>
    </div>
    <div class="panel-body table-responsive">

        <table class="items table table-bordered table-condensed" id="tblInputAnamnesisDiet">
            <thead>
                <tr>
                    <th>Waktu Makan</th>
                    <th>Menu</th>
                    <th>Bahan Makanan</th>
                </tr>
            </thead>
            <tbody>
                <?php
                $modAnamnesa = new AnamesadietT;
                $modWaktuMakanan = JeniswaktuM::model()->findAll('jeniswaktu_aktif = true');
                foreach ($modWaktuMakanan as $i => $waktumakan) {
                ?>
                    <tr>
                        <td><?php echo CHtml::activeHiddenField($modAnamnesa, '[' . $waktumakan->jeniswaktu_id . ']jeniswaktu_id', array('class' => 'span2 jeniswaktuId', 'readonly' => true)); ?>
                            <?php echo $waktumakan->jeniswaktu_nama . " &nbsp;&nbsp;&nbsp;- &nbsp;&nbsp;&nbsp;" . $waktumakan->jeniswaktu_jam; ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeHiddenField($modAnamnesa, '[' . $waktumakan->jeniswaktu_id . ']menudiet_id', array('class' => 'span2 menudietId', 'readonly' => true)); ?>
                            <?php echo CHtml::activetextField($modAnamnesa, '[' . $waktumakan->jeniswaktu_id . ']menudietNama', array('onclick' => '$("#dialogDaftarMenuDiet").dialog("open"); getIdJenisWaktu(' . $waktumakan->jeniswaktu_id . ');  return false;', 'class' => 'span2 menudietNama', 'readonly' => false)); ?>
                            <?php echo CHtml::link("<span class='icon-list'></span><span class='icon-search'></span>", '', array('href' => '', 'onclick' => '$("#dialogDaftarMenuDiet").dialog("open"); getIdJenisWaktu(' . $waktumakan->jeniswaktu_id . ');  return false;', 'style' => 'text-decoration:none;')); ?>
                        </td>
                        <td>
                            <?php echo CHtml::activeHiddenField($modAnamnesa, '[' . $waktumakan->jeniswaktu_id . ']bahanmakanan_id', array('class' => 'span2 bahanmakananId', 'readonly' => true)); ?>
                            <?php echo CHtml::activetextField($modAnamnesa, '[' . $waktumakan->jeniswaktu_id . ']bahanmakananNama', array('onclick' => '$("#dialogDaftarBahanMakanan").dialog("open"); getIdJenisWaktu(' . $waktumakan->jeniswaktu_id . ');  return false;', 'class' => 'span2 bahanmakananNama', 'readonly' => false)); ?>
                            <?php echo CHtml::link("<span class='icon-list'></span><span class='icon-search'></span>", '', array('href' => '', 'onclick' => '$("#dialogDaftarBahanMakanan").dialog("open"); getIdJenisWaktu(' . $waktumakan->jeniswaktu_id . ');  return false;', 'style' => 'text-decoration:none;')); ?>
                        </td>
                        <!--<td><?php //echo CHtml::activeHiddenField($modAnamnesa, '[0]menudiet_id', array('readonly'=>true,'class'=>'inputFormTabel')) 
                                ?>
                        <?php /*$this->widget('MyJuiAutoComplete',array(
                                    'model'=>$modAnamnesa,
                                    'name'=>'menudietNama',
                                    'attribute'=>'[0]menudietNama',
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/DaftarMenuDiet').'",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           idJenisDiet: $("#GZAnamesadietT_0_jenisdiet_id").val(),
                                                           idMenuDiet: $("#GZAnamesadietT_0_menudiet_id").val(),
                                                       },
                                                       success: function (data) {
                                                               response(data);
                                                       }
                                                   })
                                                }',
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 2,
                                       'focus'=> 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
//                                            setTindakan($(this), ui.item);
                                            return false;
                                        }',

                                    ),
                                    'tombolDialog'=>array("idDialog"=>'dialogDaftarMenuDiet'),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'),
                        ));*/ ?>
                    </td>-->
                        <!--<td><?php //echo CHtml::activeHiddenField($modAnamnesa, '[0]bahanmakanan_id', array('readonly'=>true,'class'=>'inputFormTabel')) 
                                ?>
                        <?php /*$this->widget('MyJuiAutoComplete',array(
                                    'model'=>$modAnamnesa,
                                    'name'=>'bahanmakananNama',
                                    'attribute'=>'[0]bahanmakananNama',
                                    'source'=>'js: function(request, response) {
                                                   $.ajax({
                                                       url: "'.Yii::app()->createUrl('ActionAutoComplete/DaftarBahanMakanan').'",
                                                       dataType: "json",
                                                       data: {
                                                           term: request.term,
                                                           idJenisDiet: $("#GZAnamesadietT_0_jenisdiet_id").val(),
                                                           idMenuDiet: $("#GZAnamesadietT_0_menudiet_id").val(),
                                                           idBahanMakanan: $("#GZAnamesadietT_0_bahanmakanan_id").val(),
                                                       },
                                                       success: function (data) {
                                                               response(data);
                                                       }
                                                   })
                                                }',
                                    'options'=>array(
                                       'showAnim'=>'fold',
                                       'minLength' => 2,
                                       'focus'=> 'js:function( event, ui ) {
                                            $(this).val( ui.item.label);
                                            return false;
                                        }',
                                       'select'=>'js:function( event, ui ) {
                                            setKomposisiMenu($(this), ui.item);
                                            return false;
                                        }',

                                    ),
                                    'tombolDialog'=>array("idDialog"=>'dialogDaftarBahanMakanan','jsFunction'=>"setDialogBahan(this);"),
                                    'htmlOptions'=>array('onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'span2'),
                        ));*/ ?>
                    </td>-->
                    </tr>
                <?php } ?>
            </tbody>
        </table>
    </div>
</div>