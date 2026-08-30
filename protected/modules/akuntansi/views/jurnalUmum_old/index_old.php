<script type="text/javascript">
    var id_rek = [];
</script>
<div class="white-container" id="inputJurnalUmum">
    <div class='divForForm'>
        <?php $this->widget('bootstrap.widgets.BootAlert'); ?>
    </div>
    <legend class="rim2">Jurnal <b>Umum</b></legend>
    <?php
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/form.js');
        Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/accounting.js');

        $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm',
            array(
                'id'=>'form-jurnal-umum',
                'enableAjaxValidation'=>false,
                'type'=>'horizontal',
                'htmlOptions'=>array(
                    'onKeyPress'=>'return disableKeyPress(event)'
                ),
                'focus'=>'#',
            )
        );

        $this->widget('application.extensions.moneymask.MMask',array(
            'element'=>'.currency',
            'currency'=>'PHP',
            'config'=>array(
                'symbol'=>'Rp',
                'defaultZero'=>true,
                'allowZero'=>true,
                'decimal'=>',',
                'thousands'=>'.',
                'precision'=>0,
            )
        ));

        $this->widget('application.extensions.moneymask.MMask', array(
            'element' => '.numbersOnly',
            'config' => array(
                'defaultZero' => true,
                'allowZero' => true,
                'decimal' => '.',
                'thousands' => '',
                'precision' => 0,
            )
        ));        

        $this->widget('bootstrap.widgets.BootAlert');
    ?>
    <table style="width: 100%; border: none;">
        <tr>
            <td>
                <?php
                    echo $form->hiddenField(
                        $model,
                        "jurnalrekening_id",
                        array(
                            'class'=>'span1',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'readonly'=>false
                        )
                    );
                ?>
                <?php echo $form->dropDownListRow($model,'jenisjurnal_id', JenisjurnalM::items(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'reqForm span3')); ?>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'tglbuktijurnal', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tglbuktijurnal',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array(
                                    'style'=>'width:166px','class'=>'reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                            ));
                        ?>

                    </div>
                </div>
                <div class="control-group">
                    <?php echo $form->labelEx($model,'tglreferensi', array('class'=>'control-label')) ?>
                    <div class="controls">
                        <?php   
                            $this->widget('MyDateTimePicker',array(
                                'model'=>$model,
                                'attribute'=>'tglreferensi',
                                'mode'=>'datetime',
                                'options'=> array(
                                    'dateFormat'=>Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions'=>array(
                                    'style'=>'width:166px','class'=>'reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)"
                                ),
                            ));
                        ?>

                    </div>
                </div>
            </td>
            <td>
				<?php echo $form->textFieldRow($model,'nobuktijurnal',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
                <?php echo $form->textFieldRow($model,'kodejurnal',array('class'=>'span3 reqForm', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
                <?php 
                    echo $form->hiddenField(
                        $model,
                        "rekperiod_id",
                        array(
                            'class'=>'span1',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'readonly'=>false
                        )
                    );
//                    echo $form->dropDownListRow($model,'rekperiod_id', RekperiodM::items(),array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)",'class'=>'reqForm'));
                ?>
                <?php echo $form->textFieldRow($model,'noreferensi',array('class'=>'span3 reqForm numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
            </td>
            <td>
                <?php echo $form->textFieldRow($model,'nobku',array('class'=>'span3 numbersOnly', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
                <?php echo $form->textAreaRow($model,'urianjurnal',array('class'=>'span3', 'onkeypress'=>"return $(this).focusNextInputField(event)", 'maxlength'=>32,'readonly'=>false)); ?>
            </td>
        </tr>
    </table>
    <div class="block-tabel">
        <h6>Detail <b>Jurnal</b></h6>
        <div class="control-group">
            <label class="control-label">Pilih Rekening</label>
            <div class="controls">
                <?php
                    echo CHtml::dropDownList(
                        'isJenisRekenig',
                        "",
                        LookupM::getItems('jenis_rekening'),
                        array(
                            'empty'=>'-- Pilih --',
                            'onkeypress'=>"return $(this).focusNextInputField(event)",
                            'style'=>'float:left;margin-right:5px;',
                            'class'=>'span2',
                        )
                    );
                ?>
                <?php
                    $this->widget('MyJuiAutoComplete', array(
                        'model' => $model,
                        'attribute' => 'rekening_nama',
                        'sourceUrl' => Yii::app()->createUrl('ActionAutoComplete/rekeningAkuntansi'),
                        'options' => array(
                            'showAnim' => 'fold',
                            'minLength' => 2,
                            'focus' => 'js:function( event, ui ){return false;}',
                            'select' => 'js:function( event, ui ){
                                tambahDataRekening(ui.item.rincianobyek_id);
                                return false;
                            }'
                        ),
                        'htmlOptions' => array(
                            'onkeypress' => "return $(this).focusNextInputField(event)",
                            'placeholder'=>'Pilih rekening yang akan dijurnal',
                            'class'=>'span3',
                        ),
                        'tombolDialog' => array('idDialog' =>'dialogRincianRek',),
                    ));
                ?>
            </div>
        </div>    
        <?php echo $this->renderPartial('__gridDetailJurnal', array('modelJurDetail'=>$modelJurDetail, 'form'=>$form)); ?>
        <?php 
            $this->widget('bootstrap.widgets.BootButtonGroup', array(
                'type'=>'info', // '', 'primary', 'info', 'success', 'warning', 'danger' or 'inverse'
                'buttons'=>array(
                    array(
                        'label'=>'Jurnal',
                        'icon'=>'icon-download icon-white',
                        'url'=>'#',
                        'htmlOptions'=>array(
                            'onclick'=>'simpanJurnalUmum(\'jurnal\');return false;'
                        )
                    ),
                    array(
                        'label'=>'',
                        'items'=>array(
                            array(
                                'label'=>'Posting',
                                'icon'=>'icon-download',
                                'url'=>'#',
                                'itemOptions'=>array(
                                    'onclick'=>'simpanJurnalUmum(\'posting\');return false;'
                                )
                            ),
                        )
                    ),       
                )
            ));
            echo CHtml::htmlButton(Yii::t('mds','{icon} Reset',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), array('style'=>'display:none','id' => 'reseter', 'class' => 'btn btn-default', 'type'=>'reset'));
        ?>
        <?php $this->endWidget();?>
    </div>
</div>

<?php $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogRincianRek',
    'options' => array(
        'title' => 'Saldo Rekening',
        'autoOpen' => false,
        'modal' => true,
        'width' => 700,
        'height' => 450,
        'resizable' => false,
    ),
));

if(isset($_GET['AKRekeningakuntansiV'])) {
    $rekeningakuntansiV->attributes = $_GET['AKRekeningakuntansiV'];
	// untuk mencari nama rekening antara rekening 5 sampai rekening 1 jika salah satu tidak terpenuhi
    $rekeningakuntansiV->nmrincianobyek = $_GET['AKRekeningakuntansiV']['nmrincianobyek'];
    $rekeningakuntansiV->nmobyek = $_GET['AKRekeningakuntansiV']['nmrincianobyek'];
    $rekeningakuntansiV->nmjenis = $_GET['AKRekeningakuntansiV']['nmrincianobyek'];
    $rekeningakuntansiV->nmkelompok = $_GET['AKRekeningakuntansiV']['nmrincianobyek'];
    $rekeningakuntansiV->nmstruktur = $_GET['AKRekeningakuntansiV']['nmrincianobyek'];

	// untuk mencari kode rekening antara rekening 5 sampai rekening 1 jika salah satu tidak terpenuhi
	$rekeningakuntansiV->kdrincianobyek = $_GET['AKRekeningakuntansiV']['kdrincianobyek'];
    $rekeningakuntansiV->kdobyek = $_GET['AKRekeningakuntansiV']['kdrincianobyek'];
    $rekeningakuntansiV->kdjenis = $_GET['AKRekeningakuntansiV']['kdrincianobyek'];
    $rekeningakuntansiV->kdkelompok = $_GET['AKRekeningakuntansiV']['kdrincianobyek'];
    $rekeningakuntansiV->kdstruktur = $_GET['AKRekeningakuntansiV']['kdrincianobyek'];
}

$this->widget('ext.bootstrap.widgets.HeaderGroupGridView',
    array(
        'id'=>'list-rekening-m-grid',
        'dataProvider'=>$rekeningakuntansiV->cariRekening(),
		'filter'=>$rekeningakuntansiV,
        'template'=>"{summary}\n{items}\n{pager}",
        'itemsCssClass'=>'table table-striped table-bordered table-condensed',
        'columns'=>array(
            array(
                'header'=>'No. Urut',
                'value'=>'$this->grid->dataProvider->Pagination->CurrentPage*$this->grid->dataProvider->pagination->pageSize+$row+1',
            ),
            array(
                'header'=>'Kode Rekening',
				'name'=>'kdrincianobyek',
                'value'=>'$data->getKodeRekening()',
            ),
            array(
                'header'=>'Nama',
				'name'=>'nmrincianobyek',
                'value'=>'$data->getNamaRekening()',
            ),            
            array(
                'header'=>'Pilih',
                'type'=>'raw',
                'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",
                    array(
                        "class"=>"btn-small",
                        "onClick" =>"
                            var iDRek = \'$data->id_temp_rek\';
                            tambahDataRekening(iDRek);
                            return false;
                        ")
                    )
                ',
            ),
        ),
        'afterAjaxUpdate'=>'function(id, data){jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"});}',
    )
);
$this->endWidget();
?>

<script type="text/javascript">
    var frmDetailRekening = new String(<?php echo CJSON::encode($this->renderPartial('__formInputRekening',array('form'=>$form, 'modelJurDetail'=>$modelJurDetail), true));?>);
    var periodeID = <?php echo json_encode($redirect[0]); ?>;
    var urlRedirect = "<?php echo $redirect[1]; ?>";
    
//    function cekSessionPeriode()
//    {
//        if(periodeID.length > 1 || periodeID.length == 0)
//        {
//            myAlert('Periode tidak valid, silakan cek kembali!');
//            window.location.href = urlRedirect;
//        }
//    }
//    cekSessionPeriode();

    function hapusIndexMenu()
    {
        for(key in id_rek)
        {
            delete id_rek[key];
        }
        $("#tabel-detail").find('tbody').empty();
        $("#reseter").click();
    }
    
    function batalInputJurnal(obj)
    {
        myConfirm("Apakah Anda yakin akan membatalkan jurnal?",'Perhatian!',function(r){
            if(r){
                $(obj).parents('tr').detach();
				$("#totalSaldoDebit").val(0);
				$("#totalSaldoKredit").val(0);
            }   
        });
    }
    
    function tambahDataRekening(params)
    {
        var jenisRekenig = $("#isJenisRekenig").val();
        
        if(jenisRekenig.length > 0){
            unMaskMoneyAll();
            /*
            var xxx = params+ '_' +jenisRekenig
            if (id_rek[xxx] == undefined)
            {
                $("#tabel-detail").find('tbody').append(frmDetailRekening.replace());
                if(jenisRekenig == 'D')
                {
                    $("#tabel-detail").find('input[name$="[99][saldokredit]"]').attr('disabled','disabled');
                }else{
                    $("#tabel-detail").find('input[name$="[99][saldodebit]"]').attr('disabled','disabled');
                }
                getDataRekening(params);
                
                id_rek[xxx] = 'yes';
                $("#dialogRincianRek").dialog("close");
            }else{
                myAlert("Pilih rekening yang lain");
            }*/
            $("#tabel-detail").find('tbody').append(frmDetailRekening.replace());
            if(jenisRekenig == 'D')
            {
                $("#tabel-detail").find('input[name$="[99][saldokredit]"]').attr('disabled','disabled');
            }else{
                $("#tabel-detail").find('input[name$="[99][saldodebit]"]').attr('disabled','disabled');
            }
            getDataRekening(params);
            $("#dialogRincianRek").dialog("close");
            jQuery('a[rel="tooltip"],button[rel="tooltip"],input[rel="tooltip"]').tooltip({'placement':'bottom'});
        }else{
            myAlert("Pilih Jenis rekening terlebih dahulu");
        }
        

        
    }
    
    function getDataRekening(params)
    {
        $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getDataRekening');?>", {id:params},
            function(data){
                var n = 0;
                $.each(data, function(key, value)
                {
                    $("#tabel-detail").find("span[name$='[99]["+ key +"]']").text(value);
                    n++;
                });
                $("#tabel-detail").find("input[name$='[99][rekening1_id]']").val(data.struktur_id);
                $("#tabel-detail").find("input[name$='[99][rekening2_id]']").val(data.kelompok_id);
                $("#tabel-detail").find("input[name$='[99][rekening3_id]']").val(data.jenis_id);
                $("#tabel-detail").find("input[name$='[99][rekening4_id]']").val(data.obyek_id);
                $("#tabel-detail").find("input[name$='[99][rekening5_id]']").val(data.rincianobyek_id);
                
                if(n == 39){
                    maskMoneyAll();
                    renameInput('AKJurnaldetailT', 'nourut');
                    renameInput('AKJurnaldetailT', 'jurnaldetail_id');
                    renameInput('AKJurnaldetailT', 'uraiantransaksi');
                    renameInput('AKJurnaldetailT', 'rekening1_id');
                    renameInput('AKJurnaldetailT', 'rekening2_id');
                    renameInput('AKJurnaldetailT', 'rekening3_id');
                    renameInput('AKJurnaldetailT', 'rekening4_id');
                    renameInput('AKJurnaldetailT', 'rekening5_id');
                    renameInput('AKJurnaldetailT', 'saldodebit');
                    renameInput('AKJurnaldetailT', 'saldokredit');
                    renameInput('AKJurnaldetailT', 'catatan');

                    renameInput('AKJurnaldetailT', 'kdstruktur');
                    renameInput('AKJurnaldetailT', 'kdkelompok');
                    renameInput('AKJurnaldetailT', 'kdjenis');
                    renameInput('AKJurnaldetailT', 'kdobyek');
                    renameInput('AKJurnaldetailT', 'kdrincianobyek');
                    renameInput('AKJurnaldetailT', 'nmrincianobyek');
                }
            }, "json"
        );
    }
    
    function maskMoneyAll()
    {
        $('#tabel-detail tbody tr').each(function(){
            $(this).find("input[class$='currency']").maskMoney(
                {"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
            );            
        });
    }
    
    function unMaskMoneyAll()
    {
        $('#tabel-detail tbody tr').each(function(){
            $(this).find("input[class$='currency']").unmaskMoney(
                {"symbol":"Rp ","defaultZero":true,"allowZero":true,"decimal":".","thousands":",","precision":0}
            );            
        });
    }    
    
    
    function renameInput(modelName, attributeName)
    {
        var trLength = $('#tabel-detail tbody tr').length;
        var i=-1;
        $('#tabel-detail tbody tr').each(function(){
            if($(this).has('span[name$="[kdstruktur]"]').length){
                i++;
            }
            $(this).find('span[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('span[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            
            $(this).find('input[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('input[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            
            $(this).find('textarea[name$="['+attributeName+']"]').attr('name',modelName+'['+i+']['+attributeName+']');
            $(this).find('textarea[name$="['+attributeName+']"]').attr('id',modelName+'_'+i+'_'+attributeName+'');
            
            $(this).find('span[name$="[nourut_ex]"]').text(i+1);
            $(this).find('input[name$="[nourut]"]').val(i+1);
        });
    }
    
    function hitungTotalUang()
    {
        var saldokredit = 0;
        var saldodebit = 0;
        $('#tabel-detail tbody tr').each(
            function(){
                saldodebit += parseInt(unformatNumber($(this).find('input[name$="[saldodebit]"]').val()));
                saldokredit += parseInt(unformatNumber($(this).find('input[name$="[saldokredit]"]').val()));
            }
        );
        $("#totalSaldoDebit").val(formatNumber(saldodebit));
        $("#totalSaldoKredit").val(formatNumber(saldokredit));
    }
    
    function simpanJurnalUmum(params)
    {
        var jenis_simpan = params;
        var kosong = "";
        var jumlahKosong = $("#inputJurnalUmum").find(".reqForm[value="+ kosong +"]");
        
        if(jumlahKosong.length > 0){
            myAlert('Inputan yang bertanda bintang harus diisi, silakan cek kembali!');
        }else{
            var x = 0;
            $('#tabel-detail tbody tr').each(
                function(){
                    x++;
                }
            );
            var totalSaldoDebit = $("#totalSaldoDebit").val();
            var totalSaldoKredit = $("#totalSaldoKredit").val();
            if(totalSaldoDebit !== totalSaldoKredit){
                myAlert('Saldo kredit dan debit tidak sama, silakan cek kembali!');
                return false
            }else if ((totalSaldoDebit == 0) && (totalSaldoKredit == 0)){
				myAlert('Total 0, debit/kredit tidak boleh bernilai 0!');
                return false
			}
			
            if(x > 0)
            {
                $('.currency').each(
                    function(){
                        this.value = unformatNumber(this.value)
                    }
                );                
                $.post("<?php echo Yii::app()->createUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SimpanJurnalUmum');?>", {jenis_simpan:jenis_simpan,data:$("#form-jurnal-umum").serialize()},
                    function(data){
                        if(data.status == 'ok')
                        {
                            if(data.action == 'insert')
                            {
								hapusIndexMenu();
                                $("#inputJurnalUmum").find("input[name$='[nobuktijurnal]']").val(data.pesan.nobuktijurnal);
                                $("#inputJurnalUmum").find("input[name$='[kodejurnal]']").val(data.pesan.kodejurnal);
                                $("#inputJurnalUmum").find("input[name$='[rekperiod_id]']").val(data.pesan.rekperiod_id);
								$('.divForForm').html(data.alert);
                            }else{
                                myAlert("Update data berhasil");
                            }
                        }
                    }, "json"
                );                                
            }else{
                myAlert('Detail jurnal masih kosong!');
            }

        }
        return false;
    }
    
</script>