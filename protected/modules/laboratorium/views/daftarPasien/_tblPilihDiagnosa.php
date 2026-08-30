
<div id='tblDiagnosa' class="">

<?php 
$modDiagnosaPasien = new DiagnosaV('searchDiagnosis');
$modDiagnosaPasien->unsetAttributes();  // clear any default values
if(isset($_GET['DiagnosaV'])){
	$modDiagnosaPasien->attributes=$_GET['DiagnosaV'];
}

$criteriaTab = new CDbCriteria;
$criteriaTab->compare('tabularlist_id', $modDiagnosaPasien->tabularlist_id);
$criteriaTab->addCondition('dtd_aktif = true');
$criteriaTab->order = 'dtd_nourut';
            
$this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rjdiagnosa-m-grid',
    'dataProvider'=>$modDiagnosaPasien->searchDiagnosis(),
    'filter'=>$modDiagnosaPasien,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-bordered table-striped table-condensed',
    'columns'=>array(
        /*
        array(
            'name'=>'diagnosa_nourut',
            'value'=>'$data->diagnosa_nourut',
        ),
        array(
			'header'=>'Klasifikasi Diagnosa',
            'name'=>'klasifikasidiagnosa_id',
            'value'=>'isset($data->klasifikasidiagnosa_id) ? $data->klasifikasidiagnosa_kode." - ".$data->klasifikasidiagnosa_nama : ""',
			'filter'=> CHtml::activeDropDownList($modDiagnosaPasien,'klasifikasidiagnosa_id',CHtml::listData(RJKlasifikasidiagnosaM::model()->findAll("klasifikasidiagnosa_aktif is true"), "klasifikasidiagnosa_id", "KlasifikasiKodeNama"),array('empty'=>'-- Pilih --')),
        ),
        array(
            'name'=>'diagnosa_kode',
            'value'=>'$data->diagnosa_kode',
        ),
        array(
            'name'=>'diagnosa_nama',
            'value'=>'$data->diagnosa_nama',
        ),
        array(
            'name'=>'diagnosa_namalainnya',
            'value'=>'$data->diagnosa_namalainnya',
        ),
        array(
            'name'=>'diagnosa_katakunci',
            'value'=>'$data->diagnosa_katakunci',
        ),
         
         * 
         */
        array(
            'header'=>'Tabulasi List',
            'type'=>'raw',
            'name'=>'tabularlist_id',
            'value'=>'$data->tabularlist_chapter',
            'filter'=>Chtml::activeDropDownList($modDiagnosaPasien, 'tabularlist_id', CHtml::listData(
                    TabularlistM::model()->findAll(array('order'=>'tabularlist_id', 'condition'=>'tabularlist_aktif = true')), 'tabularlist_id', 'tabularlist_chapter'
            ), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Daftar Tabulasi Data',
            'type'=>'raw',
            'name'=>'dtd_id',
            'value'=>'$data->dtd_kode',
            'filter'=>Chtml::activeDropDownList($modDiagnosaPasien, 'dtd_id', CHtml::listData(
                    DtdM::model()->findAll($criteriaTab), 'dtd_id', 'dtd_kode'
            ), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Klasifikasi Kode',
            'type'=>'raw',
            'name'=>'klasifikasidiagnosa_kode',
            'value'=>'$data->klasifikasidiagnosa_kode',
             'filter' =>  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'model'=>$modDiagnosaPasien, 
			'attribute'=>'klasifikasidiagnosa_kode',
			//'source'=>$this->createUrl('/ActionAutoComplete/cariDiagnosa',array('tabularlist_id'=>$modDiagnosaPasien->tabularlist_id)), 
                        'source'=>'js: function(request, response) {
                                $.ajax({
                                        url: "'.$this->createUrl('/ActionAutoComplete/CariKlarifikasiDiagnosaKode').'",
                                        dataType: "json",
                                        data: {
                                                term: request.term,
                                                tabularlist_id: $("#DiagnosaV_tabularlist_id").val(),
                                                dtd_id: $("#DiagnosaV_dtd_id").val(),
                                        },
                                        success: function (data) {
                                                 response(data);
                                        }
                                })
                        }',
			'options' => array(
                            'showAnim'=>'fold',
                            'minLength'=>3,
                            'select'=>'js:function( event, ui ) {
                                        $(this).val(ui.item.klasifikasidiagnosa_kode);
                                        return false;
                                }',
                            ),
			'htmlOptions' => array('class'=>'auto_klasifikasidiagnosa_kode'),
		), true),
        ),
        array(
            'header'=>'Klasifikasi Nama',
            'type'=>'raw',
            'name'=>'klasifikasidiagnosa_nama',
            'value'=>'$data->klasifikasidiagnosa_nama',
              'filter' =>  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'model'=>$modDiagnosaPasien, 
			'attribute'=>'klasifikasidiagnosa_nama',
			//'source'=>$this->createUrl('/ActionAutoComplete/cariDiagnosa',array('tabularlist_id'=>$modDiagnosaPasien->tabularlist_id)), 
                        'source'=>'js: function(request, response) {
                                $.ajax({
                                        url: "'.$this->createUrl('/ActionAutoComplete/CariKlarifikasiDiagnosa').'",
                                        dataType: "json",
                                        data: {
                                                term: request.term,
                                                tabularlist_id: $("#DiagnosaV_tabularlist_id").val(),
                                                dtd_id: $("#DiagnosaV_dtd_id").val(),
                                        },
                                        success: function (data) {
                                                 response(data);
                                        }
                                })
                        }',
			'options' => array(
                            'showAnim'=>'fold',
                            'minLength'=>3,
                            'select'=>'js:function( event, ui ) {
                                        $(this).val(ui.item.klasifikasidiagnosa_nama);
                                        $("#DiagnosaV_tabularlist_id").focus();
                                        return false;
                                }',
                            ),
			'htmlOptions' => array('class'=>'auto_klasifikasidiagnosa_nama'),
		), true),
        ),
        array(
            'header'=>'Diagnosa Kode',
            'type'=>'raw',
            'name'=>'diagnosa_kode',
            'value'=>'$data->diagnosa_kode',
             'filter' =>  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'model'=>$modDiagnosaPasien, 
			'attribute'=>'diagnosa_kode',
			//'source'=>$this->createUrl('/ActionAutoComplete/cariDiagnosa',array('tabularlist_id'=>$modDiagnosaPasien->tabularlist_id)), 
                        'source'=>'js: function(request, response) {
                                $.ajax({
                                        url: "'.$this->createUrl('/ActionAutoComplete/CariDiagnosaKode').'",
                                        dataType: "json",
                                        data: {
                                                term: request.term,
                                                tabularlist_id: $("#DiagnosaV_tabularlist_id").val(),
                                                dtd_id: $("#DiagnosaV_dtd_id").val(),
                                        },
                                        success: function (data) {
                                                 response(data);
                                        }
                                })
                        }',
			'options' => array(
                            'showAnim'=>'fold',
                            'minLength'=>3,
                            'select'=>'js:function( event, ui ) {
                                        $(this).val(ui.item.diagnosa_kode);
                                        $("#DiagnosaV_tabularlist_id").focus();
                                        return false;
                                }',
                            ),
			'htmlOptions' => array('class'=>'auto_diagnosa_kode'),
		), true),
        ),
        array(
            'header'=>'Diagnosa',
            'type'=>'raw',
            'name'=>'diagnosa_nama',
            'value'=>'$data->diagnosa_nama',
            'filter' =>  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'model'=>$modDiagnosaPasien, 
			'attribute'=>'diagnosa_nama',
			//'source'=>$this->createUrl('/ActionAutoComplete/cariDiagnosa',array('tabularlist_id'=>$modDiagnosaPasien->tabularlist_id)), 
                        'source'=>'js: function(request, response) {
                                $.ajax({
                                        url: "'.$this->createUrl('/ActionAutoComplete/CariDiagnosa').'",
                                        dataType: "json",
                                        data: {
                                                term: request.term,
                                                tabularlist_id: $("#DiagnosaV_tabularlist_id").val(),
                                                dtd_id: $("#DiagnosaV_dtd_id").val(),
                                        },
                                        success: function (data) {
                                                 response(data);
                                        }
                                })
                        }',
			'options' => array(
                            'showAnim'=>'fold',
                            'minLength'=>3,
                            'select'=>'js:function( event, ui ) {
                                        $(this).val(ui.item.diagnosa_nama);
                                        $("#DiagnosaV_tabularlist_id").focus();
                                        return false;
                                }',
                            ),
			'htmlOptions' => array('class'=>'auto_diagnosa_nama'),
		), true),
            
            // 'value'=>'$data->diagnosa_namalainnya',
        ),
        //array(
          //  'header'=>'Nama Lain',
           // 'type'=>'raw',
           // 'name'=>'diagnosa_namalainnya',
           // 'value'=>'$data->diagnosa_namalainnya',
        //),
        array(
            'header'=>'Kata Kunci',
            'name'=>'diagnosa_katakunci',
            'value'=>'$data->diagnosa_katakunci',
        ),
        array(
            'header'=>'Kelompok Diagnosa',
            'type'=>'raw',
            'value'=>'CHtml::dropDownList("kelompokDiagnosa_$data->diagnosa_id","",CHtml::listData(LBKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif is true"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);",))',
        ),   
		array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputDiagnosa(this,$data->diagnosa_id);return false;"))',
        ),
        /*
        'diagnosa_imunisasi',
        'diagnosa_aktif',
        */
    ),
        'afterAjaxUpdate'=>'function(id, data){generateExt(); generateExt3(); generateExt5(); generateExt6(); jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"}); injekEnterDiagnosa();}',
)); 
?> 
</div>
   
