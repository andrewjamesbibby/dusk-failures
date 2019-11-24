<?php

namespace Bibby\DuskFailures\Console;

use Bibby\DuskFailures\DuskFailures;
use Bibby\DuskFailures\Mail\DuskFailuresMail;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\Mail;

class DuskFailuresCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dusk:failures 
                                { --build=  : The build identifier } 
                                { --console : Include the browser console output } 
                                { --zip     : Zip and attach screenshots instead of inline }';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Email screenshots and logs of failed Dusk tests';

    /**
     * Failures.
     *
     * @var \Bibby\DuskFailures\DuskFailures
     */
    protected $failures;

    /**
     * Create a new command instance.
     *
     * @param \Bibby\DuskFailures\DuskFailures $failures
     */
    public function __construct(DuskFailures $failures)
    {
        $this->failures = $failures;
        parent::__construct();
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->failures->sendable() ? $this->send() : $this->printErrors();
    }

    /**
     * Print Command Errors.
     */
    private function printErrors(): void
    {
        foreach ($this->failures->getErrors() as $error) {
            $this->line($error);
        }
    }

    /**
     * Sends the Dusk failure email.
     */
    private function send()
    {
        try {
            Mail::to($this->failures->getRecipients())->send(
                new DuskFailuresMail($this->option('build'), $this->option('console'), $this->option('zip'))
            );
            $this->line('Screenshots will be emailed to: '.config('dusk-failures.recipient'));
        } catch (\Exception $e) {
            $this->error($e->getMessage());
        }
    }
}
