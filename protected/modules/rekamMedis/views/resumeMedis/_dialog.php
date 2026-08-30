<?php
// dialog diagnosa x
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosaX',
    'options' => array(
        'title' => 'Daftar Diagnosa X',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));
$this->renderPartial('bedahSentral.views.laporanOperasi.grid/_daftar_diagnosa_x', []);
$this->endWidget();


// dialog diagnosa x
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogDiagnosaIX',
    'options' => array(
        'title' => 'Daftar Diagnosa IX',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 600,
        'resizable' => false,
    ),
));
$this->renderPartial('bedahSentral.views.laporanOperasi.grid/_daftar_diagnosa_ix', []);

$this->endWidget();


$barisDiagnosa = json_encode($this->renderPartial('bedahSentral.views.laporanOperasi.diagnosa-x/row/_baris_diagnosax', array('model' => $modMorbi,'i'=>0, 'dropKelompok'=>$dropKelompok), true));
$barisDiagnosaIx = json_encode($this->renderPartial('bedahSentral.views.laporanOperasi.diagnosa-ix/row/_baris_diagnosaix', array('model' => $modMorbiIx,'i'=>0, 'dropKelompok'=>$dropKelompok), true));

$paramsKelDiagUtama = Params::KELOMPOKDIAGNOSA_UTAMA;
$paramsKelDiagTambah = Params::KELOMPOKDIAGNOSA_TAMBAH;
$paramsKronis = 'Kronis';

$urlAutoCompleteDiagX = $this->createUrl('/actionAutoComplete/diagnosa');
$urlAutoCompleteDiagIx = $this->createUrl('/actionAutoComplete/getDiagnosaixM');
$urlAutoCompletePegawai = $this->createUrl('/rekamMedis/resumeMedis/getPegawai');

