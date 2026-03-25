<?php

namespace Modules\Seguranca\Listeners;

use Illuminate\Http\Request;
use Illuminate\Auth\Events\Login;
use Modules\Seguranca\Logging\BaseLog;

class LogLoginListener
{

    protected $request;
    /**
     * Create the event listener.
     */
    public function __construct(Request $request) 
    {
        $this->request = $request;
    }

    /**
     * Handle the event.
     */
    public function handle($event): void 
    {
        $user = $event->user;
        BaseLog::info($this->request, 'Usuario realizando Login no sistema usr_id: '.$user->usr_id);
    }
}
