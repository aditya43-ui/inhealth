<?php
// dialog id lab
$this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
    'id' => 'dialogCariSep',
    'options' => array(
        'title' => 'Daftar Pencarian Pasien SEP',
        'autoOpen' => false,
        //'position'=>['top',20] ,
        'modal' => true,
        'width' => 650,
        'height' => 700,
        'resizable' => false,
    ),
));
$this->renderPartial('grid/_daftar_pasien_sep',[]);
$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDiagnosaPRB',
    'options' => array(
        'title' => 'Pencarian Diagnosa PRB',
        'autoOpen' => false,
        'modal' => true,
        'width' => 530,
        'height' => 450,
        'resizable' => false,
    ),
));

echo '<div id="form-diagnosa-prb" class="form-horizontal" style="padding:10px;">';
echo '<br/>';

echo $this->renderPartial('grid/_daftar_diagnosa_prb',[], true);

echo '</div>';

$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogDokterDPJP',
    'options' => array(
        'title' => 'Pencarian Dokter DPJP',
        'autoOpen' => false,
        'modal' => true,
        'width' => 530,
        'height' => 450,
        'resizable' => false,
    ),
));

echo '<div id="form-dokter-dpjp" class="form-horizontal" style="padding:10px;">';
echo '<br/>';
echo '
    <div class="control-group">
        <label class="control-label">Kode Spesialis</label>
        <div class="controls">
            '.CHtml::textField('fieldKodeSpesialis','',['class'=>'span3 required']).'
        </div>
        <div class="controls">
            '.CHtml::htmlButton("<span class='entypo-Search'></span> Cari",['class'=>'btn btn-primary', 'onclick'=>'refGridDokterDpjp();']).'
        </div>
    </div>
';
echo $this->renderPartial('grid/_daftar_dokter_dpjp',[], true);

echo '</div>';

$this->endWidget();

$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogObatPRB',
    'options' => array(
        'title' => 'Pencarian Obat PRB',
        'autoOpen' => false,
        'modal' => true,
        'width' => 530,
        'height' => 450,
        'resizable' => false,
    ),
));

echo '<div id="form-obat-prb" class="form-horizontal" style="padding:10px;">';
echo '<br/>';
echo '
    <div class="control-group">
        <label class="control-label">Nama Obat Generik</label>
        <div class="controls">
            '.CHtml::textField('fieldKodeObatPRB','',['class'=>'span3 required']).'
        </div>
        <div class="controls">
            '.CHtml::htmlButton("<span class='entypo-Search'></span> Cari",['class'=>'btn btn-primary', 'onclick'=>'refGridObatPrb();']).'
        </div>
    </div>
';
echo $this->renderPartial('grid/_daftar_obat_prb',[], true);

echo '</div>';

$this->endWidget();

$jscript = <<< JS
       
    const resetPasienSep = () => {
        $(".nosep").val("");
        $(".sep_id").val("");
        $(".tglsep").val("");
        $(".no_pendaftaran").val("");
        $(".no_rekam_medik").val("");
        $(".tgl_pendaftaran").val("");
        $(".nokartuasuransi").val("");
        $(".nama_pasien").val("");
        $(".tanggal_lahir").val("");
        $(".jeniskelamin").val("");
        $(".alamat_pasien").val("");
        $(".pendaftaran_id").val("");
    }
        
        
    const refGridPasienSep = () => {
        $.fn.yiiGridView.update('daftar-pasien-sep-grid', {
            data: {
                'PPPencarianseprujukankeluarV[default]':''
            }
        });
    }            
        
    const setPasienSep = (data) => {
        $(".nosep").val(data.nosep);
        $(".sep_id").val(data.sep_id);
        $(".tglsep").val(data.tglsep);
        $(".no_pendaftaran").val(data.no_pendaftaran);
        $(".no_rekam_medik").val(data.no_rekam_medik);
        $(".tgl_pendaftaran").val(data.tgl_pendaftaran);
        $(".nokartuasuransi").val(data.nokartuasuransi);
        $(".nama_pasien").val(data.nama_pasien);
        $(".tanggal_lahir").val(data.tanggal_lahir);
        $(".jeniskelamin").val(data.jeniskelamin);
        $(".alamat_pasien").val(data.alamat_pasien);
        $(".pendaftaran_id").val(data.pendaftaran_id);
        $(".jnspelayanan").val(data.jnspelayanan);

        $(".programprb_kode").val(data.programprb_kode);
        $(".programprb_nama").val(data.programprb_nama);
        $(".diagnosabpjskode").val(data.diagnosabpjskode);
        $(".alamat_email").val(data.alamatemail);

        $(".dpjp_id").val(data.dpjp_id);
        $(".dpjp_nama").val(data.dpjp_nama);
        
        $("#dialogCariSep").dialog("close");
    }
        
        
    const refGridDiagnosaPrb = () => {
        $.fn.yiiGridView.update('daftar-pasien-sep-grid', {
            data: {
                'ARCustomModel[default]':''
            }
        });
    }            
        
    const pilihDiagnosaPRB = (data) => {
        
        $(".programprb_kode").val(data.kode);
        $(".programprb_nama").val(data.nama);
        $(".diagnosabpjskode").val(data.kode+" - "+data.nama);
       
        $("#dialogDiagnosaPRB").dialog("close");
    }
        
    const resetDiagnosaPRB = () => {
        $(".programprb_kode").val("");
        $(".programprb_nama").val("");
        $(".diagnosabpjskode").val("");
    }
        
    const refGridObatPrb = () => {
        const obatprb = $("#fieldKodeObatPRB").val();
        if (obatprb != ''){
            $.fn.yiiGridView.update('daftar-obat-prb-grid', {
                data: {
                    'ARCustomModel[default]':'',
                    'ARCustomModel[obatprb]':obatprb

                }
            });
        }else{
            myAlert("Obat generik belum diisi");
        }
    }            
        
    const pilihObatPRB = (data) => {
        
        $(".obatprb_bpjskode").val(data.kode);
        $(".obatprb_bpjsnama").val(data.nama);
        $(".obatbpjsprb").val(data.kode+" - "+data.nama);
       
        $("#dialogObatPRB").dialog("close");
    }
        
    const resetObatPRB = () => {
        $(".obatprb_bpjskode").val("");
        $(".obatprb_bpjsnama").val("");        
    }
        
    const refGridDokterDpjp= () => {
        
        const tglsep = $(".tglsep").val();
        const jnspelayanan = $(".jnspelayanan").val();
        const kodepesialis = $("#fieldKodeSpesialis").val();
        
        if (tglsep != '' && jnspelayanan != '' && kodepesialis != ''){
            $.fn.yiiGridView.update('daftar-dokter-dpjp-grid', {
                data: {
                    'ARCustomModel[default]':'',
                    'ARCustomModel[tglsep]':tglsep,
                    'ARCustomModel[jnspelayanan]':jnspelayanan,
                    'ARCustomModel[kodespesialis]':kodepesialis,
                    'ARCustomModel[isdokterrs]':true
                }
            });
        }else{
            myAlert("kode spesialis dan pasien sep harus dipilih");
        }
    }            
        
    const pilihDokterDPJP = (data) => {
        
        $(".dpjp_id").val(data.dpjp_id);
        $(".dpjp_nama").val(data.dpjp_nama);
       
        $("#dialogDokterDPJP").dialog("close");
    }
        
    const resetDokterDPJP = () => {
        $(".dpjp_nama").val("");
        $(".dpjp_id").val("");        
    }
        
JS;

Yii::app()->clientScript->registerScript('program-rujuk-balik-dialog',$jscript, CClientScript::POS_HEAD);
?>


