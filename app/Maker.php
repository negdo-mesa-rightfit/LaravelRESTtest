<?php namespace App;
use Illuminate\Database\Eloquent\Model;

class Maker extends Model 
{

	protected $table = 'makers';	

	protected $fillable = ['id', 'name', 'phone'];
	
	protected $hidden = ['id', 'created_at', 'updated_at'];  

	public function vehicles()
	{
		return $this->hasMany('App\Vehicle');
	}
}

 ?>