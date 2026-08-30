<?php
if (file_exists(Params::pathAnatomiTubuhDirectory() . $temp_file) && !empty($temp_file)) {
    $src = Yii::app()->request->baseUrl . '/data/images/anatomi/' . $temp_file;
?>
    <style>
        #imgtag<?= $id ?> {
            position: relative;
            width: 521px !important;
            max-width: none;
            border: 3px solid #ddd;
            cursor: crosshair;
            text-align: center;
            float: none;
            background-repeat: no-repeat;
            background-size: 521px 347.5px;
            background: white;
        }

        #tagit<?= $id ?> {
            position: absolute;
            top: 0;
            left: 0;
            border: 1px solid #D7C7C7;
            z-index: 10;
            border-radius: 15px;
        }

        #tagit<?= $id ?>.name {
            background-color: #FFF;
            width: 295px;
            font-size: 10pt;
            margin: 0 auto;
            margin-bottom: 0 auto;
            border-radius: 15px;
            height: 170px;
        }

        #tagit<?= $id ?>DIV.text {
            margin-bottom: 5px;
        }

        #tagit<?= $id ?>INPUT[type=text] {
            margin-bottom: 5px;
        }

        #tagit<?= $id ?>#tagname<?= $id ?> {
            width: 110px;
        }

        .nomor-list-bagian {
            top: -6px;
            position: relative;
            left: -3px;
            color: white;
            font-weight: bold;
            font-size: 8px;
        }
    </style>
    <div align="center" id="imgtag<?php echo $id ?>">

        <img data-id='<?= $id ?>' img-no="<?php echo $id ?>" alt="<?php echo $id ?>" id="myImgId<?php echo $id ?>" src="<?= $src ?>" class="taggd<?php echo $id ?>" style="width:500px;" onclick='showInputBagian(this);' />
        <div id="tagbox<?php echo $id ?>"></div>

    </div>
<?php } else {
    if (!empty($temp_file)) {
        echo 'gambar tidak ditemukan, silahkan lakukan penyesuaian gambar anatomi tubuh';
    }
} ?>