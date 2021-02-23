<?php

use yii\db\Migration;

/**
 * Class m210222_165807_init
 */
class m210222_165807_init extends Migration
{
    public function up()
    {
        $tableOptions = null;
        if ($this->db->driverName === 'mysql') {
            // http://stackoverflow.com/questions/766809/whats-the-difference-between-utf8-general-ci-and-utf8-unicode-ci
            $tableOptions = 'CHARACTER SET utf8 COLLATE utf8_unicode_ci ENGINE=InnoDB';
        }

        $this->createTable('{{%airport}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(),
            'timezone' => $this->string(),
        ], $tableOptions);

        $this->batchInsert('{{%airport}}', ['name', 'timezone'], [
            ['Домодедово', 'Europe/Moscow'],
            ['Шереметьево', 'Europe/Moscow'],
            ['Внуково', 'Europe/Moscow'],
            ['Толмачево', 'Asia/Krasnoyarsk'],
            ['Екатеринбург', 'Asia/Yekaterinburg'],
        ]);

        $this->createTable('{{%ticket}}', [
            'id' => $this->primaryKey(),
            'from_airport' => $this->integer(),
            'to_airport' => $this->integer(),
            'departure_time' => $this->dateTime(),
            'arrival_time' => $this->dateTime(),
        ], $tableOptions);


        $this->batchInsert('{{%ticket}}', ['from_airport', 'to_airport', 'departure_time', 'arrival_time'], [
            [1, 5, '2021-02-23 18:00:00', '2021-02-23 23:30:00'],
            [2, 3, '2021-02-23 18:00:00', '2021-02-23 18:30:00'],
        ]);
    }

    public function down()
    {
        $this->dropTable('{{%airport}}');
        $this->dropTable('{{%ticket}}');
    }
}
