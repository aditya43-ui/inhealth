<?php
$this->breadcrumbs = array(
    'Laporan SIRS',
); ?>
<?php
$form = $this->beginWidget(
    'ext.bootstrap.widgets.BootActiveForm',
    array(
        'id' => 'search-form',
        'enableAjaxValidation' => false,
        'type' => 'horizontal',
        'focus' => '#isPasienLama',
        'htmlOptions' => array(
            'onKeyPress' => 'return disableKeyPress(event)'
        ),
    )
);
?>
<style>
    hr {
        height: 1px;
        margin: 10px 0;
        background: #57a595;
        border: none;
    }

    #menu li {
        display: block;
        float: left;
        width: 100px;
        height: 53px;
        border: 1px solid #559DCF;
        border-radius: 3px;
        text-align: center;
        text-decoration: none;
        margin: 5px;
    }

    #menu a {
        padding: 1px;
        text-decoration: none;
        color: #6D6D6D;
    }

    #menu img {
        display: block;
        margin: 0 auto;
        padding: 10px;
        border: none;
    }

    #menu_laporan a:hover,
    #menu_laporan a:focus {
        color: #737881;
    }

    .selected {
        background: #57a595;
        color: #ffffff !important;
        font-weight: bold;
    }

    #satu,
    #dua,
    #tiga,
    #empat,
    #lima {
        margin-bottom: 15px
    }

    .border th,
    .border td {
        border: 1px solid #000;
    }

    .col-sm-3 {
        width: 23%;
        border: solid 1px #ddd;
        margin: 5px;
        padding: 0;
        border-radius: 15px;
        text-align: center;
        background: #f2f2f2;
        cursor: pointer;
        overflow: hidden;
        transition: .25s;
    }

    .col-sm-3>a {
        display: block;
        padding: 15px;
    }

    .col-sm-3 img {
        width: 100px;
        height: 100px;
    }

    .col-sm-3 span {
        display: inline-block;
        margin-top: 15px;
        padding: 0 15px 0;
        font-size: 13px;
    }

    .col-sm-3:hover {
        filter: brightness(.85);
    }
