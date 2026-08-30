<style>
    
    .tab_header {
        width: 100%;
    }
    
    .tab_header td {
        border: 1px solid black;
        line-height: 32px;
        padding-left: 5px;
        vertical-align: top;
    }
    
    .tab_header .head_cell {
        font-weight: bold;
    }
    
    .pilihan_ijin, .pilihan_privasi {
        font-weight: bold;
        cursor: pointer;
    }
    
    .tab_informasi {
        width: 100%;
    }
    
    .tab_informasi th, .tab_informasi td {
        border: 1px solid black;
        padding: 2px;
    }
    
    .tab_informasi th {
        text-align: center;
    }
    
</style>

<?php 

$informasi = array(
    array(
        "jenis"=>"Diagnosis Penyakit",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Dasar Diagnosa Penyakit",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Tindakan Medis yang akan dilakukan",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Indikasi dilakukan Tindakan Medis",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Uraian Singkat Prosedur dan Tahapan",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Tindakan Medis yang akan dilakukan",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Tipe dan Cara Pembiusan",
        "isi"=>"",
        "tipe"=>"radio",
        "item"=>array(
            "Lokal"=>"Lokal",
            "Inhalasi"=>"Inhalasi",
            "SAB"=>"SAB",
            "Lain-lain"=>"Lain-Lain",
        ),
    ),
    array(
        "jenis"=>"Tujuan Dilakukan Tindakan Medis",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Resiko dari Tindakan Medis",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Komplikasi dari Tindakan Medis",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Prognosis Vital, Fungsional dan Kesembuhan",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Pilihan Penatalaksana dan Resiko",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Kemungkinan Perluasan Tindakan Medis",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Kemungkinan Konsuktasi Tindakan Medis",
        "isi"=>"",
        "tipe"=>"text",
    ),
    array(
        "jenis"=>"Kemungkinan Dilakukan Resusisasi",
        "isi"=>"",
        "tipe"=>"text",
    ),
);

$this->widget('bootstrap.widgets.BootAlert');

$modPasien = PasienM::model()->findByPk($modPendaftaran->pasien_id);
$modAnamnesa = AnamnesaT::model()->findByAttributes(array(
    'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
), array(
    'order'=>'anamesa_id desc',
));

if (empty($modAnamnesa)) {
    $modAnamnesa = new AnamnesaT;
}

$modProfilRs = ProfilrumahsakitM::model()->findByPk(Params::getDefaultProfilRS()); 
$konfig = KonfigsystemK::model()->find();


$form=$this->beginWidget('ext.bootstrap.widgets.BootActiveForm',array(
	'id'=>'suratpersetujuanumum-t-form',
	'enableAjaxValidation'=>false,
	'type'=>'horizontal',
	'htmlOptions'=>array('onKeyPress'=>'return disableKeyPress(event);', 'onsubmit'=>'return requiredCheck(this);'),
	'focus'=>'#',
)); 

$jenis = $model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN ? "Persetujuan" : "Penolakan";

echo $this->renderPartial($this->path_view_keterangan.'_listSuratKeterangan', array(
     'pendaftaran_id'=>$modPendaftaran->pendaftaran_id,
     'jenissurat'=>$model->jenissurat,
), true); ?>

<h3 style="text-align: center;">INFORM CONSENT</h3>
<h4 style="text-align: center;">SURAT <?php echo strtoupper($jenis); ?></h4>

	<?php echo $form->errorSummary($model); ?>
    <?php echo $form->hiddenField($model,'pendaftaran_id',array('class'=>'span3 integer', 'onkeyup'=>"return $(this).focusNextInputField(event);")); ?>

    <table class="tab_header">
        <tr>
            <td rowspan="2" colspan="2" width="50%" align="center"><img src="<?php echo Params::urlProfilRSDirectory().$modProfilRs->logo_rumahsakit_2 ?> " style="height: 60px;"/></td>
            <td width="20%" class="head_cell">No. RM</td>
            <td><?php echo $modPasien->no_rekam_medik." / ".substr($modPasien->jeniskelamin, 0, 1); ?></td>
        </tr>
        <tr>
            <td class="head_cell">Nama</td>
            <td><?php echo $modPasien->namadepan.$modPasien->nama_pasien; ?></td>
        </tr>
        <tr>
            <td width="20%" class="head_cell">Riwayat Alergi</td>
            <td><?php echo $modAnamnesa->riwayatalergiobat; ?></td>
            <td class="head_cell">Tgl. Lahir</td>
            <td><?php echo MyFormatter::formatDateTimeForUser($modPasien->tanggal_lahir); ?></td>
        </tr>
        <tr>
            <td class="head_cell">Riwayat Penyakit Terdahulu</td>
            <td><?php echo $modAnamnesa->riwayatpenyakitterdahulu; ?></td>
            <td class="head_cell">Alamat</td>
            <td><?php echo $modPasien->alamat_pasien; ?></td>
        </tr>
    </table>

