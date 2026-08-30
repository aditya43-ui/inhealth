<?php $linkHalaman = CustomFunction::getUrlByMenuID(2511); ?>
<div class="panel panel-gradient">
    <div class="panel-heading">
        <div class="panel-title">
            <i class="far fa-hdd"></i> Transaksi <b>Penerimaan Linen</b>
            <span class="pull-right">
                <a href="<?= !empty($linkHalaman) ? $linkHalaman : '#'; ?>" class="btn btn-default" target="_blank">
                    <i class="fas fa-external-link-alt"></i> Ke Halaman Informasi
                </a>
            </span>
        </div>
    </div>
    <div class="panel-body">
        <?php
        $this->breadcrumbs = array(
            'Transaksi Penerimaan Linen' => array('index'),
        );

        ?>
        <?php
        if (!empty($_GET['sukses'])) {
        ?>
            <?php echo Yii::app()->user->setFlash('success', "Data Penerimaan Linen berhasil disimpan!");
            $this->widget('bootstrap.widgets.BootAlert'); ?>
        <?php } ?>
        <?php $form = $this->beginWidget('ext.bootstrap.widgets.BootActiveForm', array(
            'id' => 'lapenerimaanlinen-t-form',
            'enableAjaxValidation' => false,
            'type' => 'horizontal',
            'htmlOptions' => array('onKeyPress' => 'return disableKeyPress(event)', 'onsubmit' => 'return requiredCheck(this);unformatNumbers();'),
            'focus' => '#',
        )); ?>

        <!--<p class="help-block"><?php // echo Yii::t('mds','Fields with <span class="required">*</span> are required.') 
                                    ?></p>-->

        <?php echo $form->errorSummary($model); ?>
        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="glyphicon glyphicon-file"></i> Data <b>Penerimaan</b>
                </div>
            </div>
            <div class="panel-body">
                <?php echo $this->renderPartial($this->path_view . '_formPenerimaan', array(
                    'model' => $model, 'form' => $form, 'format' => $format
                )); ?>
            </div>
        </div>

        <div class="panel panel-success">
            <div class="panel-heading">
                <div class="panel-title">
                    <i class="entypo-credit-card"></i> Linen
                </div>
            </div>
            <div class="panel-body table-responsive">
                <?php $this->renderPartial($this->path_view . '_tabelLinen', array('model' => $model, 'form' => $form, 'modPengajuanDetail' => $modPengajuanDetail, 'form' => $form, 'modPengajuan' => $modPengajuan)); ?>
            </div>
        </div>
        <!--RND-8869	
		<fieldset class="box">
			<legend class="rim">Linen</legend>
			<?php // $this->renderPartial($this->path_view.'_formLinen', array('model'=>$model, 'form'=>$form,)); 
            ?>		
		</fieldset>

		<?php // echo CHtml::css('#table-linen thead tr th{vertical-align:middle;}'); 
        ?>

		<table class="table table-striped table-condensed" id="table-linen">
			<thead>
				<tr>
					<th>No. </th>
					<th>No. Register Linen</th>
					<th>Nama Barang</th>
					<th>Jenis Perawatan</th>
					<th>Keterangan</th>
					<th>Batal</th>
				</tr>
			</thead>
			<tbody>
			</tbody>
		</table>-->
        <div class="form-actions">
            <?php
            $sukses = isset($_GET['sukses']) ? $_GET['sukses'] : null;
            $disableSave = false;
            $disableSave = (!empty($_GET['sukses'])) ? true : (($sukses > 0) ? true : false);
            ?>
            <?php $disablePrint = ($disableSave) ? false : true; ?>
            <?php echo CHtml::htmlButton(
                Yii::t('mds', '{icon} Save', array('{icon}' => '<i class="entypo-check"></i>')),
                array('title' => 'Simpan', 'class' => 'btn btn-danger', 'type' => 'submit', 'disabled' => $disableSave)
            ); ?>
            <?php echo CHtml::link(
                Yii::t('mds', '{icon} Reset', array('{icon}' => '<i class="entypo-arrows-ccw"></i>')),
                $this->createUrl('index'),
                array('title' => 'Ulang', 'class' => 'btn btn-default', 'onclick' => 'if(!confirm("' . Yii::t('mds', 'Apakah Anda akan mengulang input data ?') . '")) return false;')
            ); ?>
            <?php echo CHtml::link(Yii::t('mds', '{icon} Print', array('{icon}' => '<i class="entypo-print"></i>')), 'javascript:void(0);', array('class' => 'btn btn-info', 'onclick' => "print('PRINT')", 'disabled' => $disablePrint)); ?>
            <?php $content = $this->renderPartial($this->path_view . 'tips/transaksi1', array(), true);
            $this->widget('UserTips', array('type' => 'transaksi', 'content' => $content)); ?>
        </div>
    </div>
</div>

<?php $this->endWidget(); ?>
<script type="text/javascript">
    function print(caraPrint) {
        var penerimaanlinen_id = '<?php echo $model->penerimaanlinen_id; ?>';
        window.open('<?php echo $this->createUrl('print'); ?>&penerimaanlinen_id=' + penerimaanlinen_id + '&caraPrint=' + caraPrint, 'printwin', 'left=100,top=100,width=1000,height=640');
    }

    function unformatNumbers() {
        $('.integer').each(function() {
            this.value = unformatNumber(this.value)
        });
    }
</script>

<?php echo $this->renderPartial($this->path_view . '_jsFunctions', array(), true); ?>