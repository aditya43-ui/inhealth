<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/accounting2.js', CClientScript::POS_END); ?>
<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/form2.js', CClientScript::POS_END); ?>
<style>
    #css {
        /* font-family: Times New Roman; */
        font-family: "Open Sans", "Helvetica Neue", Helvetica, "Noto Sans", sans-serif, Arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        text-align: center;
    }
    
    #css td, #css th {
        text-align: center;
        border: 1px solid black;
        padding: 8px;
    }
    #css th {
        text-align: center;
        padding-top: 12px;
        padding-bottom: 12px;
    }
    #css2 {
        /* font-family: Times New Roman; */
        font-family: "Open Sans", "Helvetica Neue", Helvetica, "Noto Sans", sans-serif, Arial, sans-serif;
        border-collapse: collapse;
        width: 100%;
        text-align: center;
    }
    
    #css2 td, #css2 th {
        text-align: center;
        padding: 8px;
    }
    #css2 th {
        text-align: center;
        padding-top: 12px;
        padding-bottom: 12px;
    }
</style>
<div class="panel panel-success" style="padding-bottom: 15px;">    
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-credit-card"></i>Form Asesmen Awal dan Persetujuan/Penolakan Dosis Radiologi
        </div>
    </div>
    <div class="panel panel-gradient" style="margin: 15px;">
        <div class="panel-body">
            <?php
                $this->widget('bootstrap.widgets.BootAlert');
                
                $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
                    'id' => 'asesmenedukasi-form',
                    'enableAjaxValidation' => false,
                    'type' => 'horizontal',
                    'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)','onsubmit'=>'return requiredCheck(this);'),
                ));

                echo $form->hiddenField($modRadiologi, 'pendaftaran_id', array('class'=>'pendaftaran_id'));
                echo $form->hiddenField($modRadiologi, 'pasien_id', array('class'=>'pasien_id'));
                echo $form->hiddenField($modRadiologi, 'pasienadmisi_id', array('class'=>'pasienadmisi_id'));
                echo $form->hiddenField($modRadiologi, 'penanggungjawab_id', array('class'=>'penanggungjawab_id'));
            ?>

            <div class="row-fluid">
                <h5> <b>Data Pasien</b> </h5>
                <div class="col-sm-6">
                    <!-- <?php //echo CHtml::activeLabel($modPendaftaran, 'no_pendaftaran',array('class'=>'control-label')); ?> -->
                    <div class="control-group">
                        <?php echo CHtml::label('No. RM', 'no_rekam_medik', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPasien, 'no_rekam_medik', array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Nama Pasien', 'nama_pasien', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPasien, 'nama_pasien', array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Jenis Kelamin', 'jeniskelamin', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPasien, 'jeniskelamin', array('readonly'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Tanggal Lahir', 'tanggal_lahir', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modPasien, 'tanggal_lahir', array('readonly'=>true)); ?>
                        </div>
                    </div>
                </div>
                <div class="col-sm-6">
                    <div class="control-group">
                        <?php echo CHtml::activeLabel($modRadiologi, 'tanggal_asesmenawal',array('class'=>'control-label')); ?>
                        <div class="controls">
                            <?php
                            $this->widget('MyDateTimePicker', array(
                                'model' => $modRadiologi,
                                'attribute' => 'tanggal_asesmenawal',
                                'value' => null,
                                'mode' => 'datetime',
                                'options' => array(
                                    'dateFormat' => Params::DATE_FORMAT,
                                    'maxDate' => 'd',
                                ),
                                'htmlOptions' => array(
                                    'readonly' => true,
                                    'onkeypress' => "return $(this).focusNextInputField(event)",
                                    'class' => 'span3 htpd',
                                    // 'placeholder' => date('d M Y H:i:s'),
                                    'placeholder' => 'Pilih Tanggal Asesmen Awal',
                                ),
                            ));
                            ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <h5> <b>1. asdasdasdas Awal</b> </h5>
                <div class="col-sm-12">
                    <div class="control-group">
                        <?php echo CHtml::label('Keluhan', 'keluhan', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modRadiologi, 'keluhan', array('class'=>'span10','readonly'=>false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Riwayat Penyakit', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeTextField($modRadiologi, 'riwayatpenyakit', array('class'=>'span10','readonly'=>false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Riwayat Alergi', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php
                                $cri = new CDbCriteria();
                                $cri->addCondition(" lookup_type = 'riwayatalergirad' AND lookup_aktif = TRUE ");
                                $cri->order = " lookup_urutan ASC ";
                                $riwayatalergirad = LookupM::model()->findAll($cri);      

                                foreach($riwayatalergirad as $aa){
                                    echo $form->checkBox($modRadiologi, 'riwayatalergi[' . $aa['lookup_name'] . '][ceklis]').$aa['lookup_name'].'<span style="margin: 0 15px;"> </span>';
                                }
                            ?>
                            Lainnya : <?php echo CHtml::activeTextField($modRadiologi, 'riwayatalergi_lainnya', array('readonly'=>false)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Riwayat Kebiasaan', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeHiddenField($modRadiologi, 'statusmerokok', array('class'=>'statusmerokok')); ?>
                            <?php echo CHtml::activeHiddenField($modRadiologi, 'keb_konsumsialkohol', array('class'=>'keb_konsumsialkohol')); ?>
                            <?php
                                $cri = new CDbCriteria();
                                $cri->addCondition(" lookup_type = 'riwayatkebiasaanrad' AND lookup_aktif = TRUE ");
                                $cri->order = " lookup_urutan ASC ";
                                $riwayatkebiasaanrad = LookupM::model()->findAll($cri);      

                                foreach($riwayatkebiasaanrad as $aa){
                                    echo $form->checkBox($modRadiologi, 'riwayatkebiasaan[' . $aa['lookup_name'] . '][ceklis]').$aa['lookup_name'].'<span style="margin: 0 15px;"> </span>';
                                }
                            ?>
                            Lainnya : <?php echo CHtml::activeTextField($modRadiologi, 'riwayatkebiasaan_lainnya', array('readonly'=>false)); ?>
                        </div>
                    </div>
                    <!-- <div class="control-group">
                        <?php //echo CHtml::label('Penilaian Nyeri', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php //echo CHtml::activeRadioButtonList($modRadiologi, 'penilaian_nyeri', array('Ringan' => 'Ringan <span style="margin: 0 15px;"></span>', 'Sedang' => 'Sedang <span style="margin: 0 15px;"></span>', 'Berat' => 'Berat'), array('labelOptions' => array('style' => 'display:inline;'), 'separator' => ' ','class' => 'penilaian_nyeri', 'onclick' => '')); ?>
                        </div>
                    </div> -->
                    <!-- <div class="control-group">
                        <?php //echo CHtml::label('Keterangan Lain', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php //echo CHtml::activeTextField($modRadiologi, 'keterangan_lain', array('class'=>'span10','readonly'=>false)); ?>
                        </div>
                    </div> -->
                    <div class="control-group">
                        <?php echo CHtml::label('Pernah Difoto', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modRadiologi, 'is_pernahdifoto', array('Belum' => 'Belum <span style="margin: 0 15px;"></span>', 'Pernah' => 'Pernah'), array('labelOptions' => array('style' => 'display:inline;'), 'separator' => ' ','class' => 'is_pernahdifoto', 'onclick' => '')); ?>
                            <span style="margin: 0 13px;">Foto apa </span><?php echo CHtml::activeTextField($modRadiologi, 'foto_apa', array('class' => 'foto_apa','disabled'=>true)); ?>
                            <span style="margin: 0 13px;">Berapa kali </span><?php echo CHtml::activeTextField($modRadiologi, 'brp_kali', array('class' => 'brp_kali','disabled'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Ada Keluhan', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modRadiologi, 'is_adakeluhan', array('Tidak Ada' => 'Tidak Ada <span style="margin: 0 15px;"></span>', 'Ada' => 'Ada'), array('labelOptions' => array('style' => 'display:inline;'), 'separator' => ' ','class' => 'is_adakeluhan', 'onclick' => '')); ?>
                            <?php echo CHtml::activeTextField($modRadiologi, 'keluhan_apa', array('class' => 'keluhan_apa span8', 'style'=>'margin-left: 2px;','disabled'=>true)); ?>
                        </div>
                    </div>
                    <div class="control-group">
                        <?php echo CHtml::label('Hamil/Program', '', array('class' => 'control-label')) ?>
                        <div class="controls">
                            <?php echo CHtml::activeRadioButtonList($modRadiologi, 'is_programhamil', array('Tidak' => 'Tidak <span style="margin: 0 15px;"></span>', 'Ya' => 'Ya'), array('labelOptions' => array('style' => 'display:inline;'), 'separator' => ' ','class' => 'is_programhamil', 'onclick' => '')); ?>
                            <span style="margin: 0 20px;">Bulan ke berapa </span><?php echo CHtml::activeTextField($modRadiologi, 'bulan_ke_brp', array('class' => 'bulan_ke_brp','disabled'=>true)); ?>
                        </div>
                    </div>
                </div>
            </div>

            <div class="row-fluid">
                <h5> <b>2. Penyampaian Informasi, Edukasi Pemeriksaan dan Penerimaan Dosis Radiasi</b> </h5>
                <div class="col-sm-12">
                    a. Pemeriksaan radiologi diagnosis, diagnostik, imaging dan radiologi intercensional <br>
                    b. Penerimaan dosis radiologi pada saat pemeriksaan radiologi untuk keperluan medik, diperkenankan bedasarkan pertimbangan bahwa manfaat yang diperoleh jauh lebih besar daripada risiko bahaya radiasi yang ditimbulkan bagi pasien. <br>
                    c. Kemungkinan resiko yang dapat terjadi akibat paparan radiasi adalah efek carciogenik bila diberikan paparan radiasi yang berulang-ulang dengan dosis yang cukup bersar. <br>
                    d. Paparan medik yang diterima oleh pasien sebagai bagian dari diagnosis atau pengobatan medik bertujuan mengetahui penyakit atau keluhan lain yang dirasa dan dikeluhkan pasien dengan persetujuan DPJP <br>
                </div>
            </div>

            <div class="row-fluid">
                <h5> <b>3. Nama dan Paraf</b> </h5>
                <div class="col-sm-12">
                    <table id="css">
                        <tr>
                            <th>Pasien</th>
                            <th>Keluarga</th>
                            <th>Petugas</th>
                        </tr>
                        <tr>
                            <th><?php echo $modPasien->nama_pasien ?></th>
                            <th><?php echo CHtml::activeTextField($modRadiologi, 'keluarga_yg_menyatakan', array('class' => 'keluarga_yg_menyatakan','readonly'=>false)); ?></th>
                            <th>
                                <div class="control-group ">
                                    <div class="controls">
                                    <?php
                                        echo $form->hiddenField($modRadiologi, 'pegawai_id', array('class'=>'pegawai_id'));
                                        $this->widget('MyJuiAutoComplete', array(
                                            'model' => $modRadiologi,
                                            'attribute' => 'pegawai_nama',
                                            'source' => 'js: function(request, response) {
                                                $.ajax({
                                                    url: "' . $this->createUrl('autocompleteEdukator') . '",
                                                    dataType: "json",
                                                    data: {
                                                        term: request.term,
                                                    },
                                                    success: function (data) {
                                                        response(data);
                                                    }
                                                })
                                            }',
                                            'options' => array(
                                                'showAnim' => 'fold',
                                                'maxLength' => 3,
                                                'focus' => 'js:function( event, ui ) {
                                                    $(this).val("");
                                                    return false;
                                                }',
                                                'select' => 'js:function( event, ui ) {
                                                    $("#' . Chtml::activeId($modRadiologi, 'pegawai_id') . '").val(ui.item.pegawai_id);
                                                    $(this).val(ui.item.label);
                                                    return false;
                                                }',
                                                // $(".pegawai_id").val(ui.item.value);
                                            ),
                                            'htmlOptions' => array('class' => 'custom-only span3 pegawai_nama', 'placeholder' => 'Pilih Pegawai',
                                                'onkeyup' => "return $(this).focusNextInputField(event)",
                                                'onblur' => 'if(this.value === "") $("#' . Chtml::activeId($modRadiologi, 'pegawai_id') . '").val(""); ',
                                            ),
                                            'tombolDialog' => array('idDialog' => 'dialogEdukator'),
                                        ));
                                    ?>	
                                    </div>
                                </div>
                            </th>
                        </tr>
                    </table>
                </div>
            </div>

            <br><div class="col-sm-12" style="border: 1px solid black;"></div><br>

            <div class="row-fluid">
                <h5> <b> <center> PERSETUJUAN </center> </b> </h5>
                <div class="col-sm-12">
                    Saya mengetahui bahwa saya memiliki kondisi yang membutuhkan perawatan medis, saya mengizinkan dokter dan professional kesehatan lainnya untuk melakukan prosedur diagnosis,
                    yang diperlukan dalam penilaian proffesional mereka, meliputi : <br>
                    1. Pemeriksaan Radiognostik, meliputi <?php echo CHtml::activeTextField($modRadiologi, 'pemeriksaan_radiagnostik', array('style'=>'margin: 5px 0;','readonly'=>false)); ?><br>
                    2. Pemeriksaan Radiologi imaging, meliputi <?php echo CHtml::activeTextField($modRadiologi, 'pemeriksaan_radiologiimaging', array('style'=>'margin: 5px 0;','readonly'=>false)); ?><br>
                    3. Pemeriksaan Radiologi intervensional, meliputi <?php echo CHtml::activeTextField($modRadiologi, 'pemeriksaan_radiologiintervensional', array('style'=>'margin: 5px 0;','readonly'=>false)); ?><br>
                    Saya sadar bahwa praktik kedokteran khususnya bidang diagnostik, imaging dan radiologi intervensional menggunakan sumber radiasi yang dipergunakan untuk membantu
                    menegakkan diagnasa keluhan/penyakit yang saya alama saat ini. Penerimaan paparan radiasi kepada diri saya dalam nilai btas dosis (NBD) yang aman dan direkomendasikan
                    dibidang kesehatan serta diatus dalam peraturan nasional maupun internasional. <br>
                    Dengan tanda tangan saya dibawah ini, <br>
                    saya menyatakan <?php echo CHtml::activeRadioButtonList($modRadiologi, 'status_persetujuan', array('SETUJU' => 'SETUJU', 'TIDAK SETUJU' => 'TIDAK SETUJU'), array('labelOptions' => array('style' => 'display:inline;'), 'separator' => ' ','class' => 'status_persetujuan', 'onclick' => '')); ?> dilakukan pemeriksaan tersebut, dan saya telah membaca, memahami dan menyetujui seluruh kriteria-kriteria yang terdapat pada tindakan radiologi ini.
                </div>
                <br>
                <div class="col-sm-12">
                    <table id="css2">
                        <tr>
                            <th></th>
                            <th></th>
                            <th>Surabaya, 
                                <?php
                                    function tgl_indo($tanggal){
                                        $bulan = array (
                                            1 =>   'Januari',
                                            'Februari',
                                            'Maret',
                                            'April',
                                            'Mei',
                                            'Juni',
                                            'Juli',
                                            'Agustus',
                                            'September',
                                            'Oktober',
                                            'November',
                                            'Desember'
                                        );
                                        $pecahkan = explode('-', $tanggal);
                                        
                                        // variabel pecahkan 0 = tanggal
                                        // variabel pecahkan 1 = bulan
                                        // variabel pecahkan 2 = tahun
                                     
                                        return $pecahkan[2] . ' ' . $bulan[ (int)$pecahkan[1] ] . ' ' . $pecahkan[0];
                                    }
                                     
                                    echo tgl_indo(date('Y-m-d'));
                                ?>
                            </th>
                        </tr>
                        <tr>
                            <th>Yang Menyatakan</th>
                            <th>Saksi 1</th>
                            <th>Saksi 2</th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th></th>
                            <th></th>
                            <th></th>
                        </tr>
                        <tr>
                            <th><?php echo CHtml::activeTextField($modRadiologi, 'yang_menyatakan', array('class' => 'yang_menyatakan','readonly'=>false)); ?></th>
                            <th><?php echo CHtml::activeTextField($modRadiologi, 'saksi1', array('readonly'=>false)); ?></th>
                            <th><?php echo CHtml::activeTextField($modRadiologi, 'saksi2', array('readonly'=>false)); ?></th>
                        </tr>
                    </table>
                </div>
            </div>
            

            <div class="form-actions">
                <?php
                    if(isset($_GET['sukses'])){
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')), array('class'=>'btn btn-primary submit', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','disabled'=>true));
                        // echo "&nbsp;";
                        // echo CHtml::link(Yii::t('mds', '{icon} Cetak', array('{icon}'=>'<i class="entypo-print"></i>')), 'javascript:void(0);', array('rel'=>'tooltip','title'=>'Tombol akan aktif setelah data tersimpan','class'=>'btn btn-info','onclick'=>"return false;",'disabled'=>true, 'style'=>'cursor:not-allowed;'));
                    }else{
                        echo CHtml::htmlButton(Yii::t('mds','{icon} Save',array('{icon}'=>'<i class="entypo-check"></i>')), array('class'=>'btn btn-primary', 'type'=>'submit', 'onKeypress'=>'return formSubmit(this,event)','id'=>'btn_simpan','onclick'=>"",'disabled'=>false));
                        // echo "&nbsp;";
                        // echo CHtml::link(Yii::t('mds','{icon} Cetak',array('{icon}'=>'<i class="entypo-print"></i>')),'#', array('class'=>'btn btn-succes','onclick'=>print('PRINT')'));
                    }
                ?>
                <?php
                    if (isset($_GET['sukses'])) {
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print()", 'disabled' => false));
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'disabled' => true));
                    }
                ?>
                <?php 
                    $content = $this->renderPartial('rawatJalan.views.tips.tips',array(),true);
                    $this->widget('UserTips',array('type'=>'admin','content'=>$content));
                ?>
            </div>
            
            <?php
                $this->endWidget(); 
                
                // echo $this->renderPartial($this->path_view.'_dialog', array('model'=>$model,), true);
                
                // echo $this->renderPartial($this->path_view.'_jsFunction', array('model'=>$model,'modAsesmenNyeri' => $modAsesmenNyeri,'modResikoJatuh' => $modResikoJatuh), true);
            
            ?>
        </div>
    </div>
