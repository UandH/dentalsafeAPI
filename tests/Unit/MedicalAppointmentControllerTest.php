<?php

namespace Tests\Unit;

use function foo\func;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MedicalAppointmentControllerTest extends TestCase
{

    // Registrar citas médicas de un diagnóstico test

    public function testStore_01()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/setAppointment', [
            'userId' => '1AEE3F55-701F-4ACB-89EB-0E55BEE964A2;US',
            'diagnosisId' => '3',
            'datesToRegister' => '2018-9-23, 2018-9-29, 2018-9-31',
        ]);
        $response->assertStatus(200);
    }

    public function testStore_02()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/setAppointment', [
            'userId' => '1AEE3F55-701F-4ACB-89EB-0E55BEE964A2;US',
            'diagnosisId' => '3',
            'datesToDelete' => '2018-9-23, 2018-9-29, 2018-9-31',
        ]);
        $response->assertStatus(200);
    }

    public function testStore_Fail01()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/setAppointment', [
            'userId' => '1AEE3F55-701F-4ACB-89EB-0E55BEE964A2;US',
        ]);
        $response->assertStatus(400);
    }

    public function testStore_Fail02()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/setAppointment');
        $response->assertStatus(400);
    }

    // Verificar si tiene citas medicas registradas

    public function testCheckDates()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/checkDates', [
            'userId' => '1AEE3F55-701F-4ACB-89EB-0E55BEE964A2;US',
            'diagnosisId' => '1'
        ]);
        $response->assertStatus(200);
    }

    public function testCheckDates_Fail01()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/checkDates', [
            'userId' => '1AEE3F55-701F-4ACB-89EB-0E55BEE964A2;US',
        ]);
        $response->assertStatus(400);
    }

    public function testCheckDates_Fail02()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/checkDates');
        $response->assertStatus(400);
    }


}
