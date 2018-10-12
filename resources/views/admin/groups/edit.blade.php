@extends('layouts.layout')

@section('title')
  {{__('Edit Groups')}}
@endsection

@section('sidebar')
@include('layouts.sidebar', ['sidebar'=> Menu::get('sidebar_admin')])
@endsection

@section('content')

<div class="container">
  <h1 style="margin:15px">Edit Group</h1>
  <div class="row">
    <div class="col-8">
      <div class="card card-body">
      {!! Form::model($group) !!}
        <div class="form-group">
          {!! Form::label('name', 'Group Name')!!}
          {!! Form::text('name', null, ['class'=> 'form-control']) !!}
          <div class="text-danger" v-if="addError.title">@{{addError.title[0]}}</div>
        </div>
        <div class="form-group">
          {!! Form::label('description', 'Description') !!}
          {!! Form::textarea('description', null, ['class'=> 'form-control', 'rows' => 3]) !!}
          <div class="text-danger" v-if="addError.description">@{{addError.title[0]}}</div>
        </div>
        <div class="form-group p-0">
          {!! Form::label('status', 'Status'); !!}
          {!! Form::select('status', ['Active', 'Inactive', 'Draft'], null, ['class' => 'form-control']) !!}
        </div>
        
        <div class="card-body text-right pr-0">
          {!! Form::button('Cancel', ['class'=>'btn btn-outline-success']) !!}
          {!! Form::submit('Save', ['class'=>'btn btn-success ml-2']) !!}
        </div>
        {!! Form::close() !!}
      </div>
    </div>
    <div class="col-4">
      <div class="card card-body">
      Lorem ipsum dolor sit amet, consectetur adipisicing elit, sed do eiusmod tempor incididunt ut labore et dolore magna aliqua. Ut enim ad minim veniam, quis nostrud exercitation ullamco laboris nisi ut aliquip ex ea commodo consequat. Duis aute irure dolor in reprehenderit in voluptate velit esse cillum dolore eu fugiat nulla pariatur. Excepteur sint occaecat cupidatat non proident, sunt in culpa qui officia deserunt mollit anim id est laborum.
    </div>
  </div>
</div>
@endsection

@section('js')
<script>
  new Vue({
    el: '#addScript',
    data: {
      name: '',
      description: '',
      status: '',
      addError: {},
      submitted: false
    },
    methods: {
      onSubmit() {
        this.submitted = true;
        ProcessMaker.apiClient.put("/groups/" + uuid, {
          name: this.name,
          description: this.description
        })
        .then(response => {
          ProcessMaker.alert('Group successfully updated', 'success')
          window.location = "/admin/groups/" + response.data.uuid
        })
        .catch(error => {
          if (error.response.status === 422) {
            this.addError = error.response.data.errors
          }
        })
        .finally(()=> {
          this.submitted = false
        })
      }
    }
  })       
</script>
@endsection