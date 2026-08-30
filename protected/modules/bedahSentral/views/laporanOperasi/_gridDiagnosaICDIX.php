<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i> Tabel <b>Tindakan (ICD IX)</b>
        </div>
    </div>
    <div class="panel-body table-responsive">
        <div style="margin:3px;">
            <?php
            echo CHtml::htmlButton(
                '<i class="icon-plus icon-white"></i> Tambah Tindakan IX',
                array(
                    'onclick' => 'tambahDiagnosaix();return false;',
                    'class' => 'btn btn-primary',
                    'rel' => "tooltip",
                    'title' => "Klik untuk menambahkan Tindakan IX Pasien",
                )
            );
            ?>
        </div>
        <table class="table table-striped table-condensed form-utama" id="tbl_diagnosaix" del="pasien9">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tgl. Tindakan</th>
                    <th>Keterangan <span class="required">*</span></th>
                    <th>Kelompok Diagnosis</th>
                    <th>Dokter</th>
                    <th>Kode Tindakan</th>
                    <th>Uraian Tindakan</th>
                    <th>Nama Lain</th>
                    <th>Hapus</th>
                </tr>
            </thead>
            <tbody class="form-body">
                 <?php
                    if (!empty($model->setLoadDiagnosaIX)){
                        foreach($model->setLoadDiagnosaIX as $key => $det){
                            echo $this->renderPartial($this->path_view.'_formDiagnosaICDIX',['model'=>$det,'i'=>$key, 'form'=>$form], true);
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>

<?php
$modPasienIcd9->pegawai_id = $modPendaftaran->pegawai_id;
$modPasienIcd9->kelompokdiagnosa_id = 1;
?>
<script type="text/javascript">
    var trUraianix = new String(<?php echo CJSON::encode($this->renderPartial($this->path_view . '_formDiagnosaICDIX', array('form' => $form, 'model' => $modPasienIcd9), true)); ?>);

    const setWarnaIx = () => {
        let set = '';
        
        $("#tbl_diagnosaix > tbody > tr").removeClass("tandain");
        $("#tbl_diagnosaix > tbody > tr").each(function(){
            set = $("#diagnosaix-m-grid").find(".selectDiagnosaIX[data-id='"+$(this).find("input[name$='[diagnosaicdix_id]']").val()+"']");
            set.parents("tr").addClass("tandain");
        });
    }

    const inputDiagnosaix = (data) => {
        
        const cekSudahAda = $("#tbl_diagnosaix > tbody").find("input[name$='[diagnosaicdix_id]'][value='"+data.id+"']").length;
        if (cekSudahAda > 0){
            window.parent.myAlert("Diagnosa sudah ditambahkan");
            return false;
        }
        
        $("#tbl_diagnosaix > tbody").append(trUraianix);
                
        const tr = $("#tbl_diagnosaix > tbody > tr:last");
        tr.find("input[name$='[diagnosaicdix_id]']").val(data.id);
        tr.find("input[name$='[diagnosaicdix_kode]']").val(data.kode);
        tr.find("input[name$='[diagnosaicdix_nama]']").val(data.nama);
        tr.find("input[name$='[diagnosaicdix_namalainnya]']").val(data.namalain);        
        
        renameInputRow($("#tbl_diagnosaix"));
        generateExt($("#tbl_diagnosaix > tbody"));
        setWarnaIx();
    }

    function tambahDiagnosaix() {
        $('#dialogTambahDiagnosaix').dialog("open");
    }

    function hapusDiagnosaix(obj) {
        setWarnaIx();
    }
   
   
</script>

<?php
//========= Dialog buat cari Bahan Diet =========================
$this->beginWidget('zii.widgets.jui.CJuiDialog', array( // the dialog
    'id' => 'dialogTambahDiagnosaix',
    'options' => array(
        'title' => 'Daftar Diagnosis  ICD 9 CM',
        'autoOpen' => false,
        'modal' => true,
        'width' => 750,
        'height' => 550,
        'resizable' => false,
    ),
));
?>
<?php
$modDiagnosaix = new DiagnosaicdixM();
$modDiagnosaix->unsetAttributes();
if (isset($_GET['DiagnosaicdixM'])) {
    $modDiagnosaix->attributes = $_GET['DiagnosaicdixM'];
}
$this->widget(
    'ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'diagnosaix-m-grid',
        'dataProvider' => $modDiagnosaix->searchDialog(),
        'filter' => $modDiagnosaix,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => function($data) {
    
                    $res["id"] = $data->diagnosaicdix_id;
                    $res["kode"] = $data->diagnosaicdix_kode;
                    $res["nama"] = $data->diagnosaicdix_nama;
                    $res["namalain"] = $data->diagnosaicdix_namalainnya;
    
                    return CHtml::Link('<i class="icon-form-check"></i>',"javascript:;",array("class"=>"btn-small", 
                    "class" => "selectDiagnosaIX",                    
                    "data-id"=>$data->diagnosaicdix_id,
                    "onClick" => "inputDiagnosaix(".json_encode($res).");return false;"));
                },
            ),
            array(
                'name' => 'diagnosaicdix_nourut',
                'value' => '$data->diagnosaicdix_nourut',
                'filter' => false,
            ),
            'diagnosaicdix_kode',
            'diagnosaicdix_nama',
            'diagnosaicdix_namalainnya',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"}); updateSorotIX();}',
    )
);
$this->endWidget();
?>