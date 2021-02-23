<?php namespace modules\api\models;

use app\fixtures\AirportFixture;
use app\fixtures\TicketFixture;
use app\modules\api\models\Airport;
use app\modules\api\models\Ticket;

class AirportTest extends \Codeception\Test\Unit
{
    /**
     * @var \UnitTester
     */
    protected $tester;
    
    protected function _before()
    {
        $this->tester->haveFixtures([
            'airport' => [
                'class' => AirportFixture::className(),
                'dataFile' => codecept_data_dir() . 'airport.php'
            ],
            'ticket' => [
                'class' => TicketFixture::className(),
                'dataFile' => codecept_data_dir() . 'ticket.php'
            ]
        ]);
    }

    public function testCreate()
    {
        $model = new Airport();
        $model->name = 'Токио';
        $model->timezone = 'Asia/Tokyo';
        expect_that($model->save());
    }

    /**
     * Форма должна выдать ошибку, если пытаюсь отправить пустую форму
     */
    public function testCreateEmptyFormSubmit()
    {
        $model = new Airport();
        expect_that($model->validate());
        expect_that($model->save());
    }
    /**
     * Возможность удалить аэропорт
     */
    public function testDelete()
    {
        $model = Airport::findOne(1);
        expect_that($model !==  null);
        expect_that($model->delete());
    }
    /**
     * Возможность изменить аэропорт
     */
    public function testUpdate()
    {
        $model = Airport::findOne(['name' => 'Тюмень']);
        expect_that($model !== null);
        $model->name = 'Новый аэропорт';
        expect_that($model->save());
        $updateModel = Airport::findOne(['name' => 'Новый аэропорт']);
        expect_that($updateModel !== null);
    }

    public function Ticket()
    {
        $model = new Ticket();
        $model->from_airport = 5;
        $model->to_airport = 6;
        $model->departure_time = '2021-04-05 08:00:00';
        $model->arrival_time = '2021-04-05 11:00:00';
        expect_that($model->save());
    }

    /**
     * Должно выдавать ошибку если не ввести аэропорт прилета
     */
    public function testCreateTicketEmptyArrivalAirport()
    {
        $model = new Ticket();
        $model->from_airport = 6;
        $model->departure_time = '2021-04-05 08:00:00';
        $model->arrival_time = '2021-04-05 11:00:00';
        expect_that($model->validate());
        expect_that($model->save());
    }

    /**
     * Возможность удалить Билет
     */
    public function testDeleteTicket()
    {
        $model = Ticket::findOne(1);
        expect_that($model !==  null);
        expect_that($model->delete());
    }
    /**
     * Возможность изменить билет
     */
    public function testUpdateTicket()
    {
        $model = Ticket::findOne(['from_airport' => 1, 'to_airport' => 2, 'departure_time' => '2021-02-23 15:00:00']);
        expect_that($model !== null);
        $model->departure_time = '2021-02-23 15:30:00';
        expect_that($model->save());
        $updateModel = Ticket::findOne(['from_airport' => 1, 'to_airport' => 2, 'departure_time' => '2021-02-23 15:30:00']);
        expect_that($updateModel !== null);
    }
}