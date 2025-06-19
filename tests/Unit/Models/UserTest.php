<?php

declare(strict_types=1);

use App\Models\User;

it('has instance of user model', function () {
    $model = User::factory()->createOne();

    expect($model)->toBeInstanceOf(User::class);
});
