<?php Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/js/jquery.tiler.js'); //UNTUK PEMERIKSAAN LAB       ?>
<?php $this->widget('bootstrap.widgets.BootAlert'); ?>
<link rel="stylesheet" href="assets/js/wysihtml5/bootstrap-wysihtml5.css">

<?php
$check = false;
Yii::app()->clientScript->registerScriptFile(Yii::app()->baseUrl . '/themes/neon/assets/js/wysihtml5/bootstrap-wysihtml5_custom2.js', CClientScript::POS_END);
$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'culture-t-form',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'enctype' => 'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event);',
        'onsubmit' => 'return requiredCheck(this);'),
        ));
?>
<div class="panel panel-success">
    <div class="panel panel-heading">
        <div class="panel-title"> <b> Culture </b> </div>
    </div>
    <div class="panel-body">
        <div class="panel panel-success">
            <div class="panel panel-heading">
                <div class="panel-title"> <b> Data Spesimen </b> </div>
            </div>
            <div class="panel-body">
                <?php $this->renderPartial('_dataSpesimen', array('modSpesimen' => $modSpesimen, 'modPenilaian' => $modPenilaian, 'form' => $form)); ?>
            </div>
        </div>


        <?php
        $this->Widget('ext.bootstrap.widgets.BootAccordion', array(
            'id' => 'form-riwayat',
            'content' => array(
                'content-riwayat' => array(
                    'header' => CHtml::htmlButton("<i class='icon-accordion icon-white'></i>", array(
                        'class' => 'btn btn-primary btn-mini',
                        'onclick' => '',
                        'onkeyup' => "return $(this).focusNextInputField(event)",
                        'rel' => 'tooltip',
                        'title' => 'Klik untuk menampilkan Riwayat Inoculating Processing')) . '<b> Riwayat Inoculating Processing </b>',
                    'isi' => $this->renderPartial('_riwayatCulture', array('modRiwayatCulture' => $modRiwayatCulture), true),
                    'active' => false,
                ),
            ),
        ));
        ?>
        <div class="panel panel-success">
            <div class="panel panel-heading">
                <div class="panel-title"> <b> Inoculating Processing </b> </div>
                <span style="float:right; padding: 10px">
                    <?php echo CHtml::checkBox("pilihall", $check, array('class' => 'pilihall', 'name' => 'pilih[]', 'value' => "", 'onchange' => 'checkThis(this);')) ?>
                </span>
            </div>
            <div class="panel-body">
                <?php echo CHtml::hiddenField('no_row', '', array('readonly' => true, 'class' => 'no_row',)); ?>
                <div class="control-group">
                    <?php echo CHtml::label('Pemeriksaan', '', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo CHtml::activeHiddenField($modCulture, 'tindakanpelayanan_id', array('class' => 'span3', 'readonly' => true));
                        echo CHtml::activeHiddenField($modCulture, 'daftartindakan_id', array('class' => 'span3', 'readonly' => true));
                        echo CHtml::activeTextField($modCulture, 'daftartindakan_nama', array('class' => 'span3', 'readonly' => true));
                        ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('', '', array('class' => 'control-label', 'style' => 'margin-left:-70px')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeCheckBox($modCook, 'pilih', array('onchange' => 'showCook()')) . ' <label>Cooked Meat Broth</label>' ?>
                    </div>
                </div>
                <div class="control-group">
                    <?php echo CHtml::label('', '', array('class' => 'control-label', 'style' => 'margin-left:-70px')) ?>
                    <div class="controls">
                        <?php echo CHtml::activeCheckBox($modThigli, 'pilih', array('onchange' => 'showThighli()')) . ' <label>Thioglikolat Broth</label>' ?>
                    </div>
                </div>
                <div class="row-fluid">
                    <div id="input-cookagar" style="display: none">
                        <div class="panel-cookagar">

                        </div>
                    </div>
                </div>
                <div class="clear"> </div>
                <div class="row-fluid">
                    <div id="input-thigliagar" style="display: none">
                        <div class="panel-thigliagar">

                        </div>
                    </div>
                </div>
                <div class="clear"> </div>
                <div class="row-fluid">
                    <div id="input-bloodagar">
                        <div class="panel-bloodagar">

                        </div>
                    </div>
                </div>
                <div class="clear"> </div>
                <div class="row-fluid">
                    <div id="input-chocagar">
                        <div class="panel-chocagar">

                        </div>
                    </div>
                </div>
                <div class="clear"> </div>
                <div class="row-fluid">
                    <div id="input-mcagar">
                        <div class="panel-mcagar">

                        </div>
                    </div>
                </div>
                <div class="clear"> </div>
                <div class="row-fluid">
                    <div id="input-rsagar">
                        <div class="panel-rsagar">

                        </div>
                    </div>
                </div>
                <div class="clear"> </div>
            </div>
        </div>

        <!--        <div class="panel panel-success">
                    <div class="panel panel-heading">
                        <div class="panel-title"> <b> Person In Charge </b> </div>
                    </div>
                    <div class="panel-body">-->
        <?php $this->renderPartial('_formVerifikator', array('modCulture' => $modCulture, 'form' => $form)); ?>
        <!--            </div>
                </div>-->
        <div class="form-actions">
            <?php
            echo CHtml::htmlButton(Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="icon-ok icon-white"></i>')), array('class' => 'btn btn-primary', 'type' => 'submit', 'disabled' => (isset($_GET['sukses'])) ? true : false));
            ?>
            <?php echo CHtml::activeHiddenField($modCulture, 'statusnya', array('class' => 'span3 statusnya', 'placeholder' => 'Tulis Pilihan Lainnya', 'readonly' => true)) ?>

            <?php
//            if (!empty($_GET['culture_id'])) {
//                echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index', array('spesimen_id' => $modSpesimen->spesimen_id, 'culture_id' => $_GET['culture_id'])), array('class' => 'btn btn-danger',
//                    'onclick' => 'return refreshForm(this);')) . "&nbsp;";
//            } else {
            echo CHtml::link(Yii::t('mds', '{icon} Ulang', array('{icon}' => '<i class="icon-refresh icon-white"></i>')), $this->createUrl($this->id . '/index', array('spesimen_id' => $modSpesimen->spesimen_id)), array('class' => 'btn btn-danger',
                'onclick' => 'return refreshForm(this);')) . "&nbsp;";
//            }

            if (!empty($_GET['culture_id'])) {
                $modBlood = BloodAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
                $modChoc = ChocAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
                $modMc = McconceyAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));
                $modBrucella = RosellaAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id));

                $modBlood2 = BloodAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null'));
                $modChoc2 = ChocAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null'));
                $modMc2 = McconceyAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null'));
                $modBrucella2 = RosellaAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null'));

                $modBlood3 = BloodAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null and tgl_verifikasi_dpjtm is not null'));
                $modChoc3 = ChocAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null and tgl_verifikasi_dpjtm is not null'));
                $modMc3 = McconceyAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null and tgl_verifikasi_dpjtm is not null'));
                $modBrucella3 = RosellaAgarT::model()->findAllByAttributes(array('culture_id' => $modCulture->culture_id), array('condition' => 'tgl_verifikasi_ppds is not null and tgl_verifikasi_dpjtm is not null'));
                $login_ppds = !empty(Yii::app()->user->getState('ppds_id')) ? Yii::app()->user->getState('ppds_id') : 0;
                $login_dpjtm = !empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 0;

                if (count($modBlood) == count($modBlood2) && count($modChoc) == count($modChoc2) && count($modMc) == count($modMc2) && count($modBrucella) == count($modBrucella2)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Terverifikasi PPDS', array('{icon}' => '<i class="icon-check icon-white"></i>')), $this->createUrl($this->id . '/index', array('spesimen_id' => $_GET['spesimen_id'], 'culture_id' => $modCulture->culture_id, 'verifikasippds' => true)), array('class' => 'btn btn-success', 'disabled' => true)) . "&nbsp;";
                } else {
                    if ($login_ppds != 0) {
                        echo CHtml::link(Yii::t('mds', '{icon} Verifikasi PPDS', array('{icon}' => '<i class="icon-check icon-white"></i>')), $this->createUrl('index'), array(
                            'class' => 'btn btn-gold',
                            'onclick' => 'cek_ceklisPPDS(); return false;')) . "&nbsp;";
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Verifikasi PPDS', array('{icon}' => '<i class="icon-check icon-white"></i>')), 'javascript:void(0)', array(
                            'class' => 'btn btn-gold',
                            'onclick' => 'myAlert("Anda tidak bisa melakukan verifikasi PPDS"); return false;')) . "&nbsp;";
                    }
                }

                if (count($modBlood) == count($modBlood3) && count($modChoc) == count($modChoc3) && count($modMc) == count($modMc3) && count($modBrucella) == count($modBrucella3)) {
                    echo CHtml::link(Yii::t('mds', '{icon} Terverifikasi DPJTM', array('{icon}' => '<i class="icon-check icon-white"></i>')), $this->createUrl($this->id . '/index', array('spesimen_id' => $_GET['spesimen_id'], 'culture_id' => $modCulture->culture_id, 'verifikasippds' => true)), array('class' => 'btn btn-success', 'disabled' => true)) . "&nbsp;";
                } else {
                    if ($login_dpjtm != 0) {
                        echo CHtml::link(Yii::t('mds', '{icon} Verifikasi DPJTM', array('{icon}' => '<i class="icon-check icon-white"></i>')), $this->createUrl('index'), array(
                            'class' => 'btn btn-orange',
                            'onclick' => 'cek_ceklisDPJTM(); return false;')) . "&nbsp;";
                    } else {
                        echo CHtml::link(Yii::t('mds', '{icon} Verifikasi DPJTM', array('{icon}' => '<i class="icon-check icon-white"></i>')), 'javascript:void(0)', array(
                            'class' => 'btn btn-orange',
                            'onclick' => 'myAlert("Anda tidak bisa melakukan verifikasi DPJTM"); return false;')) . "&nbsp;";
                    }
                }
            }

            echo CHtml::link(Yii::t('mds', '{icon} Kembali', array('{icon}' => '<i class="icon-arrow-left icon-white"></i>')), $this->createUrl('InformasiDaftarSpesimen/index', array()), array('class' => 'btn btn-danger')) . "&nbsp;";
            ?>
        </div>
    </div>
