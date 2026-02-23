<?php

namespace App\Observers;

use App\Models\Maintainer;
use App\Models\User;

class MaintainerObserver
{
    public function created(Maintainer $maintainer): void
    {
        $this->updateMatchingUser($maintainer);
    }

    public function updated(Maintainer $maintainer): void
    {
        // Make sure we don't get in a loop
        if (! $maintainer->isDirty('user_id')) {
            $this->updateMatchingUser($maintainer);
        }
    }

    protected function updateMatchingUser(Maintainer $maintainer)
    {
        $user = User::where('github_username', $maintainer->github_username)->first();

        if ($user) {
            $maintainer->user_id = $user->id;
            $maintainer->save();
        }
    }
}
