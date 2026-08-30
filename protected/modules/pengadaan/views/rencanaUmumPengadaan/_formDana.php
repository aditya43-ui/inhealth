<div class="row-fluid">
    <div class="col-md-12">
        <div class="control-group">
            <?php echo $form->labelEx($model,'ispradpa',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->checkBox($model,'ispradpa',array('value'=>1,'uncheckValue'=>0, 'onclick'=>'cekDipaDpa(this);')); ?>
            </div>
        </div>
        <div class="control-group kppuas">
            <?php echo $form->labelEx($model,'nomor_kppuas',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'nomor_kppuas',array('class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'placeholder'=>'Nomor KUA-PPAS')); ?>
            </div>
        </div>
        <span id="totalnya">
        <div class="control-group">
            <?php echo $form->labelEx($model,'Sisa Pagu pada DPA',array('class'=>'control-label')); ?>
            <div class="controls">
                <?php echo $form->textField($model,'dpa_pagu',array('readonly'=>true,'class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'placeholder'=>'Sisa Pagu pada DPA')); ?>
            </div>
        </div>
        </span>
        <div class="control-group">
            <?php echo $form->labelEx($model,'Sumber Dana',array('class'=>'control-label')); ?>
            <div class="controls">
                <table class="table table-striped table-bordered table-condensed" id="tabel-sumberdana">
                    <thead>
                        <tr>
                            <th>No.</th>
                            <th>Sumber Dana <span class="required">*</span></th>
                            <th>Asal Dana</th>
                            <th>MAK <span class="required">*</span></th>
                            <th>Komponen/Kegiatan</th>
                            <th>Pagu (Rp) <span class="required">*</span></th>
                            <th style="text-align: center">Aksi</th>
                        </tr>
                    </thead>
                    <tbody id="sumberDana">
                        <?php /*
                        if(isset($_GET['sukses'])){
                            $tr = "";
                            if(count($arrSumberDana)){
                                foreach ($arrSumberDana as $key => $value) {
                                    $tr .= $this->renderPartial("_rowSumberDana", array('sendiri'=>true,'modSumberDana'=>$value,'form'=>$form), true);
                                }
                                echo $tr;
                            }
                        }else{
                            echo $this->renderPartial("_rowSumberDana", array('sendiri'=>true,'modSumberDana'=>$modSumberDana,'form'=>$form), true); 
                        }*/
                        ?>
                    </tbody>
                    <tfoot>
                        <tr>
                            <td style="text-align: right" colspan="5">Total</td>
                            <td>
                                <?= CHtml::textField('totalDana', 0, array('class'=>'span2 integer-decimal', 'style'=>"width: 110px;text-align:right",'readonly'=>true)); ?>
                            </td>
                            <td> </td>
                        </tr>
                    </tfoot>
                </table>
            </div>
        </div>
        <div class="penyedia">
            <?php echo $form->textFieldRow($model,'nomorizin_tahunjamak',array('class'=>'span4', 'onkeyup'=>"return $(this).focusNextInputField(event);", 'placeholder'=>'Izin Tahun Jamak')); ?>
            <div class="control-group">
                <?php echo $form->labelEx($model,'Jenis Pengadaan',array('class'=>'control-label')); ?>
                <div class="controls">
                    <table class="table table-striped table-bordered table-condensed">
                        <thead>
                            <tr>
                                <th>No.</th>
                                <th>Jenis Pengadaan <span class="required">*</span></th>
                                <th>Jumlah Pagu (Rp) <span class="required">*</span></th>
                            </tr>
                        </thead>
                        <tbody id="jenisPengadaan">
                            <?php 
                            if(isset($_GET['sukses'])){
                                $tr = "";
                                if(count($arrJenis)){
                                    foreach ($arrJenis as $key => $value) {
                                        $tr .= $this->renderPartial("_rowJenisPengadaan", array('sendiri'=>true,'modJenis'=>$value,'form'=>$form), true);
                                    }
                                    echo $tr;
                                }
                            }else{
                                echo $this->renderPartial("_rowJenisPengadaan", array('sendiri'=>true,'modJenis'=>$modJenis,'form'=>$form), true); 
                            }
                            ?>
                        </tbody>
                        <tfoot>
                            <tr>
                                <td style="text-align: right" colspan="2">Total</td>
                                <td>
                                    <?= CHtml::textField('totalJenisPengadaan', 0, array('class'=>'span2 integer-decimal', 'style'=>"width: 160px;text-align:right",'readonly'=>true)); ?>
                                </td>
                            </tr>
                        </tfoot>
                    </table>
                </div>
            </div>
            
            <div class="control-group">
                <label class="control-label">Pengadaan Dikecualikan</label>
                <div class="controls">
                    <?php echo $form->radioButtonList($model, 'isdikecualikan', array('1' => "YA", '0' => 'TIDAK'), array('class' => 'span1', 'value' => '', 'inline' => true, 'onkeypress' => "return $(this).focusNextInputField(event)", 'onchange' => 'cekMetode(this);')) ?>
                </div>
            </div>
            
            <?php echo $form->dropDownListRow($model,'metodepengadaan_id', CHtml::listData(MetodepengadaanM::model()->findAll('metodepengadaan_aktif IS TRUE ORDER BY metodepengadaan_nama ASC'), 'metodepengadaan_id', 'metodepengadaan_nama'),
                array('class'=>'span4', 'onkeypress'=>"return $(this).focusNextInputField(event)",'empty'=>'-- Pilih --')); ?>
        </div>
    </div>
</div>
<?php
/* ========= Dialog untuk mencari data PPDS ========================= */
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id'=>'dialogMAK',
    'options'=>array(
            'title'=>'Daftar MAK',
            'autoOpen'=>false,
            'modal'=>true,
            'width'=>800,
            'height'=>500,
            'resizable'=>false,
    ),
));
$modPengadaan = new ADDokumenpelaksanaananggarandetT('search');
$modPengadaan->default = 'ada';
if(isset($_GET['ADDokumenpelaksanaananggarandetT'])){
    $modPengadaan->attributes = $_GET['ADDokumenpelaksanaananggarandetT'];
    $modPengadaan->default = isset($_GET['ADDokumenpelaksanaananggarandetT']['default'])?$_GET['ADDokumenpelaksanaananggarandetT']['default']:null;    
    $modPengadaan->kodeanggaran = isset($_GET['ADDokumenpelaksanaananggarandetT']['kodeanggaran'])?$_GET['ADDokumenpelaksanaananggarandetT']['kodeanggaran']:null;    
    $modPengadaan->subprogramkerja_nama = isset($_GET['ADDokumenpelaksanaananggarandetT']['subprogramkerja_nama'])?$_GET['ADDokumenpelaksanaananggarandetT']['subprogramkerja_nama']:null;    
}

$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'mak-m-grid',
    'dataProvider'=>$modPengadaan->searchDialogRekMAK(),
    'filter'=>$modPengadaan,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
                array(
                    'header'=>'Pilih',
                    'type'=>'raw',
                    'value'=>function($data) {
                            $dt = $data->attributes;
                                                        
                            $dt['namarekening'] = $data->kodeanggaran.' - '.$data->nama_rekeninganggaran5;
                            $dt['rekeninganggaran5_id'] = $data->rekeninganggaran5_id;
                            $dt['mappingrekeninganggaran_id'] = $data->mappingrekeninganggaran_id;                            
                            $dt['subprogramkerja_nama'] = $data->subprogramkerja_nama;                            
                            
                            $res = json_encode($dt);
    
                            return CHtml::Link('<span style="font-size:15px;"><i class="entypo-check"></i></span>',"#",array("class"=>"btn-small", 
                                    "onclick" => " setPengadaan(".$res."); return false; "));
                        },
                ),                
                array(
                    'header'=>'Kegiatan',
                    'name'=>'subprogramkerja_nama',
                    'filter'=> 
                    CHtml::activeHiddenField($modPengadaan, 'default',array('class'=>'default')). 
                    CHtml::activeHiddenField($modPengadaan, 'paketpekerjaan_id',array('class'=>'paketpekerjaan_id')). 
                    CHtml::activeTextField($modPengadaan, 'subprogramkerja_nama').
                    CHtml::activeHiddenField($modPengadaan, 'subkegiatanprogram_id',array('class'=>'subkegiatanprogram_id'))
                ),                
                array(
                    'header'=>'Nama Rekening',
                    'name'=>'kodeanggaran',
                    'value'=>'$data->kodeanggaran." - ".$data->nama_rekeninganggaran5'
                ),
        ),
    'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
)); 

$this->endWidget();
?>
