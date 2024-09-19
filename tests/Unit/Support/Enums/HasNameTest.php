<?php

use OnurSimsek\LaravelExtended\Support\Enums\HasName;

it('should have names', function () {
    $mock = Mockery::mock(HasName::class);
    $mock->shouldReceive('cases')
        ->once()
        ->andReturn([
            ['name' => 'Foo'],
            ['name' => 'Bar'],
        ]);

    expect($mock::names())->toEqual(['Foo', 'Bar']);
});
