<?php namespace BFACP\AdKats;

use BFACP\Elegant;
use Carbon\Carbon;

class Statistics extends Elegant
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'adkats_statistics';

    /**
     * Table primary key
     * @var string
     */
    protected $primaryKey = 'stat_id';

    /**
     * Fields not allowed to be mass assigned
     * @var array
     */
    protected $guarded = ['*'];

    /**
     * Date fields to convert to carbon instances
     * @var array
     */
    protected $dates = ['stat_time'];

    /**
     * Should model handle timestamps
     *
     * @var boolean
     */
    public $timestamps = false;

    /**
     * Append custom attributes to output
     * @var array
     */
    protected $appends = [];

    /**
     * Models to be loaded automaticly
     * @var array
     */
    protected $with = ['server'];

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function player()
    {
        return $this->belongsTo('BFACP\Battlefield\Player', 'target_id');
    }

    /**
     * Only get certian types.
     * @param  array $type
     * @return object
     */
    public function scopeOfTypes($query, $type)
    {
        return $query->whereIn('stat_type', $type);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function server()
    {
        return $this->belongsTo('BFACP\Battlefield\Server', 'server_id')->select([
            'ServerID',
            'ServerName',
            'GameID'
        ]);
    }
}
