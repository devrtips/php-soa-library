<?php

namespace Devrtips\Soa;

class BaseRepository
{
    protected function db()
    {
        return app('db');
    }
}