</div>
<script>
    $(document).ready(function() {
        var statusmerokok = $(".statusmerokok").val();
        var keb_konsumsialkohol = $(".keb_konsumsialkohol").val();
        if(statusmerokok == true){
            $("#AsesmenawalradiologiT_riwayatkebiasaan_Merokok_ceklis").prop("checked", true);
        } else {
            $("#AsesmenawalradiologiT_riwayatkebiasaan_Merokok_ceklis").prop("checked", false);
        }
        // if(keb_konsumsialkohol != 'Ya'){
        if(keb_konsumsialkohol == true){
            $("#AsesmenawalradiologiT_riwayatkebiasaan_Alkohol_ceklis").prop("checked", true);
        } else {
            $("#AsesmenawalradiologiT_riwayatkebiasaan_Alkohol_ceklis").prop("checked", false);
        }
    });

    $(".keluarga_yg_menyatakan").keyup(function () {
      var value = $(this).val();
      $(".yang_menyatakan").val(value);
    }).keyup();
    $(".yang_menyatakan").keyup(function () {
      var value = $(this).val();
      $(".keluarga_yg_menyatakan").val(value);
    }).keyup();

    function print(){
        window.open('<?php echo $this->createUrl('print',array('pendaftaran_id'=>$modPendaftaran->pendaftaran_id)); ?>','printwin','left=100,top=100,width=640,height=480');
    }
    $(".is_pernahdifoto").change(function(){
        if ($(this).val() === 'Pernah') {
            console.log('false');
            $(".foto_apa").prop("disabled", false);
            $(".brp_kali").prop("disabled", false);
        } else if ($(this).val() === 'Belum') {
            console.log('true 1');
            $(".foto_apa").prop("disabled", true);
            $(".brp_kali").prop("disabled", true);
        }
    });
    $(".is_adakeluhan").change(function(){
        if ($(this).val() === 'Ada') {
            console.log('false');
            $(".keluhan_apa").prop("disabled", false);
        } else if ($(this).val() === 'Tidak Ada') {
            console.log('true 1');
            $(".keluhan_apa").prop("disabled", true);
        }
    });
    $(".is_programhamil").change(function(){
        if ($(this).val() === 'Ya') {
            console.log('false');
            $(".bulan_ke_brp").prop("disabled", false);
        } else if ($(this).val() === 'Tidak') {
            console.log('true 1');
            $(".bulan_ke_brp").prop("disabled", true);
        }
    });
