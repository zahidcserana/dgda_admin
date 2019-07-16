@extends('layouts.master')
@section('content')
    <div class="m-content">
        <div class="row">
            <div class="col-lg-12">
            @if(!empty($user))
                <!--begin::Portlet-->
                    <div class="m-portlet">
                        <div class="m-portlet__head">
                            <div class="m-portlet__head-caption">
                                <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                                    <h3 class="m-portlet__head-text">
                                        <span style="color: #0b2e13">Change Password: </span>
                                        <i style="padding-left: 50px">Name: {{$user->name}}</i>,
                                        <i style="padding-left: 50px">Email: {{$user->email}}</i>
                                    </h3>
                                </div>
                            </div>
                        </div>
                        <!--begin::Form-->
                        <form class="m-form" name="data-form" method="POST" action="{{route('user_edit',$user->id)}}">
                            {{ csrf_field() }}
                            <div class="m-portlet__body">
                                <div class="m-form__section m-form__section--first">
                                    <div class="form-group m-form__group row">
                                        <label class="col-lg-2 col-form-label">
                                            Password:
                                        </label>
                                        <div class="col-lg-3">
                                            <input type="text" name="password" class="form-control m-input">
                                        </div>
                                        <label class="col-lg-2 col-form-label">
                                            Confirm Password:
                                        </label>
                                        <div class="col-lg-3">
                                            <input type="text" name="password_confirmation"
                                                   class="form-control m-input">
                                        </div>
                                        <div class="col-lg-1">
                                            <button type="submit" class="btn btn-success">
                                                Submit
                                            </button>
                                        </div>
                                        <div class="col-lg-1">
                                            <button type="reset" id="reset" class="btn btn-secondary">
                                                Cancel
                                            </button>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <!--end::Form-->
                    </div>
            @endif
            <!--end::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div style="float: left" class="m-portlet__head-title">
                                <h3 class="m-portlet__head-text">
                                    User List
                                </h3>
                            </div>
                            <div style="float: right;padding-top: 1%;">
                                <a class="btn btn-primary" href="{{route('register')}}">Add New User</a>
                            </div>
                        </div>
                    </div>
                    <div class="m-portlet__body">
                        @if ($errors->any())
                            <div class="alert alert-danger">
                                <ul>
                                    @foreach ($errors->all() as $error)
                                        <li>{{ $error }}</li>
                                    @endforeach
                                </ul>
                            </div>
                        @endif
                        @if (session('status'))
                            <div class="alert alert-success">
                                {{ session('status') }}
                            </div>
                    @endif
                    <!--begin::Section-->
                        <div class="m-section">
                            <div class="m-section__content">
                                <table class="table m-table m-table--head-bg-success">
                                    <thead>
                                    <tr>
                                        <th>
                                            #
                                        </th>
                                        <th>
                                            Name
                                        </th>
                                        <th>
                                            Email
                                        </th>
                                        <th>
                                            Created
                                        </th>
                                        <th>
                                            Action
                                        </th>
                                    </tr>
                                    </thead>
                                    <tbody>
                                    @foreach($users as $row)
                                        <tr>
                                            <th scope="row">
                                                {{$row->id}}
                                            </th>
                                            <td>
                                                {{$row->name}}
                                            </td>
                                            <td>
                                                {{$row->email}}
                                            </td>
                                            <td>
                                                {{$row->created_at}}
                                            </td>
                                            <td>
                                                <div class="dropdown">
                                                    <button class="btn btn-default dropdown-toggle" type="button" data-toggle="dropdown" data-hover="dropdown">
                                                        Action <span class="caret"></span>
                                                    </button>
                                                    <ul class="dropdown-menu">
                                                        <li><a href="{{url('/users',$row->id)}}">Change Password</a></li>
                                                        <li><a href="{{url('/user-delete',$row->id)}}">Delete</a></li>
                                                    </ul>
                                                </div>
                                            </td>
                                        </tr>
                                    @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                        <!--end::Section-->
                    </div>
                    <!--end::Form-->
                </div>
            </div>
        </div>
    </div>
@endsection