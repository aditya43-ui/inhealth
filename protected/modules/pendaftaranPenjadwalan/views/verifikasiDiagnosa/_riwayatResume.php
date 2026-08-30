<?php 
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/ckeditor/ckeditor.js', CClientScript::POS_END);

$this->widget('ext.bootstrap.widgets.BootGridView', array(
    'id' => 'daftar-riwayat-grid',
    'dataProvider' => $modRiwayatResume->searchRiwayat(),
    'template' => "{summary}\n{items}\n{pager}",
    'itemsCssClass' => 'table table-striped table-bordered table-condensed',
    'columns' => array(
        [
            'header' => '<center>Tanggal Pemeriksaan</center>',
            'value' => '!empty($data->tglresume)?MyFormatter::formatDateTimeForUser($data->tglresume):""'
        ],
        [
            'header' => '<center>Dokter</center>',
            'value' => '!empty($data->pegawai)?$data->pegawai->namaLengkap:""'
        ],
        [
            'header' => '<center>Lihat Detail</center>',
            'value' => function ($data) {
                echo CHtml::link("<i class='icon-form-lihat'></i>", 'javascript:;', ['onclick' => 'setDetailResume(' . $data->resumemedis_id . ', ' . $data->pendaftaran_id . ')', 'rel' => 'tooltip', 'title' => 'detail resume medis pasien']);
            },
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
        ],
        [
            'header' => '<center>Cetak</center>',
            'value' => function ($data) {
                echo CHtml::link("<i class='fa fa-print'></i>", 'javascript:;', ['onclick' => 'cetak(' . $data->resumemedis_id . ')', 'rel' => 'tooltip', 'title' => 'Cetak resume medis pasien']);
            },
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
        ],
        [
            'header' => '<center>Rekam Medis</center>',
            'value' => function ($data) {
                if($data->is_verifikasirekammedis){
                    echo "<i class='icon-form-check'></i>";
                }else{
                    echo "";
                }
                
            },
            'htmlOptions' => [
                'style' => 'text-align:center;'
            ]
        ],
        [
            'header' => '<center>Ruangan</center>',
            'value' => function ($data) {
                echo $data->createruangan->ruangan_nama;
            },
        ]
    ),
    'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});}',
));

?>
<div class="col sm-12">
    <div class="panel panel-info">
        <div class="panel-heading">
            <div class="panel-title">
                <i class="entypo-list"></i><b>Detail Resume Medis</b>
            </div>
        </div>
        <div class="panel-body" id="body-resume">
            <?php $this->renderPartial($this->path_view . '_formDetailResume', [
                'modResume' => $modResume,
                'riwayatDiagnosaICDX' => $riwayatDiagnosaICDX,
                'riwayatDiagnosaICD9' => $riwayatDiagnosaICD9,
                'riwayatDiagnosaKematian' => $riwayatDiagnosaKematian,
                'riwayatObatAlkesPasien' => $riwayatObatAlkesPasien
            ]) ?>
        </div> <!-- ./panel-body -->
    </div>
</div>
<script>
    const cetak = (id) => {
        window.open("<?= $this->createUrl('/rekamMedis/ResumeMedis/printR') ?>&id=" + id, "cetak-resume-medis-pasien", "width=860,height=480");
    }

    const detail = (id) => {
        window.open("<?= $this->createUrl('/rekamMedis/ResumeMedis/detail') ?>&id=" + id, "cetak-resume-medis-pasien", "width=860,height=480");
    }

    // dokumen ready function 
    $(function(){
        $('#panel-resume').find('textarea').each(function(){
            var idTextArea = $(this).attr('id'); 

            CKEDITOR.replace(idTextArea, {
                extraPlugins: 'colorbutton,colordialog',
                toolbarGroups: [
                   
                ],
                readOnly: true
            });
        });
       
    });

    function setDetailResume(resumemedis_id, pendaftaran_id) {
        $('#body-resume').addClass('animation-loading');
        $.get('<?= $this->createUrl('setDetailResume') ?>', {
            resumemedis_id:resumemedis_id,
            pendaftaran_id:pendaftaran_id
        }, function(data, textStatus, jqXhr){
            console.log(textStatus, jqXhr);
            if(data.status == 1) {
                $('#body-resume').html(data.html);
                
                $('#panel-resume').find('textarea').each(function(){
                    var idTextArea = $(this).attr('id'); 

                    CKEDITOR.replace(idTextArea, {
                        extraPlugins: 'colorbutton,colordialog',
                        toolbarGroups: [
                        
                        ],
                        readOnly: true
                    });
                });
                $('#body-resume').removeClass('animation-loading');

            }
        }, 'json');
    }
</script>