<?php namespace BFACP\AdKats;

use BFACP\Elegant;
use Carbon\Carbon;

class Record extends Elegant
{
    /**
     * Table name
     * @var string
     */
    protected $table = 'adkats_records_main';

    /**
     * Table primary key
     * @var string
     */
    protected $primaryKey = 'record_id';

    /**
     * Fields not allowed to be mass assigned
     * @var array
     */
    protected $guarded = ['record_id'];

    /**
     * Date fields to convert to carbon instances
     * @var array
     */
    protected $dates = ['record_time'];

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
    protected $appends = ['is_web', 'stamp'];

    /**
     * Models to be loaded automaticly
     * @var array
     */
    protected $with = ['server'];

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function target()
    {
        return $this->belongsTo('BFACP\Battlefield\Player', 'target_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function source()
    {
        return $this->belongsTo('BFACP\Battlefield\Player', 'source_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function server()
    {
        return $this->belongsTo('BFACP\Battlefield\Server', 'server_id');
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function type()
    {
        return $this->belongsTo('BFACP\AdKats\Command', 'command_type')->select([
            'command_id',
            'command_active',
            'command_name',
            'command_playerInteraction'
        ]);
    }

    /**
     * @return \Illuminate\Database\Eloquent\Model
     */
    public function action()
    {
        return $this->belongsTo('BFACP\AdKats\Command', 'command_action')->select([
            'command_id',
            'command_active',
            'command_name',
            'command_playerInteraction'
        ]);
    }

    /**
     * Was record issued from the web
     * @return bool
     */
    public function getIsWebAttribute()
    {
        return $this->attributes['adkats_web'] == 1;
    }

    public function getStampAttribute()
    {
        return $this->record_time->toIso8601String();
    }
}
