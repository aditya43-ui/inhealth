<?php
include('Barcode.php');

class MyBarcodeAction extends CAction
{
    public $canvasWidth = 50;
    public $canvasHeight = 80;
    //public $font = './NOTTB___.TTF';
    public $font = '';
    public $fontSize = 16;   // GD1 in px ; GD2 in point
    public $marge = 5;   // between barcode and hri in pixel
    public $height = 30;   // barcode height in 1D ; module size in 2D
    public $width = 2;    // barcode height in 1D ; not use in 2D
    public $angle = 0;   // rotation in degrees : nb : non horizontable barcode might not be usable because of pixelisation
    public $code = ''; // barcode, of course ;)
    public $is_text = ''; // is_text, of course ;)
    public $type = 'code128';

    protected function drawCross($im, $color, $x, $y)
    {
        imageline($im, $x - 10, $y, $x + 10, $y, $color);
        imageline($im, $x, $y- 10, $x, $y + 10, $color);
    }

    protected function drawBorder($im, $color, $widthCanvas, $heightCanvas,$i)
    {
        imageline($im, 0, 0, $widthCanvas, 0, $color);
        imageline($im, $widthCanvas-1, 0, $widthCanvas-1, $heightCanvas, $color);
        imageline($im, 0, $heightCanvas-1, $widthCanvas, $heightCanvas-1, $color);
        imageline($im, 0, $heightCanvas, 0, 0, $color);
    }
    
    public function run()
    {
            if(isset($_GET['code']))
                $this->code = $_GET['code'];
            
            if(isset($_GET['is_text']))
                $this->is_text = $_GET['is_text'];
            
            $this->renderImage($this->code);
            Yii::app()->end();
    }
    
    protected function renderImage($code)
    {
            $image  = imagecreatetruecolor($this->canvasWidth, $this->canvasHeight);
            $black  = ImageColorAllocate($image,0x00,0x00,0x00);
            $white  = ImageColorAllocate($image,0xff,0xff,0xff);
            $red    = ImageColorAllocate($image,0xff,0x00,0x00);
            $blue   = ImageColorAllocate($image,0x00,0x00,0xff);
            //$transparent  = imagecolortransparent($image,$white);
            $x      = $this->canvasWidth/2;  // barcode center
            $y      = $this->canvasHeight/2 - 10;  // barcode center

            imagefilledrectangle($image, 0, 0, $this->canvasWidth, $this->canvasHeight, $white);

            $data = Barcode::gd($image, $black, $x, $y, $this->angle, $this->type, array('code'=>$code), $this->width, $this->height);
            
            $this->font = dirname(__FILE__) . '/font/NOTTB___.TTF';
            
            // echo $this->font; die;
            if (!empty($this->font)){
                $box = imagettfbbox($this->fontSize, 0, $this->font, $data['hri']);
                $len = $box[2] - $box[0];
                Barcode::rotate(-$len / 2, ($data['height'] / 2) + $this->fontSize + $this->marge, $this->angle, $xt, $yt);
                if($this->is_text)
                {
                    imagettftext($image, $this->fontSize, $angle, $x + $xt, $y + $yt, $black, $this->font, $data['hri']);
                }
            }

            //$this->drawBorder($image, $black, $this->canvasWidth, $this->canvasHeight,$i);

            header('Content-type: image/png');
            imagegif($image);
            imagedestroy($image);
    }
}
?>
