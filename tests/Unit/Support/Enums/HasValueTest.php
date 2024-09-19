<?php

use OnurSimsek\LaravelExtended\Support\Enums\HasValue;

it('should have names and values', function () {
    $mock = Mockery::mock(HasValue::class);
    $mock->shouldReceive('cases')
        ->twice()
        ->andReturn([
            ['name' => 'Foo', 'value' => 'foo'],
            ['name' => 'Bar', 'value' => 'bar'],
        ]);

    expect($mock::names())->toEqual(['Foo', 'Bar'])
        ->and($mock::values())->toEqual(['foo', 'bar']);
});
