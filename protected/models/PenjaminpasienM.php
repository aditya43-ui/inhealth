<?php

/**
 * This is the model class for table "penjaminpasien_m".
 *
 * The followings are the available columns in table 'penjaminpasien_m':
 * @property integer $penjamin_id
 * @property integer $carabayar_id
 * @property string $penjamin_nama
 * @property string $penjamin_namalainnya
 * @property boolean $penjamin_aktif
 * @property string $create_time
 * @property string $update_time
 * @property integer $create_loginpemakai_id
 * @property integer $update_loginpemakai_id
 * @property integer $create_ruangan
 * @property double $diskon_tagihan
 * @property double $diskon_klaim
 * @property integer $lama_tempo
 * @property double $biaya_administrasi
 * @property double $diskon_rj
 * @property double $diskon_rd
 * @property double $diskon_ri
 * @property string $kode_cob_inacbg
 * @property string $nama_cob_inacbg
 * @property string $penjamin_cp
 * @property string $penjamin_nomobile
 * @property string $path_logoasuransi
 * @property string $path_gbr_asuransi
 * @property boolean $is_penanggungjwbnaikklsbpjs
 * @property boolean $is_cob
 * @property string $bpjs_kodepenjamin
 * @property string $bpjs_namapenjamin
 *
 */
class PenjaminpasienM extends CActiveRecord
{
	/**
	 * Returns the static model of the specified AR class.
	 * @param string $className active record class name.
	 * @return PenjaminpasienM the static model class
	 */

