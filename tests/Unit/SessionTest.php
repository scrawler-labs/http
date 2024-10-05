<?php

it('tests if session has key', function () {
    $session = new \Scrawler\Http\Session();
    $session->set('test', 'test');
    expect($session->has('test'))->toBeTrue();
    expect($session->has('test1'))->toBeFalse();
});

it('tests if session has key in flashbag', function () {
    $session = new \Scrawler\Http\Session();
    $session->getFlashBag()->add('test', 'test');
    expect($session->has('test'))->toBeTrue();
    expect($session->has('test1'))->toBeFalse();
});

it('tests __get()', function () {
    $session = new \Scrawler\Http\Session();
    $session->set('test', 'test');
    expect($session->test)->toBe('test');
});

it('tests __set()', function () {
    $session = new \Scrawler\Http\Session();
    $session->test = 'test';
    expect($session->get('test'))->toBe('test');
});

it('tests stop()', function () {
    $session = new \Scrawler\Http\Session();
    $session->set('test', 'test');
    $session->stop();
    expect($session->get('test'))->toBeNull();
});


it('tests set flashback with flash()', function () {
    $session = new \Scrawler\Http\Session();
    $session->flash('testkey', 'test');
    expect($session->getFlashBag()->get(type: 'testkey'))->toBe(['test']);

});

it('tests get flashback with flash()', function () {
    $session = new \Scrawler\Http\Session();
    $session->getFlashBag()->add('testkey', 'test');
    expect($session->flash('testkey'))->toBe(['test']);
});

it('tests flashbag all values with flash()',function(){
    $session = new \Scrawler\Http\Session();
    $session->getFlashBag()->add('testkey', 'test');
    $session->getFlashBag()->add('testkey2', 'test2');
    expect($session->flash())->toBe(['testkey' => ['test'], 'testkey2' => ['test2']]);
});