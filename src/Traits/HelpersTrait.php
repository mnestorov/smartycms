<?php

namespace SmartyStudio\SmartyCms\Traits;

use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

trait HelpersTrait
{
    /**
     * Sanitize elements.
     */
    protected function sanitizeElements($element)
    {
        return trim(strtolower(preg_replace('/[^a-zA-Z0-9_]/', '', $element)), '_');
    }

    /**
     * Generate nested page list.
     */
    protected function generateNestedPageList($pages, $navigation = '')
    {
        $navigation .= '<ul class="border">';

        foreach ($pages as $page) {
            $navigation .= '<li>';
            $navigation .= '<a href="pages/edit/' . $page->id . '">' . $page->title . '</a>';

            if ($page->subpages()->count()) {
                $navigation = $this->generateNestedPageList($page->subpages(), $navigation);
            }

            $navigation .= '</li>';
        }

        $navigation .= '</ul>';

        return $navigation;
    }

    /**
     * Save uploaded image. Overwrites existing.
     * Prepends 'images/' to storage key by default if it doesn't exists already.
     *
     * @param \Symfony\Component\HttpFoundation\File $image
     * @param string                                 $storage_key
     *
     * @throws \Exception
     *
     * @return string
     */
    protected function saveImage($image, $storage_key = '')
    {
        if (!$image || !$image->isValid()) {
            throw new \Exception('Missing or invalid image');
        }

        if (!in_array($image->getClientOriginalExtension(), ['jpg', 'jpeg', 'gif', 'png', 'svg'])) {
            throw new \Exception('Image extension not allowed');
        }

        $storage_key = trim($storage_key);

        if (Str::endsWith($storage_key, '/')) {
            $directory = $storage_key;
            $filename = $this->sanitizeFilename($image->getClientOriginalName());
        } else {
            $directory = dirname($storage_key);
            $filename = basename($storage_key);
        }

        if (!Str::startsWith($directory, 'images')) {
            $directory = 'images/' . $directory;
        }

        if (!Storage::exists($directory)) {
            Storage::makeDirectory($directory, 0755, true);
        }

        $storage_key = $directory . DIRECTORY_SEPARATOR . $filename;

        Storage::put($storage_key, file_get_contents($image));

        return $storage_key;
    }

    /**
     * Save uploaded image with randomly generated name.
     *
     * @param \Symfony\Component\HttpFoundation\File $image
     * @param string                                 $directory
     *
     * @return string
     */
    protected function saveImageWithRandomName($image, $directory)
    {
        $storage_key = $directory . '/' . Str::random(5) . '.' . $image->getClientOriginalExtension();

        return $this->saveImage($image, $storage_key);
    }

    /**
     * Update existing image. Delete previous version.
     *
     * @param string                                 $storage_key
     * @param \Symfony\Component\HttpFoundation\File $image
     *
     * @return string
     */
    protected function updateImage($storage_key, $image)
    {
        if (!$image || !$image->isValid()) {
            return false;
        }

        if (Storage::exists($storage_key)) {
            Storage::delete($storage_key);
        }

        return $this->saveImage($image, $storage_key);
    }

    /**
     * Upload PDF.
     *
     * @param \Symfony\Component\HttpFoundation\File $file
     * @param string                                 $storage_path
     *
     * @return string|false
     */
    public static function savePdf($file, $storage_dir)
    {
        if ($file && $file->isValid()) {
            $dirname = 'pdf/' . $storage_dir . '/' . $file->getClientOriginalName();

            if (!Storage::exists('pdf/' . $storage_dir)) {
                Storage::makeDirectory('pdf/' . $storage_dir, 0755, true);
            }

            Storage::put($dirname, file_get_contents($file));

            return $dirname;
        }

        return false;
    }

    /**
     * Sanitize slug leave "/".
     *
     * @param string $slug
     *
     * @return string
     */
    public function sanitizeSlug($slug)
    {
        return trim(strtolower(preg_replace(['/[^a-zA-Z0-9-\/]/', '/\/+/', '/-+/'], ['', '/', '-'], $slug)), '-');
    }

    /**
     * Signature for console.
     */
    public function consoleSignature()
    {
        $this->line('');
        $this->line('');
        $this->line(' __________________________________________________________________________________________________ ');
        $this->line('');
        $this->line('   _____ __  __          _____ _________     __   ');
        $this->line('  / ____|  \/  |   /\   |  __ \__   __\ \   / /   ');
        $this->line(' | (___ | \  / |  /  \  | |__) | | |   \ \_/ /    ');
        $this->line('  \___ \| |\/| | / /\ \ |  _  /  | |    \   /     ');
        $this->line('  ____) | |  | |/ ____ \| | \ \  | |     | |      ');
        $this->line(' |_____/|_|  |_/_/    \_\_|  \_\ |_|     |_|      ');
        $this->line('                                                  ');
        $this->line('   _____ __  __  _____          __    __          ');
        $this->line('  / ____|  \/  |/ ____|        /_ |  /_ |         ');
        $this->line(' | |    | \  / | (___   __   _  | |   | |         ');
        $this->line(' | |    | |\/| |\___ \  \ \ / / | |   | |         ');
        $this->line(' | |____| |  | |____) |  \ V /  | |   | |         ');
        $this->line('  \_____|_|  |_|_____/    \_/   |_|(_)|_|         ');
        $this->line('');
        $this->line(' __________________________________________________________________________________________________ ');
        $this->line('');
        $this->line('');
    }

    public function sanitizeFilename($string)
    {
        $utf8 = [
            '/[áàâãªä]/u' => 'a',
            '/[ÁÀÂÃÄ]/u'  => 'A',
            '/[ÍÌÎÏ]/u'   => 'I',
            '/[íìîï]/u'   => 'i',
            '/[éèêë]/u'   => 'e',
            '/[ÉÈÊË]/u'   => 'E',
            '/[óòôõºö]/u' => 'o',
            '/[ÓÒÔÕÖ]/u'  => 'O',
            '/[úùûü]/u'   => 'u',
            '/[ÚÙÛÜ]/u'   => 'U',
            '/ç/'         => 'c',
            '/Ç/'         => 'C',
            '/ñ/'         => 'n',
            '/Ñ/'         => 'N',
            '/–/'         => '-', // UTF-8 hyphen to "normal" hyphen
            '/[’‘‹›‚]/u'  => ' ', // Literally a single quote
            '/[“”«»„]/u'  => ' ', // Double quote
            '/ /'         => ' ', // nonbreaking space (equiv. to 0x160)
        ];

        $string = urldecode($string);
        $string = strtolower($string);
        $string = preg_replace(array_keys($utf8), array_values($utf8), $string);
        $string = preg_replace(['#[\\s-]+#', '#[^a-z0-9\. -]+#'], ['-', ''], $string);

        return $string;
    }
}