<div id="tblKasuspenyakitDiagnosa" class="hide">
    <?php echo CHtml::hiddenField('autojeniskasus_id',$modKasuspenyakitDiagnosa->jeniskasuspenyakit_id,array('readonly' => true)) ?>
<?php $this->widget('ext.bootstrap.widgets.BootGridView',array(
    'id'=>'rjkasuspenyakitdiagnosa-m-grid',
    'dataProvider'=>$modKasuspenyakitDiagnosa->search(),
    'filter'=>$modKasuspenyakitDiagnosa,
	'template'=>"{summary}\n{items}\n{pager}",
	'itemsCssClass'=>'table table-bordered table-striped table-condensed',
    'columns'=>array(
        /*
        array(
            'name'=>'diagnosa_nourut',
            'value'=>'$data->diagnosa->diagnosa_nourut',
//            'filter'=>true,
        ),
        array(
			'header'=>'Klasifikasi Diagnosa',
			'name'=>'klasifikasidiagnosa_id',
            'value'=>'isset($data->diagnosa->klasifikasidiagnosa_id) ? $data->diagnosa->klasifikasidiagnosa->KlasifikasiKodeNama : ""',
			'filter'=> CHtml::activeDropDownList($modKasuspenyakitDiagnosa,'klasifikasidiagnosa_id',CHtml::listData(RJKlasifikasidiagnosaM::model()->findAll("klasifikasidiagnosa_aktif is true"), "klasifikasidiagnosa_id", "KlasifikasiKodeNama"),array('empty'=>'-- Pilih --')),
        ),
		array(
            'name'=>'diagnosa_kode',
            'value'=>'$data->diagnosa->diagnosa_kode',
        ),
        array(
            'name'=>'diagnosa_nama',
            'value'=>'$data->diagnosa->diagnosa_nama',
//			'filter'=>true,
        ),
        array(
            'name'=>'diagnosa_namalainnya',
            'value'=>'$data->diagnosa->diagnosa_namalainnya',
//			'filter'=>true,
        ),
        array(
            'name'=>'diagnosa_katakunci',
            'value'=>'$data->diagnosa->diagnosa_katakunci',
//			'filter'=>true,
        ),
        array(
            'header'=>'Kelompok Diagnosa',
            'type'=>'raw',
            'value'=>'CHtml::dropDownList("kelompokDiagnosa_$data->diagnosa_id","",CHtml::listData(LBKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif is true"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);",))',
//			'filter'=>true,
        ),
         * 
         */
        array(
            'header'=>'Tabulasi List',
            'type'=>'raw',
            'name'=>'tabularlist_id',
            'value'=>'$data->tabularlist_chapter',
            'filter'=>Chtml::activeDropDownList($modKasuspenyakitDiagnosa, 'tabularlist_id', CHtml::listData(
                    TabularlistM::model()->findAll(array('order'=>'tabularlist_id', 'condition'=>'tabularlist_aktif = true')), 'tabularlist_id', 'tabularlist_chapter'
            ), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Daftar Tabulasi Data',
            'type'=>'raw',
            'name'=>'dtd_id',
            'value'=>'$data->dtd_kode',
            'filter'=>Chtml::activeDropDownList($modKasuspenyakitDiagnosa, 'dtd_id', CHtml::listData(
                    DtdM::model()->findAll($criteriaTab), 'dtd_id', 'dtd_kode'
            ), array('empty'=>'-- Pilih --')),
        ),
        array(
            'header'=>'Klasifikasi Kode',
            'type'=>'raw',
            'name'=>'klasifikasidiagnosa_kode',
            'value'=>'$data->klasifikasidiagnosa_kode',
        ),
        array(
            'header'=>'Klasifikasi Nama',
            'type'=>'raw',
            'name'=>'klasifikasidiagnosa_nama',
            'value'=>'$data->klasifikasidiagnosa_nama',
        ),
        array(
            'header'=>'Diagnosa Kode',
            'type'=>'raw',
            'name'=>'diagnosa_kode',
            'value'=>'$data->diagnosa_kode',
            'filter' =>  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'model'=>$modKasuspenyakitDiagnosa, 
			'attribute'=>'diagnosa_kode',
			//'source'=>$this->createUrl('/ActionAutoComplete/cariDiagnosa',array('tabularlist_id'=>$modDiagnosaPasien->tabularlist_id)), 
                        'source'=>'js: function(request, response) {
                                $.ajax({
                                        url: "'.$this->createUrl('/ActionAutoComplete/CariKasusPenyakitDiagnosaKode').'",
                                        dataType: "json",
                                        data: {
                                                term: request.term,
                                                jeniskasuspenyakit_id: $("#autojeniskasus_id").val(),                                                
                                        },
                                        success: function (data) {
                                                 response(data);
                                        }
                                })
                        }',
			'options' => array(
                            'showAnim'=>'fold',
                            'minLength'=>3,
                            'select'=>'js:function( event, ui ) {
                                        $(this).val(ui.item.diagnosa_kode);
                                        $("#KasuspenyakitdiagnosaV_tabularlist_id").focus();
                                        return false;
                                }',
                            ),
			'htmlOptions' => array('class'=>'auto_jeniskasus_kode'),
		), true),
        ),
        /*array(
            'header'=>'Diagnosa',
            'type'=>'raw',
            'name'=>'diagnosa_nama',
            'value'=>'$data->diagnosa_nama',
        ),*/
        array(
            'header'=>'Diagnosa',
            'type'=>'raw',
            'name'=>'diagnosa_nama',
            'value'=>'$data->diagnosa_nama',
            'filter' =>  $this->widget('zii.widgets.jui.CJuiAutoComplete', array(
			'model'=>$modKasuspenyakitDiagnosa, 
			'attribute'=>'diagnosa_nama',
			//'source'=>$this->createUrl('/ActionAutoComplete/cariDiagnosa',array('tabularlist_id'=>$modDiagnosaPasien->tabularlist_id)), 
                        'source'=>'js: function(request, response) {
                                $.ajax({
                                        url: "'.$this->createUrl('/ActionAutoComplete/CariKasusPenyakitDiagnosa').'",
                                        dataType: "json",
                                        data: {
                                                term: request.term,
                                                jeniskasuspenyakit_id: $("#autojeniskasus_id").val(),                                                
                                        },
                                        success: function (data) {
                                                 response(data);
                                        }
                                })
                        }',
			'options' => array(
                            'showAnim'=>'fold',
                            'minLength'=>3,
                            'select'=>'js:function( event, ui ) {
                                        $(this).val(ui.item.diagnosa_nama);
                                        $("#KasuspenyakitdiagnosaV_tabularlist_id").focus();
                                        return false;
                                }',
                            ),
			'htmlOptions' => array('class'=>'auto_jeniskasus'),
		), true),
            
            // 'value'=>'$data->diagnosa_namalainnya',
        ),
        array(
            'header'=>'Nama Lain',
            'type'=>'raw',
            'name'=>'diagnosa_namalainnya',
            'value'=>'$data->diagnosa_namalainnya',
        ),
        array(
            'header'=>'Kata Kunci',
            'name'=>'diagnosa_katakunci',
            'value'=>'$data->diagnosa_katakunci',
        ),
        array(
            'header'=>'Kelompok Diagnosa',
            'type'=>'raw',
            'value'=>'CHtml::dropDownList("kelompokDiagnosa_$data->diagnosa_id","",CHtml::listData(LBKelompokDiagnosaM::model()->findAll("kelompokdiagnosa_aktif is true"), "kelompokdiagnosa_id", "kelompokdiagnosa_nama"),array("empty"=>"-- Pilih --","class"=>"span2", "onkeypress"=>"return $(this).focusNextInputField(event);",))',
//			'filter'=>true,
        ),
        array(
            'header'=>'Pilih',
            'type'=>'raw',
            'value'=>'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small", 
                            "id" => "selectPasien",
                            "onClick" => "inputDiagnosa(this,$data->diagnosa_id);return false;"))',
        ),
    ),
        'afterAjaxUpdate'=>'function(id, data){generateExt2();generateExt4();jQuery(\''.Params::TOOLTIP_SELECTOR.'\').tooltip({"placement":"'.Params::TOOLTIP_PLACEMENT.'"}); injekEnterPenyakitDiagnosa();}',
)); ?> 
</div>
<script>
function injekEnterDiagnosa() {
    $("#tblDiagnosa :input").keypress(function(e) {
        if (e.key.toLowerCase() === "enter") {
            $.fn.yiiGridView.update("rjdiagnosa-m-grid", {data: $("#tblDiagnosa :input").serialize()});
        }
    });
}

