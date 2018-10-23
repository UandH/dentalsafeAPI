<?php

namespace Tests\Unit;

use Tests\TestCase;

class RecommendationControllerTest extends TestCase
{

    // Registrar un diagnóstico presuntivo obteniendo las indicaciones test

    public function testGetRecommendation()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/getRecommendation', [
            'tda' => '1',
            'teeth' => '1',
            'deviceId' => '1AEE3F55-701F-4ACB-89EB-0E55BEE964A2;US'
        ]);
        $response->assertStatus(200);
    }

    public function testGetRecommendation_Fail01()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/getRecommendation', [
            'tda' => '1',
            'teeth' => '1',
            'deviceId' => ''
        ]);
        $response->assertStatus(400);
    }

    public function testGetRecommendation_Fail02()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/getRecommendation');
        $response->assertStatus(400);
    }

    // Registrarun diagnóstico presuntivo test

    public function testStoreDiagnosis()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/storeDiagnosis', [
            'tda' => '1',
            'teeth' => '1',
            'deviceId' => '1AEE3F55-701F-4ACB-89EB-0E55BEE964A2;US'
        ]);
        $response->assertStatus(200);
    }

    public function testStoreDiagnosis_Fail01()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/storeDiagnosis', [
            'tda' => '1',
            'teeth' => '1',
            'deviceId' => ''
        ]);
        $response->assertStatus(400);
    }

    public function testStoreDiagnosis_Fail02()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/storeDiagnosis');
        $response->assertStatus(400);
    }

    // Actualizar el estado de un diagnóstico test

    public function testUpdateDiagnosis_01()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/tdaUpdated', [
            'diagnosisId' => '1',
            'tdaId' => '1'
        ]);
        $response->assertStatus(200);
    }

    public function testUpdateDiagnosis_02()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/tdaUpdated', [
            'diagnosisId' => '2',
        ]);
        $response->assertStatus(200);
    }

    public function testUpdateDiagnosis_Fail01()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/tdaUpdated', [
            'tdaId' => '2'
        ]);
        $response->assertStatus(400);
    }

    public function testUpdateDiagnosis_Fail02()
    {
        $response = $this->call('POST', 'http://127.0.0.1:8000/api/tdaUpdated');
        $response->assertStatus(400);
    }

}
