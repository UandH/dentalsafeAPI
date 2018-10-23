<?php

namespace Tests\Unit;

use Tests\TestCase;

class CommuneControllerTest extends TestCase
{

    // Registrar al usuario (respaldo) test

    public function testGetIdCommune()
    {
        $response = $this->withHeader('auth', 'US')->json('POST', 'http://127.0.0.1:8000//api/getIdCommune', [
            'deviceId' => '1AEE3F55-701F-4ACB-89EB-0E55BEE964A2;US'
        ]);
        $response->assertStatus(200);
    }

    public function testGetIdCommune_Fail01()
    {
        $response = $this->withHeader('auth', 'CL')->json('POST','http://127.0.0.1:8000/api/getIdCommune', [
            'deviceId' => '1AEE3F55-701F-4ACB-89EB-0E55BEE964A2;US'
        ]);
        $response->assertStatus(500);
    }

    public function testGetIdCommune_Fail02()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/getIdCommune');
        $response->assertStatus(500);
    }

}
