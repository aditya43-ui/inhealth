<?php
/**
* @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
* @version     2.0.0
* @digunakan   - form pencarian pengeluaran aset
* RSST-1640
*/
?>

<div class="panel panel-success">
    <!--<span class="group-title">
        Cari Pengeluaran Aset
    </span>-->
    <div class="panel-heading">
        <div class="panel-title">
            <i class="glyphicon glyphicon-file"></i> Cari Pengeluaran Aset
        </div>
    </div>
    <div class="panel-body">
        <div class="col-sm-2">
            &nbsp;
        </div>
        <div class="col-sm-8">
            <div class="control-group">
                <label class="control-label">Tgl Pengeluaran</label>
                <div class="controls">
                    <div class="daterange daterange-inline input-inline setIndikator" data-format="D MMMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($model->tgl_awal)) ?>" data-end-date="<?php echo date('d M Y', strtotime($model->tgl_akhir)) ?>">
                        <i class="entypo-calendar"></i>
                        <span ><?php echo date('d M Y', strtotime($model->tgl_awal)) ?> - <?php echo date('d M Y', strtotime($model->tgl_akhir)) ?></span>
                        <?php echo $form->hiddenField($model,'tgl_awal', array('class' => 'start','onfocus'=>'refreshTable();','onblur'=>'refreshTable();', )) ?>
                        <?php echo $form->hiddenField($model,'tgl_akhir', array('class' => 'end','onfocus'=>'refreshTable();','onblur'=>'refreshTable();')) ?>
                    </div>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Jenis Pengeluaran</label>
                <div class="controls">
                    <?php echo $form->dropDownList($model,'jenisperuntukan', LookupM::getItems('jenisperuntukan'),array('empty' => '-- Pilih --','onchange'=>'refreshTable();', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">No Pengeluaran</label>
                <div class="controls">
                    <?php echo $form->textField($model,'nopengeluaranaset',array('empty' => '-- Pilih --','onblur'=>'refreshTable();', 'onkeypress'=>"return $(this).focusNextInputField(event);")); ?>
                </div>
            </div>
        </div>
        <div class="col-sm-2">
            &nbsp;
        </div>
    </div>
    <div class="clear"></div>
    
</div>

