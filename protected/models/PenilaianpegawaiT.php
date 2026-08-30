<?php

/**
 * This is the model class for table "penilaianpegawai_t".
 *
 * The followings are the available columns in table 'penilaianpegawai_t':
 * @property integer $penilaianpegawai_id
 * @property integer $pegawai_id
 * @property string $tglpenilaian
 * @property string $periodepenilaian
 * @property string $sampaidengan
 * @property integer $kesetiaan
 * @property integer $prestasikerja
 * @property integer $tanggungjawab
 * @property integer $ketaatan
 * @property integer $kejujuran
 * @property integer $kerjasama
 * @property integer $prakarsa
 * @property integer $kepemimpinan
 * @property integer $jumlahpenilaian
 * @property integer $nilairatapenilaian
 * @property double $performanceindex
 * @property string $penilaianpegawai_keterangan
 * @property string $keberatanpegawai
 * @property string $tanggal_keberatanpegawai
 * @property string $tanggapanpejabat
 * @property string $tanggal_tanggapanpejabat
 * @property string $keputusanatasan
 * @property string $tanggal_keputusanatasan
 * @property string $lainlain
 * @property string $dibuattanggalpejabat
 * @property string $diterimatanggalpegawai
 * @property string $diterimatanggalatasan
 * @property string $penilainama
 * @property string $penilainip
 * @property string $penilaipangkatgol
 * @property string $penilaijabatan
 * @property string $penilaiunitorganisasi
 * @property string $pimpinannama
 * @property string $pimpinannip
 * @property string $pimpinanpangkatgol
 * @property string $pimpinanjabatan
 * @property string $pimpinanunitorganisasi
 * @property string $create_time
 * @property string $update_time
 * @property string $create_loginpemakai_id
 * @property string $update_loginpemakai_id
 * @property string $create_ruangan
 */
class PenilaianpegawaiT extends CActiveRecord
{
	public $nama_pegawai;
	public $nilai;
	public $jumlah;
	
	
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenilaianpegawaiT the static model class
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
		return 'penilaianpegawai_t';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('pegawai_id, tglpenilaian', 'required'),
			array('pegawai_id', 'numerical', 'integerOnly'=>true),
			array('nilairatapenilaian','numerical'),
			array('jumlahpenilaian','numerical'),
			array('performanceindex', 'numerical'),
			array('penilainama, pimpinannama, pimpinanpangkatgol, pimpinanjabatan, pimpinanunitorganisasi', 'length', 'max'=>100),
			array('penilainip, penilaipangkatgol, penilaijabatan, penilaiunitorganisasi, pimpinannip', 'length', 'max'=>50),
			array('kategoripegawai, jabatan_id, rekomendasi, catatan, periodepenilaian, sampaidengan, penilaianpegawai_keterangan, keberatanpegawai, tanggal_keberatanpegawai, tanggapanpejabat, tanggal_tanggapanpejabat, keputusanatasan, tanggal_keputusanatasan, lainlain, dibuattanggalpejabat, diterimatanggalpegawai, diterimatanggalatasan, update_time, update_loginpemakai_id', 'safe'),
                        
