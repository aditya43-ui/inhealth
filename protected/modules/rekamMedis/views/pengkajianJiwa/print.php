<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/entypo/css/entypo.css">        
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/themes/neon/assets/css/font-icons/font-awesome/css/font-awesome.css">
<link rel="stylesheet" type="text/css" href="<?php echo Yii::app()->request->baseUrl; ?>/css/_print_triase.css">

<style>
    .radio_d {
        display: inline-block;
        width: 150px;
        vertical-align: top;
    }
    
    .mo_erm {
        text-align: right;
        font-weight:  bold;
    }
    
</style>
<?php
$ceklis = '<span class="fa fa-check-square-o"></span>';
$unceklis = '<span class="fa fa-square-o"></span>';
$pasien = $pendaftaran->pasien;
?>

<table class="tab_page">
    <tr>
        <td>
            <div class="mo_erm">FRM/12/RSBM</div>
            <?php echo $this->renderPartial($this->path_view."printHalaman._hal1a", array(
                'pendaftaran'=>$pendaftaran, 'model'=>$model, 'diagnosa'=>$diagnosa, 'pasien'=>$pasien,
            ), true); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="mo_erm">FRM/12/RSBM</div>
            <?php echo $this->renderPartial($this->path_view."printHalaman._hal1b", array(
                'pendaftaran'=>$pendaftaran, 'model'=>$model, 'diagnosa'=>$diagnosa, 'pasien'=>$pasien,
            ), true); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="mo_erm">FRM/12/RSBM</div>
            <?php echo $this->renderPartial($this->path_view."printHalaman._hal2a", array(
                'pendaftaran'=>$pendaftaran, 'model'=>$model, 'diagnosa'=>$diagnosa, 'pasien'=>$pasien,
            ), true); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="mo_erm">FRM/12/RSBM</div>
            <?php echo $this->renderPartial($this->path_view."printHalaman._hal2b", array(
                'pendaftaran'=>$pendaftaran, 'model'=>$model, 'diagnosa'=>$diagnosa, 'pasien'=>$pasien,
            ), true); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="mo_erm">FRM/12/RSBM</div>
            <?php echo $this->renderPartial($this->path_view."printHalaman._hal3a", array(
                'pendaftaran'=>$pendaftaran, 'model'=>$model, 'diagnosa'=>$diagnosa, 'pasien'=>$pasien,
            ), true); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="mo_erm">FRM/12/RSBM</div>
            <?php echo $this->renderPartial($this->path_view."printHalaman._hal3b", array(
                'pendaftaran'=>$pendaftaran, 'model'=>$model, 'diagnosa'=>$diagnosa, 'pasien'=>$pasien,
            ), true); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="mo_erm">FRM/12/RSBM</div>
            <?php echo $this->renderPartial($this->path_view."printHalaman._hal4a", array(
                'pendaftaran'=>$pendaftaran, 'model'=>$model, 'diagnosa'=>$diagnosa, 'pasien'=>$pasien,
            ), true); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="mo_erm">FRM/12/RSBM</div>
            <?php echo $this->renderPartial($this->path_view."printHalaman._hal4b", array(
                'pendaftaran'=>$pendaftaran, 'model'=>$model, 'diagnosa'=>$diagnosa, 'pasien'=>$pasien,
            ), true); ?>
        </td>
    </tr>
    <tr>
        <td>
            <div class="mo_erm">FRM/12/RSBM</div>
            <?php echo $this->renderPartial($this->path_view."printHalaman._hal5a", array(
                'pendaftaran'=>$pendaftaran, 'model'=>$model, 'diagnosa'=>$diagnosa, 'pasien'=>$pasien,
            ), true); ?>
        </td>
    </tr>
    <tr>
        <td>
            <?php echo $this->renderPartial($this->path_view."printHalaman._hal5b", array(
                'pendaftaran'=>$pendaftaran, 'model'=>$model, 'diagnosa'=>$diagnosa, 'pasien'=>$pasien,
            ), true); ?>
        </td>
    </tr>
</table>