</script>
<?php
$this->beginWidget('zii.widgets.jui.CJuiDialog',
    array(
        'id' => 'dialogEdukator',
        'options' => array(
            'title' => 'Nama Pemeriksa',
            'autoOpen' => false,
            'modal' => true,
            'width' => 860,
            'height' => 380,
            'resizable' => false,
        ),
    )
);
// echo CHtml::hiddenField('dokter_untuk',"",array('readonly'=>true));
$modPegawai = new PegawairuanganV();
$modPegawai->unsetAttributes();

$modPegawai->pegawai_aktif = true;
// $modPegawai->ruangan_id = Yii::app()->user->getState('ruangan_id');

if (isset($_GET['PegawairuanganV'])) {
    $modPegawai->attributes = $_GET['PegawairuanganV'];
}

$prov = $modPegawai->search();
$prov->sort->defaultOrder = 'nama_pegawai';

$this->widget('ext.bootstrap.widgets.BootGridView',
    array(
        'id' => 'edukator-grid',
        'dataProvider' => $prov,
        'filter' => $modPegawai,
        'template' => "{summary}\n{items}\n{pager}",
        'itemsCssClass' => 'table table-striped table-bordered table-condensed',
        'columns' => array(
            array(
                'header' => 'Pilih',
                'type' => 'raw',
                'value' => 'CHtml::Link("<i class=\"icon-form-check\"></i>","#",array("class"=>"btn-small",'
                . '"onClick" => "
                    $(\'.pegawai_id\').val(\'".$data->pegawai_id."\');
                    $(\'.pegawai_nama\').val(\'".$data->namaLengkap."\');
                    $(\'#dialogEdukator\').dialog(\'close\');
                    return false;"))',
            ),
            //'gelardepan',
            array(
                'name' => 'nama_pegawai',
                'value' => '$data->namaLengkap',
            ),
            array(
                'name' => 'jabatan_id',
                'type' => 'raw',
                'value' => function($data) {
                    if (empty($data->jabatan_id))
                        return "-";
                    $j = JabatanM::model()->findByPk($data->jabatan_id);

                    return $j->jabatan_nama;
                },
                'filter' => CHtml::activeDropDownList($modPegawai, 'jabatan_id',
                    CHtml::listData(JabatanM::model()->findAll('jabatan_aktif = true order by jabatan_nama'), 'jabatan_id', 'jabatan_nama'),
                    array('empty' => '-- Pilih --')),
            ),
            //'gelarbelakang_nama',
            'jeniskelamin',
        // 'agama',
        ),
        'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
    )
);

$this->endWidget('zii.widgets.jui.CJuiDialog');
?>