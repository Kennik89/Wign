<?php namespace App;
 
use Illuminate\Database\Eloquent\Model;

class Word extends Model {

    // MASS ASSIGNMENT ------------------------------------------
    // define which attributes are mass assignable (for security)
    protected $fillable = array('word');

    // DEFINING RELATIONSHIPS -----------------------------------
    public function signs()
    {
        return $this->hasMany('App\Sign');
    }

    public function request()
    {
        return $this->hasMany('App\RequestWord');
    }

    // CREATE SCOPES -----------------------------------------------
    // It makes it easier to make some certain queries
    public function scopeLatest($query, $antal = 25)
    {
        return $query->orderBy('updated_at', 'desc')->take($antal);
    }

    public function scopeRandom($query, $antal = 1){
        $totalRows = static::has('signs')->count() - 1;
        $skip = $totalRows > 0 ? mt_rand(0, $totalRows) : 0;

        return  $query->skip($skip)->take($antal);
    }
}