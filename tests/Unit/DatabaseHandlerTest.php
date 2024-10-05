<?php

beforeAll(function () {
    db()->connect(
        [
            'dbname' => 'test',
            'user' => 'root',
            'password' => 'root@1432',
            'host' => '127.0.0.1',
            'driver' => 'pdo_mysql',
        ]
    );
    print ("Database connected\n");
});

it('tests session set with database adapter', function () {
    $session = new \Scrawler\Http\Session(new \Scrawler\Http\Adapters\Session\DatabaseAdapter());
    $session->set('test', 'test');
    $session->set('test2', 'test2');
    $session->save();
    expect($session->get('test'))->toBe('test');
    expect($session->get('test2'))->toBe('test2');
    expect($session->all())->toBe(['test' => 'test', 'test2' => 'test2']);

});

it('tests session close with database adapter', function () {
    $session = new \Scrawler\Http\Session(new \Scrawler\Http\Adapters\Session\DatabaseAdapter());
    $session->set('test', 'test');
    $session->clear();
    expect($session->get('test'))->toBe(null);
});

it('tests session update database adapter', function () {
    $session = new \Scrawler\Http\Session(new \Scrawler\Http\Adapters\Session\DatabaseAdapter());
    $session->set('test', 'test');
    $session->save();
    expect($session->get('test'))->toBe('test');
    $session->set('test', 'test1');
    $session->save();
    expect($session->get('test'))->toBe('test1');
});

it('tests invalidate database adapter', function () {
    $session = new \Scrawler\Http\Session(new \Scrawler\Http\Adapters\Session\DatabaseAdapter());
    $session->set('test', 'test');
    $session->save();
    $session->invalidate(0);

    expect($session->get('test'))->toBe(null);
});

it('tests lifetime', function () {
    $session = new \Scrawler\Http\Session(new \Scrawler\Http\Adapters\Session\DatabaseAdapter());

    expect($session->getMetadataBag()->getLifetime())->toBe(0);
});

// it('test session gc',function(){
//     db()->getConnection()->executeStatement("DROP TABLE IF EXISTS session; ");
//     (int) \Safe\ini_set( 'session.gc_maxlifetime',1);
//     $session = new \Scrawler\Http\Session(new \Scrawler\Http\Adapters\Session\DatabaseAdapter());
//     $session->invalidate(0);
//     $session->set('test', 'test');
//     $session->save();
//     $session->gcCalled = true;
//     sleep(2);

//     expect($session->gcCalled)->toBe('1');
//     expect($session->get('test'))->toBe(null);

// });

it('tests session gc with database adapter', function () {
    $session = new \Scrawler\Http\Session(new \Scrawler\Http\Adapters\Session\DatabaseAdapter());
    (int) \Safe\ini_set(  'session.gc_maxlifetime',1);
    $expiry = \Safe\ini_get('session.gc_maxlifetime');
    $session->set('test', 'test');
    $session->save();
    session_gc();
    sleep($expiry+2);
    expect($session->get('test'))->toBe(null);
});

it('test auto table creation for db handler',function(){
    db()->getConnection()->executeStatement("DROP TABLE IF EXISTS session; ");
    $session = new \Scrawler\Http\Session(new \Scrawler\Http\Adapters\Session\DatabaseAdapter());
    $session->set('test', 'test');
    $session->save();
    expect($session->get('test'))->toBe('test');
});


