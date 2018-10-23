<?php

namespace Tests\Unit;

use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class MedicalEstablishmentControllerTest extends TestCase
{

    // Obtener lista de centros médicos test

    public function testGetEstablishments()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/getEstablishments',[
            'commune' => 'Santiago',
            'schedule' => '1'
        ]);
        $response->assertStatus(200);
    }

    public function testGetEstablishments_Fail01()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/getEstablishments',[
            'commune' => 'Santiago',
            'schedule' => '2'
        ]);
        $response->assertStatus(400);
    }

    public function testGetEstablishments_Fail02()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/getEstablishments');
        $response->assertStatus(400);
    }
}
