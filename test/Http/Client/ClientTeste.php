<?php
namespace Test\Http\Client;

use PHPUnit\Framework\TestCase;
use Basicis\Http\Client\Client;
use Basicis\Http\Message\Request;
use Basicis\Http\Message\Response;

 /**
 * ClassTest\Http\Client\ClientTest
 *
 */

class ClientTest extends TestCase
{
    /**
     * testSendRequest function
     *
     * @return void
     */
    public function testSendRequest()
    {
        $request = new Request('https://www.google.com');
        $this->client = new Client();
        $this->assertInstanceOf(Client::class, $this->client);
        $this->assertInstanceOf(Request::class, $request);
        $response = $this->client->sendRequest($request);
        $this->assertInstanceOf(Response::class, $response);
    }
}
