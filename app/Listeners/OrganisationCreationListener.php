<?php

namespace App\Listeners;

use Illuminate\Support\Facades\Mail;
use Illuminate\Queue\InteractsWithQueue;
use App\Events\OrganisationCreationEvent;
use Illuminate\Contracts\Queue\ShouldQueue;

class OrganisationCreationListener
{
    /**
     * Create the event listener.
     *
     * @return void
     */
    public function __construct()
    {
        //
    }

    /**
     * Handle the event.
     *
     * @param  \App\Events\OrganisationCreationEvent  $event
     * @return void
     */
    public function handle(OrganisationCreationEvent $event)
    {
        $organisation = $event->organisation;
        $user = $organisation->owner;

        Mail::send('emails.organisation-created', compact('organisation'), function ($m) use ($organisation) {
            $m->to($organisation->owner->email, $organisation->owner->name)
                ->subject('Your organisation ' . $organisation->name . ' has been created!');
        });
    }
}
