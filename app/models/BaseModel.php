<?php

class BaseModel extends Eloquent {

    public function getCreatedAtAttribute($attr)
    {        
        return Carbon::parse($attr)->format('D M d, Y h:i A');
    }
    public function getUpdatedAtAttribute($attr) {        
        return Carbon::parse($attr)->format('D M d, Y h:i A');
    }
}