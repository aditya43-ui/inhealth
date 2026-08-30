<?php
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'suratpernyataan-umum',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array('class' => 'form_pendaftaran', 'onKeyPress' => 'return disableKeyPress(event);'), //dimatikan karena pakai verifikasi >> ,'onsubmit'=>'return requiredCheck(this);'
    'focus' => '#' . CHtml::activeId($modSurat, 'saksi_pihakkeluarga'),
        ));
?>

<style>
    body {
        color: black; 
    }
</style>

<?php
$modCaraBayar = CarabayarM::model()->findByPk($modPendaftaran->carabayar_id);
$modPenjamin = PenjaminpasienM::model()->findByPk($modPendaftaran->penjamin_id);
?>

<table width='100%'>
    <tr>
        <td>
            <?= $this->renderPartial('application.views.headerReport._headerPernyataanRI', ['judulLaporan' => $judulLaporan, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran]) ?>
        </td>
    </tr>
</table>

<table class="tabelSurat" width="100%" style="border: 2px black solid">
    <tr>
        <td> 
            <table width='100%'>

                <tr>
                    <td>
                        <table width="100%">
                         
                            <tr>
                                <td>
                                    <?php  $this->renderPartial($this->path_viewRD2 . '/suratPersetujuan/_0_defaultSurat_1', ['form' => $form, 'modSurat'=>$modSurat,'judulLaporan' => $judulLaporan, 'modPenanggungJawab' => $modPenanggungJawab, 'modPasien' => $modPasien, 'modPendaftaran' => $modPendaftaran]) ?>
                                </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td colspan="2" style="text-align: justify"> 
                                <p style="margin-left: 12px;" >
                                Saya telah diberi penjelasan dan memahami setiap pernyataan yang terdapat pada formulir ini. <br>
Oleh sebab itu saya bersedia mendatangani lembar persetujuan ini tanpa paksaan dan secara <br>
bertanggung jawab. <br>
                
                                </p>
                                </td>
                                </tr>
                            <tr>
                            <tr>
                                <td colspan="3"> <br> </td>
                            </tr>
                            <tr>
                                <td> </td>
                                <td colspan='2'> 
                                        <tr>
                                            
                                            <td colspan="2"> 
                                                Surabaya  <br>
                                                <?php
                                                $modSurat->create_time = date('d/m/Y H:i:s');
                                                $this->widget('MyDateTimePicker', array(
                                                    'model' => $modSurat,
                                                    'attribute' => 'create_time',
                                                    'mode' => 'datetime',
                                                    'options' => array(
                                                        'showOn' => false,
                                                        'maxDate' => 'd',
                                                    ),
                                                    'htmlOptions' => array('class' => 'dtPicker3 datetimemask required', 'onkeyup' => "return $(this).focusNextInputField(event)",),
                                                ));
                                                ?>

                                            </td>
                                        </tr>
                                        <tr>
                                          
                                            <td width='90%' colspan="2">
                                                <table width='100%'>
                                                    <tr>
                                                        <td> Mengetahui </td>
                                                    </tr>
                                                    <tr>
                                                    <td> Pasien / Keluarga / Penanggung Jawab, </td>
                                                  
                                                    <td> Petugas Pemberi Informasi, </td>
                                                    </tr>
                                                    <tr>
                                                        <td colspan="3">
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                            <br>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                    <td> <?php echo $form->textField($modSurat, 'penanggungjawab_pasien', array('placeholder' => 'Saksi pihak keluarga', 'class' => 'span3 angkahuruf-only required form-control')); ?> </td>
                                                        <td> 
                                                            <?php echo $form->dropDownList($modSurat, 'nama_pj', PegawairuanganV::getDropPegawai(Yii::app()->user->getState('ruangan_id')), array('class' => 'span4 required', 'empty' => '-- Pilih --', 'onkeyup' => "return $(this).focusNextInputField(event)"));
                                                            ?></td>
                                                       
                                                    </tr>

                                                </table>
                                            </td>
                                        </tr>
                                    </table>
                                </td>
                            </tr>
                            </tr>
                        </table>
                    </td>
                </tr>
            </table>
        </td>
    </tr>
    <tr>

    </tr>
</table>
<?php
echo CHtml::htmlButton($modSurat->isNewRecord ? Yii::t('mds', '{icon} Create', array('{icon}' => '<i class="entypo-check"></i>')) :
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array(
    'title' => 'Simpan', 'class' => 'btn btn-success', 'type' => 'submit', 'onKeypress' => 'return formSubmit(this,event)'
));
?>
<?php
echo CHtml::link(
        Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="fa fa-reset"></i>')), $this->createUrl($this->id . '/suratPernyataanUmum&pendaftaran_id=' . $modPendaftaran->pendaftaran_id), array(
    'class' => 'btn btn-danger',
    'onclick' => 'return refreshForm(this);',
    'title' => 'Ulang'
        )
);

if (empty($modSurat)) {
    echo CHtml::htmlButton(
            Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), array('title' => 'Print', 'class' => 'btn btn-info', 'type' => 'button', 'title' => 'Simpan', 'onclick' => 'return false', 'onkeypress' => 'return false', 'disabled' => true, 'style' => 'cursor:not-allowed;')
    );
} else {
    echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "suratPernyataanUmum(" . $modSurat->formpersetujuanumumri_id . ");return false"));
}
?>
<?php $this->endWidget(); ?>


<script>
    function suratPernyataanUmum(id)
    {
        window.open('<?php echo $this->createUrl('printSuratPernyataanUmum&id='); ?>' + id, 'printwin', 'left=100,top=100,width=480,height=640');
    }
</script>