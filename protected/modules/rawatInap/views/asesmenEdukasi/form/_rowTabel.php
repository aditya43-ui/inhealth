<!--AutocompletePegawai-->
<tr>
    <td>
        <?php 
        
        echo CHtml::activeHiddenField($modDet, '[ii]kel_id',array('readonly'=>true,'class'=>'kel_id'));
        echo CHtml::activeHiddenField($modDet, '[ii]asesmenedukasi_det_id',array('readonly'=>true,'class'=>'det_id'));
        
        if(!empty($modDet->tglpemeriksaan)){
            $modDet->tglpemeriksaan = date("d M Y H:i:s", strtotime($modDet->tglpemeriksaan));
        }else{
            $modDet->tglpemeriksaan = date('d M Y H:i:s');
        }
        
           
        
        
        echo   $this->widget('MyDateTimePicker', array(
                'model'=>$modDet, 
                'attribute'=>'[ii]tglpemeriksaan',                                
                'mode' => 'date',                                 
                'htmlOptions' => array(
                    //'id' => 'GUInvbarangdetT_'.($modInvBrgDet->invbarangdet_id+1).'_tglperiksafisik',
                    'size' => '10',
                    'style'=>'width:200px',
                    'readonly'=>true,
                    'class'=>'tglpemeriksaan',
                    'onkeypress' => "return $(this).focusNextInputField(event);"
                ),
                'options' => array(  // (#3)                    
                    'dateFormat' => Params::TIME_FORMATV2,                    
                    'maxDate' => 'd',
                ),       
                
            ), 
            true);
        ?>
    </td>
    <td>
        <span class="materi_edukasi"><?php echo $modDet->materiedukasi; ?></span>
        <?php                
                echo CHtml::activeHiddenField($modDet, '[ii]materiedukasi',array('readonly'=>true,'class'=>'materiedukasi', 'onkeypress' => "return $(this).focusNextInputField(event);"));
        ?>
    </td>
    <td>
        <?php 
            echo CHtml::activeDropDownList($modDet, '[ii]metodeedukasi', LookupM::getItems('metodeedukasi'),array('empty'=>'-- Pilih --','class'=>'metodeedukasi', 'onkeypress' => "return $(this).focusNextInputField(event);"));
        ?>
    </td>
    <td colspan="2">
         <?php //echo CHtml::activeDropDownList($modDet, '[ii]durasi',array('class'=>'numbers-only')) ?>
        <?php 
            echo CHtml::activeDropDownList($modDet, '[ii]durasi', CHtml::listData($modDet->getDurasi(), 'id', 'label') ,array('empty'=>'-- Pilih --','class'=>'metodeedukasi', 'onkeypress' => "return $(this).focusNextInputField(event);"));
        ?>
    </td>
    
    <td>
        <?php echo CHtml::activeTextArea($modDet, '[ii]hasilevaluasi',array('class' => 'autogrow hasilevaluasi', 'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
    </td>
    <td>
        
        <?php   
        $modDet->pegawai_pemberiedukasi_id = Yii::app()->user->getState('pegawai_id');
        $modDet->pegawai_pemberiedukasi_nama = Yii::app()->user->getState('nama_pegawai');
            echo CHtml::activeHiddenField($modDet, '[ii]pegawai_pemberiedukasi_id',array('readonly'=>true,'class'=>'pemberiedukasi_id required'));
            $this->widget('MyJuiAutoComplete', array(
                'model'=>$modDet,
                'attribute' => '[ii]pegawai_pemberiedukasi_nama',
                'source' => 'js: function(request, response) {
                    $.ajax({
                            url: "' . $this->createUrl('AutoComplete/DropPetugasRuanganAll') . '",
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
                    'minLength' => 3,
                    'focus' => 'js:function( event, ui ) {
                            $(this).val(ui.item.label);
                            return false;
                    }',
                    'select' => 'js:function( event, ui ) {
                            setPegawai($(this), ui.item);
                            return false;
                    }',
                ),
               // 'tombolDialog'=>array("idDialog"=>'dialogPegawai','jsFunction'=>"setDialog(this);"),
                'htmlOptions'=>array(
                    'onblur'=>'if(this.value == ""){$(this).parents("tr").find("input[name$=\"[pegawai_pemberiedukasi_id]\"]").'
                    . 'val("");}',
                    'class'=>'span2 required pemberiedukasi_nama',
                    'onkeypress'=>"return $(this).focusNextInputField(event)",'placeholder'=>'Ketik nama pegawai'),
            ));		
        ?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDet, '[ii]namapenerima_edukasi',array('readonly'=>true,'class'=>'penerimaedukasi',
            'onkeypress' => "return $(this).focusNextInputField(event);")) ?>
    </td>
</tr>