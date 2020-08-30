<?php

namespace Market;

use Config;
use Crypto;
use Illuminate\Database\Eloquent\Collection;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Filesystem\Filesystem;
use Illuminate\Support\Arr;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use ReflectionClass;
use Request;
use Session;

use View;

class Market
{
    protected $version;
    protected $filesystem;

    /**
     * The current locale, cached in memory
     *
     * @var string
     */
    private $locale;
    public $backendRoute = 'admin';

    public function __construct()
    {
        $this->filesystem = app(Filesystem::class);

        $this->findVersion();
    }

    public function getVersion()
    {
        return $this->version;
    }

    protected function findVersion()
    {
        if (!is_null($this->version)) {
            return;
        }

        if ($this->filesystem->exists(base_path('composer.lock'))) {
            // Get the composer.lock file
            $file = json_decode(
                $this->filesystem->get(base_path('composer.lock'))
            );

            // Loop through all the packages and get the version of market
            foreach ($file->packages as $package) {
                if ($package->name == 'sierratecnologia/market') {
                    $this->version = $package->version;
                    break;
                }
            }
        }
    }
    /**
     * SierraTecnologia CMS url generator - handles custom siravel url
     *
     * @param  string $string
     *
     * @return string
     */
    public function url($string)
    {
        $url = str_replace('.', '/', $string);

        return url($this->backendRoute.'/'.$url);
    }
}
