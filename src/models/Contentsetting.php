<?php
use Illuminate\Database\Eloquent\SoftDeletes;

class Contentsetting extends Eloquent {
    protected $fillable = array('content_id', 'name', 'value', 'field_type');

    protected $table = 'content_settings';
    
    use SoftDeletes;
    protected $dates = ['deleted_at'];
    
    const DEFAULT_UPLOAD_JSON = '{
        "validation": {
          "mimes":"gif,jpeg,bmp,png",
          "size":"5120"
        },
        "tooltip": "",
        "max_number": 1
    }';
    
    const DEFAULT_DROPDOWN_JSON = '{
        "values": {
          "": "Please Select",
          "customise": "You need to cusomise the values from field_parameters"
        },
        "max_number":1,
        "tooltip": ""
    }';

    const DEFAULT_DATEPICKER_JSON = '{
        "options":{
            "data-date-format": "dd/mm/yyyy",
            "data-date-today-button": "true"
        },
        "max_number":1,
        "tooltip": ""
    }';

    const DEFAULT_CHECKBOX_JSON = '{
        "values": {
          "checked": "1",
          "unchecked": "0"
        },
        "tooltip": ""
    }';
    
    const DEFAULT_TEXT_JSON = '{
        "tooltip":"",
        "max_number":1
    }';

    const DEFAULT_TINYMCE_JSON = '{
        "tooltip":"",
        "max_number":1,
        "height":300
    }';
    
    
    public function languages($code = NULL){

        $langs = $this->hasMany('ContentsettingLanguage', 'content_setting_id');
        if($code){
            $langs->where('code',$code);
        }
        return($langs);
    }
    
    
    
    /*
     * Grabs the params field from wherever it can and parses the json.
     */
    public static function parseParams($setting){
        if(@$setting->field_parameters){
            $params = $setting->field_parameters;
        }
        else if(@$setting->default_setting->field_parameters){
            $params = @$setting->default_setting->field_parameters;
        }
        else{
            $params = self::getDefaultParams($setting);
        }
        return(json_decode($params));
    }
    
    public static function getDefaultParams($setting){
        //todo: there must be a nicer way than this..
        //dd($setting->field_type);
        if($setting->field_type == 'upload'){
            $params = self::DEFAULT_UPLOAD_JSON;
        }
        else if($setting->field_type == 'dropdown'){
            $params = self::DEFAULT_DROPDOWN_JSON;
        }
        else if($setting->field_type == 'checkbox'){
            $params = self::DEFAULT_CHECKBOX_JSON;
        }
        else if($setting->field_type == 'datepicker'){
            $params = self::DEFAULT_DATEPICKER_JSON;
        }
        else if($setting->field_type == 'tinymce'){
            $params = self::DEFAULT_TINYMCE_JSON;
        }
        else{
            $params = self::DEFAULT_TEXT_JSON;
        } 
        return($params);
    }

    public function getValueAttribute($value){
        $this->language = $this->languages(\App::getLocale())->first();
        return @$this->language->value?$this->language->value:$value;
    }

    public function getNameAttribute($name){
        $this->language = $this->languages(\App::getLocale())->first();
        return @$this->language->name?$this->language->name:$name;
    }
}
