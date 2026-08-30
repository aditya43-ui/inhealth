<?php

/**
 * This is the model class for table "laporankebutuhankalibrasi_v".
 *
 * The followings are the available columns in table 'laporankebutuhankalibrasi_v':
 * @property integer $barang_id
 * @property string $barang_nama
 * @property integer $lokasi_id
 * @property string $lokasiaset_namalokasi
 * @property integer $ruangan_id
 * @property string $ruangan_nama
 * @property integer $gedung_id
 * @property string $gedung_nama
 * @property double $tahun_perolehan
 * @property string $sumberdana
 * @property string $jumlah
 */
class LaporankebutuhankalibrasiV extends CActiveRecord
{
        public $no, $tgl_awal, $tgl_akhir, $tipe;
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return LaporankebutuhankalibrasiV the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'laporankebutuhankalibrasi_v';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('barang_id, lokasi_id, ruangan_id, gedung_id', 'numerical', 'integerOnly'=>true),
			array('tahun_perolehan', 'numerical'),
			array('barang_nama, lokasiaset_namalokasi, gedung_nama', 'length', 'max'=>100),
			array('ruangan_nama, sumberdana', 'length', 'max'=>50),
			array('jumlah', 'safe'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('barang_id, barang_nama, lokasi_id, lokasiaset_namalokasi, ruangan_id, ruangan_nama, gedung_id, gedung_nama, tahun_perolehan, sumberdana, jumlah', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'barang_id' => 'Barang',
			'barang_nama' => 'Barang Nama',
			'lokasi_id' => 'Lokasi',
			'lokasiaset_namalokasi' => 'Lokasiaset Namalokasi',
			'ruangan_id' => 'Ruangan',
			'ruangan_nama' => 'Ruangan Nama',
			'gedung_id' => 'Gedung',
			'gedung_nama' => 'Gedung Nama',
			'tahun_perolehan' => 'Tahun Perolehan',
			'sumberdana' => 'Sumberdana',
			'jumlah' => 'Jumlah',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 * @return CActiveDataProvider the data provider that can return the models based on the search/filter conditions.
	 */
	public function search()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;
                $criteria->select = [
                    'barang_nama',
                    'sumberdana',
                    'tahun_perolehan',
                    'sum(jumlah)as jumlah',                    
                ];
                $criteria->group = 'barang_nama, sumberdana, tahun_perolehan';
		$criteria->compare('barang_id',$this->barang_id);		
		$criteria->compare('lokasi_id',$this->lokasi_id);		
		$criteria->compare('ruangan_id',$this->ruangan_id);		
		$criteria->compare('gedung_id',$this->gedung_id);
                $criteria->addCondition('tahun_perolehan < '.$this->tahun_perolehan);
                $criteria->compare('sumberdana',$this->sumberdana);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        public function getTotal($init){
            $criteria = $this->search();       
            $criteria->criteria->group = null;
            $criteria->criteria->select = [
                'sum('.$init.')as '.$init
            ];
            
            $load = self::model()->find($criteria->criteria);           

            return $load->jumlah;
        }

        public function loadGrafik(){
            $tipe = $this->tipe;
            $load_set = $this->search();
            $load_set->criteria->group = 'sumberdana';            
            $load_set->criteria->select = [
                'sum(jumlah) as jumlah',
                'sumberdana',                       
            ];
            $load_set->criteria->order = "jumlah DESC";

            $load = $load_set->getData();
            $grafik = [];

            if (!empty($load)){
                if ($tipe != 'pie'){
                    $grafik['labels'] = [
                      '','Data',''  
                    ];
                    foreach($load as $i => $det){
                    
                        $grafik['datasets'][$i]['data'] = [
                            'NaN',$det->jumlah,'Nan'
                        ];                
                        $grafik['datasets'][$i]['backgroundColor'] = $this->setColor($i); 
                        $grafik['datasets'][$i]['label'] = $det->sumberdana;                           
                    }
                }else{                     
                    foreach($load as $i => $det){
                        $grafik['labels'][] = $det->sumberdana;
                        $grafik['datasets'][0]['data'][] = $det->jumlah;
                        $grafik['datasets'][0]['backgroundColor'][] = $this->setColor($i);
                    }                                                                                                                        
                }       
            }

            return $grafik;
        }
        
        public function setColor($i){
            $color = [
                '#01b8aa',//ijo
                '#c49e6d',//orange
                '#fd625e',//pink
                '#eed771',//gold
                '#8bd4eb',//blue sky,
                '#f09293',//pink terang
                '#31ce3c',//hijau gelap
                '#a0994e',//coklat
                '#96bf3f',//kuning kehijaun
                '#d1c8c8',//menuju putih
            ];
            return isset($color[$i])?$color[$i]:'red';
        }
}