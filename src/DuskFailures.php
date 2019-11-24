<?php

namespace Bibby\DuskFailures;

use Symfony\Component\Finder\Finder;
use ZipArchive;

class DuskFailures
{
    /**
     * The failed dusk screenshots
     *
     * @var array
     */
    private $screenshots;

    /**
     * Email recipients
     *
     * @var array
     */
    private $recipients;

    /**
     * Console Errors
     *
     * @var array
     */
    private $console;

    /**
     * Error messages
     *
     * @var array
     */
    private $errors;

    /**
     * Dusk Failures constructor
     *
     * @return void
     */
    public function __construct()
    {
        $this->screenshots = $this->extractScreenshots();
        $this->recipients = $this->extractRecipients();
        $this->console  = $this->extractConsole();
    }

    /**
     * Returns array of screenshots
     *
     * @return array
     */
    public function getScreenshots(): array
    {
        return $this->screenshots;
    }

    /**
     * Returns array of recipients
     *
     * @return array
     */
    public function getRecipients(): array
    {
        return $this->recipients;
    }

    /**
     * Returns array of console errors
     *
     * @return array
     */
    public function getConsole(): array
    {
        return $this->console;
    }

    /**
     * Extracts Dusk failure screenshots to array
     *
     * @return array
     */
    private function extractScreenshots(): array
    {
        $finder = Finder::create()->files()
                    ->in(base_path( config('dusk-failures.screenshot_path') ) )
                    ->name('*.png');

        return iterator_to_array($finder);
    }

    /**
     * Extracts Dusk failure console logs to array
     *
     * @return array
     */
    private function extractConsole(): array
    {
        $finder = Finder::create()->files()
                    ->in(base_path( config('dusk-failures.console_path') ) )
                    ->name('*.json');

        return iterator_to_array($finder);
    }

    /**
     * Extracts Dusk failure recipients to array
     *
     * @return array
     */
    private function extractRecipients(): array
    {
        return preg_split('/,/', config('dusk-failures.recipient'), null, PREG_SPLIT_NO_EMPTY);
    }

    /**
     * Determines if can send Dusk failures and sets errors
     *
     * @return bool
     */
    public function sendable(): bool
    {
        if(empty($this->screenshots)){
            $this->errors[] = "No failure screenshots to send.";
        }

        if(empty($this->recipients)){
            $this->errors[] = "No recipients are specified - set DUSK_FAILURES_RECIPIENT in your environment file.";
        }

        return $this->errors ? false : true;
    }

    /**
     * Zips Dusk screenshots
     *
     * @return string
     */
    public function zipScreenshots(): string
    {
        $zipPath = base_path(config('dusk-failures.screenshot_path') . '/screenshots.zip');
        $sourcePath = config('dusk-failures.screenshot_path');
        return $this->zip($zipPath, $sourcePath);
    }

    /**
     * Zips Dusk console errors
     *
     * @return string
     */
    public function zipConsole(): string
    {
        $zipPath = base_path(config('dusk-failures.console_path') . '/console.zip');
        $sourcePath = config('dusk-failures.console_path');
        return $this->zip($zipPath, $sourcePath);
    }

    /**
     * Zips the contents of specified directory
     *
     * @param $zipPath
     * @param $sourcePath
     * @return string
     */
    private function zip(String $zipPath, String $sourcePath): string
    {
        $zip = new ZipArchive;

        if($zip->open($zipPath, ZipArchive::CREATE) === true) {

            $files = Finder::create()->files()->in($sourcePath)->notName('*.zip');

            foreach ($files as $key => $value) {
                $relativeNameInZipFile = basename($value);
                $zip->addFile($value, $relativeNameInZipFile);
            }

            $zip->close();
        }

        return $zipPath;
    }

}
