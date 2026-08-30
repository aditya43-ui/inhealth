<tr class="trparent" row-data="0">
    <td rowspan="2" style="text-align: center; vertical-align: middle">
        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick'=>'tambahkantindakan();', 'class' => 'btn btn-primary')); ?>
        <?php echo CHtml::htmlButton('<i class="icon-minus icon-white"></i>', array('onclick'=>'hapusTindakan(this);', 'class' => 'btn btn-danger')); ?>
    </td>
    <td rowspan="2" style="text-align: center; vertical-align: middle" class="td_date">
        <?php $this->widget('MyDateTimePicker',array(
                'id'=>'tgl_tindakan',
                'name'=>'tgl_tindakan',
                'value'=>MyFormatter::formatDateTimeForUser(date('Y-m-d H:i:s')),
                'mode'=>'datetime',
                'options'=> array(
                    'showOn' => false,
                    'yearRange'=> "-150:+0",
                ),
                'htmlOptions'=>array(
					'placeholder'=>'00/00/0000 00:00:00',
					'class'=>'tgl_tindakan required',
					'onkeyup'=>"return $(this).focusNextInputField(event)",
					'style' => 'width:150px;'
                ),
        )); ?>
    </td>
    <td rowspan="2" style="text-align: center; vertical-align: middle">
        <div class='form-tindakan-luar'>
            <?php echo CHtml::textArea('tindakanluar_nama','',array('class'=>'tindakanluar_nama span3 required')); ?>
        </div>
        
        <div class='form-tindakan hide'>
            <?php
                echo CHtml::hiddenField('daftartindakan_id','',['class'=>'daftartindakan_id']);
                $this->widget('MyJuiAutoComplete', array(      
                    'id'=>'daftartindakan_nama',
                    'name' => 'daftartindakan_nama',
                    'source' => 'js: function(request, response) {
                        $.ajax({
                            url: "' . $this->createUrl('/actionAutoComplete/daftarTindakan') . '",
                            dataType: "json",
                            data: {
                                    term: request.term,
                            },
                            success: function (data) {
                                    response(data);
                            }
                        })
                    }',
                    'options' => array(
                        'showAnim' => 'fold',
                        'minLength' => 2,
                        'focus' => 'js:function( event, ui ) {
                                $(this).val( ui.item.label);
                                return false;
                         }',
                        'select' => 'js:function( event, ui ) { 
                                setTindakan(ui.item, this)
                                return false;
                        }',
                    ),
                    'htmlOptions' => array(
                        'onkeypress' => "return $(this).focusNextInputField(event)",
                        'placeholder' => "Ketik tindakan",
                        'class' => 'span3 daftartindakan_nama',
                        'onblur'=>'if(this.value==""){resetTindakan(this);}'
                    ),
                    'tombolDialog' => array('idDialog' => 'dialogTindakan', 'jsFunction'=>'$("#dialogTindakan").dialog("open");setNo(this);refreshGridTindakan();'),
                ));
            ?>
        </div>
        
        <div class='control-group hide'>
            <?= CHtml::checkBox("ceklisDarah",false,['onclick'=>'setCeklisDarah(this);']) ?> <label >Cheklis jika pembelian darah</label>
        </div>
        
        <div class='control-group form-tindakan hide'>
            <?= CHtml::checkBox("ceklisDarah",false,['onclick'=>'seTindakanRS(this);']) ?> <label>Cheklis jika tindakan dari RS</label>
        </div>
    </td>
    <td style="margin: 0px !important; padding: 0px !important;">
        <table class="items table table-bordered table-striped table-condensed">
            <tbody class='tblchild'>
                <tr class='trcld'>
                    <td>
                        <?php echo CHtml::dropDownList('komponen_id','',CHtml::listData(KomponentarifM::model()->findAll('komponentarif_aktif = true and komponentarif_id <> 6 order by komponentarif_nama ASC'),'komponentarif_id','komponentarif_nama'),array('class'=>'komponen_id span3', 'empty'=>'Pilih')); ?>    
                        <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>', array('onclick'=>'tambahkomp(this);', 'class' => 'btn btn-primary')); ?>
                        <?php echo CHtml::htmlButton('<i class="icon-minus icon-white"></i>', array('onclick'=>'hapusTindakan(this);', 'class' => 'btn btn-danger')); ?>
                    </td>
                </tr>
            </tbody>
            
        </table>
    </td>
    <td style="margin: 0px !important; padding: 0px !important;">
        <table class="items table table-bordered table-striped table-condensed">
            <tbody class='tblchild_tarif'>
                <tr class='trcld_tarif'>
                    <td>
                        <?php echo CHtml::textField('tarif_kompsatuan',0,array('class'=>'tarif_kompsatuan span2 integer-decimal', 'onblur'=>'hitungTotal();')); ?>
                    </td>
                </tr>
            </tbody>
            
        </table>
    </td>
    <td style="text-align: center; vertical-align: middle">
        <?php echo CHtml::textField('qty_tindakan',1,array('class'=>'qty_tindakan span1 integer2', 'onblur'=>'hitungTotal();')); ?>
    </td>
    <td style="margin: 0px !important; padding: 0px !important;">
        <table class="items table table-bordered table-striped table-condensed">
            <tbody class='tblchild_diskon'>
                <tr class='trcld_diskon'>
                    <td>
                        <?php echo CHtml::textField('discountkomptindakan',0,array('class'=>'discountkomptindakan span2 integer-decimal', 'onblur'=>'hitungTotal();')); ?>
                    </td>
                </tr>
            </tbody>
            
        </table>
    </td>
    <td style="margin: 0px !important; padding: 0px !important; top:0;">
        <table class="items table table-bordered table-striped table-condensed">
            <tbody class='tblchild_total'>
                <tr class='trcld_total'>
                    <td>
                        <?php echo CHtml::textField('tarif_tindakankomp',0,array('class'=>'tarif_tindakankomp span2 integer-decimal','readonly'=>true)); ?>
                    </td>
                </tr>
            </tbody>
            
        </table>
    </td>
