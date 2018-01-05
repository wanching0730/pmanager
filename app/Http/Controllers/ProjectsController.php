<?php

namespace App\Http\Controllers;

use App\Project;
use App\Company;
use App\User;
use App\ProjectUser;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProjectsController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        if(Auth::check()){
            $projects = Project::where('user_id', Auth::user()->id)->get();

            return view('projects.index', ['projects'=>$projects]);
        }

        return view('auth.login');
    }

    public function adduser(Request $request)
    {
       //add user to projects

       //take a project, add a user to it
       $project = Project::find($request->input('project_id'));
       if(Auth::user()->id == $project->user_id)
       {
           $user = User::where('email', $request->input('email'))->first(); //retrieve single record

           //Check if user is already added to the project
           $projectUser = ProjectUser::where('user_id', $user->id)
           ->where('project_id', $project->id)
           ->first();

           if($projectUser)
           {
               //if user already exist, exit
               return redirect()->route('projects.show', ['project'=>$project->id])
               ->with('success', $request->input('email').' is already exist');
           }

           if($user && $project)
           {
               $project->users()->attach($user->id); 

               //***why pass in project->id, but use project->() in show.blade?? */
               return redirect()->route('projects.show', ['project'=>$project->id])
               ->with('success', $request->input('email').' was added to the project successfully');
           }           
       }

       return redirect()->route('projects.show', ['project'=>$project->id])
           ->with('errors', 'Error adding user to project');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create($company_id = null)
    {
        $companies = null;
        if(!$company_id){
            $companies = Company::where('user_id', Auth::user()->id)->get();
        }

        return view('projects.create', ['company_id'=>$company_id, 'companies'=>$companies]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        if(Auth::check()){
            $project = Project::create([
                'name' => $request->input('name'),
                'description' => $request->input('description'),
                'company_id'=> $request->input('company_id'),
                'user_id' => Auth::user()->id
            ]);

            if($project){
                return redirect()->route('projects.show', ['project' => $project->id])
                ->with('success', 'Project created successfully');
            }
        }

        return back()->withInput()->with('error', 'Error in creating new Project');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Project  $Project
     * @return \Illuminate\Http\Response
     */
    public function show(Project $project)
    {
        //search database to find matched ID
        //$Project = Project::where('id', $Project->id)->first();

        //$Project = Project::find($Project->id);

        $comments = $project->comments;

        return view('projects.show', ['project'=>$project, 'comments'=>$comments]);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Project  $Project
     * @return \Illuminate\Http\Response
     */
    public function edit(Project $project)
    {
        return view('projects.edit', ['project'=>$project]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Project  $Project
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Project $project)
    {
        $ProjectUpdate = Project::where('id', $project->id)
                            ->update([
                                'name'=>$request->input('name'),
                                'description'=>$request->input('description')
                            ]);

        if($ProjectUpdate){
            return redirect()->route('projects.show', ['Project'=>$project->id])
            ->with('success', 'Project updated successfully');
        }

        // go back to the page where we coming from
        return back()->withInput();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Project  $Project
     * @return \Illuminate\Http\Response
     */
    public function destroy(Project $project)
    {
        $findProject = Project::find($project->id);
        if($findProject->delete()){

            return redirect()->route('projects.index')
            ->with('success', 'Project deleted successfully');
        }

        return back()->withInput()->with('error', 'Project could not be deleted');
    }
}
