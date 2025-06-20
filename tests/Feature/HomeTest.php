<?php

declare(strict_types=1);

use function Pest\Laravel\get;

it('should be redirect to login', function () {
    $response = get('/');

    $response->assertRedirectToRoute('filament.admin.auth.login');
});
