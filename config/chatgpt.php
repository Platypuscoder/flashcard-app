<?php

return [

    /*
    |--------------------------------------------------------------------------
    | OpenAI API Key
    |--------------------------------------------------------------------------
    |
    | Your OpenAI API key used to authenticate requests to the OpenAI API.
    | Store the key securely in your .env file and reference it here.
    |
    */

    'api_key' => env('OPENAI_API_KEY'),

    /*
    |--------------------------------------------------------------------------
    | OpenAI Model
    |--------------------------------------------------------------------------
    |
    | The default model you want to use for OpenAI interactions. You can
    | customize this if needed, e.g., 'gpt-3.5-turbo' or 'gpt-4'.
    |
    */

    'model' => env('OPENAI_MODEL', 'gpt-3.5-turbo'),
];
