@extends('layouts.app')

@section('content')
    <div class="col-md-9 col-lg-9 col-sm-9 pull-left">
         <!-- The justified navigation menu is meant for single line per list item.
           Multiple lines will require custom code not provided by Bootstrap. -->
      <div class="masthead">
        <h3 class="text-muted">Company name</h3>
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
      <div class="jumbotron">
        <h1>{{$company->name}}</h1>
        <p class="lead">{{$company->description}}</p>
        <!--<p><a class="btn btn-lg btn-success" href="#" role="button">Get started today</a></p>-->
      </div>

      <!-- Example row of columns -->
      <div class="row" style="background: white; margin: 10px">

      <li><a href="/projects/create" class="pull-right btn btn-default">Add Project</a></li>

        @foreach($company->projects as $project)
            <div class="col-lg-4">
              <h2>{{$project->name}}</h2>
              <p class="text-danger">{{$project->description}}</p>
              <p><a class="btn btn-primary" href="/projects/{{$project->id}}" role="button">View details »</a></p>
            </div>
        @endforeach
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
              <li><a href="/companies/{{$company->id}}/edit"><i class="fa fa-pencil-square-o" aria-hidden="true"></i> Edit</a></li>
              <li><a href="/projects/create"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add Project</a></li>
              <li><a href="/companies"><i class="fa fa-list-ol" aria-hidden="true"></i> List of companies</a></li>
              <li><a href="/companies/create"><i class="fa fa-plus-circle" aria-hidden="true"></i> Add new company</a></li>          

              <li>
                <a
                href="#"
                  onclick="
                  var result = confirm('Are you sure you wish to delete this company?');
                    if(result){
                      event.preventDefault();
                      document.getElementById('delete-form').submit();
                      }"><i class="fa fa-trash" aria-hidden="true"></i> Delete                
                </a>

                <!-- form will not be displayed -->
                <form id="delete-form" action="{{ route('companies.destroy', [$company->id]) }}"
                      method="POST" style="display: none;">

                    <input type="hidden" name="_method" value="delete">
                      {{ csrf_field() }}
                </form>
              
              </li>
              
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