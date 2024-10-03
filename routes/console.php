<?php

use Illuminate\Support\Facades\Schedule;

Schedule::command('due-date:check')->daily();