</div>
<?php
$this->renderPartial('_jsFunction', array(
    'modCook' => $modCook,
    'modThigli' => $modThigli,
    'modBlood' => $modBlood,
    'modBloodGambar' => $modBloodGambar,
    'modChoc' => $modChoc,
    'modChocGambar' => $modChocGambar,
    'modMcConcey' => $modMcConcey,
    'modMcConceyGambar' => $modMcConceyGambar,
    'modBrucella' => $modBrucella,
    'modBrucellaGambar' => $modBrucellaGambar));
?>
<?php $this->renderPartial('_dialog', array()); ?>
<?php $this->endWidget(); ?>

<script>
    
    /**
     * Show hide panel Cooked Meat Broth
     * @returns {undefined}
     */
    function showCook(){
        var checklist = $('#CookedmeatbrothT_pilih');
        var pilih = checklist.attr('checked');
        if(pilih){
            document.getElementById('input-cookagar').setAttribute("style","display:block;");
        }else{
            document.getElementById('input-cookagar').setAttribute("style","display:none;");
        }
    }
    
    /**
     * Show hide Thiglikolat Broth
     * @returns {undefined}
     */
    function showThighli(){
        var checklist = $('#ThiglikolatbrothT_pilih');
        var pilih = checklist.attr('checked');
        if(pilih){
            document.getElementById('input-thigliagar').setAttribute("style","display:block;");
        }else{
            document.getElementById('input-thigliagar').setAttribute("style","display:none;");
        }
    }
    
    /**
     * Set verifikasi
     * @param {type} obj
     * @param {type} id
     * @returns {undefined}
     */
    function setVerifikasi() {
        myConfirm('Apakah anda yakin untuk melakukan verifikasi untuk culture ini?', 'Perhatian!', function (r) {
            $('.statusnya').val('DISETUJUI');
            $('#culture-t-form').submit();
        });
    }

    /*
     * Check All
     * @param {type} obj
     * @returns {undefined}     
     */
    function checkThis(obj) {
        if ($(".pilihall").is(":checked")) {
            var item = [];
            var i = 0;
            var no1 = 0;
            $(".panel-det-blood").each(function () {
                var culture_id = <?php echo!empty($_GET['culture_id']) ? $_GET['culture_id'] : 0; ?>;
                if (culture_id != 0) {
                    var blood = 'Blood Agar ke-' + (no1 + 1);
                    var ppds_id = $(this).find("input[name$='[ppds_id]']").val();
                    var dpjtm_id = $(this).find("input[name$='[dpjtm_id]']").val();
                    var login_ppds = <?php echo!empty(Yii::app()->user->getState('ppds_id')) ? Yii::app()->user->getState('ppds_id') : 0; ?>;
                    var login_dpjtm = <?php echo!empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 0; ?>;

                    if (login_ppds !== 0) {
                        if (ppds_id != login_ppds) {
                            var arraycontains_item = (item.indexOf(ppds_id) > -1);
                            if (arraycontains_item == false) {
                                item[i] = blood;
                                i++;
                            }
                            $(this).find('.pilihcheck').attr("checked", false);
                        } else {
                            $(this).find('.pilihcheck').attr("checked", true);
                        }
                    } else if (login_dpjtm !== 0) {
                        if (dpjtm_id != login_dpjtm) {
                            var arraycontains_item = (item.indexOf(dpjtm_id) > -1);
                            if (arraycontains_item == false) {
                                item[i] = blood;
                                i++;
                            }
                            $(this).find('.pilihcheck').attr("checked", false);
                        } else {
                            $(this).find('.pilihcheck').attr("checked", true);
                        }
                    }
                }
                no1++;
            });

            var no2 = 0;
            $(".panel-det-choc").each(function () {
                var culture_id = <?php echo!empty($_GET['culture_id']) ? $_GET['culture_id'] : 0; ?>;
                if (culture_id != 0) {
                    var choc = 'Choc Agar ke-' + (no2 + 1);
                    var ppds_id = $(this).find("input[name$='[ppds_id]']").val();
                    var dpjtm_id = $(this).find("input[name$='[dpjtm_id]']").val();
                    var login_ppds = <?php echo!empty(Yii::app()->user->getState('ppds_id')) ? Yii::app()->user->getState('ppds_id') : 0; ?>;
                    var login_dpjtm = <?php echo!empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 0; ?>;

                    if (login_ppds !== 0) {
                        if (ppds_id != login_ppds) {
                            var arraycontains_item = (item.indexOf(ppds_id) > -1);
                            if (arraycontains_item == false) {
                                item[i] = choc;
                                i++;
                            }
                            $(this).find('.pilihcheck').attr("checked", false);
                        } else {
                            $(this).find('.pilihcheck').attr("checked", true);
                        }
                    } else if (login_dpjtm !== 0) {
                        if (dpjtm_id != login_dpjtm) {
                            var arraycontains_item = (item.indexOf(dpjtm_id) > -1);
                            if (arraycontains_item == false) {
                                item[i] = choc;
                                i++;
                            }
                            $(this).find('.pilihcheck').attr("checked", false);
                        } else {
                            $(this).find('.pilihcheck').attr("checked", true);
                        }
                    }
                }
                no2++;
            });

            var no3 = 0;
            $(".panel-det-mc").each(function () {
                var culture_id = <?php echo!empty($_GET['culture_id']) ? $_GET['culture_id'] : 0; ?>;
                if (culture_id != 0) {
                    var mc = 'Mc Conkey Agar ke-' + (no3 + 1);
                    var ppds_id = $(this).find("input[name$='[ppds_id]']").val();
                    var dpjtm_id = $(this).find("input[name$='[dpjtm_id]']").val();
                    var login_ppds = <?php echo!empty(Yii::app()->user->getState('ppds_id')) ? Yii::app()->user->getState('ppds_id') : 0; ?>;
                    var login_dpjtm = <?php echo!empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 0; ?>;

                    if (login_ppds !== 0) {
                        if (ppds_id != login_ppds) {
                            var arraycontains_item = (item.indexOf(ppds_id) > -1);
                            if (arraycontains_item == false) {
                                item[i] = mc;
                                i++;
                            }
                            $(this).find('.pilihcheck').attr("checked", false);
                        } else {
                            $(this).find('.pilihcheck').attr("checked", true);
                        }
                    } else if (login_dpjtm !== 0) {
                        if (dpjtm_id != login_dpjtm) {
                            var arraycontains_item = (item.indexOf(dpjtm_id) > -1);
                            if (arraycontains_item == false) {
                                item[i] = mc;
                                i++;
                            }
                            $(this).find('.pilihcheck').attr("checked", false);
                        } else {
                            $(this).find('.pilihcheck').attr("checked", true);
                        }
                    }
                }
                no3++;
            });

            var no4 = 0;
            $(".panel-det-rs").each(function () {
                var culture_id = <?php echo!empty($_GET['culture_id']) ? $_GET['culture_id'] : 0; ?>;
                if (culture_id != 0) {
                    var rosella = 'Brucella Agar ke-' + (no4 + 1);
                    var ppds_id = $(this).find("input[name$='[ppds_id]']").val();
                    var dpjtm_id = $(this).find("input[name$='[dpjtm_id]']").val();
                    var login_ppds = <?php echo!empty(Yii::app()->user->getState('ppds_id')) ? Yii::app()->user->getState('ppds_id') : 0; ?>;
                    var login_dpjtm = <?php echo!empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 0; ?>;

                    if (login_ppds !== 0) {
                        if (ppds_id != login_ppds) {
                            var arraycontains_item = (item.indexOf(ppds_id) > -1);
                            if (arraycontains_item == false) {
                                item[i] = rosella;
                                i++;
                            }
                            $(this).find('.pilihcheck').attr("checked", false);
                        } else {
                            $(this).find('.pilihcheck').attr("checked", true);
                        }
                    } else if (login_dpjtm !== 0) {
                        if (dpjtm_id != login_dpjtm) {
                            var arraycontains_item = (item.indexOf(dpjtm_id) > -1);
                            if (arraycontains_item == false) {
                                item[i] = rosella;
                                i++;
                            }
                            $(this).find('.pilihcheck').attr("checked", false);
                        } else {
                            $(this).find('.pilihcheck').attr("checked", true);
                        }
                    }
                }
                no4++;
            });

            if (item.length > 1) {
                myAlert("<strong>Anda tidak dapat melakukan verifikasi pada data <br>" + item.join(', ') + "</strong>", "Perhatian");
                return false;
            }
        } else {
            $(".panel-det-blood").each(function () {
                $(this).find('.pilihcheck').attr("checked", false);
            });
            $(".panel-det-choc").each(function () {
                $(this).find('.pilihcheck').attr("checked", false);
            });
            $(".panel-det-mc").each(function () {
                $(this).find('.pilihcheck').attr("checked", false);
            });
            $(".panel-det-rs").each(function () {
                $(this).find('.pilihcheck').attr("checked", false);
            });
        }
    }

    /**
     * Verifikasi ceklis pada rosella
     * @param {type} obj
     * @returns {Boolean}
     */
    function cekverifikasi_brucella(obj) {
        var culture_id = <?php echo!empty($_GET['culture_id']) ? $_GET['culture_id'] : 0; ?>;
        if (culture_id != 0) {
            var ppds_id = $(obj).parents(".panel-det-rs").find("input[name$='[ppds_id]']").val();
            var dpjtm_id = $(obj).parents(".panel-det-rs").find("input[name$='[dpjtm_id]']").val();
            var login_ppds = <?php echo!empty(Yii::app()->user->getState('ppds_id')) ? Yii::app()->user->getState('ppds_id') : 0; ?>;
            var login_dpjtm = <?php echo!empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 0; ?>;

            if (login_ppds !== 0) {
                if (ppds_id != login_ppds) {
                    myAlert('Anda tidak dapat melakukan verifikasi');
                    $(obj).parents(".panel-det-rs").find('.pilihcheck').attr("checked", false);
                    return false;
                }
            } else if (login_dpjtm !== 0) {
                if (dpjtm_id != login_dpjtm) {
                    myAlert('Anda tidak dapat melakukan verifikasi');
                    $(obj).parents(".panel-det-rs").find('.pilihcheck').attr("checked", false);
                    return false;
                }
            } else {
                myAlert('Tidak ada data ppds');
                return false;
            }
        }
    }

    /**
     * Verifikasi ceklis pada blood
     * @param {type} obj
     * @returns {Boolean}
     */
    function cekverifikasi_blood(obj) {
        var culture_id = <?php echo!empty($_GET['culture_id']) ? $_GET['culture_id'] : 0; ?>;
        if (culture_id != 0) {
            var ppds_id = $(obj).parents(".panel-det-blood").find("input[name$='[ppds_id]']").val();
            var dpjtm_id = $(obj).parents(".panel-det-blood").find("input[name$='[dpjtm_id]']").val();
            var login_ppds = <?php echo!empty(Yii::app()->user->getState('ppds_id')) ? Yii::app()->user->getState('ppds_id') : 0; ?>;
            var login_dpjtm = <?php echo!empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 0; ?>;

            if (login_ppds !== 0) {
                if (ppds_id != login_ppds) {
                    myAlert('Anda tidak dapat melakukan verifikasi');
                    $(obj).parents(".panel-det-blood").find('.pilihcheck').attr("checked", false);
                    return false;
                }
            } else if (login_dpjtm !== 0) {
                if (dpjtm_id != login_dpjtm) {
                    myAlert('Anda tidak dapat melakukan verifikasi');
                    $(obj).parents(".panel-det-blood").find('.pilihcheck').attr("checked", false);
                    return false;
                }
            } else {
                myAlert('Tidak ada data ppds');
                return false;
            }
        }
    }

    /**
     * Verifikasi ceklis pada choc
     * @param {type} obj
     * @returns {Boolean}
     */
    function cekverifikasi_choc(obj) {
        var culture_id = <?php echo!empty($_GET['culture_id']) ? $_GET['culture_id'] : 0; ?>;
        if (culture_id != 0) {
            var ppds_id = $(obj).parents(".panel-det-choc").find("input[name$='[ppds_id]']").val();
            var dpjtm_id = $(obj).parents(".panel-det-choc").find("input[name$='[dpjtm_id]']").val();
            var login_ppds = <?php echo!empty(Yii::app()->user->getState('ppds_id')) ? Yii::app()->user->getState('ppds_id') : 0; ?>;
            var login_dpjtm = <?php echo!empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 0; ?>;

            if (login_ppds !== 0) {
                if (ppds_id != login_ppds) {
                    myAlert('Anda tidak dapat melakukan verifikasi');
                    $(obj).parents(".panel-det-choc").find('.pilihcheck').attr("checked", false);
                    return false;
                }
            } else if (login_dpjtm !== 0) {
                if (dpjtm_id != login_dpjtm) {
                    myAlert('Anda tidak dapat melakukan verifikasi');
                    $(obj).parents(".panel-det-choc").find('.pilihcheck').attr("checked", false);
                    return false;
                }
            } else {
                myAlert('Tidak ada data ppds');
                return false;
            }
        }
    }

    /**
     * Verifikasi ceklis pada mc
     * @param {type} obj
     * @returns {Boolean}
     */
    function cekverifikasi_mc(obj) {
        var culture_id = <?php echo!empty($_GET['culture_id']) ? $_GET['culture_id'] : 0; ?>;
        if (culture_id != 0) {
            var ppds_id = $(obj).parents(".panel-det-mc").find("input[name$='[ppds_id]']").val();
            var dpjtm_id = $(obj).parents(".panel-det-mc").find("input[name$='[dpjtm_id]']").val();
            var login_ppds = <?php echo!empty(Yii::app()->user->getState('ppds_id')) ? Yii::app()->user->getState('ppds_id') : 0; ?>;
            var login_dpjtm = <?php echo!empty(Yii::app()->user->getState('pegawai_id')) ? Yii::app()->user->getState('pegawai_id') : 0; ?>;

            if (login_ppds !== 0) {
                if (ppds_id != login_ppds) {
                    myAlert('Anda tidak dapat melakukan verifikasi');
                    $(obj).parents(".panel-det-mc").find('.pilihcheck').attr("checked", false);
                    return false;
                }
            } else if (login_dpjtm !== 0) {
                if (dpjtm_id != login_dpjtm) {
                    myAlert('Anda tidak dapat melakukan verifikasi');
                    $(obj).parents(".panel-det-mc").find('.pilihcheck').attr("checked", false);
                    return false;
                }
            } else {
                myAlert('Tidak ada data ppds');
                return false;
            }
        }
    }

    /**
     * Sebelum verifikasi, dicek terlebih dahulu apakah sudah ada data yang diceklis atau belum
     * @returns {Boolean}     
     */
    function cek_ceklisPPDS() {
        var ada = 0;
        $(".panel-det-rs").each(function () {
            if ($(this).find('.pilihcheck').prop("checked") == true) {
                ada++;
            }
        });

        $(".panel-det-blood").each(function () {
            if ($(this).find('.pilihcheck').prop("checked") == true) {
                ada++;
            }
        });

        $(".panel-det-choc").each(function () {
            if ($(this).find('.pilihcheck').prop("checked") == true) {
                ada++;
            }
        });

        $(".panel-det-mc").each(function () {
            if ($(this).find('.pilihcheck').prop("checked") == true) {
                ada++;
            }
        });

        if (ada == 0) {
            myAlert('Ceklis data Agar terlebih dahulu !');
            return false;
        } else {
            myConfirm("Apakah anda menyetujui pemeriksaan ini?", "Perhatian!", function (r) {
                if (r)
                    $('.verifikasiPPDS').val('Ya');
                $('#culture-t-form').submit();
            });
            return false;
        }
    }


    /**
     * Sebelum verifikasi, dicek terlebih dahulu apakah sudah ada data yang diceklis atau belum
     * @returns {Boolean}     
     */
    function cek_ceklisDPJTM() {
        var ada = 0;
        $(".panel-det-rs").each(function () {
            if ($(this).find('.pilihcheck').prop("checked") == true) {
                ada++;
            }
        });

        $(".panel-det-blood").each(function () {
            if ($(this).find('.pilihcheck').prop("checked") == true) {
                ada++;
            }
        });

        $(".panel-det-choc").each(function () {
            if ($(this).find('.pilihcheck').prop("checked") == true) {
                ada++;
            }
        });

        $(".panel-det-mc").each(function () {
            if ($(this).find('.pilihcheck').prop("checked") == true) {
                ada++;
            }
        });

        if (ada == 0) {
            myAlert('Ceklis data Agar terlebih dahulu !');
            return false;
        } else {
            myConfirm("Apakah anda menyetujui pemeriksaan ini?", "Perhatian!", function (r) {
                if (r)
                    $('.verifikasiDPJTM').val('Ya');
                $('#culture-t-form').submit();
            });
            return false;
        }
    }
</script>