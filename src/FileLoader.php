<?php

namespace Datalogix\Translation;

use Illuminate\Translation\FileLoader as BaseFileLoader;
use RuntimeException;

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
        return collect(array_merge($this->paths(), [$path]))
            ->unique()
            ->reduce(function ($output, $path) use ($locale, $group) {
                if ($this->files->exists($full = "{$path}/{$locale}/{$group}.php")) {
                    $output = array_replace_recursive($output, $this->files->getRequire($full));
                }

                return $output;
            }, []);
    }

    /**
     * Load a locale from the given JSON file path.
     *
     * @param  string  $locale
     * @return array
     *
     * @throws \RuntimeException
     */
    protected function loadJsonPaths($locale)
    {
        return collect(array_merge($this->jsonPaths, $this->paths))
            ->unique()
            ->reduce(function ($output, $path) use ($locale) {
                if ($this->files->exists($full = "{$path}/{$locale}.json")) {
                    $decoded = json_decode($this->files->get($full), true);

                    if (is_null($decoded) || json_last_error() !== JSON_ERROR_NONE) {
                        throw new RuntimeException("Translation file [{$full}] contains an invalid JSON structure.");
                    }

                    $output = array_merge($output, $decoded);
                }

                return $output;
            }, []);
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

    /**
     * Get an array of all the registered paths to JSON translation files.
     *
     * @return array
     */
    public function jsonPaths()
    {
        return $this->jsonPaths;
    }
}