function injekEnterPenyakitDiagnosa() {
    $("#tblKasuspenyakitDiagnosa :input").keypress(function(e) {
        if (e.key.toLowerCase() === "enter") {
            $.fn.yiiGridView.update("rjkasuspenyakitdiagnosa-m-grid", {data: $("#tblKasuspenyakitDiagnosa :input").serialize()});
        }
    });
}

function generateExt(){    
    $(".auto_diagnosa_nama").each(function(){                                                    
        $(this).autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function(event, ui )
                {
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui )
                {                                                
                    $(this).val(ui.item.diagnosa_nama);
                    $("#DiagnosaV_tabularlist_id").focus();
                    return false;
                },
                'source':function(request, response)
                {                                                                                                                                  
                    $.ajax({
                        url: "<?php echo $this->createUrl('/actionAutoComplete/cariDiagnosa');?>",
                        dataType: "json",
                        data:{
                            term: request.term,                                
                            tabularlist_id: $("#DiagnosaV_tabularlist_id").val(),
                            dtd_id: $("#DiagnosaV_dtd_id").val(),                   
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                },
            }
        );
    });

    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
}

function generateExt3(){    
    $(".auto_diagnosa_kode").each(function(){                                                    
        $(this).autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function(event, ui )
                {
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui )
                {                                                
                    $(this).val(ui.item.diagnosa_kode);
                    $("#DiagnosaV_tabularlist_id").focus();
                    return false;
                },
                'source':function(request, response)
                {                                                                                                                                  
                    $.ajax({
                        url: "<?php echo $this->createUrl('/actionAutoComplete/cariDiagnosaKode');?>",
                        dataType: "json",
                        data:{
                            term: request.term,                                
                            tabularlist_id: $("#DiagnosaV_tabularlist_id").val(),
                            dtd_id: $("#DiagnosaV_dtd_id").val(),                   
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                },
            }
        );
    });

    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
}

function generateExt2(){    
    $(".auto_jeniskasus").each(function(){                                                    
        $(this).autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function(event, ui )
                {
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui )
                {                                                
                    $(this).val(ui.item.diagnosa_nama);
                    $("#KasuspenyakitdiagnosaV_tabularlist_id").focus();
                    return false;
                },
                'source':function(request, response)
                {                                                                                                                                  
                    $.ajax({
                        url: "<?php echo $this->createUrl('/actionAutoComplete/CariKasusPenyakitDiagnosa');?>",
                        dataType: "json",
                        data:{
                            term: request.term,                                
                            jeniskasuspenyakit_id: $("#autojeniskasus_id").val(),                                          
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                },
            }
        );
    });

    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
}

function generateExt4(){    
    $(".auto_jeniskasus_kode").each(function(){                                                    
        $(this).autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function(event, ui )
                {
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui )
                {                                                
                    $(this).val(ui.item.diagnosa_kode);
                    $("#KasuspenyakitdiagnosaV_tabularlist_id").focus();
                    return false;
                },
                'source':function(request, response)
                {                                                                                                                                  
                    $.ajax({
                        url: "<?php echo $this->createUrl('/actionAutoComplete/CariKasusPenyakitDiagnosaKode');?>",
                        dataType: "json",
                        data:{
                            term: request.term,                                
                            jeniskasuspenyakit_id: $("#autojeniskasus_id").val(),                                          
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                },
            }
        );
    });

    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
}

function generateExt5(){    
    $(".auto_klasifikasidiagnosa_nama").each(function(){                                                    
        $(this).autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function(event, ui )
                {
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui )
                {                                                
                    $(this).val(ui.item.klasifikasidiagnosa_nama);
                    $("#DiagnosaV_tabularlist_id").focus();
                    return false;
                },
                'source':function(request, response)
                {                                                                                                                                  
                    $.ajax({
                        url: "<?php echo $this->createUrl('/actionAutoComplete/CariKlarifikasiDiagnosa');?>",
                        dataType: "json",
                        data:{
                            term: request.term,                                
                            tabularlist_id: $("#DiagnosaV_tabularlist_id").val(),
                            dtd_id: $("#DiagnosaV_dtd_id").val(),                   
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                },
            }
        );
    });

    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
}

function generateExt6(){    
    $(".auto_klasifikasidiagnosa_kode").each(function(){                                                    
        $(this).autocomplete(
            {
                'showAnim':'fold',
                'minLength':3,
                'focus':function(event, ui )
                {
                    $(this).val("");
                    return false;
                },
                'select':function( event, ui )
                {                                                
                    $(this).val(ui.item.auto_klasifikasidiagnosa_kode);
                    return false;
                },
                'source':function(request, response)
                {                                                                                                                                  
                    $.ajax({
                        url: "<?php echo $this->createUrl('/actionAutoComplete/CariKlarifikasiDiagnosaKode');?>",
                        dataType: "json",
                        data:{
                            term: request.term,                                
                            tabularlist_id: $("#DiagnosaV_tabularlist_id").val(),
                            dtd_id: $("#DiagnosaV_dtd_id").val(),                   
                        },
                        success: function (data) {
                            response(data);
                        }
                    })
                },
            }
        );
    });

    jQuery('<?php echo Params::TOOLTIP_SELECTOR; ?>').tooltip();
}

injekEnterDiagnosa(); injekEnterPenyakitDiagnosa();
</script>