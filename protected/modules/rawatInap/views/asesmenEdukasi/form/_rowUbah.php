<tr>
    <td>
        <?php
        echo CHtml::activeHiddenField($modDet, '[ii]kel_id', array('readonly' => true, 'class' => 'kel_id'));
        echo CHtml::activeHiddenField($modDet, '[ii]asesmenedukasi_det_id', array('readonly' => true, 'class' => 'det_id'));
        echo CHtml::activeTextField($modDet, '[ii]tglpemeriksaan', array('readonly' => true));
        
        ?>
    </td>
    <td>
        <span class="materi_edukasi"><?php echo $modDet->materiedukasi; ?></span>
<?php
echo CHtml::activeHiddenField($modDet, '[ii]materiedukasi', array('readonly' => true, 'class' => 'materiedukasi'));
?>
    </td>
    <td>
        <?php
        echo CHtml::activeDropDownList($modDet, '[ii]metodeedukasi', LookupM::getItems('metodeedukasi'), array('empty' => '-- Pilih --', 'class' => 'metodeedukasi'));
        ?>
    </td>
    <td colspan="2">
         <?php echo CHtml::activeDropDownList($modDet, '[ii]durasi', CHtml::listData($modDet->getDurasi(), 'id', 'label') ,array('empty'=>'-- Pilih --','class'=>'metodeedukasi')); ?>
    </td>
    <td>
        <?php echo CHtml::activeTextArea($modDet, '[ii]hasilevaluasi', array('class' => 'autogrow hasilevaluasi')) ?>
    </td>
    <td>

<?php
echo CHtml::activeHiddenField($modDet, '[ii]pegawai_pemberiedukasi_id', array('readonly' => true, 'class' => 'pemberiedukasi_id required'));
$this->widget('MyJuiAutoComplete', array(
    'model' => $modDet,
    'attribute' => '[ii]pegawai_pemberiedukasi_nama',
    'source' => 'js: function(request, response) {
                    $.ajax({
                            url: "' . $this->createUrl('AutocompletePegawai') . '",
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
    'htmlOptions' => array(
        'onblur' => 'if(this.value == ""){$(this).parents("tr").find("input[name$=\"[pegawai_pemberiedukasi_id]\"]").val("");}',
        'class' => 'span2 required pemberiedukasi_nama', 'onkeypress' => "return $(this).focusNextInputField(event)", 'placeholder' => 'Ketik nama pegawai'),
));
?>
    </td>
    <td>
        <?php echo CHtml::activeTextField($modDet, '[ii]namapenerima_edukasi', array('readonly' => true, 'class' => 'penerimaedukasi')) ?>
    </td>
</tr>