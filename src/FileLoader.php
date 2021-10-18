<?php

namespace Datalogix\Translation;

use Illuminate\Translation\FileLoader as BaseFileLoader;

class FileLoader extends BaseFileLoader implements Loader
{
    /**
     * All of the registered paths to translation files.
     *
     * @var array
     */
    protected $paths = [];

    /**
     * Load a locale from a given path.
     *
     * @param  string  $path
     * @param  string  $locale
     * @param  string  $group
     * @return array
     */
    protected function loadPath($path, $locale, $group)
    {
        if ($path === $this->path) {
            $paths = array_merge($this->paths(), [$this->path]);

            foreach ($paths as $path) {
                $result = parent::loadPath($path, $locale, $group);

                if (! empty($result)) {
                    return $result;
                }
            }
        }

        return parent::loadPath($path, $locale, $group);
    }

    /**
     * Add a new path to the loader.
     *
     * @param  string  $path
     * @param  bool  $jsonPath
     * @return void
     */
    public function addPath($path, $jsonPath = true)
    {
        $this->paths[] = $path;

        if ($jsonPath) {
            $this->addJsonPath($path);
        }
    }

    /**
     * Get an array of all the registered paths to translation files.
     *
     * @return array
     */
    public function paths()
    {
        return $this->paths;
    }
}
