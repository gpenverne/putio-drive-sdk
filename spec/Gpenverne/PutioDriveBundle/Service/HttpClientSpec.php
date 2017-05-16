<?php

namespace spec\Gpenverne\PutioDriveBundle\Service;

use Gpenverne\PutioDriveBundle\Service\HttpClient;
use GuzzleHttp\Client;
use PhpSpec\ObjectBehavior;
use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\StreamInterface;

class HttpClientSpec extends ObjectBehavior
{
    public function let(Client $client)
    {
        $this->beConstructedWith($client);
    }

    public function it_is_initializable()
    {
        $this->shouldHaveType(HttpClient::class);
    }

    public function it_makes_get_request_using_guzzle_client(StreamInterface $stream, RequestInterface $request, $client)
    {
        $client->request('GET', 'some-url', ['headers' => ['Accept' => 'application/json']])->willReturn($request)->shouldBeCalled();
        $request->getBody()->willReturn($stream);
        $stream->getContents()->willReturn('Some content');

        $this->get('some-url')->shouldReturn('Some content');
    }

    public function it_makes_get_request_and_return_json(StreamInterface $stream, RequestInterface $request, $client)
    {
        $client->request('GET', 'some-url', ['headers' => ['Accept' => 'application/json']])->willReturn($request)->shouldBeCalled();
        $request->getBody()->willReturn($stream);
        $stream->getContents()->willReturn('"some json content"');

        $this->getJson('some-url')->shouldReturn('some json content');
    }
}
