
 <?php
        $mod = new PengkajianresikojatuhT;
        $mod->pendaftaran_id = $model->pendaftaran_id;
        $mod->tgl_awal_kaji = $mod->tgl_awal_daftar = date('Y-m-d');
        $mod->tgl_akhir_kaji = $mod->tgl_akhir_daftar = date('Y-m-d');

        if (isset($_GET['PengkajianresikojatuhT'])) {
            $mod->attributes = $_GET['PengkajianresikojatuhT'];

            $mod->tgl_awal_kaji = MyFormatter::formatDateTimeForDb($_GET['PengkajianresikojatuhT']['tgl_awal_kaji']);
            $mod->tgl_akhir_kaji = MyFormatter::formatDateTimeForDb($_GET['PengkajianresikojatuhT']['tgl_akhir_kaji']);
            
            if (isset($_GET['PengkajianresikojatuhT']['is_ceklis']) && $_GET['PengkajianresikojatuhT']['is_ceklis'] == 1) {
                $mod->is_ceklis = $_GET['PengkajianresikojatuhT']['is_ceklis'];
                $mod->tgl_awal_daftar = MyFormatter::formatDateTimeForDb($_GET['PengkajianresikojatuhT']['tgl_awal_daftar']);
                $mod->tgl_akhir_daftar = MyFormatter::formatDateTimeForDb($_GET['PengkajianresikojatuhT']['tgl_akhir_daftar']);
            }
        }
        ?>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">Riwayat Pengkajian Resiko Jatuh</div>
    </div>
    <div class="panel-body">
   


        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title"><i class="entypo-search"></i> Pencarian</div>
            </div>
            <div class="panel-body">
                <form id="searchRiwayat" class="form-horizontal">
                <div class="row-fluid">
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label("Tanggal Pengkajian", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($mod->tgl_awal_kaji)) ?>" data-end-date="<?php echo date('d M Y', strtotime($mod->tgl_akhir_kaji)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span ><?php echo date('d M Y', strtotime($mod->tgl_awal_kaji)) ?> - <?php echo date('d M Y', strtotime($mod->tgl_akhir_kaji)) ?></span>
                                    <?php echo CHtml::activeHiddenField($mod, 'tgl_awal_kaji', array('class' => 'start')) ?>
                                    <?php echo CHtml::activeHiddenField($mod, 'tgl_akhir_kaji', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label(CHtml::activeCheckBox($mod, 'is_ceklis') . " Tanggal Pendaftaran", 'tgl_rekam', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <div class="daterange daterange-inline add-ranges input-inline span4" data-format="DD MMM YYYY" data-start-date="<?php echo date('d M Y', strtotime($mod->tgl_awal_daftar)) ?>" data-end-date="<?php echo date('d M Y', strtotime($mod->tgl_akhir_daftar)) ?>">
                                    <i class="entypo-calendar"></i>
                                    <span ><?php echo date('d M Y', strtotime($mod->tgl_awal_daftar)) ?> - <?php echo date('d M Y', strtotime($mod->tgl_akhir_daftar)) ?></span>
                                    <?php echo CHtml::activeHiddenField($mod, 'tgl_awal_daftar', array('class' => 'start')) ?>
                                    <?php echo CHtml::activeHiddenField($mod, 'tgl_akhir_daftar', array('class' => 'end')) ?>
                                </div>
                            </div>
                        </div>
                    </div>
                    <div class="col-sm-6">
                        <div class="control-group">
                            <?php echo CHtml::label('Instalasi', 'instalasi_id', array('class' => 'control-label')) ?>
                            <div class="controls">
                                <?php
                                $criIns = new CDbCriteria();
                                $criIns->addCondition(" instalasi_aktif = TRUE ");
                                $criIns->order = " instalasi_nama ASC ";
                                echo CHtml::activeDropDownList($mod, 'instalasi_id', CHtml::listData(InstalasiM::model()->findAll($criIns), 'instalasi_id', 'instalasi_nama'), array(
                                    'id'=>'search_instalasi_id', 'class' => 'span3', 'empty'=>'-- Pilih --', 'onchange'=>'setRuanganMulti();'));
                                ?>
                            </div>
                        </div>
                        <div class="control-group">
                            <?php echo CHtml::label('Ruangan', 'ruangan_id', array('class' => 'control-label')) ?>
                            <div class="controls">												 
                                <?php
                                echo CHtml::activeDropDownList($mod, 'ruangan_id',
                                    CHtml::listData(RuanganM::model()->findAll('ruangan_aktif = true order by instalasi_id, ruangan_nama'), 'ruangan_id', 'ruangan_nama'),
                                    array('id'=>'search_ruangan_id', 'class' => 'form-control', 'multiple' => 'multiple'));
                                ?>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="form-actions">
                    <?php echo CHtml::htmlButton(Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                        array('class' => 'btn btn-primary', 'type' => 'submit', 'id' => 'btn_cari'));
                    ?>
                    <?php echo CHtml::link(Yii::t('mds','{icon} Ulang',array('{icon}'=>'<i class="entypo-arrows-ccw"></i>')), 
                        Yii::app()->createUrl($this->module->id.'/'.Yii::app()->controller->id.'/'.Yii::app()->controller->action->id.''), 
                            array('class'=>'btn btn-danger',
                                'onclick'=>'myConfirm("Apakah anda ingin mengulang ini?","Perhatian!",function(r){if(r) $("#searchRiwayat").reset(); }); return false;'));  
                    ?>
                </div>
                </form>
            </div>
        </div>

            <?php
            $prov = $mod->searchRiwayat();

            $this->widget('ext.bootstrap.widgets.BootGridView', array(
                'id' => 'riwayatrisikojatuh-grid',
                'enableSorting' => false,
                'dataProvider' => $prov,
                'template' => "{summary}\n{items}\n{pager}",
                'itemsCssClass' => 'table table-striped table-bordered table-condensed',
                'columns' => array(
                    array(
                        'header'=>'No',
                        'type'=>'raw',
                        'value'=>'$row+1',
                    ),
                    array(
                        'header'=>'Tanggal Pendaftaran/ No. Pendaftaran',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->pendaftaran->tgl_pendaftaran)." / ".$data->pendaftaran->no_pendaftaran',
                    ),
                    array(
                      'header'=>'Instalasi / Ruangan',
                      'type'=>'raw',
                      'value'=>'$data->getInstalasiRuangan()',
                    ),
                      array(
                        'header'=>'Petugas Pengisi',
                        'type'=>'raw',
                        'value'=>'$data->petugas->namaLengkap',
                    ),
                    array(
                        'header'=>'Tanggal/Jam Pengkajian Resiko Jatuh',
                        'type'=>'raw',
                        'value'=>'MyFormatter::formatDateTimeForUser($data->tanggal_pengkajian)." / ".$data->jam_pengkajian',
                    ),
                    array(
                        'header'=>'Waktu Dilakukan Pengkajian',
                        'type'=>'raw',
                        'value'=>'$data->waktupengkajian_resikojatuh',
                    ),
                    array(
                        'header'=>'Skor Jatuh',
                        'type'=>'raw',
                        'value'=>'$data->keteranganskor_resikojatuh',
                    ),
                    array(
                        'header'=>'Waktu Intervensi Pencegahan',
                        'type'=>'raw',
                        'value'=> function($data){
                            $intervensi = IntervensicegahjatuhpasienT::model()->findByattributes(array('pengkajianresikojatuh_id'=>$data->pengkajianresikojatuh_id));
                            if (!empty($intervensi)){
                                echo MyFormatter::formatDateTimeForUser($intervensi->tgl_intervensi)." ".$intervensi->jam_intervensi;
                            }else{
                                echo "-";
                            }
                        } 
                    ),
                    array(
                        'header'=>'Evaluasi',
                        'type'=>'raw',
                        'value'=> function($data){
                            $intervensi = IntervensicegahjatuhpasienT::model()->findByattributes(array('pengkajianresikojatuh_id'=>$data->pengkajianresikojatuh_id));
                            if (!empty($intervensi)){
                                if ($intervensi->evaluasi_pencegahanjatuh == true){
                                    echo "Terjadi insiden jatuh";
                                }else{
                                    echo "Tidak terjadi insiden jatuh";
                                }
                            }else{
                                echo "-";
                            }
                        }
                    ),
                    array(
                        'header'=>'Detail Pengkajian',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::link(
                                '<icon class="icon-rekaptrans"></icon>', Yii::app()->createUrl("/rawatInap/PengkajianResikoJatuh/detail", array("pengkajianresikojatuh_id"=>$data->pengkajianresikojatuh_id,"frame"=>true)),
                                array(
                                    "target"=>"iframeDetail",
                                    "onclick"=>"dialogRiwayat('');",
                                    "rel"=>"tooltip",
                                    "title"=>"Klik untuk Melihat Detail Intervensi Pencegahan Pasien Jatuh ",

                                ));
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        )
                    ),
                    array(
                        'header'=>'Ubah',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::link('<i class="entypo-pencil" style="font-size: 14pt"></i>', Yii::app()->controller->createUrl('indexAnak', array(
                                'pendaftaran_id'=>$data->pendaftaran_id,
                                'pengkajianresikojatuh_id'=>$data->pengkajianresikojatuh_id,
                            )));
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        )
                    ),
                    array(
                        'header'=>'Hapus',
                        'type'=>'raw',
                        'value'=>function($data) {
                            return CHtml::link('<i class="entypo-trash" style="font-size: 14pt"></i>', 'javascript:void(0)', array(
                                'onclick'=>'hapusRiwayat('.$data->pengkajianresikojatuh_id.'); return false'
                            ));
                        },
                        'htmlOptions'=>array(
                            'style'=>'text-align: center;',
                        )
                    ),


                ),
                'afterAjaxUpdate' => 'function(id, data){jQuery(\'' . Params::TOOLTIP_SELECTOR . '\').tooltip({"placement":"' . Params::TOOLTIP_PLACEMENT . '"});'
                . '$(".custom-only").keyup(function(){setCustomOnly(this);});}',
            ));
            ?>
        <br />
        <?php //$this->renderPartial($this->path_view.'_tombolPrinout',array('modPendaftaran'=>$modPendaftaran)); ?>
    </div>