$hariini = date('Y-m-d');
$jscript = <<< JS
        
    const cekKelDianosaX = (obj) => {
        const diagUtama = '${paramsKelDiagUtama}';
        const jumlahUtama = $('#tbl_diagnosax tbody tr').find("select[name$='[kelompokdiagnosa_id]'] option:selected[value='"+diagUtama+"']").length;
                
        if (jumlahUtama > 1){
            myAlert("Kelompok diagnosa utama untuk diagnosa x, tidak boleh lebih dari 1");
            $(obj).val('${paramsKelDiagTambah}');
        }       
    }
            
    const cekKelDianosaIx = (obj) => {
        const diagUtama = '${paramsKelDiagUtama}';
        const jumlahUtama = $('#tbl_diagnosaix tbody tr').find("select[name$='[kelompokdiagnosa_id]'] option:selected[value='"+diagUtama+"']").length;
        
        if (jumlahUtama > 1){
            myAlert("Kelompok diagnosa utama untuk diagnosa ix, tidak boleh lebih dari 1");
            $(obj).val('${paramsKelDiagTambah}');
        }             
    }
        
    const hapusDiagnosa = (obj) => {
        window.parent.myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!", function(r){
            if (r){
                $(obj).parents("tr").detach();
            }
        });
    }
            
    const hapusDiagnosaIx = (obj) => {
        window.parent.myConfirm("Apakah Anda yakin ingin menghapus data ini ?","Perhatian!", function(r){
            if (r){
                $(obj).parents("tr").detach();
            }
        });
    }
        
    const setDiagnosa = (obj, data) => {
        var trUraian = new String(${barisDiagnosa});
        const kasusdiagnosa = $(obj).parents("tr").find(".kasusdiagnosa").val();
        
        let formbody = $("#tbl_diagnosax > tbody");
        formbody.append(trUraian);
                
        formbody = formbody.find("tr:last");
        formbody.find("input[name='[tglmorbiditas]']").val('${hariini}');
        formbody.find(".diagnosa_id").val(data.diagnosa_id);
        formbody.find(".diagnosa_kode").val(data.diagnosa_kode);
        formbody.find(".diagnosa_nama").val(data.diagnosa_nama);
        formbody.find(".diagnosa_namalainnya").val(data.diagnosa_namalainnya);               
        formbody.find(".kasusdiagnosa").val(kasusdiagnosa); 
        formbody.find(".statusdiagnosapasien").val('${paramsKronis}'); 
        
        const diagUtama = '${paramsKelDiagUtama}';
        const jumlahUtama = $('#tbl_diagnosax tbody tr').find("select[name$='[kelompokdiagnosa_id]'] option:selected[value='"+diagUtama+"']").length;
                
        if (jumlahUtama > 1){
            formbody.find("select[name$='[kelompokdiagnosa_id]']").val('${paramsKelDiagTambah}');
        }   
        
        renameInputRow($("#tbl_diagnosax"));
        
        generateExtX($("#tbl_diagnosax"));
    }
            
    const setDiagnosaIx = (obj, data) => {
        var trUraian = new String(${barisDiagnosaIx});
        const kasusdiagnosa = $(obj).parents("tr").find(".kasusdiagnosa").val();
        
        let formbody = $("#tbl_diagnosaix > tbody");
        formbody.append(trUraian);
                
        formbody = formbody.find("tr:last");
        formbody.find("input[name='[tglpasienicd9cm]']").val('${hariini}');
        formbody.find(".diagnosaicdix_id").val(data.diagnosaicdix_id);
        formbody.find(".diagnosaicdix_kode").val(data.diagnosaicdix_kode);
        formbody.find(".diagnosaicdix_nama").val(data.diagnosaicdix_nama);
        formbody.find(".diagnosaicdix_namalainnya").val(data.diagnosaicdix_namalainnya);               
        formbody.find(".kasusdiagnosa").val(kasusdiagnosa); 
        
        const diagUtama = '${paramsKelDiagUtama}';
        const jumlahUtama = $('#tbl_diagnosaix tbody tr').find("select[name$='[kelompokdiagnosa_id]'] option:selected[value='"+diagUtama+"']").length;
                
        if (jumlahUtama > 1){
            formbody.find("select[name$='[kelompokdiagnosa_id]']").val('${paramsKelDiagTambah}');
        }   
        
        renameInputRow($("#tbl_diagnosaix"));
        
        generateExt(formbody);
    }
            
    const generateExtX = (formbody) => {
        formbody.find("input[name*='[tglmorbiditas]']").datetimepicker(
            jQuery.extend({
                    showMonthAfterYear: false
                },
                jQuery.datepicker.regional['id'], {
                    'dateFormat': 'dd M yy',
                    'maxDate': 'd',                    
                    'showSecond': true,                    
                    'changeYear': true,
                    'changeMonth': true,
                    'showAnim': 'fold',
                    'yearRange': '-80y:+20y'
                }
            )
        );
            
            
        formbody.find("input[name$='[diagnosa_nama]']").autocomplete({
           'showAnim': 'fold',
           'minLength': 3,
           'focus': function(event, ui) {
               return false;
           },
           'select': function(event, ui) {
               pilihDiagnosa(ui.item, this);
               return false;
           },
           'source': '${urlAutoCompleteDiagX}&param=nama'
       });
           
        formbody.find("input[name$='[diagnosa_kode]']").autocomplete({
           'showAnim': 'fold',
           'minLength': 3,
           'focus': function(event, ui) {
               return false;
           },
           'select': function(event, ui) {
               pilihDiagnosa(ui.item, this);
               return false;
           },
           'source': '${urlAutoCompleteDiagX}&param=kode'
       });
           
        formbody.find("input[name$='[diagnosa_namalainnya]']").autocomplete({
           'showAnim': 'fold',
           'minLength': 3,
           'focus': function(event, ui) {
               return false;
           },
           'select': function(event, ui) {
               pilihDiagnosa(ui.item, this);
               return false;
           },
           'source': '${urlAutoCompleteDiagX}&param=lainnya'
       });
           
       formbody.find("input[name$='[pegawai_nama]']").autocomplete({
          'showAnim': 'fold',
          'minLength': 3,
          'focus': function(event, ui) {
               $(this).val(ui.item.label);
               return false;
          },
          'select': function(event, ui) {
              pilihPegawaiX(ui.item, this);
              return false;
          },
          'source': '${urlAutoCompletePegawai}'
      });
    }
            
    const generateExt = (formbody) => {
        formbody.find("input[name*='[tglpasienicd9cm]']").datetimepicker(
            jQuery.extend({
                    showMonthAfterYear: false
                },
                jQuery.datepicker.regional['id'], {
                    'dateFormat': 'dd M yy',
                    'maxDate': 'd',                    
                    'showSecond': true,                    
                    'changeYear': true,
                    'changeMonth': true,
                    'showAnim': 'fold',
                    'yearRange': '-80y:+20y'
                }
            )
        );
            
            
        formbody.find("input[name$='[diagnosaicdix_nama]']").autocomplete({
           'showAnim': 'fold',
           'minLength': 3,
           'focus': function(event, ui) {
               return false;
           },
           'select': function(event, ui) {
               pilihDiagnosaIx(ui.item, this);
               return false;
           },
           'source': '${urlAutoCompleteDiagIx}&param=nama'
       });
           
        formbody.find("input[name$='[diagnosaicdix_kode]']").autocomplete({
           'showAnim': 'fold',
           'minLength': 3,
           'focus': function(event, ui) {
               return false;
           },
           'select': function(event, ui) {
               pilihDiagnosaIx(ui.item, this);
               return false;
           },
           'source': '${urlAutoCompleteDiagIx}&param=kode'
       });
           
        formbody.find("input[name$='[diagnosaicdix_namalainnya]']").autocomplete({
           'showAnim': 'fold',
           'minLength': 3,
           'focus': function(event, ui) {
               return false;
           },
           'select': function(event, ui) {
               pilihDiagnosaIx(ui.item, this);
               return false;
           },
           'source': '${urlAutoCompleteDiagIx}&param=lainnya'
       });
           
        formbody.find("input[name$='[pegawai_nama]']").autocomplete({
           'showAnim': 'fold',
           'minLength': 3,
           'focus': function(event, ui) {
                $(this).val(ui.item.namaLengkap);
                return false;
           },
           'select': function(event, ui) {
               pilihPegawaiIx(ui.item, this);
               return false;
           },
           'source': '${urlAutoCompletePegawai}'
       });
    }
           
    const pilihDiagnosaIx = (data, obj) => {
        const tr = $(obj).parents(".baris");
           
        tr.find("input[name$='[diagnosaicdix_nama]']").val(data.diagnosaicdix_nama);
        tr.find("input[name$='[diagnosaicdix_kode]']").val(data.diagnosaicdix_kode);
        tr.find("input[name$='[diagnosaicdix_namalainnya]']").val(data.diagnosaicdix_namalainnya);
//        tr.find("input[name$='[keterangan]']").val(data.diagnosaicdix_nama);
        console.log(data.diagnosaixdix_nama);
    }
           
    const pilihDiagnosa = (data, obj) => {
        const tr = $(obj).parents(".baris");
           
        tr.find("input[name$='[diagnosa_nama]']").val(data.diagnosa_nama);
        tr.find("input[name$='[diagnosa_kode]']").val(data.diagnosa_kode);
        tr.find("input[name$='[diagnosa_namalainnya]']").val(data.diagnosa_namalainnya);
//        tr.find("input[name$='[keterangan]']").val(data.diagnosa_nama);
    }
        
    const pilihPegawaiIx = (data, obj) => {         
        const tr = $(obj).parents(".baris");
           
        tr.find("input[name$='[pegawai_id]']").val(data.pegawai_id);
        tr.find("input[name$='[pegawai_nama]']").val(data.namaLengkap);
    }  

         
    const pilihPegawaiX = (data, obj) => {         
        const tr = $(obj).parents(".baris");
           
        tr.find("input[name$='[pegawai_id]']").val(data.value);
        tr.find("input[name$='[pegawai_nama]']").val(data.label);
    }  
               
    const refreshGridDiagnosaX = () => {
        $.fn.yiiGridView.update('daftar-diagnosa-x-grid', {
            data: {
                'DiagnosaM[default]':''
            }
        });
    }   
        
    const refreshGridDiagnosaIX = () => {
        $.fn.yiiGridView.update('daftar-diagnosa-ix-grid', {
            data: {
                'DiagnosaicdixM[default]':''
            }
        });
    }  
        
    const refreshGridPetugas = () => {
        $.fn.yiiGridView.update('daftar-petugas-grid', {
            data: {
                'PegawaiV[default]':''
            }
        });
    }
        
JS;

Yii::app()->clientScript->registerScript('cryopreservasi-dialog',$jscript, CClientScript::POS_HEAD);
?>


