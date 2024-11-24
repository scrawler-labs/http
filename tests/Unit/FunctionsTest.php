<?php


it('tests response()', function (): void {
    $response = response();
    expect($response)->toBeInstanceOf(Scrawler\Http\Response::class);
});

it('tests session()', function (): void {
    $session = session();
    expect($session)->toBeInstanceOf(Scrawler\Http\Session::class);
});

it('tests session() with storage', function (): void {
    $session = session(new Symfony\Component\HttpFoundation\Session\Storage\MockArraySessionStorage());
    expect($session)->toBeInstanceOf(Scrawler\Http\Session::class);
});

it('tests redirect()', function (): void {
    $response = redirect('/test');
    expect($response)->toBeInstanceOf(Scrawler\Http\RedirectResponse::class);
    expect($response->getStatusCode())->toBe(302);
    expect($response->headers->get('Location'))->toBe('/test');
});

it('tests redirect() with flash message', function (): void {
    $response = redirect('/test', ['message' => 'test']);
    expect($response)->toBeInstanceOf(Scrawler\Http\RedirectResponse::class);
    expect($response->getStatusCode())->toBe(302);
    expect($response->headers->get('Location'))->toBe('/test');
    expect(session()->flash('message'))->toBe(['test']);
});
