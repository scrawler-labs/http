<?php

it('tests request()', function () {
    $request = request();
    expect($request)->toBeInstanceOf(\Scrawler\Http\Request::class);
});

it('tests response()', function () {
    $response = response();
    expect($response)->toBeInstanceOf(\Scrawler\Http\Response::class);
});

it('tests session()', function () {
    $session = session();
    expect($session)->toBeInstanceOf(\Scrawler\Http\Session::class);
});

it('tests session() with storage', function () {
    $session = session(new \Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage());
    expect($session)->toBeInstanceOf(\Scrawler\Http\Session::class);
});

it('tests redirect()', function () {
    $response = redirect('/test');
    expect($response)->toBeInstanceOf(\Scrawler\Http\RedirectResponse::class);
    expect($response->getStatusCode())->toBe(302);
    expect($response->headers->get('Location'))->toBe('/test');
});

it('tests redirect() with flash message', function () {
    $response = redirect('/test', ['message' => 'test']);
    expect($response)->toBeInstanceOf(\Scrawler\Http\RedirectResponse::class);
    expect($response->getStatusCode())->toBe(302);
    expect($response->headers->get('Location'))->toBe('/test');
    expect(session()->flash('message'))->toBe(['test']);
});