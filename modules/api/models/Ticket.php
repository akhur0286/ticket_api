<?php

namespace app\modules\api\models;

use Yii;

/**
 * This is the model class for table "ticket".
 *
 * @property int $id
 * @property int|null $from_airport
 * @property int|null $to_airport
 * @property string|null $departure_time
 * @property string|null $arrival_time
 */
class Ticket extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'ticket';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['from_airport', 'to_airport', 'departure_time', 'arrival_time'], 'required'],
            [['from_airport', 'to_airport'], 'integer'],
            [['from_airport', 'to_airport'], 'exist', 'targetClass' => Airport::className(), 'targetAttribute' => 'id'],
            [['departure_time', 'arrival_time'], 'datetime', 'format' => 'php:Y-m-d H:i:s'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_airport' => 'From Airport',
            'to_airport' => 'To Airport',
            'departure_time' => 'Departure Time',
            'arrival_time' => 'Arrival Time',
        ];
    }

    public function fields()
    {
        return [
            'from_airport' => function($model) {
                return $model->fromAirport->name;
            },
            'to_airport' => function($model) {
                return $model->toAirport->name;
            },
            'departure_time' => function($model) {
                return Yii::$app->formatter->asDate($model->departure_time, 'php: d.m.Y H:i');
            },
            'arrival_time' => function($model) {
                return Yii::$app->formatter->asDate($model->arrival_time, 'php: d.m.Y H:i');
            },
            'flight_duration' => function($model) {
                //конвертируем время прилета на часовой пояс аэропорт вылета
                $arrivalTime = new \DateTime($model->arrival_time, new \DateTimeZone($model->toAirport->timezone));
                $arrivalTime->setTimezone(new \DateTimeZone($model->fromAirport->timezone));

                //теперь считаем интервал между датами
                $departureTime = new \DateTime($model->departure_time, new \DateTimeZone($model->fromAirport->timezone));
                $arrivalTime = new \DateTime($model->arrival_time, new \DateTimeZone($model->toAirport->timezone));
                $interval = $arrivalTime->diff($departureTime);

                return $interval->format('%h часа %i минут');
            }
        ];
    }

    /**
     * @return \yii\db\ActiveQuery|Airport
     */
    public function getFromAirport()
    {
        return $this->hasOne(Airport::className(), ['id' => 'from_airport']);
    }

    /**
     * @return \yii\db\ActiveQuery|Airport
     */
    public function getToAirport()
    {
        return $this->hasOne(Airport::className(), ['id' => 'to_airport']);
    }
}
