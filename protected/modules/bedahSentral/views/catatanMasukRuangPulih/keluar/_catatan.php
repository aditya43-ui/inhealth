<?php
$det = new CatatankhususRuangpulihT();
?>

<div class="control-group">
    <?php echo $form->labelEx($det, 'catatankhusus_jam', array('class' => 'control-label')); ?>
    <div class="controls">
        <?php
        $this->widget('MyDateTimePicker', array(
            'model' => $det,
            'attribute' => 'catatankhusus_jam',
            'mode' => 'time',
            'options' => array(
                'dateFormat' => Params::DATE_FORMAT,
            ),
            'htmlOptions' => array('readonly' => true, 'class' => 'span3 catatankhusus_jam', 'onclick' => "return $(this).focusNextInputField(event)"),
        ));
        ?> 
    </div>
</div>
<?php echo $form->textAreaRow($det, 'catatankhusus_isi', array('class'=>'span3 catatankhusus_isi')); ?>
<?php 

$list = $penunjang->getParamedisItems(Params::RUANGAN_ID_BEDAH);
$opList = array();

foreach ($list as $item) {
    
    $jabatan = JabatanM::model()->findByPk($item->jabatan_id);
    
    $opList[$item->pegawai_id] = array(
        'data-jabatan'=>empty($jabatan) ? "-" : $jabatan->jabatan_nama,
    );
}

echo $form->dropDownListRow($det, 'pembericatatan_id', CHtml::listData($penunjang->getParamedisItems(Params::RUANGAN_ID_BEDAH), 'pegawai_id', 'nama_pegawai'), array(
    'empty' => '-- Pilih --', 'class' => 'span3 pembericatatan_id', 'onkeyup' => "return $(this).focusNextInputField(event);", 'options'=>$opList,
)); ?>
<div class="control-group">
    <label class="control-label"></label>
    <div class="controls">
        <?php echo CHtml::htmlButton('+', array(
            'class' => 'btn btn-danger',
            'onclick'=>'tambahRowCatatan();'
        )); ?>
        
    </div>
</div>

<table class="table table-bordered table-condensed">
    <thead>
        <tr>
            <th>Jam</th>
            <th>Catatan Khusus Ruang Pulih</th>
            <th>Nama/Jabatan Pemberi Catatan</th>
            <th>Batal</th>
        </tr>
    </thead>
    <tbody id="tab_catatan">
        <?php
        if (!$model->isNewRecord) {
            $detail = CatatankhususRuangpulihT::model()->findAllByAttributes(array(
                'pasienruangpulih_id'=>$model->pasienruangpulih_id,
            ));
            
            foreach ($detail as $ii=>$item) {
                echo $this->renderPartial('keluar/_rowCatatan', array('mod'=>$item, 'idx'=>$ii), true);
            }
        }
        
        ?>
    </tbody>
</table>

<script>
    var row = <?php echo CJSON::encode(array('html'=>$this->renderPartial('keluar/_rowCatatan', array(), true))); ?>;
    
    
    function tambahRowCatatan() {
        $("#tab_catatan").append(row.html);
        
        var last = $("#tab_catatan tr:last-child");
        
        
        $(last).find(".row_catatankhusus_jam").val($(".catatankhusus_jam").val());
        $(last).find(".row_catatankhusus_isi").val($(".catatankhusus_isi").val());
        $(last).find(".row_pembericatatan_id").val($(".pembericatatan_id").val());
        $(last).find(".txt_catatankhusus_jam").text($(".catatankhusus_jam").val());
        $(last).find(".txt_catatankhusus_isi").text($(".catatankhusus_isi").val());
        $(last).find(".txt_pembericatatan_nama").text($(".pembericatatan_id :selected").html() + " / " + $(".pembericatatan_id :selected").data("jabatan"));
        
        renameInputCatatan();
        $(".catatankhusus_jam, .catatankhusus_isi, .pembericatatan_id").val("");
        
        
    }
    
    
    function renameInputCatatan() {
        var idx = 0;
        $("#tab_catatan tr").each(function() {
            $(this).find(".row_catatankhusus_jam").attr("name", "CatatankhususRuangpulihT[detail][" + idx + "][catatankhusus_jam]");
            $(this).find(".row_catatankhusus_isi").attr("name", "CatatankhususRuangpulihT[detail][" + idx + "][catatankhusus_isi]");
            $(this).find(".row_pembericatatan_id").attr("name", "CatatankhususRuangpulihT[detail][" + idx + "][pembericatatan_id]");
            idx++;
        });
    }
    
    
    function hapusCatatan(obj) {
        $(obj).parents("tr").remove();
    }
    
    

</script>