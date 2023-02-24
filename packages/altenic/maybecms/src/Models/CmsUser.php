<?php

namespace Altenic\MaybeCms\Models;

use Illuminate\Database\Eloquent\Relations\BelongsToMany;

trait CmsUser
{
    public function roles(): BelongsToMany
    {
        return $this->belongsToMany(Role::class)->withTimestamps();
    }
}
