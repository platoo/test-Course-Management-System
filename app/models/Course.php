<?php

class Course extends Eloquent {

	

	/**
	 * The database table used by the model.
	 *
	 * @var string
	 */
	protected $table = 'courses';

	public function category()
    {
        return $this->belongsTo('category');
    }

    public function createdBy()
    {
        return $this->belongsTo('User','created_by');
    }

}
