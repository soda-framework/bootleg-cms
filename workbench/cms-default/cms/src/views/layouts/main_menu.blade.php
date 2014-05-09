<div class="col-sm-3 col-md-2 sidebar">
    <ul class="nav nav-sidebar">
        <li class="{{Request::is(Utils::cmsRoute.'users/dashboard*')?'active':''}}">
            <a href="{{action('UsersController@anyDashboard', array())}}">
                <i class="menu-icon glyphicon glyphicon-home"></i>
                <span class="mm-text">Dashboard</span>
            </a>
        </li>
        <li class="{{Request::is(Utils::cmsRoute.'content/*')?'active':''}}">
            <a href="{{action('ContentsController@anyIndex', array())}}">
                <i class="menu-icon glyphicon glyphicon-list-alt"></i>
                <span class="mm-text">Content</span>
            </a>
        </li>
        <li class="{{Request::is(Utils::cmsRoute.'users/index*')?'active':''}}">
            <a href="{{action('UsersController@anyIndex', array())}}">
                <i class="menu-icon glyphicon glyphicon-user"></i>
                <span class="mm-text">Users</span>
            </a>
        </li>
        <li class="{{Request::is(Utils::cmsRoute.'application/settings*')?'active':''}}">
            <a href="{{action('ApplicationController@anySettings', array())}}">
                <i class="menu-icon glyphicon glyphicon-cog"></i>
                <span class="mm-text">Settings</span>
            </a>
        </li>
        <li class="text-center menu-additional">
            <?php
                $application = Application::getApplication();
            ?>
            <h2>{{@$application->name}}</h2>
            <div class="btn-group">
                <a href="{{action('UsersController@anyLogout', array())}}" class="btn btn-danger btn-sm"><span class="glyphicon glyphicon-log-out"></span></a>
                <a href="{{action('UsersController@anySettings', array())}}" class="btn btn-warning btn-sm"><span class="glyphicon glyphicon-cog"></span></a>
                <a href="{{action('UsersController@anySettings', array())}}" class="btn btn-primary btn-sm"><span class="glyphicon glyphicon-user"></span></a>
            </div>
        </li>
    </ul>
</div>