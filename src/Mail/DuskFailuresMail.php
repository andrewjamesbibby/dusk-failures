<?php

namespace Bibby\DuskFailures\Mail;

use Illuminate\Queue\SerializesModels;
use Illuminate\Bus\Queueable;
use Illuminate\Mail\Mailable;
use File;

class DuskFailuresMail extends Mailable
{
    use Queueable, SerializesModels;

    /**
     * The CI build reference.
     *
     * @var string
     */
    private $build;

    /**
     * The screenshots to send.
     *
     * @var array
     */
    private $screenshots;

    /**
     * DuskFailuresMail constructor.
     *
     * @param $screenshots
     * @param null $build
     */
    public function __construct($screenshots, $build = null)
    {
        $this->screenshots = $screenshots;
        $this->build = $build;
    }

    /**
     * Build the message.
     *
     * @return $this
     */
    public function build()
    {
        return $this->view('vendor.dusk-failures.failures', [
            'screenshots' => $this->screenshots,
            'build'       => $this->build
        ]);
    }
}
