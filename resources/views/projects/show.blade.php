@extends('layouts.app')

@section('content')
  <div class="col-md-9 col-lg-9 col-sm-9 pull-left">
         <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <div class="masthead">
        <h3 class="text-muted">Project name</h3>
        <nav>
          <ul class="nav nav-justified">
            <li class="active"><a href="#">Home</a></li>
            <li><a href="#">Projects</a></li>
            <li><a href="#">Services</a></li>
            <li><a href="#">Downloads</a></li>
            <li><a href="#">About</a></li>
            <li><a href="#">Contact</a></li>
          </ul>
        </nav>
      </div>

      <!-- Jumbotron -->
      <div class="well well-lg">
        <h1>{{$project->name}}</h1>
        <p class="lead">{{$project->description}}</p>
        <!--<p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p>-->
      </div>

      <!-- Example row of columns -->
      <div class="row" style="background: white; margin: 10px">

      <!--<li><a href="/projects/create" class="pull-right btn btn-default">Add Project</a></li>-->

      </br>

      @include('partials.comments')

      <div class="container-fluid">
        <form method="post" action="{{ route('comments.store') }}">
              {{csrf_field()}}

              <input type="hidden" name="commentable_type" value="App\Project">
              <input type="hidden" name="commentable_id" value="{{ $project->id }}">

                <div class="form-group">
                  <label for="company-content"><i class="fa fa-commenting" aria-hidden="true"></i> Comments</label>
                  <textarea placeholder="Enter comment"
                          style="resize: vertical"
                          id="comment-content"
                          name="body"
                          rows="3"                     
                          spellcheck="false"
                          class="form-control autosize-target text-left">
                          </textarea>
                </div>

                <div class="form-group">
                <label for="company-name"><i class="fa fa-internet-explorer" aria-hidden="true"></i> URL (proof of work done)<span class="required">*</span></label>
                <input placeholder="Enter url"
                        id="comment-content" 
                        required
                        name="url"
                        spellcheck="false"
                        class="form-control" />
                </div>

                <div class="form-group">
                  <input type="submit" class="btn btn-primary" value="Submit"/>
                </div>
          </form>
        </div>

      </div>     

    <div class="col-sm-3 col-md-3 col-lg-3 pull-right">
          <!--<div class="sidebar-module sidebar-module-inset">
            <h4>About</h4>
            <p>Etiam porta <em>sem malesuada magna</em> mollis euismod. Cras mattis consectetur purus sit amet fermentum. Aenean lacinia bibendum nulla sed consectetur.</p>
          </div>-->

          <div class="sidebar-module">
            <h4>Actions</h4>
            <ol class="list-unstyled">
              <li><a href="/projects/{{$project->id}}/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></li>
              <li><a href="/projects/create"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add new project</a></li>   
              <li><a href="/projects"><i class="fa fa-list-ol" aria-hidden="true"></i> List of projects</a></li>

            <!-- Check whether the logged in person is the one who created the project or not -->
            @if($project->user_id == Auth::user()->id)   
              <li>
                <a
                href="#"
                  onclick="
                  var result = confirm('Are you sure you wish to delete this project?');
                    if(result){
                      event.preventDefault();
                      document.getElementById('delete-form').submit();
                      }"><i class="fa fa-trash" aria-hidden="true"></i> Delete                
                </a>

                <!-- form will not be displayed -->
                <form id="delete-form" action="{{ route('projects.destroy', [$project->id]) }}"
                      method="POST" style="display: none;">

                    <input type="hidden" name="_method" value="delete">
                      {{ csrf_field() }}
                </form>
              
              </li>
            @endif
            </ol>

            <hr/>

            <h4>Add Members</h4>
            <div class="row">
              <div class="col-lg-12 col-xs-12 col-md-12 col-sm-12">
              <form id="add-user" action="{{ route('projects.adduser') }}" method="POST">
              {{ csrf_field() }}
                <div class="input-group">   
                <input type="hidden" class="form-control" name="project_id" value="{{$project->id}}" >
                  <input type="text" class="form-control" name="email" placeholder="Email">
                  <span class="input-group-btn">
                    <button class="btn btn-default" type="submit">Add!</button>
                  </span>
                </div>
                </form>
              </div>
            </div>

            </br>

            <h4>Team Members</h4>
            <ol class="list-unstyled">
             @foreach($project->users as $user)
              <li><a href="#">{{$user->email}}</a></li>
            @endforeach
            </ol>

      </div>

          <!--<div class="sidebar-module">
            <h4>Archives</h4>
            <ol class="list-unstyled">
              <li><a href="#">March 2014</a></li>
            </ol>
          </div>-->

    </div>

@endsection