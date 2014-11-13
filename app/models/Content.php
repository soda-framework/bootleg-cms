<?php

class Content extends Baum\Node{ //Eloquent {status
    protected $fillable = array('name', 'identifier', 'position', 'parent_id', 'set_parent_id', 'user_id', 'deleted_at', 'service_provider', 'view', 'layout', 'content_type_id', 'application_id', 'status', 'slug');
    
    protected $guarded = array('id', 'parent_id', 'lft', 'rgt', 'depth');
    
    public $table = 'content';
        
    public $policy, $signature;
    
    protected $softDelete = true;
    
    //protected $scoped = array('application_id');
    
    protected $_settings = NULL; //holds settings for this content item so we don't have to contantly query it.    
    
    protected $closure = '\contentClosure';
    

    //some refaults for thw whole app should normal database stuff fail.
    const SERVICE_PROVIDER = 'Bootleg\Cms\CmsServiceProvider';
    const PACKAGE = 'cms';
    const VIEW = 'default.view';
    const LAYOUT = 'default.layout';
    const EDIT_VIEW = 'contents.form';

    public $rules = array(
		//'content' => 'required',
		//'parent_id' => 'required'
    );

    public function author(){
        return $this->belongsTo('User');
    }
    
    public function application()
    {
        return($this->belongsTo('Application'));
    }

    public function content_parent()
    {
        return $this->belongsTo('Content');
    }
	
	public function template()
	{
		return $this->belongsTo('Template', 'template_id');
	}

    public function template_setting()
    {
        return $this->hasMany('Templatesetting', 'template_id', 'template_id');
    }

    public function default_page()
    {
        return $this->belongsTo('Contentdefaultpage', 'content_type_id');
    }
    
    public function default_fields()
    {
        return $this->belongsTo('Templatesetting', 'template_id');
    }

    public function permission()
    {
        return $this->morphMany('Permission', 'controller');
    }
    
    public function childs()
    {
        return $this->hasMany('Content', 'parent_id');
    }
    
    //keeps content within this application.
    public function scopeFromApplication($query)
    {
        $qu = $query->where('application_id', '=', Application::getApplication()->id);
        return($qu);
    }
    
    //keeps content within this application.
    public function scopeLive($query)
    {
        $qu = $query->where('status', '=', Content::LIVE_STATUS);
        return($qu);
    }

        
    public function setting()
    {
        return $this->hasMany('Contentsetting');
    }
    
//    public function contenttype(){
//    	return $this->belongsTo('Contenttype');
//    }
    
    const DRAFT_STATUS = 0;
    const LIVE_STATUS = 1;

	/*
	 *Mutator that should replace the attributes with the correct language
	 **/

    public static function boot(){
        parent::boot();
		
        
//        App::register($this->service_provider);
        
        
        //we need to fill in all the defaults for this item..

		
		Content::created(function($content){
			//we need check for sub pages and create them!
		});
        
    }
    
    /*recursivly create sub pages.*/
    public function superSave($input){
        $input = Content::loadDefaultValues($input);
        $parent = Content::find($input['parent_id']);
        $template = Template::find($input['template_id']);
        unset($input['parent_id']);
        //SAVE CONTENT ITEM
        $saved = $parent->children()->create($input);  
        if($template){
            $templateChildren = $template->getImmediateDescendants();
            foreach($templateChildren as $templateChild){
                //dd($templateChild->id);
                //we need to run a create on this..
                $inp['template_id'] = $templateChild->id;
                $inp['parent_id'] = $saved->id;
                $this->superSave($inp);
            }
        }
          
        return($saved);
    }
    
