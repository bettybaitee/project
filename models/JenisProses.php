<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "jenis_proses".
 *
 * @property int $id
 * @property string|null $namaProses
 * @property string|null $mailSubjek
 *
 * @property ProsesPerolehan[] $prosesPerolehans
 */
class JenisProses extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'jenis_proses';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['namaProses'], 'string', 'max' => 100],
            [['mailSubjek'], 'string', 'max' => 200],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'namaProses' => 'Nama Proses',
            'mailSubjek' => 'Mail Subjek',
        ];
    }

    /**
     * Gets query for [[ProsesPerolehans]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProsesPerolehans()
    {
        return $this->hasMany(ProsesPerolehan::className(), ['jenis_id' => 'id']);
    }
}
