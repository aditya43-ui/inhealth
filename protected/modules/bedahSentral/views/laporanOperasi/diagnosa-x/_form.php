


<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title"><i class="entypo-credit-card"></i> Tabel <b>Diagnosa ICD (10)</b></div>
    </div>
    <div class="panel-body overflow-x">
        <?= CHtml::htmlButton('<i class="icon-plus icon-white"></i> Tambah Diagnosa 10',['onclick'=>'$("#dialogDiagnosaX").dialog("open");refreshGridDiagnosaX();','class'=>'btn btn-primary']); ?>
        <hr/>
        <table class="table table-striped table-condensed form-utama" id="tbl_diagnosax" del="morbi">
            <thead>
                <tr>
                    <th>No.</th>
                    <th>Tgl. Diagnosa</th>
                    <th>Keterangan<span class="required">*</span></th>
                    <th>Kelompok Diagnosis</th>
                    <th>Dokter</th>
                    <th>Kode Diagnosa</th>
                    <th>Nama Diagnosa</th>
                    <th>Nama Lain</th>
                    <th>Status Diagnosa</th>
                    <th class="el-aksi">Hapus</th>
                </tr>
            </thead>
            <tbody class="form-body">
                <?php
                    if (!empty($model->setLoadDiagnosaX)){
                        foreach($model->setLoadDiagnosaX as $key => $det){
                            echo $this->renderPartial('bedahSentral.views.laporanOperasi.diagnosa-x/row/_baris_diagnosax',['model'=>$det,'i'=>$key], true);
                        }
                    }
                ?>
            </tbody>
        </table>
    </div>
</div>