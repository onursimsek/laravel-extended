<?php

use Illuminate\Support\Str;

it('str', function ($method, $str, $params, $expected) {
    expect(Str::{$method}($str, ...$params))->toEqual($expected);
    expect(Str::of($str)->{$method}(...$params))->toEqual($expected);
})->with([
    ['squishBetween', "ey\t\nedip adanada pide\t\nye", ['pide', 'ye'], "ey\t\nedip adanada pide ye"],
    ['squishBetween', 'ey   edip adanada pide    ye', ['pide', 'ye'], 'ey   edip adanada pide ye'],
    ['replaceBetween', 'ey edip adanada pide ye', ['edip', 'pide', 'adanada', 'tokatta'], 'ey edip tokatta pide ye'],
    ['replaceBetweenMatch', 'ey edip adanada pide ye', ['edip', 'pide', '/a(.*)a/', 'tokatta'], 'ey edip tokatta pide ye'],
]);
