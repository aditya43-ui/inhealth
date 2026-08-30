<?php 
    $modKantong = KantongdarahT::model()->findByAttributes(array('pendonor_id' => $modPendonor->pendonor_id, 'daftarpendonor_id' => $_GET['daftardonasi_id']));
?>
<div class="control-group <?php echo (empty($modKantong)?'':'hide') ?>" id="form-kantong-darah">
    <label class="control-label"> Nomor Kantong Darah </label>
    <div class="controls">
        <?php
        $this->widget('MyJuiAutoComplete', array(
            'name' => 'no_kantongdarah',
            'value' => "",
            'source' => 'js: function(request, response) {
                                   $.ajax({
                                       url: "' . $this->createUrl('autocompleteKantongDarah') . '",
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
                                $(this).val("");
                                return false;
                            }',
                'select' => 'js:function( event, ui ) {
                                //pilihKantongDarah(ui.item.value, "auto");
                                $(this).val(ui.item.no_kantongdarah);
                                $("#no_kantongdarah").blur();
                                $(this).val("");
                                return false;
                            }',
            ),
            'htmlOptions' => array(
                'disabled' => false,
                'onkeyup' => "return $(this).focusNextInputField(event)",
                'class' => 'span3',
                'onblur' => 'cekKantongDarah(this.value, this);',
            ),
            'tombolDialog' => array('idDialog' => 'dialogKantongDarah'),
        ));
        ?>

    </div>
</div>

<table class="table table-bordered table-condensed" id="pilih-kantong">
    <thead>
        <tr>
            <th>No.</th>
            <th>Jenis Kantong Darah</th>
            <th>No. Kantong Utama</th>
            <th>No. Kantong Pabrik <span class="required">*</span></th>
            <th>Tanggal Pembuatan </th>
            <th>Petugas Pencatatan</th>
            <th>Batal</th>
        </tr>
    </thead>
    <tbody id="tab_kantong_darah">
        <?php 
        $modSuksesKantong = KantongdarahT::model()->findAllByAttributes(array('pendonor_id' => $modPendonor->pendonor_id, 'daftarpendonor_id' => $_GET['daftardonasi_id']));
        if(!empty($modSuksesKantong)) { 
            foreach($modSuksesKantong as $ii => $modKantong) {
                echo $this->renderPartial($this->path_view_detailkantong.'ajaxKantongDarahSukses',array('kantong'=>$modKantong,'jenis'=>$modKantong->jeniskantongdarah, 'pendonor'=>$modKantong->pendonor, 'ii' => $ii),true);
            }
        }
        ?>
    </tbody>
</table>

<table id="hapus-kantong" class="hide">
    <tbody>
        
    </tbody>
</table>