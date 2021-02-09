<?php

namespace common\components;

use Yii;
use yii\base\Component;
use common\models\GlobalFunction;
use common\models\KonfRujukan;

class konfComp extends Component
{
    public function getAllRujukanByFlag($flag)
    {
        $model = KonfRujukan::find()
            ->where('rujukanFlag = :rujukanFlag AND rujukanDeleted IS NULL')
            ->params([
                ':rujukanFlag' => $flag
            ])
            ->orderby('rujukanSusunan, rujukanNama')
            ->all();

        foreach($model as $data) {
            $string = Yii::t('app', 'KonfRujukan'.$data->id);
            $data->rujukanNama = ($string == 'KonfRujukan'.$data->id ? $data->rujukanNama : $string);
            #$data->rujukanNama = Yii::t('app', 'KonfRujukan'.$data->id);
        }

        return $model;
    }

    public function getDetailsRujukanByFlagAndName($nama, $flag)
    {
        $rujukan = KonfRujukan::find()
            ->where([
                'rujukanNama' => $nama,
                'rujukanFlag' => $flag
            ])
            ->one();

        if($rujukan)
            return $rujukan;
        else
            return NULL;
    }

    public function getDetailsRujukanByFlagAndDefault($default, $flag)
    {
        $rujukan = KonfRujukan::find()
            ->where([
                'rujukanDefault' => $default,
                'rujukanFlag' => $flag
            ])
            ->one();

        if($rujukan)
            return $rujukan;
        else
            return NULL;
    }

    public function getSingleRujukanByFlag($flag)
    {
        $rujukan = KonfRujukan::find()
            ->where([
                'rujukanFlag' => $flag
            ])
            ->one();

        if ($rujukan)
            return $rujukan;
        else
            return NULL;
    }
}