</style>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="entypo-newspaper"></i> Laporan <b>SIRS</b>
        </div>
    </div>
    <div class="panel-body">
        <div class="row">
            <div class="col-sm-4">
                <?php echo CHtml::hiddenField('type', '');
                $format = new MyFormatter(); ?>
                <?php echo CHtml::label('Periode Laporan', 'tglpemeriksaan', array('class' => 'control-label')) ?>
                <div class="controls">
                    <?php echo Chtml::dropDownList('jns_periode', '', array('hari' => 'Hari', 'bulan' => 'Bulan', 'tahun' => 'Tahun'), array('class' => 'span3', 'onchange' => 'ubahJnsPeriode();')); ?>
                </div>
            </div>
            <div class="col-sm-4">
                <div class='control-group hari'>
                    <?php echo CHtml::label('Dari Tanggal', 'dari_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $model->tgl_awal = $format->formatDateTimeForUser($model->tgl_awal); ?>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'name' => 'tgl_awal',
                            'attribute' => 'tgl_awal',
                            'mode' => 'date',
                            'value' => $model->tgl_awal,
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => "span3",
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                        <?php $model->tgl_awal = $format->formatDateTimeForDb($model->tgl_awal); ?>
                    </div>
                </div>
                <div class='control-group bulan'>
                    <?php echo CHtml::label('Dari Bulan', 'dari_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $model->bln_awal = $format->formatMonthForUser($model->bln_awal); ?>
                        <?php
                        $this->widget('MyMonthPicker', array(
                            'name' => 'bln_awal',
                            'attribute' => 'bln_awal',
                            'value' => $model->bln_awal,
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true,
                                'class' => "span3",
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                        <?php $model->bln_awal = $format->formatMonthForDb($model->bln_awal); ?>
                    </div>
                </div>
                <div class='control-group tahun'>
                    <?php echo CHtml::label('Dari Tahun', 'dari_tanggal', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo Chtml::dropDownList('thn_awal', $model->thn_awal, CustomFunction::getTahun(null, null), array('class' => "span3", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        ?>
                    </div>
                </div>
            </div>
            <div class="col-sm-4">
                <div class='control-group hari'>
                    <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $model->tgl_akhir = $format->formatDateTimeForUser($model->tgl_akhir); ?>
                        <?php
                        $this->widget('MyDateTimePicker', array(
                            'name' => 'tgl_akhir',
                            'attribute' => 'tgl_akhir',
                            'mode' => 'date',
                            'value' => $model->tgl_akhir,
                            'options' => array(
                                'dateFormat' => Params::DATE_FORMAT,
                                'maxDate' => 'd',
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => "span3",
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                        <?php $model->tgl_akhir = $format->formatDateTimeForDb($model->tgl_akhir); ?>
                    </div>
                </div>
                <div class='control-group bulan'>
                    <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php $model->bln_akhir = $format->formatMonthForUser($model->bln_akhir); ?>
                        <?php
                        $this->widget('MyMonthPicker', array(
                            'name' => 'bln_akhir',
                            'attribute' => 'bln_akhir',
                            'value' => $model->bln_awal,
                            'options' => array(
                                'dateFormat' => Params::MONTH_FORMAT,
                            ),
                            'htmlOptions' => array(
                                'readonly' => true, 'class' => "span3",
                                'onkeypress' => "return $(this).focusNextInputField(event)"
                            ),
                        ));
                        ?>
                        <?php $model->bln_akhir = $format->formatMonthForDb($model->bln_akhir); ?>
                    </div>
                </div>
                <div class='control-group tahun'>
                    <?php echo CHtml::label('Sampai Dengan', 'sampai_dengan', array('class' => 'control-label')) ?>
                    <div class="controls">
                        <?php
                        echo Chtml::dropDownList('thn_akhir', $model->thn_akhir, CustomFunction::getTahun(null, null), array('class' => "span3", 'onkeypress' => "return $(this).focusNextInputField(event)"));
                        ?>
                    </div>
                </div>
            </div>
            <div class="form-actions">
                <!--
            <?php
            echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Search', array('{icon}' => '<i class="entypo-search"></i>')),
                array('title' => 'Cari', 'class' => 'btn btn-danger', 'type' => 'submit')
            );
            ?>
            <?php
            echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                Yii::app()->createUrl($this->module->id . '/' . $this->id),
                array(
                    'title' => 'Ulang',
                    'class' => 'btn btn-default',
                    'onclick' => 'if(!confirm("' . Yii::t('mds', 'Do You want to cancel?') . '")) return false;'
                )
            );
            ?>
-->
            </div>
            <?php
            $this->endWidget();
            ?>
            <div class="clear"></div>
            <div class="col-sm-12" style="margin-top: 17px;">
                <div class="panel panel-success">
                    <div class="panel-heading">
                        <div class="panel-title">
                            <i class="glyphicon glyphicon-file"></i> Data
                        </div>
                    </div>
                    <div id="menu_laporan" class="panel-body">
                        <div class="dashboard" id="satu">
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/dataDasarRS'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL1.1.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Data Dasar Rumah Sakit</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/KegiatanPelayananRS'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL1.2.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Indikator Pelayanan Rumah Sakit</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/tempatTidurRI'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL1.3.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Fasilitas Tempat Tidur Rawat Inap</span>
                                </a>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <hr>
                        <div class="dashboard" id="dua">
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/ketenagaan'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL2.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Ketenagaan</span>
                                </a>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <hr>
                        <div class="dashboard" id="tiga">
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/KegiatanPelayananRawatInap'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.1.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Rawat Inap</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/kunjunganRD'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.2.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Rawat Darurat</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/gigiMulut'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.3.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Gigi dan Mulut</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/KegiatanKebidanan'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.4.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Kebidanan</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/KegiatanPerinatologi'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.5.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Perinatologi</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/kegiatanPembedahan'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.6.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Pembedahan</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/kegiatanRadiologi'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.7.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Radiologi</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/PemeriksaanLaboratorium'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.8.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Laboratorium</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/PelayananRehabMedik'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.9.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Rehabilitasi Medik</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/KegiatanPelayananKhusus'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.10.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Pelayanan Khusus</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/KegiatanKesehatanJiwa'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.11.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Kesejahteraan Jiwa</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/KegiatanKeluargaBerencana'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.12.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Keluarga Berencana</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/PengadaanObatResep'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.13.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Farmasi Rumah Sakit</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/KegiatanRujukan'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.14.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Rujukan</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/CaraBayar'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL3.15.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Jenis Penjamin</span>
                                </a>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <hr>
                        <div class="dashboard" id="empat">
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/morbiditasRawatInap'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL4A.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Data Keadaan Morbiditas Pasien Rawat Inap</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/morbiditasRawatInapKecelakaan'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL4B.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Data Keadaan Morbiditas Pasien Rawat Inap Penyebab Kecelakaan</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/morbiditasRawatJalan'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL4C.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Data Keadaan Morbiditas Pasien Rawat Jalan</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/morbiditasRawatJalanKecelakaan'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL4D.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Data Keadaan Morbiditas Pasien Rawat Jalan Penyebab Kecelakaan</span>
                                </a>
                            </div>
                        </div>
                        <div class="clear"></div>
                        <hr>
                        <div class="dashboard" id="lima">
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/pengunjungRUmahSakit'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL5.1.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Pengunjung Rumah Sakit</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/kunjunganRawatJalan'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL5.2.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Kunjungan Rawat Jalan</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SepuluhBesarPenyakitRawatInap'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL5.3.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Daftar 10 Besar Penyakit Rawat Inap</span>
                                </a>
                            </div>
                            <div class="col-sm-3">
                                <a href="<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/SepuluhBesarPenyakitRawatJalan'); ?>">
                                    <img src="<?php echo Params::urliconmenu() . 'rl/RL5.4.svg' ?>" onclick="setAttributes();"></img><br>
                                    <span>Daftar 10 Besar Penyakit Rawat Jalan</span>
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="clear"></div>
            <!--<div class="form-actions">
            <div style="float:left;">
                <?php
                //                echo CHtml::htmlButton(Yii::t('mds','{icon} Print',array('{icon}'=>'<i class="entypo-print"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printLaporan(\'PRINT\')')); 
                //                echo CHtml::htmlButton(Yii::t('mds','{icon} PDF',array('{icon}'=>'<i class="entypo-book"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printLaporan(\'PDF\')')); 
                //                echo CHtml::htmlButton(Yii::t('mds','{icon} Excel',array('{icon}'=>'<i class="entypo-doc-text"></i>')),array('class' => 'btn btn-danger', 'type'=>'button','onclick'=>'printLaporan(\'EXCEL\')'));
                ?>
            </div>
            <div style="float:left;">
                <?php
                //                    $content = $this->renderPartial('tips',array(),true);
                //            $this->widget('TipsMasterData',array('type'=>'transaksi','content'=>$content)); 
                ?>
            </div>
        </div>-->
        </div>
    </div>
</div>
<script>
    function printLaporan(params) {
        var obj_selected = $('#menu_laporan').find("a[class$='selected']");
        if (obj_selected.length > 0) {
            window.open($(obj_selected).attr('href') + "&" + $('#search-form').serialize() + "&caraPrint=" + params, "", 'location=_new, width=900px, scrollbars=yes');
        } else {
            myAlert('Silakan pilih laporan terlebih dahulu!');
        }
        return false;
    }

    function autoPeriode(obj) {
        $.ajax({
            dataType: "json",
            data: {
                periode: $(obj).val()
            },
            url: "<?php echo Yii::app()->createAbsoluteUrl(Yii::app()->controller->module->id . '/' . Yii::app()->controller->id . '/getPeriodeLaporan'); ?>",
            success: function(data) {
                $('#tgl_awal').val(data.tgl_awal);
                $('#tgl_akhir').val(data.tgl_akhir);
            }
        });
    }

    function linkSelect(obj) {
        Dialog = 'Dialog';
        $(obj).parents('#menu_laporan').find("a[class$='selected']").each(
            function() {
                $(this).removeClass('selected');
            }
        );
        $(obj).addClass('selected');
        printLaporan(Dialog);
    }

    function setAttributes() {
        $('#menu_laporan').find("div[class$='dashboard']").each(
            function() {
                if ($(this).attr('id') == 'satu') {
                    $(this).find("a").each(
                        function() {
                            $(this).attr('class', 'shortcut3 rl_satu');
                            $(this).attr('onClick', 'linkSelect(this);return false;');
                        }
                    );
                }
                if ($(this).attr('id') == 'dua') {
                    $(this).find("a").each(
                        function() {
                            $(this).attr('class', 'shortcut3 rl_dua');
                            $(this).attr('onClick', 'linkSelect(this);return false;');
                        }
                    );
                }
                if ($(this).attr('id') == 'tiga') {
                    $(this).find("a").each(
                        function() {
                            $(this).attr('class', 'shortcut3 rl_tiga');
                            $(this).attr('onClick', 'linkSelect(this);return false;');
                        }
                    );
                }
                if ($(this).attr('id') == 'empat') {
                    $(this).find("a").each(
                        function() {
                            $(this).attr('class', 'shortcut3 rl_empat');
                            $(this).attr('onClick', 'linkSelect(this);return false;');
                        }
                    );
                }
                if ($(this).attr('id') == 'lima') {
                    $(this).find("a").each(
                        function() {
                            $(this).attr('class', 'shortcut3 rl_lima');
                            $(this).attr('onClick', 'linkSelect(this);return false;');
                        }
                    );
                }
            }
        );
    }
    setAttributes();
</script>
<?php $this->renderPartial('_jsFunctions', array('model' => $model)); ?>