    //Loads default values into the model based off the tree stuff..
    public static function loadDefaultValues($input = ''){

		
        $parent = Content::find($input['parent_id']);
		
        if(!@$input['template_id']){
            $parentTemplate = Template::find($parent->template_id);
            if($parentTemplate){
                $parentTemplateChild = @$parentTemplate->getImmediateDescendants()->first();

                $input['template_id'] = @$parentTemplateChild->id;
                //dd('aaa'.$input['template_id']);
                
            }
            if(!@$input['template_id']){
                //if it's still nothing we can safely set this to 0;
                $input['template_id'] = null;
            }
        }
        $template = Template::find($input['template_id']);
		
		//dd($template->name);
        //TODO: replace with something like this: dd($this->default_fields()->first()->id);
        //$contentDefaultFields = Contentdefaultfield::where('content_type_id', '=', $this->content_type_id)->get();
        
        //plug in the fields we wanted..
        if(!@$input['template_id'])$input['template_id'] = @$template->id;
        if(!@$input['name'])$input['name'] = @$template->name;
        if(!@$input['view'])$input['view'] = @$template->view;
        if(!@$input['layout'])$input['layout'] = @$template->layout;
        if(!@$input['identifier'])$input['identifier'] = @$template->identifier;

        if(!@$input['package'])$input['package'] = @$template->package;
        if(!@$input['service_provider'])$input['service_provider'] = @$template->service_provider;

        if(!@$input['edit_view'])$input['edit_view'] = @$template->edit_view;
        if(!@$input['edit_package'])$input['edit_package'] = @$template->edit_package;
        if(!@$input['edit_service_provider'])$input['edit_service_provider'] = @$template->edit_service_provider;
		
        //work out the slug if not manually set
        if(!@$input['slug']){
            $input['slug'] = Content::createSlug($input, $parent);
        }
		
		
        //and the user_id (author)
        $input['user_id'] = Auth::user()->id;
        
        //and the application:
        if(!@$input['application_id']){
            $application = Application::getApplication();
            $input['application_id'] = $application->id;
        }
		
		//set language
		
		if(!@$input['language']){
            $input['language'] = App::getLocale();
        }
        
        //and the service_provider if not set
        if (!@$input['service_provider']) {
            //set it as parent one..
            $input['service_provider'] = @$parent->service_provider;
            
            //still nothing - set from application
            $application = Application::getApplication();
            if($application->service_provider){
                $input['service_provider'] = $application->service_provider;
            }
            
            //still nothing - we have to set it to default.
            if(!$input['service_provider']){
                //last ditch attempt to put something sensible in here
                $input['service_provider'] = Content::SERVICE_PROVIDER;
            }
        }
		
        
        //and the package if not set
        if(!@$input['package']){
            //set it as parent one..
            $input['package'] = @$parent->package;
            
            //still nothing - set from application
            $application = Application::getApplication();
            if($application->package){
                $input['package'] = $application->package;
            }
            
            //still nothing - we have to set it to default.
            if(!$input['package']){
                //last ditch attempt to put something sensible in here
                $input['package'] = Content::PACKAGE;
            }
        }


        //and the edit details:
        if (!@$input['edit_service_provider']) {
            //set it as parent one..
            $input['edit_service_provider'] = @$parent->edit_service_provider;
            
            //still nothing - we have to set it to default.
            if(!$input['edit_service_provider']){
                //last ditch attempt to put something sensible in here
                $input['edit_service_provider'] = Content::SERVICE_PROVIDER;
            }
        }

        if(!@$input['edit_package']){
            //set it as parent one..
            $input['edit_package'] = @$parent->edit_package;
            
            //still nothing - we have to set it to default.
            if(!$input['edit_package']){
                //last ditch attempt to put something sensible in here
                $input['edit_package'] = Content::PACKAGE;
            }
        }

        if(!@$input['edit_view']){
            //set it as parent one..
            $input['edit_view'] = @$parent->edit_view;
            
            //still nothing - we have to set it to default.
            if(!$input['edit_view']){
                //last ditch attempt to put something sensible in here
                $input['edit_view'] = Content::EDIT_VIEW;
            }
        }

        //and the view/layout if they're not set can safely be set to default.
        if(!@$input['layout']){
            $input['layout'] = Content::LAYOUT;
        }
        if(!@$input['view']){
            $input['view'] = Content::VIEW;
        }
		return($input);
    }
    
    
    public static function createSlug( $input, $parent ){

        if(@$input['name']){
            $pageSlug = $input['name'];
        }
        else{
            $pageSlug = uniqid();    
        }

        $pageSlug = str_replace(" ", "-", $pageSlug);    //spaces
        $pageSlug = urlencode($pageSlug);  //last ditch attempt to sanitise

        $wholeSlug = rtrim(@$parent->slug,"/")."/$pageSlug";
        //does it already exist?
        if(Content::where("slug","=",$wholeSlug)->first()){
            //it already exists.. find the highest numbered example and increment 1.
            $highest = Content::where('slug', 'like', "$wholeSlug-%")->orderBy('slug', 'desc')->first();
            $num = 1;
            if($highest){
                $num = str_replace("$wholeSlug-", "", $highest->slug);
                $num++;
            }
            return("$wholeSlug-$num");
        }
        else{
            return($wholeSlug);
        }
        
    }
    
    
    
