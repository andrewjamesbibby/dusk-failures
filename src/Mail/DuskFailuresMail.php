<?php

namespace Bibby\DuskFailures\Mail;

use Illuminate\Queue\SerializesModels;
use Bibby\DuskFailures\DuskFailures;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use File;

class DuskFailuresMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The options
     *
     * @var array
     */
    private $options;

    /**
     * DuskFailuresMail constructor.
     *
     * @param null $build
     * @param bool $console
     * @param bool $zip
     */
    public function __construct($build = null, $console = false, $zip = false)
    {
        $this->options = [ 'build' => $build, 'console' => $console, 'zip' => $zip ];
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build(DuskFailures $failures)
    {
        $view = $this->view('dusk-failures::failures', [
            'screenshots' => $failures->getScreenshots(),
            'options'     => $this->options,
        ]);

        if($this->options['zip']){
            $view->attach($failures->zipScreenshots());
        }

        if($this->options['console']){
            $view->attach($failures->zipConsole());
        }

        return $view;
    }
}
