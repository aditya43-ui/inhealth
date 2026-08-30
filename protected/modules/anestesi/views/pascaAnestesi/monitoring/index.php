<?php
/**
 * view ini digunakan untuk menampilkan semua form pada menu transaksi peminjaman barang
 * 
 * @author      M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
 * @version     2.0.0
 * @link      <http://piindonesia.co.id>
 * @link      <http://172.9.1.15/simpp/docs/>
 */
$this->widget('bootstrap.widgets.BootAlert');

$form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
    'id' => 'monitoringpasca-anestesi',
    'enableAjaxValidation' => false,
    'type' => 'horizontal',
    'htmlOptions' => array(
        'class' => 'form-horizontal',
        'enctype' => 'multipart/form-data',
        'onKeyPress' => 'return disableKeyPress(event)'
    ),
        //'focus' => '#'.CHtml::activeId($model, 'tgl_publikasi').'',
        ));
?>
<style>
    .control-label{
        /**text-align:left !important;
        vertical-align: top !important;**/
    }        

    .form-wizard > ul > li.active a span{
        background: #0066cc;        
    }

    .form-wizard > ul > li.active a{        
        color: #0066cc;
    }

    .form-wizard > ul > li a span{
        color:#333;
    }

    .form-wizard > ul > li a{        
        color:#333;
    }

    li.next > a, li.previous > a{
        border:1px solid #333;
        border-radius: 70%; 
        background: #333;
        color:#fff; 
        padding:0px;

    }        

    li.next > a:hover, li.previous > a:hover{
        border:1px solid #333;
        border-radius: 70%; 
        background: #333;
        color:#fff; 
        padding:0px;

    }   

    li.next > a > span, li.previous > a > span{
        font-size: 30px;
    }

    .tab-content > .tab-pane > .col-sm-2, .tab-content > .tab-pane > .col-sm-10{
        padding:2px;
    }
</style>
<p>&nbsp;</p>

<?php echo $this->renderPartial($this->path_view . 'form/_formAwal', array('model' => $model), true); ?>   

<div class="clear"></div>        

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Data Monitoring Pasca Anestesi / Sedasi
        </div>
    </div>
    <div class="panel-body" id="form-tambah-monitoring">
        <?php echo $this->renderPartial($this->path_view . 'form/_formMonitoring', array('model' => $model), true); ?>   

        <div class="clear"></div>

        <div class="control-group">
            <label class="control-label">
                <?php
                echo CHtml::htmlButton($model->isNewRecord ? Yii::t('mds', '{icon} Tambah', array('{icon}' => '<i class="' . MyIcon::getIcons('tambah-baris') . '"></i>')) :
                                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')), array('class' => (isset($_GET['sukses'])) ? 'btn btn-primary' : 'btn btn-primary', 'type' => 'button', 'onclick' => 'tambahDataMonitor();'));
                ?>
            </label>           
        </div>
    </div>        
</div>

<div class="clear"></div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Tabel Monitoring Pasca Anestesi / Sedasi
        </div>
    </div>
    <div class="panel-body">
        <table class="table table-bordered table-condensed table-striped" id="tabel-monitoring">
            <thead>
            <th>Menit Monitoring</th>
            <th>Temperatur</th>
            <th>Respiration Rate</th>
            <th>Nadi</th>
            <th>Sistolik</th>
            <th>Diastolik</th>
            <th>Ubah</th>
            <th>Hapus</th>
            </thead>
            <tbody>
                <?php
                if (!empty($loadDet)) {
                    foreach ($loadDet as $i => $det) {
                        echo $this->renderPartial($this->path_view . 'form/_rowMonitoring', array('model' => $det, 'i' => $i));
                    }
                }
                ?>
            </tbody>
        </table>

        <table id="tabel-hapus" class="hide">
            <tbody>

            </tbody>
        </table>
    </div>        
</div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Grafik Monitoring Pasca Anestesi / Sedasi
        </div>        
    </div>
    <div class="panel-body">
        <div class="row-fluid">
            <?php echo $this->renderPartial($this->path_view . 'form/_formGrafik', array('model' => $model), true); ?>   
        </div>   
    </div>
</div>

<div class="clear"></div>

<div class="panel panel-success">
    <div class="panel-heading">
        <div class="panel-title">
            Catatan
        </div>
    </div>
    <div class="panel-body">
        <?php echo $this->renderPartial($this->path_view . 'form/_formCatatan', array('model' => $model), true); ?>   
    </div>
</div>

<div class="clear"></div>
<?php echo $this->renderPartial($this->path_view . '_button', array('model' => $model), true); ?>
<?php echo $this->renderPartial($this->path_view . '_dialog', array('model' => $model), true); ?>
<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array('model' => $model), true); ?>       

<?php $this->endWidget(); ?>   
<script src="themes/neon/assets/js/jquery.bootstrap.wizard.min.js"></script>

