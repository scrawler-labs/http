<?php

it('tests get()', function (): void {
    $request = new Scrawler\Http\Request();
    $request->query->set('key', 'value');
    $request->request->set('key1', 'value1');
    expect($request->get('key'))->toBe('value');
    expect($request->get('key1'))->toBe('value1');
    expect($request->get('key2', 'default'))->toBe('default');
});

it('tests get() with json request', function (): void {
    $request = new Scrawler\Http\Request(
        [],
        [],
        [],
        [],
        [],
        [],
        '{"name":"Pranjal"}'
    );

    expect($request->get('name'))->toBe('Pranjal');
});

it('tests __get()', function (): void {
    $request = new Scrawler\Http\Request();
    $request->query->set('key', 'value');
    $request->request->set('key1', 'value1');
    expect($request->key)->toBe('value');
    expect($request->key1)->toBe('value1');
    expect($request->key2)->toBeNull();
});

it('tests all()', function (): void {
    $request = new Scrawler\Http\Request();
    $request->query->set('key', 'value');
    $request->request->set('key1', 'value1');
    expect($request->all())->toMatchArray(['key' => 'value', 'key1' => 'value1']);
});

it('tests all() with json', function (): void {
    $request = new Scrawler\Http\Request(
        [],
        [],
        [],
        [],
        [],
        [],
        '{"name":"Pranjal"}'
    );
    $request->query->set('key', 'value');
    $request->request->set('key1', 'value1');
    expect($request->all())->toMatchArray(['key' => 'value', 'key1' => 'value1', 'name' => 'Pranjal']);
});

it('tests has()', function (): void {
    $request = new Scrawler\Http\Request();
    $request->query->set('key', 'value');
    $request->request->set('key1', 'value1');
    expect($request->has('key'))->toBeTrue();
    expect($request->has('key1'))->toBeTrue();
    expect($request->has('key2'))->toBeFalse();
});

it('tests has() with json', function (): void {
    $request = new Scrawler\Http\Request(
        [],
        [],
        [],
        [],
        [],
        [],
        '{"name":"Pranjal"}'
    );
    $request->query->set('key', 'value');
    $request->request->set('key1', 'value1');
    expect($request->has('key'))->toBeTrue();
    expect($request->has('key1'))->toBeTrue();
    expect($request->has('name'))->toBeTrue();
    expect($request->has('key2'))->toBeFalse();
});

it('tests url()', function (): void {
    $request = Scrawler\Http\Request::create('/test');
    expect($request->url())->toBe('http://localhost/test');
});

it('tests url() generation with path', function (): void {
    $request = Scrawler\Http\Request::create('/test');
    expect($request->url('/hello'))->toBe('http://localhost/hello');
});

it('tests is()', function (): void {
    $request = Scrawler\Http\Request::create('/test');
    expect($request->is('/test'))->toBeTrue();
    expect($request->is('/test1'))->toBeFalse();
});
