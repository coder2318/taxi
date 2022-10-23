<?php

namespace App\Services;

use Spatie\TranslationLoader\LanguageLine;

class LanguageLineService
{
    protected $model;

    public function __construct(LanguageLine $model)
    {
        $this->model = $model;
    }

    
}
