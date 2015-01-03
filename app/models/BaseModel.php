<?php

class BaseModel extends Eloquent {

    public function getCreatedAtAttribute($attr)
    {        
        return Carbon::parse($attr)->format('D jS \\of F Y h:i A'); //Change the format to whichever you desire
    }
    public function getUpdatedAtAttribute($attr) {        
        return Carbon::parse($attr)->format('D jS \\of F Y h:i A'); //Change the format to whichever you desire
    }
}