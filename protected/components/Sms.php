<?php 

	class Sms	{

        var $pesantersimpan = true;
        var $pesanotomatistersimpan = true;

        function __construct()
        {
            $this->pesantersimpan = true;
            $this->pesanotomatistersimpan = true;
        }

		private function getRandomHex() {
	        $possibilities = array(1, 2, 3, 4, 5, 6, 7, 8, 9, "A", "B", "C", "D", "E", "F" );
	        shuffle($possibilities);
	        $hex = "";
	        for($i=1;$i<=8;$i++){
	            $hex .= $possibilities[rand(0,14)];
	        }
	        return $hex;
	    }

        private function get2RandomHex() {
            $possibilities = array(1, 2, 3, 4, 5, 6, 7, 8, 9, "A", "B", "C", "D", "E", "F" );
            shuffle($possibilities);
            $hex = "";
            for($i=1;$i<=2;$i++){
                $hex .= $possibilities[rand(0,14)];
            }
            return $hex;
	}
            
            
        /**
         * Digunakan untuk mengirim pesan
         * @param type $notujuans = array() , @pesan = text
         * @return type
         */
	    function kirim($no_tujuans,$pesan){
            $issmsgateway = Yii::app()->user->getState('issmsgateway');
            if($issmsgateway){
                $pesan = str_split(isset($pesan)?$pesan:'', 153);
                
                // var_dump($pesan);
                
                $jumlah_part = count($pesan);
                $id = null;
                $udh = '';
                $hex_number = '';
                if(is_array($no_tujuans)){
                    foreach ($no_tujuans as $i => $nomor) {
                        $hex_number = $this->get2RandomHex();
                        foreach ($pesan as $j => $psn) {
                            $udh = "050003".$hex_number.str_pad($jumlah_part, 2, "0", STR_PAD_LEFT).str_pad($j+1, 2, "0", STR_PAD_LEFT);
                            if(count($pesan)<=1){
                                $udh = '';
                            }
                            if($j==0){
                                $model = new Outbox;
                                $model->DestinationNumber = $nomor;
                                $model->UDH = $udh;
                                $model->TextDecoded = $psn;
                                $model->MultiPart = ($jumlah_part>1)?'true':'false';
                                $model->CreatorID = Yii::app()->user->id;
                                if($model->save()){
                                $this->pesantersimpan &= true;
                                $id = $model->ID;
                                }else{
                                    $this->pesantersimpan &= false;
                                }
                            }else{
                                $modMultiPart = new OutboxMultipart;
                                $modMultiPart->UDH = $udh;
                                $modMultiPart->TextDecoded = $psn;
                                $modMultiPart->ID = $id;
                                $modMultiPart->SequencePosition = $j+1;
                                if($modMultiPart->save()){
                                    $this->pesantersimpan &= true;
                                }else{
                                    $this->pesantersimpan &= false;
                                }
                            }

                        }
                    }
                }else{
                    $hex_number = $this->get2RandomHex();
                    foreach ($pesan as $j => $psn) {
                        $udh = "050003".$hex_number.str_pad($jumlah_part, 2, "0", STR_PAD_LEFT).str_pad($j+1, 2, "0", STR_PAD_LEFT);
                        // var_dump($udh);
                        if(count($pesan)<=1){
                            $udh = '';
                        }
                        if($j==0){
                            $model = new Outbox;
                            $model->DestinationNumber = $no_tujuans;
                            $model->UDH = $udh;
                            $model->TextDecoded = $psn;
                            $model->MultiPart = ($jumlah_part>1)?true:false;
                            $model->CreatorID = Yii::app()->user->id;
                            if($model->save()){
                            $this->pesantersimpan &= true;
                            $id = $model->ID;
                            // var_dump($model->attributes);
                            }else{
                                $this->pesantersimpan &= false;
                            }
                        }else{
                            $modMultiPart = new OutboxMultipart;
                            $modMultiPart->UDH = $udh;
                            $modMultiPart->TextDecoded = $psn;
                            $modMultiPart->ID = $id;
                            $modMultiPart->SequencePosition = $j+1;
                            // var_dump($modMultiPart->attributes);
                            if($modMultiPart->save()){
                                $this->pesantersimpan &= true;
                            }else{
                                $this->pesantersimpan &= false;
                            }
                        }
                    }
                }
                return $this->pesantersimpan;
    	    }else{
                return true;
            }
        }


        /**
         * Digunakan untuk mengirim pesan
         * @param type $notujuans = array() , @pesan = text
         * @return type
         */
        function kirimOtomatis($no_tujuans,$pesan){
                $pesan = str_split(isset($pesan)?$pesan:'', 153);
                $jumlah_part = count($pesan);
                $id = null;
                $udh = '';
                $hex_number = '';
                if(is_array($no_tujuans)){
                    foreach ($no_tujuans as $i => $nomor) {
                        $hex_number = $this->getRandomHex();
                        foreach ($pesan as $j => $psn) {
                            $udh = $hex_number.str_pad($jumlah_part, 2, "0", STR_PAD_LEFT).str_pad($j+1, 2, "0", STR_PAD_LEFT);
                            if(count($pesan)<=1){
                                $udh = '';
                            }
                            if($j==0){
                                $model = new Outbox;
                                $model->DestinationNumber = $nomor;
                                $model->UDH = $udh;
                                $model->TextDecoded = $psn;
                                $model->MultiPart = ($jumlah_part>1)?'true':'false';
                                $model->CreatorID = 'Otomatis';
                                if($model->save()){
                                $this->pesanotomatistersimpan &= true;
                                $id = $model->ID;
                                }else{
                                    $this->pesanotomatistersimpan &= false;
                                }
                            }else{
                                $modMultiPart = new OutboxMultipart;
                                $modMultiPart->UDH = $udh;
                                $modMultiPart->TextDecoded = $psn;
                                $modMultiPart->ID = $id;
                                $modMultiPart->SequencePosition = $j+1;
                                if($modMultiPart->save()){
                                    $this->pesanotomatistersimpan &= true;
                                }else{
                                    $this->pesanotomatistersimpan &= false;
                                }
                            }

                        }
                    }
                }else{
                    $hex_number = $this->getRandomHex();
                    foreach ($pesan as $j => $psn) {
                        $udh = $hex_number.str_pad($jumlah_part, 2, "0", STR_PAD_LEFT).str_pad($j+1, 2, "0", STR_PAD_LEFT);
                        if(count($pesan)<=1){
                            $udh = '';
                        }
                        if($j==0){
                            $model = new Outbox;
                            $model->DestinationNumber = $no_tujuans;
                            $model->UDH = $udh;
                            $model->TextDecoded = $psn;
                            $model->MultiPart = ($jumlah_part>1)?'true':'false';
                            $model->CreatorID = 'Otomatis';
                            if($model->save()){
                            $this->pesanotomatistersimpan &= true;
                            $id = $model->ID;
                            }else{
                                $this->pesanotomatistersimpan &= false;
                            }
                        }else{
                            $modMultiPart = new OutboxMultipart;
                            $modMultiPart->UDH = $udh;
                            $modMultiPart->TextDecoded = $psn;
                            $modMultiPart->ID = $id;
                            $modMultiPart->SequencePosition = $j+1;
                            if($modMultiPart->save()){
                                $this->pesanotomatistersimpan &= true;
                            }else{
                                $this->pesanotomatistersimpan &= false;
                            }
                        }
                    }
                }
                return $this->pesanotomatistersimpan;
        }

	}
?>