<?php

namespace App\Repositories;

use App\Note;

class NoteRepository
{
    public function getCount ()
    {
        return Note::count();
    }
}