                        array('create_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'insert'),
                        array('update_time','default','value'=>date( 'Y-m-d H:i:s'),'setOnEmpty'=>false,'on'=>'update,insert'),
                        array('create_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'insert'),
                        array('update_loginpemakai_id','default','value'=>Yii::app()->user->id,'on'=>'update,insert'),
                        array('create_ruangan','default','value'=>Yii::app()->user->getState('ruangan_id'),'on'=>'insert'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penilaianpegawai_id, pegawai_id, tglpenilaian, periodepenilaian, sampaidengan, prestasikerja, tanggungjawab, ketaatan, kejujuran, kerjasama, prakarsa, kepemimpinan, jumlahpenilaian, nilairatapenilaian, performanceindex, penilaianpegawai_keterangan, keberatanpegawai, tanggal_keberatanpegawai, tanggapanpejabat, tanggal_tanggapanpejabat, keputusanatasan, tanggal_keputusanatasan, lainlain, dibuattanggalpejabat, diterimatanggalpegawai, diterimatanggalatasan, penilainama, penilainip, penilaipangkatgol, penilaijabatan, penilaiunitorganisasi, pimpinannama, pimpinannip, pimpinanpangkatgol, pimpinanjabatan, pimpinanunitorganisasi, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, tanggal_approvepemimpin, tanggal_approvepenilai', 'safe', 'on'=>'search'),
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
                                    'pegawai'=>array(self::BELONGS_TO,'PegawaiM','pegawai_id'),
                                    'loginpemakai'=>array(self::BELONGS_TO,'LoginpemakaiK','create_loginpemakai_id'),
                                    'loginpemakaiupdate'=>array(self::BELONGS_TO,'LoginpemakaiK','update_loginpemakai_id'),
                                    'ruangan'=>array(self::BELONGS_TO,'RuanganM','create_ruangan'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penilaianpegawai_id' => 'Penilaian Pegawai',
			'pegawai_id' => 'Pegawai',
			'tglpenilaian' => 'Tanggal Penilaian',
			'periodepenilaian' => 'Periode Penilaian',
			'sampaidengan' => 'Sampai Dengan',
			'prestasikerja' => 'Prestasi Kerja',
			'tanggungjawab' => 'Tanggung Jawab',
			'ketaatan' => 'Ketaatan',
			'kejujuran' => 'Kejujuran',
			'kerjasama' => 'Kerjasama',
			'prakarsa' => 'Prakarsa',
			'kepemimpinan' => 'Kepemimpinan',
			'jumlahpenilaian' => 'Jumlah Penilaian',
			'nilairatapenilaian' => 'Nilai Rata Penilaian',
			'performanceindex' => 'Performance Index',
			'penilaianpegawai_keterangan' => 'Penilaian Pegawai Keterangan',
			'keberatanpegawai' => 'Keberatan Pegawai',
			'tanggal_keberatanpegawai' => 'Tanggal Keberatan Pegawai',
			'tanggapanpejabat' => 'Tanggapan Pejabat',
			'tanggal_tanggapanpejabat' => 'Tanggal Tanggapan Pejabat',
			'keputusanatasan' => 'Keputusan Atasan',
			'tanggal_keputusanatasan' => 'Tanggal Keputusan Atasan',
			'lainlain' => 'Lain Lain',
			'dibuattanggalpejabat' => 'Dibuat Tanggal Pejabat',
			'diterimatanggalpegawai' => 'Diterima Tanggal Pegawai',
			'diterimatanggalatasan' => 'Diterima Tanggal Atasan',
			'penilainama' => 'Penilai Nama',
			'penilainip' => 'NIP Penilai',
			'penilaipangkatgol' => 'Penilai Pangkat Gol',
			'penilaijabatan' => 'Jabatan Penilai',
			'penilaiunitorganisasi' => 'Unit Organisasi Penilai',
			'pimpinannama' => 'Pimpinan Nama',
			'pimpinannip' => 'NIP Pimpinan',
			'pimpinanpangkatgol' => 'Golongan Pangkat Pimpinan',
			'pimpinanjabatan' => 'Jabatan Pimpinan',
			'pimpinanunitorganisasi' => 'Unit Organisasi Pimpinan',
			'create_time' => 'Tanggal dibuat',
			'update_time' => 'Perubahan terakhir',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Ruangan',
			'rekomendasi' => 'Rekomendasi dari hasil penilaian',
			'catatan' => 'Catatan'
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

		$criteria->compare('penilaianpegawai_id',$this->penilaianpegawai_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglpenilaian)',strtolower($this->tglpenilaian),true);
		$criteria->compare('LOWER(periodepenilaian)',strtolower($this->periodepenilaian),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('prestasikerja',$this->prestasikerja);
		$criteria->compare('tanggungjawab',$this->tanggungjawab);
		$criteria->compare('ketaatan',$this->ketaatan);
		$criteria->compare('kejujuran',$this->kejujuran);
		$criteria->compare('kerjasama',$this->kerjasama);
		$criteria->compare('prakarsa',$this->prakarsa);
		$criteria->compare('kepemimpinan',$this->kepemimpinan);
		$criteria->compare('jumlahpenilaian',$this->jumlahpenilaian);
		$criteria->compare('nilairatapenilaian',$this->nilairatapenilaian);
		$criteria->compare('performanceindex',$this->performanceindex);
		$criteria->compare('LOWER(penilaianpegawai_keterangan)',strtolower($this->penilaianpegawai_keterangan),true);
		$criteria->compare('LOWER(keberatanpegawai)',strtolower($this->keberatanpegawai),true);
		$criteria->compare('LOWER(tanggal_keberatanpegawai)',strtolower($this->tanggal_keberatanpegawai),true);
		$criteria->compare('LOWER(tanggapanpejabat)',strtolower($this->tanggapanpejabat),true);
		$criteria->compare('LOWER(tanggal_tanggapanpejabat)',strtolower($this->tanggal_tanggapanpejabat),true);
		$criteria->compare('LOWER(keputusanatasan)',strtolower($this->keputusanatasan),true);
		$criteria->compare('LOWER(tanggal_keputusanatasan)',strtolower($this->tanggal_keputusanatasan),true);
		$criteria->compare('LOWER(lainlain)',strtolower($this->lainlain),true);
		$criteria->compare('LOWER(dibuattanggalpejabat)',strtolower($this->dibuattanggalpejabat),true);
		$criteria->compare('LOWER(diterimatanggalpegawai)',strtolower($this->diterimatanggalpegawai),true);
		$criteria->compare('LOWER(diterimatanggalatasan)',strtolower($this->diterimatanggalatasan),true);
		$criteria->compare('LOWER(penilainama)',strtolower($this->penilainama),true);
		$criteria->compare('LOWER(penilainip)',strtolower($this->penilainip),true);
		$criteria->compare('LOWER(penilaipangkatgol)',strtolower($this->penilaipangkatgol),true);
		$criteria->compare('LOWER(penilaijabatan)',strtolower($this->penilaijabatan),true);
		$criteria->compare('LOWER(penilaiunitorganisasi)',strtolower($this->penilaiunitorganisasi),true);
		$criteria->compare('LOWER(pimpinannama)',strtolower($this->pimpinannama),true);
		$criteria->compare('LOWER(pimpinannip)',strtolower($this->pimpinannip),true);
		$criteria->compare('LOWER(pimpinanpangkatgol)',strtolower($this->pimpinanpangkatgol),true);
		$criteria->compare('LOWER(pimpinanjabatan)',strtolower($this->pimpinanjabatan),true);
		$criteria->compare('LOWER(pimpinanunitorganisasi)',strtolower($this->pimpinanunitorganisasi),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        
        public function searchPrint()
        {
                // Warning: Please modify the following code to remove attributes that
                // should not be searched.

                $criteria=new CDbCriteria;
		$criteria->compare('penilaianpegawai_id',$this->penilaianpegawai_id);
		$criteria->compare('pegawai_id',$this->pegawai_id);
		$criteria->compare('LOWER(tglpenilaian)',strtolower($this->tglpenilaian),true);
		$criteria->compare('LOWER(periodepenilaian)',strtolower($this->periodepenilaian),true);
		$criteria->compare('LOWER(sampaidengan)',strtolower($this->sampaidengan),true);
		$criteria->compare('prestasikerja',$this->prestasikerja);
		$criteria->compare('tanggungjawab',$this->tanggungjawab);
		$criteria->compare('ketaatan',$this->ketaatan);
		$criteria->compare('kejujuran',$this->kejujuran);
		$criteria->compare('kerjasama',$this->kerjasama);
		$criteria->compare('prakarsa',$this->prakarsa);
		$criteria->compare('kepemimpinan',$this->kepemimpinan);
		$criteria->compare('jumlahpenilaian',$this->jumlahpenilaian);
		$criteria->compare('nilairatapenilaian',$this->nilairatapenilaian);
		$criteria->compare('performanceindex',$this->performanceindex);
		$criteria->compare('LOWER(penilaianpegawai_keterangan)',strtolower($this->penilaianpegawai_keterangan),true);
		$criteria->compare('LOWER(keberatanpegawai)',strtolower($this->keberatanpegawai),true);
		$criteria->compare('LOWER(tanggal_keberatanpegawai)',strtolower($this->tanggal_keberatanpegawai),true);
		$criteria->compare('LOWER(tanggapanpejabat)',strtolower($this->tanggapanpejabat),true);
		$criteria->compare('LOWER(tanggal_tanggapanpejabat)',strtolower($this->tanggal_tanggapanpejabat),true);
		$criteria->compare('LOWER(keputusanatasan)',strtolower($this->keputusanatasan),true);
		$criteria->compare('LOWER(tanggal_keputusanatasan)',strtolower($this->tanggal_keputusanatasan),true);
		$criteria->compare('LOWER(lainlain)',strtolower($this->lainlain),true);
		$criteria->compare('LOWER(dibuattanggalpejabat)',strtolower($this->dibuattanggalpejabat),true);
		$criteria->compare('LOWER(diterimatanggalpegawai)',strtolower($this->diterimatanggalpegawai),true);
		$criteria->compare('LOWER(diterimatanggalatasan)',strtolower($this->diterimatanggalatasan),true);
		$criteria->compare('LOWER(penilainama)',strtolower($this->penilainama),true);
		$criteria->compare('LOWER(penilainip)',strtolower($this->penilainip),true);
		$criteria->compare('LOWER(penilaipangkatgol)',strtolower($this->penilaipangkatgol),true);
		$criteria->compare('LOWER(penilaijabatan)',strtolower($this->penilaijabatan),true);
		$criteria->compare('LOWER(penilaiunitorganisasi)',strtolower($this->penilaiunitorganisasi),true);
		$criteria->compare('LOWER(pimpinannama)',strtolower($this->pimpinannama),true);
		$criteria->compare('LOWER(pimpinannip)',strtolower($this->pimpinannip),true);
		$criteria->compare('LOWER(pimpinanpangkatgol)',strtolower($this->pimpinanpangkatgol),true);
		$criteria->compare('LOWER(pimpinanjabatan)',strtolower($this->pimpinanjabatan),true);
		$criteria->compare('LOWER(pimpinanunitorganisasi)',strtolower($this->pimpinanunitorganisasi),true);
		$criteria->compare('LOWER(create_time)',strtolower($this->create_time),true);
		$criteria->compare('LOWER(update_time)',strtolower($this->update_time),true);
		$criteria->compare('LOWER(create_loginpemakai_id)',strtolower($this->create_loginpemakai_id),true);
		$criteria->compare('LOWER(update_loginpemakai_id)',strtolower($this->update_loginpemakai_id),true);
		$criteria->compare('LOWER(create_ruangan)',strtolower($this->create_ruangan),true);
                // Klo limit lebih kecil dari nol itu berarti ga ada limit 
                $criteria->limit=-1; 

                return new CActiveDataProvider($this, array(
                        'criteria'=>$criteria,
                        'pagination'=>false,
                ));
        }
        
	public function searchInformasi()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                                $criteria->with = 'pegawai';
//		$criteria->compare('tglpenilaian',$this->tglpenilaian);
                                $criteria->compare('LOWER(nama_pegawai)',strtolower($this->nama_pegawai),true);
		$criteria->addBetweenCondition('periodepenilaian',$this->periodepenilaian,$this->sampaidengan);
		$criteria->addBetweenCondition('sampaidengan',$this->periodepenilaian,$this->sampaidengan);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
        
        protected function beforeValidate ()
        {
            // convert to storage format
            //$this->tglrevisimodul = date ('Y-m-d', strtotime($this->tglrevisimodul));
            $format = new MyFormatter();
            //$this->tglrevisimodul = $format->formatDateTimeForDb($this->tglrevisimodul);
            foreach($this->metadata->tableSchema->columns as $columnName => $column){
                    if ($column->dbType == 'date')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
                    else if ( $column->dbType == 'timestamp without time zone')
                        {
                            $this->$columnName = $format->formatDateTimeForDb($this->$columnName);
                        }
            }

            return parent::beforeValidate ();
        }

        public function beforeSave() {         
            if($this->tglpenilaian===null || trim($this->tglpenilaian)==''){
	        $this->setAttribute('tglpenilaian', null);
            }
            if($this->periodepenilaian===null || trim($this->periodepenilaian)==''){
	        $this->setAttribute('periodepenilaian', null);
            }
            if($this->sampaidengan===null || trim($this->sampaidengan)==''){
	        $this->setAttribute('sampaidengan', null);
            }
            if($this->tanggal_keberatanpegawai===null || trim($this->tanggal_keberatanpegawai)==''){
	        $this->setAttribute('tanggal_keberatanpegawai', null);
            }
            if($this->tanggal_keputusanatasan===null || trim($this->tanggal_keputusanatasan)==''){
	        $this->setAttribute('tanggal_keputusanatasan', null);
            }
            if($this->tanggal_tanggapanpejabat===null || trim($this->tanggal_tanggapanpejabat)==''){
	        $this->setAttribute('tanggal_tanggapanpejabat', null);
            }
            if($this->dibuattanggalpejabat===null || trim($this->dibuattanggalpejabat)==''){
	        $this->setAttribute('dibuattanggalpejabat', null);
            }
            if($this->diterimatanggalatasan===null || trim($this->diterimatanggalatasan)==''){
	        $this->setAttribute('diterimatanggalatasan', null);
            }
            if($this->diterimatanggalpegawai===null || trim($this->diterimatanggalpegawai)==''){
	        $this->setAttribute('diterimatanggalpegawai', null);
            }
            return parent::beforeSave();
        }

        protected function afterFind(){
            foreach($this->metadata->tableSchema->columns as $columnName => $column){

                if (!strlen($this->$columnName)) continue;

                if ($column->dbType == 'date'){                         
                        $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd'),'medium',null);
                        }elseif ($column->dbType == 'timestamp without time zone'){
                                $this->$columnName = Yii::app()->dateFormatter->formatDateTime(
                                        CDateTimeParser::parse($this->$columnName, 'yyyy-MM-dd hh:mm:ss'));
                        }
            }
            return true;
        }
		
		/**
		 * - digunakan untuk menampilkan data
		 * @param type $penilaianpegawai_id
		 * @return string
		 */
		public function getAspekPenilaian($penilaianpegawai_id,$st = ''){
			$dt = '';
			
			$cri = new CDbCriteria();
			$cri->select = "t.jenispenilaian_id, j.jenispenilaian_nama, sum(penilaianpegdet_socre) as nilai, count(j.jenispenilaian_id) as jumlah ";
			$cri->join = " JOIN jenispenilaian_m j ON j.jenispenilaian_id = t.jenispenilaian_id ";
			$cri->addCondition(" penilaianpegawai_id = '".$penilaianpegawai_id."' ");
			$cri->group = " j.jenispenilaian_nama, t.jenispenilaian_id";
			$det = PenilaianpegawaidetT::model()->findAll($cri);
						
			$dt .= '<ul>';
			foreach ($det as $get){
				$dt .= '<li>'.$get->jenispenilaian_nama.'</li>'; //.'('.floor($get->nilai/$get->jumlah).')</li>';
			}
			$dt .= '</ul>';
		
			return $dt;
		}
}