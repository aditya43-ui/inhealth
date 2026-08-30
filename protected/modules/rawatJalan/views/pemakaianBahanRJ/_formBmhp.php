<div class="row">
    <div class="col-sm-12">
        <div style="display: none;">
            <?php 
                $this->widget('MyDateTimePicker',array(
                    'id'=>"tglpakaibmhp",
                    'name'=>'tglpakaibmhp',
                    'mode'=>'datetime',
                    'options'=> array(
                        'showOn' => false,
                        'maxDate' => 'd',
                        'yearRange'=> "-150:+0",
                    ),
                    'htmlOptions'=>array('readonly'=>true,'class'=>'span3 dtPicker2 datetimemask','onkeyup'=>"return $(this).focusNextInputField(event)"
                    ),
            ));
            ?>
        </div>
        <div class="control-group ">
            <div class="controls">
                <?php echo CHtml::checkBox('isbukanbebanpasien'); ?> <label>Pilih Jika Pemakaian Bahan Tidak Dibebankan Kepada Pasien</label>
            </div>
        </div>
        <div class="control-group ">
            <?php echo CHtml::label('Tipe Paket','',array('class'=>'control-label')) ?>
            <div class="controls">
                <?php $tipepaket_data = TipepaketM::model()->findAll('tipepaket_aktif = true order by tipepaket_nama asc');

                    $list_tipepaket = CHtml::listData($tipepaket_data,'tipepaket_id','tipepaket_nama');
                    $option_tipepaket = array();

                    foreach ($tipepaket_data as $item) {
                        $option_tipepaket[$item->tipepaket_id] = array(
                            'data-isnonpaket'=>$item->isnonpaket,
                        );
                    }
                echo CHtml::dropDownList('tipepaket_id','',$list_tipepaket ,array('class'=>'span3','empty'=>'Pilih','options'=>$option_tipepaket,'onchange'=>'changeTipePaketBahanMedis()')); ?>
            </div>
        </div>
    </div>
    <div class="clear"></div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('Nama Bahan Medis', '', array('class'=>'control-label')); ?>
            <div class="controls clsnonpaket">
                <?php echo CHtml::hiddenField('obatalkes_id'); ?>
                <?php 
                    $this->widget('MyJuiAutoComplete', array(
                        'name'=>'obatalkes_nama',
                        'source'=>'js: function(request, response) {
                                    $.ajax({
                                        url: "'.$this->createUrl('PemakaianBmhp/AutocompleteObatAlkes').'",
                                        dataType: "json",
                                        data: {
                                            term: request.term,
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
                                    $(this).val("");
                                    return false;
                                }',
                            'select'=>'js:function( event, ui ) {
                                    $(this).val(ui.item.value);
                                    $("#obatalkes_id").val(ui.item.obatalkes_id);
                                    tambahPemakaianBahan();
                                    return false;
                                }',
                        ),
                        'htmlOptions'=>array(
                                'onkeyup'=>"return $(this).focusNextInputField(event)",
                        ),
                        'tombolDialog'=>array('idDialog'=>'dialogPemakaianBahan'),
                    )); 
                ?>
            </div>
        </div>
    </div>
    <div class="col-sm-6">
        <div class="control-group ">
            <?php echo CHtml::label('jumlah', '', array('class'=>'control-label')); ?>
            <div class="controls clsnonpaket">
                <?php echo CHtml::textField('qtypakaibahan', '1', array('class'=>'span1 integer-decimal')) ?>
                <?php echo CHtml::textField('satuanpakaibahan', '', array('class'=>'span2','disabled'=>true)) ?>
                <?php echo CHtml::htmlButton('<i class="icon-plus icon-white"></i>',
                        array('onclick'=>'tambahPemakaianBahan();return false;',
                            'class'=>'btn btn-primary',
                            'onkeyup'=>"tambahPemakaianBahan();",
                            'rel'=>"tooltip",
                            'id'=>'btntmbbahanmedis',
                            'title'=>"Klik untuk menambahkan Pemakaian Bahan Pasien")); ?>
            </div>
        </div>
    </div>
</div>
<div style="overflow: auto;">
    <table class="table table-condensed table-bordered" style="width: 1170px !important; max-width: 1200px !important;">
        <thead>
            <th width="50px">No.</th>
            <th width="150px">Tgl. Pemakaian</th>
            <th width="150px">Tipe Paket</th>
            <th width="100px">Jenis Obat Alkes</th>
            <th width="200px">Nama Bahan Medis</th>
            <th width="120px">Tgl. Kedaluwarsa</th>
            <th width="100px">Harga</th>
            <th style="width: 60px !important;">Jumlah</th>
            <th style="width: 60px !important;">Satuan</th>
            <th width="100px">Subtotal</th>
            <th width="80px">Batal</th>
        </thead>
        <tbody id="tblpemakaianbahan">
            
        </tbody>
        <tfoot>
            <tr>
                <td style="font-weight: bold; text-align: right;" colspan="9">Total Harga</td>
                <td>
                    <?php echo CHtml::textField('totalbahanmedis',0,array('class'=>'span2 integer-decimal','readonly'=>true)); ?>
                </td>
                <td></td>
            </tr>
        </tfoot>
    </table>        
</div>