</div>

<?php
    // Dialog untuk tindak lanjut pasien ke RI=========================
    $this->beginWidget('zii.widgets.jui.CJuiDialog', array(// the dialog
        'id' => 'dialogDetail',
        'options' => array(
            'title' => 'Detail Pengkajian',
            'autoOpen' => false,
            'modal' => true,
            'zIndex'=>1002,
            'width' => 1000,
            'height' => 700,
            'resizable' => true
        ),
    ));
    ?>
    <iframe name='iframeDetail' width="100%" height="100%"></iframe>
<?php $this->endWidget(); ?>

<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl.'/js/bootstrap-multiselect/js/bootstrap-multiselect.js', CClientScript::POS_END); ?>
<script>
    
    var ru = $('#search_ruangan_id');
    
    
    function setRuanganMulti() {
        
        console.log("Kick");
        
        var ins  = jQuery('#search_instalasi_id');
        var ins_all = jQuery('#search_instalasi_id option:selected');
        var ru  = jQuery('#search_ruangan_id');

        var brands = ins_all;
        var selected = [];


        $(brands).each(function(index, brand){
                selected.push($(this).val());
        });

        ru.addClass('animation-loading');
        //alert(selected);

        $.post('<?php echo $this->createUrl('/actionDynamic/getRuanganDariInstalasi', array('namaModel'=>'PengkajianresikojatuhT')) ?>', $("#searchRiwayat").serialize(), function(data){	

            //alert(data.ruangan);
            ru.html(data);
            console.log(ru.find("option[value='']").remove());
            ru.find("options[value='']").remove();
            ru.multiselect('rebuild');																
            ru.removeClass('animation-loading');
            						
        });

    }

    $("#btn_cari").on('click', function() {
        
        $.fn.yiiGridView.update('riwayatrisikojatuh-grid', {data: $("#searchRiwayat").serialize()});
        
        return false;
    });

    function hapusRiwayat(id) {
        myConfirm("Anda yakin untuk menghapus data ini ?", "Peringatan", function(r) {
            if (r) {
                $.post('<?php echo $this->createUrl('delete'); ?>', {id: id}, function(data) {
                    if (data.sukses === 1) {
                        myAlert(data.msg);
                        $.fn.yiiGridView.update('riwayatrisikojatuh-grid', {
                            data: $('#searchRiwayat').serialize()
                        });
                    } else {
                        myAlert(data.msg);
                    }
                }, 'json');
            }
        });
    }
    
    
    
    
    $(document).ready(function() {
        console.log(ru);
        jQuery(ru).multiselect({
            includeSelectAllOption: true,
            buttonClass: "form-control",
            maxHeight: 300,
            buttonWidth: '150px',
            enableCaseInsensitiveFiltering: true
        }).hide();
        
    });
</script>