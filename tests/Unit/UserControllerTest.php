<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;


class UserControllerTest extends TestCase
{


    // Existen diagnosticos del usuario test

    
    public function testExistDiagnosis()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/existDiagnosis', [
            'user'  => '1AEE3F55-701F-4ACB-89EB-0E55BEE964A2;US',
        ]);
        $response->assertStatus(200);
    }

    public function testExistDiagnosisFail_01()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/existDiagnosis', [
            'user'  => '12312321',
        ]);
        $response->assertStatus(400);
    }
    
    public function testExistDiagnosisFail_02()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/existDiagnosis');
        $response->assertStatus(400);
    }


    // Registrar usuario  test
    
    public function testStore_01()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/registerUser', [
            'deviceId'  => '1AEE3F55-701F-4ACB-89EB-0E55BEE964A2;US',
        ]);
        $response->assertStatus(200);
    }

    public function testStore_02()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/registerUser', [
            'deviceId'  => '0000;CL',
            'deviceCountry' => 'CL',
        ]);
        $response->assertStatus(200);
    }

    public function testStoreFail_01()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/registerUser', [
            'deviceId' => '0001;CL',
        ]);
        $response->assertStatus(500);
    }

    public function testStoreFail_02()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/registerUser');
        $response->assertStatus(400);
    }

    
    

}
