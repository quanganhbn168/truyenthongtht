<?php

namespace App\Settings;

use Spatie\LaravelSettings\Settings;

class HomepageSettings extends Settings
{
    public string $intro_title = '';

    public string $intro_description = '';

    public array $intro_cards = [];

    public static function group(): string
    {
        return 'homepage';
    }
}
