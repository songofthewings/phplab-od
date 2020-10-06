<?php

namespace App\Tests;


use App\Controller\DictionaryController;
use PHPUnit\Runner\Exception;
use Symfony\Bundle\FrameworkBundle\Test\WebTestCase;


class DictionaryControllerTest extends WebTestCase
{
    private $client;
    private $dictionaryMock;
    private $responseTest;

    public function setUp(): void
    {
        $this->client = $this->getMockBuilder(GuzzleClientTest::class)->getMock();
        $this->responseTest = $this->getMockBuilder(ResponseTest::class)->getMock();

        $this->responseTest->expects($this->any())->method('getBody')
            ->willReturn($this->responseTest);

        $this->client->expects($this->any())->method('get')
            ->willReturn($this->responseTest);
        $this->dictionaryMock = new DictionaryController($this->client);
    }

    public function test_OD_returns_definition_and_pronunciations()
    {
        $this->responseTest->expects($this->any())->method('getContents')
            ->willReturn(json_encode(['definition' => 'test', 'pronunciation' => 'test']));

        $resp = $this->dictionaryMock->entriesLogic();
        $responseArray = json_decode(json_encode($resp), true); //converting stD Object to array

        $this->assertTrue(array_key_exists('definition', $responseArray));
        $this->assertTrue(array_key_exists('pronunciation', $responseArray));
    }

    public function test_OD_returns_definition()
    {
        $this->responseTest->expects($this->any())->method('getContents')
            ->willReturn(json_encode(['definition' => 'test']));

        $resp = $this->dictionaryMock->entriesLogic();
        $responseArray = json_decode(json_encode($resp), true); //converting stD Object to array

        $this->assertTrue(array_key_exists('definition', $responseArray));
        $this->assertFalse(array_key_exists('pronunciation', $responseArray));
    }

    public function test_OD_returns_no_results()
    {
        $this->responseTest->expects($this->any())->method('getContents')
            ->willReturn(json_encode(''));

        $resp = $this->dictionaryMock->entriesLogic();
        $responseArray = json_decode(json_encode($resp), true); //converting stD Object to array

        $this->assertTrue(empty($responseArray));
    }

    public function test_OD_throws_exception_when_invalid_HTTP()
    {
        $this->expectException(\App\Exceptions\DictionaryException::class);

        $this->responseTest->expects($this->any())->method('getContents')
            ->willReturn(self::throwException(new Exception()));
        $this->dictionaryMock->entriesLogic();
    }
}
//Guzzle Client class for mock
class GuzzleClientTest
{
    public function get()
    {
        return '';
    }
}

//Response class for mock
class ResponseTest
{
    public function getBody()
    {
        return '';
    }

    public function getContents()
    {
        return '';
    }
}