</tr>
<tr class="trpemeriksaan">
    <td colspan="2" style="margin: 0px; padding: 0px; top:0; left: 0;">
        <table>
            <tr>
                <td class="tdcolorwhite td_date">
                    <?php echo CHtml::hiddenField('dokterpemeriksa1_id ','',array('class'=>'dokterpemeriksa1_id')); ?>
                    <?php $this->widget('MyJuiAutoComplete',array(
                        'id'=>'dokterpemeriksa1_nama',
                        'name'=>'dokterpemeriksa1_nama',
                        'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.Yii::app()->controller->createUrl('AutoCompletePegawai').'",
                                    dataType: "json",
                                    data: {
                                        term: request.term
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
                                setDokter1($(this), ui.item);
                                return false;
                            }',

                        ),
                        'tombolDialog'=>array("idDialog"=>'dialogDokter1','jsFunction'=>"setDialogDokter1(this);"),
                        'htmlOptions'=>array('placeholder'=>'Dokter Pemeriksaan 1','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'dokterpemeriksa1_nama span3'),
                    )); ?> 
                </td>
                <td class="tdcolorwhite td_date">
                    <?php echo CHtml::hiddenField('dokterpemeriksa2_id ','',array('class'=>'dokterpemeriksa2_id')); ?>
                    <?php $this->widget('MyJuiAutoComplete',array(
                        'id'=>'dokterpemeriksa2_nama',
                        'name'=>'dokterpemeriksa2_nama',
                        'source'=>'js: function(request, response) {
                                $.ajax({
                                    url: "'.Yii::app()->controller->createUrl('AutoCompletePegawai').'",
                                    dataType: "json",
                                    data: {
                                        term: request.term
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
                                setDokter2($(this), ui.item);
                                return false;
                            }',

                        ),
                        'tombolDialog'=>array("idDialog"=>'dialogDokter2','jsFunction'=>"setDialogDokter2(this);"),
                        'htmlOptions'=>array('placeholder'=>'Dokter Pemeriksaan 2','onkeypress'=>"return $(this).focusNextInputField(event)", 'class'=>'dokterpemeriksa2_nama span3'),
                    )); ?> 
                </td>
            </tr>
        </table>
    </td>
    <td style="font-weight: bold; text-align:right">
        Total
    </td>
    <td>
        <?php echo CHtml::textField('discount_tindakan','',array('class'=>'discount_tindakan span2 integer-decimal','readonly'=>true)); ?>
    </td>
    <td>
        <?php echo CHtml::hiddenField('tarif_satuan','',array('class'=>'tarif_satuan integer-decimal')); ?>
        <?php echo CHtml::textField('tariftindakan','',array('class'=>'tariftindakan span2 integer-decimal','readonly'=>true)); ?>
    </td>
</tr>

