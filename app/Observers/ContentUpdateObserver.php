<?php

namespace App\Observers;

use App\Models\ContentUpdate;
use Illuminate\Support\Facades\Http;

class ContentUpdateObserver
{
    /**
     * Handle the ContentUpdate "created" event.
     */
    public function created(ContentUpdate $contentUpdate): void
    {
        //
    }

    /**
     * Handle the ContentUpdate "updated" event.
     */
    public function updated(ContentUpdate $contentUpdate): void
    {
        //
    }

    /**
     * Handle the ContentUpdate "deleted" event.
     */
    public function deleted(ContentUpdate $contentUpdate): void
    {
        //
    }

    /**
     * Handle the ContentUpdate "restored" event.
     */
    public function restored(ContentUpdate $contentUpdate): void
    {
        //
    }

    /**
     * Handle the ContentUpdate "force deleted" event.
     */
    public function forceDeleted(ContentUpdate $contentUpdate): void
    {
        //
    }
}