	public $ispembayaran;
	public $pilih,$nomor_valid;
	public $carabayar_nama;
	public $jenistarif_id;
		 
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}

	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'penjaminpasien_m';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('carabayar_id, penjamin_nama', 'required'),
			array('carabayar_id, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, lama_tempo', 'numerical', 'integerOnly'=>true),
			array('diskon_tagihan, diskon_klaim, biaya_administrasi, diskon_rj, diskon_rd, diskon_ri', 'numerical'),
			array('penjamin_nama', 'length', 'max'=>50),
			array('penjamin_namalainnya', 'length', 'max'=>70),
			array('kode_cob_inacbg, nama_cob_inacbg', 'length', 'max'=>4),
			array('is_penanggungjwbnaikklsbpjs, is_cob, penjamin_aktif, create_time, update_time, penjamin_cp, penjamin_nomobile, path_logoasuransi, path_gbr_asuransi', 'safe'),
			array('bpjs_kodepenjamin, bpjs_namapenjamin', 'safe'),
			//array('lampiranpks', 'file', 'types'=>'pdf'),
			//array('path_logoasuransi', 'file', 'types'=>'jpg, gif, png, pdf'),
			// The following rule is used by search().
			// Please remove those attributes that should not be searched.
			array('penjamin_id, carabayar_id, penjamin_nama, penjamin_namalainnya, penjamin_aktif, create_time, update_time, create_loginpemakai_id, update_loginpemakai_id, create_ruangan, diskon_tagihan, diskon_klaim, lama_tempo, biaya_administrasi, diskon_rj, diskon_rd, diskon_ri, kode_cob_inacbg, nama_cob_inacbg, penjamin_cp, penjamin_nomobile, path_logoasuransi, path_gbr_asuransi', 'safe', 'on'=>'search'),
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
			'carabayar' => array(self::BELONGS_TO, 'CarabayarM', 'carabayar_id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'penjamin_id' => 'Penjamin',
			'carabayar_id' => 'Jenis Penjamin',
			'penjamin_nama' => 'Nama Penjamin',
			'penjamin_namalainnya' => 'Nama lainnya',
			'penjamin_aktif' => '',
			'create_time' => 'Waktu Create',
			'update_time' => 'Waktu Update',
			'create_loginpemakai_id' => 'Create Login Pemakai',
			'update_loginpemakai_id' => 'Update Login Pemakai',
			'create_ruangan' => 'Create Ruangan',
			'diskon_tagihan' => 'Keringanan Tagihan',
			'diskon_klaim' => 'Keringanan Klaim',
			'lama_tempo' => 'Lama Jatuh Tempo',
			'biaya_administrasi' => 'Biaya Administrasi',
			'diskon_rj' => 'Keringanan Rawat Jalan',
			'diskon_rd' => 'Keringanan Rawat Darurat',
			'diskon_ri' => 'Keringanan Rawat Inap',
			'kode_cob_inacbg' => 'Kode Cob Inacbg',
			'nama_cob_inacbg' => 'Nama Cob Inacbg',
			'penjamin_cp' => 'Contact Person',
			'penjamin_nomobile' => 'No Telepon',
			'path_logoasuransi' => 'Upload Logo',
			'path_gbr_asuransi' => 'Path Gbr Asuransi',
			'lampiranpks' => 'Lampiran File PKS',
			'bpjs_kodepenjamin' => 'Kode Penjamin Naik Kelas BPJS',
			'bpjs_namapenjamin' => 'Nama Penjamin Naik Kelas BPJS',
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

		$criteria->compare('penjamin_id',$this->penjamin_id);
		$criteria->compare('carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama),true);
		$criteria->compare('penjamin_namalainnya',$this->penjamin_namalainnya,true);
		$criteria->compare('penjamin_aktif',$this->penjamin_aktif);
		$criteria->compare('create_time',$this->create_time,true);
		$criteria->compare('update_time',$this->update_time,true);
		$criteria->compare('create_loginpemakai_id',$this->create_loginpemakai_id);
		$criteria->compare('update_loginpemakai_id',$this->update_loginpemakai_id);
		$criteria->compare('create_ruangan',$this->create_ruangan);
		$criteria->compare('diskon_tagihan',$this->diskon_tagihan);
		$criteria->compare('diskon_klaim',$this->diskon_klaim);
		$criteria->compare('lama_tempo',$this->lama_tempo);
		$criteria->compare('biaya_administrasi',$this->biaya_administrasi);
		$criteria->compare('diskon_rj',$this->diskon_rj);
		$criteria->compare('diskon_rd',$this->diskon_rd);
		$criteria->compare('diskon_ri',$this->diskon_ri);
		$criteria->compare('kode_cob_inacbg',$this->kode_cob_inacbg,true);
		$criteria->compare('nama_cob_inacbg',$this->nama_cob_inacbg,true);
		$criteria->compare('penjamin_cp',$this->penjamin_cp,true);
		$criteria->compare('penjamin_nomobile',$this->penjamin_nomobile,true);
		$criteria->compare('path_logoasuransi',$this->path_logoasuransi,true);
		$criteria->compare('path_gbr_asuransi',$this->path_gbr_asuransi,true);
		$criteria->compare('lampiranpks', $this->lampiranpks,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	public function searchPrint()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

		$criteria->with=array('carabayar');
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
                $criteria->compare('t.carabayar_id',$this->carabayar_id);
                //$criteria->compare('t.rekeningdebit_id',$this->rekeningdebit_id);
                //$criteria->compare('t.rekeningkredit_id',$this->rekeningkredit_id);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_nama),true);
//                $criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_id),true);
		$criteria->compare('LOWER(t.penjamin_namalainnya)',strtolower($this->penjamin_namalainnya),true);
                $criteria->compare('penjamin_aktif',isset($this->penjamin_aktif)?$this->penjamin_aktif:true);
//		$criteria->compare('penjamin_aktif',$this->penjamin_aktif);
                $criteria->limit=-1;
                $criteria->order='penjamin_id';
//                $criteria->with='carabayar';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
                         'pagination'=>false,
		));
	}
        
         public function getCarabayarItems()
        {
            return CarabayarM::model()->findAll('carabayar_aktif=true ORDER BY carabayar_nama');
        }
        
         public function beforeSave() {
            $this->penjamin_nama = ucwords(strtolower($this->penjamin_nama));
            $this->penjamin_namalainnya = strtoupper($this->penjamin_namalainnya);
            return parent::beforeSave();
        }
        
        public function searchPenjamin()
		{			
			$criteria=new CDbCriteria;

			$criteria->with=array('carabayar');
			$criteria->compare('t.penjamin_id',$this->penjamin_id);
			$criteria->compare('t.carabayar_id',$this->carabayar_id);					
			$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_nama),true);	
			$criteria->compare('LOWER(t.penjamin_namalainnya)',strtolower($this->penjamin_namalainnya),true);
			$criteria->addCondition("penjamin_id not in(select penjamin_id from penjaminrek_m)");
			$criteria->compare('penjamin_aktif',isset($this->penjamin_aktif)?$this->penjamin_aktif:true);
			$criteria->limit=10;
				


			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,

			));
		}
		
		 public function searchRekeningPenjaminPrint()
		{			
			$criteria=new CDbCriteria;

			$criteria->with=array('carabayar');
			$criteria->compare('t.carabayar_id',$this->carabayar_id);					
			$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->addCondition('penjamin_aktif = true');		
			$criteria->limit=-1;

			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria,
				'pagination' => false

			));
		}

		public function searchRekeningPenjamin()
		{			
			$criteria=new CDbCriteria;

			$criteria->with=array('carabayar');
			$criteria->compare('t.carabayar_id',$this->carabayar_id);					
			$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
			$criteria->addCondition('penjamin_aktif = true');		

			return new CActiveDataProvider($this, array(
				'criteria'=>$criteria

			));
		}
    

    public function search_ekios()
	{

		$criteria=new CDbCriteria;

        $criteria->with=array('carabayar');
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
        $criteria->compare('t.carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(t.penjamin_namalainnya)',strtolower($this->penjamin_namalainnya),true);
		$criteria->order = 't.penjamin_id';

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'pagination'=>array(
		      'pageSize'=>12,
		    ),
		));
	}    
	
	public function searchPenjaminForJenisTarif(){
		$getPen = JenistarifpenjaminM::model()->findAll();
			
		$dt = array();

		if (count((array)$getPen)){
			foreach ($getPen as $gr){
				$dt[] = $gr->penjamin_id;
			}
		}

		$criteria = new CDbCriteria();
		$criteria->compare('LOWER(penjamin_nama)', strtolower($this->penjamin_nama), true);                
		if (!empty($dt)){
			$criteria->addNotInCondition("penjamin_id", $dt);
		}
		$criteria->addCondition(" penjamin_aktif = true ");
		$criteria->order = 'penjamin_nama';
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
	
	/**
	 * - digunakan untuk meload data dalam bentuk dialog box
	 * @author       M Iqbal Laksana <iqbal.laksana@piindonesia.co.id>
	 * @website      <piindonesia.co.id>
	 * @wiki         <https://piiproject.atlassian.net/wiki/display/MDO>
	 */
	public function searchDialog()
	{
		$criteria=new CDbCriteria;
		if (!empty($this->carabayar_id)){
			$criteria->addCondition(" carabayar_id = ".$this->carabayar_id." ");
		}
		
		$criteria->compare(" LOWER(penjamin_nama) ", strtolower($this->penjamin_nama));
		$criteria->addCondition(" penjamin_aktif = TRUE ");
		$criteria->order = " carabayar_id ASC, penjamin_nama ASC ";
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
    
    public function searchDialogSms()
	{
		// Warning: Please modify the following code to remove attributes that
		// should not be searched.

		$criteria=new CDbCriteria;

                
                $criteria->with=array('carabayar');
		$criteria->compare('t.penjamin_id',$this->penjamin_id);
                $criteria->compare('t.carabayar_id',$this->carabayar_id);
		$criteria->compare('LOWER(t.penjamin_nama)',strtolower($this->penjamin_nama),true);
		$criteria->compare('LOWER(carabayar.carabayar_nama)',strtolower($this->carabayar_nama),true);
		$criteria->compare('LOWER(t.penjamin_namalainnya)',strtolower($this->penjamin_namalainnya),true);
		$criteria->compare('LOWER(t.penjamin_cp)',strtolower($this->penjamin_cp),true);
		$criteria->compare('LOWER(t.penjamin_nomobile)',strtolower($this->penjamin_nomobile),true);
		$criteria->addCondition("penjamin_aktif IS TRUE");
                if($this->nomor_valid==1){
                    $criteria->addCondition("length(penjamin_nomobile) >= 9 OR LEFT(penjamin_nomobile, 2) = '08' OR LEFT(penjamin_nomobile, 4) = '+628'");
                }
				

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
			'sort'=>array(
				'defaultOrder'=>'t.penjamin_nama asc',
			)
//                        'pagination'=>false,
		));
	}

	public function searchDialogPenjamin()
	{
		$criteria=new CDbCriteria;
		$criteria->select = "t.penjamin_id, t.penjamin_nama, carabayar_m.carabayar_id, carabayar_m.carabayar_nama";
		$criteria->join = 'join carabayar_m on carabayar_m.carabayar_id = t.carabayar_id';

		if (!empty($this->carabayar_id)){
			$criteria->addCondition("t.carabayar_id = ".$this->carabayar_id." ");
		}
		
		$criteria->compare(" LOWER(t.penjamin_nama) ", strtolower($this->penjamin_nama));
		$criteria->compare(" LOWER(carabayar_m.carabayar_nama) ", strtolower($this->carabayar_nama));
		$criteria->addCondition(" penjamin_aktif = TRUE ");
		$criteria->order = " carabayar_id ASC, penjamin_nama ASC ";
		$criteria->limit = 10;

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}
}