<?php

it('tests redirect()', function () {
    $response = new \Scrawler\Http\Response();
    $redirect = $response->redirect('https://example.com');
    expect($redirect)->toBeInstanceOf(\Scrawler\Http\RedirectResponse::class);
});

it('tests json()', function () {
    $response = new \Scrawler\Http\Response();
    $json = $response->json(['key' => 'value']);
    expect($json)->toBeInstanceOf(\Scrawler\Http\Response::class);
    expect($json->getContent())->toBe('{"key":"value"}');
});

it('tests response() with headers', function () {
    $response = new \Scrawler\Http\Response();
    $json = $response->json(['key' => 'value'], ['Content-Type' => 'application/json']);
    expect($json)->toBeInstanceOf(\Scrawler\Http\Response::class);
    expect($json->getContent())->toBe('{"key":"value"}');
    expect($json->headers->get('Content-Type'))->toBe('application/json');
});
