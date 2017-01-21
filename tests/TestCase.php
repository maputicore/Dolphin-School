<?php

abstract class TestCase extends Illuminate\Foundation\Testing\TestCase
{
    /**
     * The base URL to use while testing the application.
     *
     * @var string
     */
    protected $baseUrl = 'http://localhost';

    protected $prefixDomain = '';

    /**
     * Creates the application.
     *
     * @return \Illuminate\Foundation\Application
     */
    public function createApplication()
    {
        $app = require __DIR__.'/../bootstrap/app.php';

        $app->make(Illuminate\Contracts\Console\Kernel::class)->bootstrap();
        $this->setBaseUrl();

        return $app;
    }

    protected function setBaseUrl()
    {
        $this->baseUrl = env('APP_URL', $this->baseUrl);
        if ($this->prefixDomain) {
            $this->baseUrl = substr_replace(
                $this->prefixDomain,
                $this->baseUrl,
                strlen('https://'),
                0
            );
        }
    }
}