<table class="tab_informasi">
    <thead>
        <tr>
            <th>JENIS INFORMASI</th>
            <th>ISI INFORMASI</th>
            <th>PARAF / TANDA</th>
        </tr>
    </thead>
    <tbody>
        <?php 
        if ($inform->isNewRecord) :
        foreach ($informasi as $item) : ?>
        <tr>
            <td><?php echo $item['jenis']; ?></td>
            <td>
                <?php
                if ($item['tipe'] == "text") {
                    echo $form->textField($inform, 'informasi_tindakan_medis['.$item['jenis'].'][text]', array(
                        'class'=>'col-sm-6',
                    ));
                } else if ($item['tipe'] == "radio") {
                    echo $form->radioButtonList($inform, 'informasi_tindakan_medis['.$item['jenis'].'][text]', $item['item'], array(
                        'template'=>'<div class="radio-inline">{input}{label}</div>'
                    ));
                }
                
                
                ?>
            </td>
            <td style="text-align: center;">
                <?php echo $form->checkBox($inform, 'informasi_tindakan_medis['.$item['jenis'].'][ceklis]'); ?>
            </td>
        </tr>
        
        
        <?php endforeach;
        
        else : 
            foreach ($inform->informasi_tindakan_medis as $jenis => $item): ?>
        <tr>
            <td><?php echo $jenis; ?></td>
            <td><?php echo $item['text']; ?></td>
            <td style="text-align: center;">
                <?php echo '<span class="fa fa'.($item['ceklis'] == 1 ? '-check' : '').'-square-o"></span>'?>
            </td>
        </tr>
        <?php
            endforeach;
        endif; ?>
        <tr>
            <td colspan="3">&nbsp;</td>
        </tr>
        <tr>
            <td colspan="2">
                Dengan ini menyatakan bahwa saya sebagai Dokter telah menjelaskan semua hal tersebut diatas
                secara benar dan jelas serta memberikan kesempatan untuk bertanya dan atau berdiskusi.
            </td>
            <td style="text-align: center;">
                <br>
                <br>
                <?php echo !$inform->isNewRecord ? $inform->nama_menyetujui1 : $form->textField($inform, 'nama_menyetujui1', array('class'=>'span3')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Dengan ini menyatakan bahwa saya telah menerima semua informasi dari Dokter sebagaimana diatas
                kemudian saya beri tanda (V) atau paraf dan telah memahami semua penjelasan Dokter.
            </td>
            <td style="text-align: center;">
                <br>
                <br>
                <?php echo !$inform->isNewRecord ? $inform->nama_menyetujui2 : $form->textField($inform, 'nama_menyetujui2', array('class'=>'span3')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Dengan ini saya memahami manfaat dari Tindakan Medis sebagaimana yang telah dijelaskan kepada
                saya, termasuk Resiko dan Komplikasi yang mungkin timbul.
            </td>
            <td style="text-align: center;">
                <br>
                <br>
                <?php echo !$inform->isNewRecord ? $inform->nama_menyetujui3 : $form->textField($inform, 'nama_menyetujui3', array('class'=>'span3')); ?>
            </td>
        </tr>
        <tr>
            <td colspan="2">
                Dengan ini saya memahami bahwa Dokter melakukan suatu upaya maksimal maka keberhasilan Tindakan
                Medis bukanlah keniscayaan melainkan sangat tergantung pada izin Allah SWT
            </td>
            <td style="text-align: center;">
                <br>
                <br>
                <?php echo !$inform->isNewRecord ? $inform->nama_menyetujui4 : $form->textField($inform, 'nama_menyetujui4', array('class'=>'span3')); ?>
            </td>
        </tr>
    </tbody>
</table>
<div style="text-align: center; padding: 20px">
    Dengan ini saya menyatakan <b>
        <?php echo $model->jenissurat == Params::SURAT_PERSETUJUAN_PERSETUJUAN ? "SETUJU" : "TIDAK SETUJU"; ?>
    </b> dengan Tindakan Medis yang dilaksanakan tersebut.
</div>
<table>
    
</table>
<table class="tab_informasi">
    <tr>
        <td width="33%" align="center">
            Dokter/Operator
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            (
            <?php 
            // $peg = PegawaiM::model()->findByPk($model->dokter_id);
            
            // echo $form->hiddenField($model, 'dokter_id');
            // echo $peg->namaLengkap;
            
            ?>
             <?php 
                $cr = new CDbCriteria();
                $cr->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
                $listDokter = DokterV::model()->findAll($cr);

                if (!$model->isNewRecord && !empty($model->dokter_id)) {
                    $dok = PegawaiM::model()->findByPk($model->dokter_id);
                    echo $form->hiddenField($model, 'dokter_id');
                    echo $dok->namaLengkap;
                } else {
                    echo CHtml::activeDropDownlist($model, 'dokter_id', CHtml::listData($listDokter, 'pegawai_id','namaLengkap'), array('empty'=>'-- Pilih --', 'onkeypress'=>"return $(this).focusNextInputField(event)"));
                }
            ?>
            )
        </td>
        <td align="center">
            Yang Membuat Pernyataan<b style="color: red;">*</b>
            <br>
            <br>
            <br>
            <br>
            <br>
            <br>
            <?php echo !$model->isNewRecord ? "(".$model->nama_yangmenyetujui.")" : $form->textField($model, 'nama_yangmenyetujui', array('class'=>'span3 required', 'onkeypress'=>"return $(this).focusNextInputField(event);", 'maxlength'=>50)); ?>
           
        </td>
        <td width="33%" align="center">
            Perawat/Bidan
            <br>Pemberi Penjelasan
            <br>
            <br>
            <br>
            <br>
            <br>
            <?php 
            $cr = new CDbCriteria();
            $cr->addInCondition('kelompokpegawai_id', array(Params::KELOMPOKPEGAWAI_ID_BIDAN, Params::KELOMPOKPEGAWAI_ID_TENAGA_KEPERAWATAN, Params::KELOMPOKPEGAWAI_ID_TENAGA_NONKEPERAWATAN));
            $cr->compare('ruangan_id', Yii::app()->user->getState('ruangan_id'));
            $listPegawai = PegawairuanganV::model()->findAll($cr);
            
            if (!$model->isNewRecord && !empty($model->pegawaisaksi1_id)) {
                $peg = PegawaiM::model()->findByPk($model->pegawaisaksi1_id);
                echo "(".$peg->nama_pegawai.")";
            } else {
                echo CHtml::activeDropDownList($model,'pegawaisaksi1_id', CHtml::listData($listPegawai, 'pegawai_id', 'nama_pegawai'), array('empty'=>'-- Pilih --','onkeypress'=>"return $(this).focusNextInputField(event)"));
            }
            
            ?>
            
            
        </td>
    </tr>
</table>

<div class="form-actions">
    <?php
    
        $is_persetujuan = $model->jenissurat = Params::SURAT_PERSETUJUAN_PERSETUJUAN;
    
        if(!$model->isNewRecord){
            echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
            array('{icon}'=>'<i class="entypo-check"></i>')),array('class' => 'btn btn-danger', 'type'=>'submit', 
                    'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>true)); 
            echo "&nbsp";
            echo CHtml::link(Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')), 
                    $this->createUrl($is_persetujuan ? 'index'  : 'penolakan', array(
                        'pendaftaran_id'=>$model->pendaftaran_id,
                       // 'frame'=>$frame,
                    )),
                    array('class' => 'btn btn-default', 'disabled' => false, 'type' => 'button'));
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>false,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
        }else{
            echo CHtml::htmlButton(Yii::t('mds','{icon} Create',
            array('{icon}'=>'<i class="entypo-check"></i>')),array('class'=>(!$model->isNewRecord)? 'btn btn-primary' : 'btn btn-primary submit','disabled'=>(!$model->isNewRecord)? true : false, 'type'=>'submit', 
                    'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan')); 
            echo "&nbsp";
            echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class'=>'btn btn-info', 'disabled'=>true,'type'=>'button','onclick'=>'print(\'PRINT\')'));                 
        }
    ?>
</div>
    

<?php $this->endWidget(); ?>

<script>

function print(caraPrint)
{
    var suratpersetujuantm_id = '<?php echo !empty($model->suratpersetujuantm_id) ? $model->suratpersetujuantm_id : null; ?>';
    var pendaftaran_id = '<?php echo !empty($model->pendaftaran_id) ? $model->pendaftaran_id : null; ?>';
    window.open('<?php echo $this->createUrl('print'); ?>&suratpersetujuantm_id='+suratpersetujuantm_id+'&pendaftaran_id='+pendaftaran_id+'&caraprint='+caraPrint,'printwin','left=100,top=100,width=1000,height=640');
}

</script>