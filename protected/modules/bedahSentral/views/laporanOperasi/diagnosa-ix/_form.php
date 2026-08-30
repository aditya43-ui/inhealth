


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <b>Tindakan ICD (IX)</b></div>
    </div>
    <div class="panel-body overflow-x">
        <?= CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah Tindakan ICD (IX)',['onclick'=>'$("#dialogDiagnosaIX").dialog("open");refreshGridDiagnosaIX();','class'=>'btn btn-primary']); ?>
        <hr/>
        <table class="table table-striped table-condensed form-utama" id="tbl_diagnosaix" del="pasien9">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tgl. Tindakan (ICD IX)</th>
                    <th>Keterangan<span class="required">*</span></th>
                    <th>Kelompok Tindakan (ICD IX)</th>
                    <th>Dokter</th>
                    <th>Kode Tindakan (ICD IX)</th>
                    <th>Uraian Tindakan (ICD IX)</th>
                    <th>Nama Lain</th>
                    <th class="el-aksi">Hapus</th>
                </tr>
            </thead>
            <tbody class="form-body">
                <?php
                    if (!empty($model->setLoadDiagnosaIX)){
                        foreach($model->setLoadDiagnosaIX as $key => $det){                              
                            echo $this->renderPartial('bedahSentral.views.laporanOperasi.diagnosa-ix/row/_baris_diagnosaix',['model'=>$det,'i'=>$key, 'dropKelompok'=>$dropKelompok], true);
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>