@include('cms::layouts.flash_messages')

<h1>{{@$content->id?'Update':'Create'}} {{$content->name or 'Content'}}</h1>

<ul class="nav nav-tabs">
    <?php $i = 0; $advanced = false; $contentSection = false?>
    @foreach($settings as $key=>$section)
        <?php
        if($key == 'Advanced'){
            $advanced = true;
        }
        if($key == 'Content'){
            $contentSection = true;
        }
        ?>
        <li class='{{$i==0?"active":""}}'><a href="#tab-{{$key}}" data-toggle="tab">{{$key}}</a></li>
        <?php $i++; ?>
    @endforeach
    @if(!$contentSection)
        <li class="active"><a href="#tab-Content" data-toggle="tab">Content</a></li>
    @endif
    @if(!$advanced)
        <li><a href="#tab-Advanced" data-toggle="tab">Advanced</a></li>
    @endif
</ul>

{{ Form::model($content, array('method' => 'POST', 'files'=>true, 'class'=>'main-form', 'action' => array('ContentsController@anyUpdate', @$content->id))) }}
<div class="tab-content">
<?php 
$i = 0; 
if(!$contentSection){
    $settings['Content'] = 'dummy';
}
if(!$advanced){
    $settings['Advanced'] = 'dummy';
}
?>
@foreach($settings as $key=>$section)
    <?php
    //we need to group this correctly.. I think there is a bug in Laravel that prevents 
    //nested groups working correctly. TODO: Probably look at this again later after I've
    //had some sleep]
    $fields = "";
    if($key != 'Advanced'){
        $model = new Baum\Extensions\Eloquent\Collection;
        if(count($section) > 1){
            foreach($section as $flds){
                $model->push($flds);
            }
            $fields = $model->groupBy('name');
        }
    }
    ?>
    <div class="tab-pane {{$i==0?'active in':''}} fade edit-content-tab" id="tab-{{$key}}">
        <ul>
            @if($key == 'Advanced')
                <li class="form-group">
                    {{ Form::label('slug', 'Slug:') }}
                    <div class="input-group">
                        <?php
                        $niceFullSlug = "http://".ApplicationUrl::getApplicationUrl()->domain;
                        $niceFullSlug .= ApplicationUrl::getApplicationUrl()->folder=='/'?'':ApplicationUrl::getApplicationUrl()->folder;
                        ?>
                        <span class="input-group-addon">{{$niceFullSlug}}</span>

                    {{ Form::text('slug', null, array('class'=>'form-control')) }}
                    </div>
                </li>

                <li class="form-group">
                    {{ Form::label('identifier', 'Identifier:') }}
                    {{ Form::input('identifier', 'identifier', null, array('class'=>'form-control')) }}
                </li>

                <li class="form-group">
                    {{ Form::label('parent_id', 'Parent_id:') }}
                    {{ Form::input('number', 'parent_id', null, array('class'=>'form-control')) }}
                </li>
                
                <li class="form-group">
                    {{ Form::label('package', 'Package:') }}
                    {{ Form::input('text', 'package', null, array('class'=>'form-control')) }}
                </li>
                <li class="form-group">
                    {{ Form::label('service_provider', 'Service Provider:') }}
                    {{ Form::input('text', 'service_provider', null, array('class'=>'form-control')) }}
                </li>
                <li class="form-group">
                    {{ Form::label('view', 'View:') }}
                    {{ Form::input('text', 'view', null, array('class'=>'form-control')) }}
                </li>
                <li class="form-group">
                    {{ Form::label('layout', 'Layout:') }}
                    {{ Form::input('text', 'layout', null, array('class'=>'form-control')) }}
                </li>

                <li class="form-group">
                    {{ Form::label('content_type_id', 'content_type_id:') }}
                    {{ Form::input('number', 'content_type_id', null, array('class'=>'form-control')) }}
                </li>
            @endif
            
            @if($i == 0)
                <li class="form-group">
                    {{ Form::label('name', 'Name:') }}
                    {{ Form::text('name', null, array('class'=>'form-control')) }}
                </li>
                <li class="form-group">
                    <label>Status:</label>
                    <div class="radio">
                        <label>
                            {{ Form::radio('status','0','') }}
                            Draft
                        </label>
                    </div>
                    <div class="radio">
                        <label>
                            {{ Form::radio('status','1','') }}
                            Published
                        </label>
                    </div>
                </li>
            @endif
            
            @if(@$fields)
                @foreach($fields as $field)
                    <li class="form-group">
                        <?php
                        $view = @$field[0]->field_type?$field[0]->field_type:'text';
                        ?>
                        @include("cms::contents.input_types.$view", array('setting'=>$field, 'content'=>$content))
                    </li>
                @endforeach
            @endif


            <li class="form-group">
                <div class='btn-group btn-group-lg'>
                    {{ Form::submit(@$content->id?'Update':'Create', array('class' => 'btn btn-success')) }}
                    {{ link_to_action('ContentsController@anyEdit', 'Cancel', @$content->id, array('class' => 'btn btn-danger')) }}
                </div>
            </li>
        </ul>
    </div>
    <?php $i++; ?>
@endforeach
</div>
{{ Form::close() }}