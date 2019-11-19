<?php

namespace Bibby\DuskFailures\Console;

use Bibby\DuskFailures\Mail\DuskFailuresMail;
use Illuminate\Support\Facades\Mail;
use Illuminate\Console\Command;
use File;

class DuskFailuresCommand extends Command
{
    /**
     * The name and signature of the console command.
     *
     * @var string
     */
    protected $signature = 'dusk:failures {--build=} ';

    /**
     * The console command description.
     *
     * @var string
     */
    protected $description = 'Emails the screenshots of failed Dusk tests';

    /**
     * The failed dusk screenshots
     *
     * @var array
     */
    protected $screenshots;

    /**
     * Screenshot Recipients
     *
     * @var array
     */
    protected $recipients;

    /**
     * Create a new command instance.
     *
     * @return void
     */
    public function __construct()
    {
        parent::__construct();
    }

    /**
     * Extract Screenshots
     *
     * @return array
     */
    private function extractScreenshots(): array
    {
        return File::allFiles(config('dusk-failures.path'));
    }

    /**
     * Extract Recipients
     *
     * @return array
     */
    private function extractRecipients(): array
    {
        return explode(',', config('dusk-failures.recipient'));
    }

    /**
     * Execute the console command.
     *
     * @return mixed
     */
    public function handle()
    {
        $this->screenshots = $this->extractScreenshots();
        $this->recipients = $this->extractRecipients();

        if(!$this->screenshots){
            $this->line('No failure screenshots to send.');
            return;
        }

        if(!$this->recipients){
            $this->line('No recipients are specified - set the DUSK_FAILURES_RECIPIENT in your environment file.');
            return;
        }

        $this->send();
    }

    /**
     * Sends the dusk failure screenshots
     */
    private function send()
    {
        try {
            Mail::to($this->recipients)->send(new DuskFailuresMail($this->screenshots, $this->option('build')));
            $this->line('Screenshots will be emailed to: ' . config('dusk-failures.recipient'));
        } catch(\Exception $e) {
            $this->error('There was a problem sending the screenshots.');
            $this->error($e->getMessage());
        }
    }
}
