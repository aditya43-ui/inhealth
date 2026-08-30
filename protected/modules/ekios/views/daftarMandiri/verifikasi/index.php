
<div class="col-sm-2">
</div>
<div class="col-sm-8">
    <div class="panel panel-success">
        <div class="panel-heading">
            <div class="panel-title">Data Pasien</div>
        </div>
        <div class="panel-body">
            <table class="table table-verifikasi" width="100%">
                <tr>
                    <td width="20%">Tgl Pendaftaran</td>
                    <td width="2%">:</td>
                    <td><?= MyFormatter::formatDateTimeForUser($model->tgl_pendaftaran) ?></td>
                    <?php if (!empty($model->no_pendaftaran)){ ?>
                    <td width="5%"></td>
                    <td width="20%">No Pendaftaran</td>
                    <td width="2%">:</td>
                    <td><?= $model->no_pendaftaran ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>No Rekam Medis</td>
                    <td>:</td>
                    <td><?= $model->no_rekam_medik ?></td>
                    <?php if (!empty($model->no_pendaftaran)){ ?>
                    <td></td>
                    <td>No Antrian Poli</td>
                    <td width="2%">:</td>
                    <td><?= $model->nourutpoli ?></td>
                    <?php } ?>
                </tr>
                <tr>
                    <td>Nama Pasien</td>
                    <td>:</td>
                    <td><?= $model->nama_pasien ?></td>
                </tr>
                <tr>
                    <td>Tgl Lahir</td>
                    <td>:</td>
                    <td><?= MyFormatter::formatDateTimeForUser($model->tanggal_lahir) ?></td>
                </tr>
                <tr>
                    <td>Jenis Kelamin</td>
                    <td>:</td>
                    <td><?= $model->jeniskelamin ?></td>
                </tr>
                <tr>
                    <td>Poli Tujuan</td>
                    <td>:</td>
                    <td><?= $model->politujuan ?></td>
                </tr>
                <tr>
                    <td>Dokter</td>
                    <td>:</td>
                    <td><?= $model->dpjp ?></td>
                </tr>
            </table>
        </div>
    </div>
    
     <div class="form-actions">
        <div class="col-sm-12">
            <?php 
                if (empty($model->no_pendaftaran)){
                    echo CHtml::button("< Kembali",['onclick'=>"bukaTabJadwal();", 'class'=>'btn btn-white']).'&nbsp;';
                    echo CHtml::htmlButton("<i class='entypo-check'></i> Simpan",['onclick'=>"simpanDaftar(this);", 'class'=>'btn btn-success']).'&nbsp;';
                    echo CHtml::button("Struk Kunjungan",['disabled'=>true, 'class'=>'btn btn-blue']).'&nbsp;';
                }else{
                    echo CHtml::button("< Kembali",['disabled'=>true, 'class'=>'btn btn-primary']).'&nbsp;';
                    echo CHtml::htmlButton("<i class='entypo-check'></i> Simpan",['disabled'=>true,  'class'=>'btn btn-primary']).'&nbsp;';
                    echo CHtml::button("Struk Kunjungan",['onclick'=>'printStruk('.$model->pendaftaran_id.');', 'class'=>'btn btn-blue']).'&nbsp;';
                }
            ?>
        </div>      
    </div>
</div>
<div class="col-sm-2">
</div>
</div>
<div class="clear"></div>
