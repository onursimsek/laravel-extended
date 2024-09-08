<?php

use Workbench\App\Models\Product;

it('boundary constraints', function ($method, $column, $value, $sql) {
    expect(Product::query()->{$method}($column, $value)->toRawSql())->toEqual($sql);
})->with([
    // Greater
    ['whereGreaterThan', 'price', 500, 'select * from "products" where "price" > 500'],
    ['whereGreaterThanOrEqual', 'price', 500, 'select * from "products" where "price" >= 500'],
    ['whereColumnGreaterThan', 'price', 'amount', 'select * from "products" where "price" > "amount"'],
    ['whereColumnGreaterThanOrEqual', 'price', "amount", 'select * from "products" where "price" >= "amount"'],
    // Less
    ['whereLessThan', 'price', 500, 'select * from "products" where "price" < 500'],
    ['whereLessThanOrEqual', 'price', 500, 'select * from "products" where "price" <= 500'],
    ['whereColumnLessThan', 'price', 'amount', 'select * from "products" where "price" < "amount"'],
    ['whereColumnLessThanOrEqual', 'price', "amount", 'select * from "products" where "price" <= "amount"'],
]);

it('conditional constraints', function ($value, $column, $sql) {
    expect(Product::query()->whenWhere($value, $column)->toRawSql())->toEqual($sql);
})->with([
    [true, 'is_active', 'select * from "products" where "is_active" = 1'],
    [false, 'is_active', 'select * from "products"'],
]);