    /*TODO: figure out this better.*/
    public function getTree($parent_id = null, $recurse = false){
        //TODO: look at this.
        if($parent_id){
            $contentTree = Content::fromApplication()->language()->where('parent_id', '=', $parent_id)->immediateDescendants();
        }
        else{
            $contentTree = $this->immediateDescendants();
        }
        
        $obj = new stdClass;
        $data = array();
        foreach($contentTree as $content){
            $data[] = '{
                "text": "'.$content->name.'",
                "state": {
                  "opened": false,
                  "selected": false
                },
                "li_attr":{},
                "a_attr":{}
            },';
        }
        $data[count($data)] = rtrim($data[count($data)], ',');
    }
    
    /*
     * returns a single setting given the name;
     */
    public function getSetting($getSetting){
        $settings = $this->setting->filter(function($model) use(&$getSetting){
            return $model->name === $getSetting;
            
        });
        if($settings->count() == 0){
            return null;
        }
        if($settings->count() > 1){
            $return = array();
            foreach($settings as $setting){
                $return[] = $setting->value;
            }
        }
        else{
            $return = $settings->first()->value;
        }
        return($return);
    }
    
    
    public static function getMainRoot(){
        return(Content::fromApplication()->whereNull('parent_id')->first());
    }
    
    /*duplicating $this app into $newApp*/
    public static function doop($recursive, $themeContent, $parent_id, $newAppId){  
        
        //we neeed to dupe all this crap..
        $newContent = new Content();
        $newContent->name = $themeContent->name;
        $newContent->slug = $themeContent->slug;
        $newContent->identifier = $themeContent->identifier;
        $newContent->service_provider = $themeContent->service_provider;
        $newContent->package = $themeContent->package;
        $newContent->view = $themeContent->view;
        $newContent->layout = $themeContent->layout;
        $newContent->content_type_id = $themeContent->content_type_id;
        $newContent->position = $themeContent->position;
        $newContent->edit_view = $themeContent->edit_view;
        $newContent->edit_service_provider = $themeContent->edit_service_provider;
        $newContent->edit_package = $themeContent->edit_package;
        $newContent->status = $themeContent->status;
        
        
        //$newContent->children = @$themeContent->children;
        if($themeContent->parent_id){
            $newContent->parent_id = $parent_id;
        }
        
        $newContent->application_id = $newAppId;
        echo('duplicated ' . $newContent->name."|".$newContent->application_id. "<br />");
        
        if($saved = $newContent->save()){
            if(@$themeContent->children){
                foreach($themeContent->children as $oldContent){
                    //dd($newContent->id);
                    Content::doop(true, $oldContent, $newContent->id, $newAppId);               
                    //exit();
                }
            }
        }
    }
}