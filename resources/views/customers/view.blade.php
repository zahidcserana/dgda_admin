@extends('layouts.master')
@section('include_js')
    @parent
    <link rel="stylesheet" href="{{ asset('assets/cropper/cropper.css') }}">
    <script src="{{ asset('js/jquery.min.js') }}" type="text/javascript"></script>
    <script src="{{ asset('assets/cropper/cropper.min.js') }}"></script>
    <style>
        img {
            max-width: 100%;
        }
    </style>
    <script>
        $(document).ready(function(){
            var cropper;
            var div2Width;
            var imageWidth;
            $("#change_picture").click(function()
            {
                $( "#imageFile" ).click();
            });
            $("#picture_change").click(function()
            {
                $( "#imageFile" ).click();
            });
            $( "#imageFile" ).change(function()
            {
                console.log('cropper created');
                var _URL = window.URL || window.webkitURL;
                img = new Image();
                img.onerror = function() { alert('Please chose an image file!'); };
                img.onload = function () {
                    var imageWidth = this.width;
                    $("#imageCropped").hide();
                    $('#image_upload').attr('src',this.src);
                    $("#image-div1").show();
                    $("#change_picture").hide();
                    $("#back").hide();
                    $("#save").hide();
                    $("#discard").show();
                    $("#getCroppedImage").show();
                    $('#modalChangePicture').modal('show');
                };
                img.src = _URL.createObjectURL(this.files[0]);
            });

            $("#getCroppedImage").click(function(){
                var imageSrc = cropper.getCroppedCanvas().toDataURL('image/jpeg');
                $("#image-div1").hide();
                $("#imageCropped").show();
                $("#imageCropped").attr('src', imageSrc );
                $("#save").show();
                $("#discard").show();
                $("#back").show();
                $("#change_picture").hide();
                $("#getCroppedImage").hide();

            });

            $( "#save" ).click(function()
            {
                $(".progress").show();
                var img = document.getElementById('imageFile');
                var cropedImg = $('#imageCropped').attr('src');
                $('#base_image').attr('src',cropedImg);
                var CSRF_TOKEN = "{{ csrf_token() }}";
                var data = new FormData();
                data.append('file', img.files[0]);
                data.append('user_id', $("#userId").val());
                data.append('cropedImageContent', cropedImg);
                data.append('_token', CSRF_TOKEN);
                var Url = "{{route('customer_image')}}";

                var xhr = new XMLHttpRequest();
                xhr.upload.addEventListener('progress',function(ev){
                    var progress = parseInt(ev.loaded / ev.total * 100);
                    $('#progressBar').css('width', progress + '%');
                    $('#progressBar').html(progress + '%');
                }, false);
                xhr.onreadystatechange = function(ev)
                {
                    console.log(xhr.readyState);
                    if(xhr.readyState == 4){
                        if(xhr.status = '200')
                        {
                            $("#imageCropped").hide();
                            $(".progress").hide();
                            $("#save").hide();
                            $("#back").hide();
                            $("#discard").hide();
                            $("#getCroppedImage").hide();
                            $('#progressBar').css('width','0' + '%');
                            $('#progressBar').html('0' + '%');
                            $('#modalChangePicture').modal('hide');
                            $(".image-profile").show();
                        }

                    }
                };
                xhr.open('POST', Url , true);
                xhr.send(data);
                return false;
            });

            $( "#back" ).click(function()
            {
                $("#image-div1").show();
                $("#imageCropped").hide();
                $("#discard").show();
                $("#getCroppedImage").show();
                $("#save").hide();
                $("#back").hide();
                $("#change_picture").hide();

            });

            $( "#discard" ).click(function()
            {
                $('#modalChangePicture').modal('hide');
            });

            $("#modalChangePicture").on('hidden.bs.modal', function () {
                console.log('hide modal');
                cropper.destroy();
                $("#imageFile").val("");
            });

            $('#modalChangePicture').on('shown.bs.modal', function() {
                var div2Width = $("#upImage").width();
                if (this.width<div2Width)
                {
                    document.getElementById('image-div1').style.width = this.width;
                }
                var image = document.getElementById('image_upload');

                cropper = new Cropper(image, {
                    aspectRatio: 1,
                    crop: function(e) {
                        console.log(e.detail.x);
                        console.log(e.detail.y);
                        console.log(e.detail.width);
                        console.log(e.detail.height);
                        console.log(e.detail.rotate);
                        console.log(e.detail.scaleX);
                        console.log(e.detail.scaleY);
                    }
                });
            });
        });
    </script>


@endsection

@section('content')
    <!-- BEGIN: Subheader -->
    <div class="m-subheader ">
        <div class="d-flex align-items-center">
            <div class="mr-auto">
                <h3 class="m-subheader__title m-subheader__title--separator">
                    Customer Details
                </h3>
                <ul class="m-subheader__breadcrumbs m-nav m-nav--inline">
                    <li class="m-nav__item m-nav__item--home">
                        <a href="#" class="m-nav__link m-nav__link--icon">
                            <i class="m-nav__link-icon la la-home"></i>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{route('customers')}}" class="m-nav__link">
											<span class="m-nav__link-text">
												Products
											</span>
                        </a>
                    </li>
                    <li class="m-nav__separator">
                        -
                    </li>
                    <li class="m-nav__item">
                        <a href="{{'add_customer'}}" class="m-nav__link">
											<span class="m-nav__link-text">
												New
											</span>
                        </a>
                    </li>
                </ul>
            </div>
            <div>
                <div class="m-dropdown m-dropdown--inline m-dropdown--arrow m-dropdown--align-right m-dropdown--align-push"
                     data-dropdown-toggle="hover" aria-expanded="true">
                    <a href="#"
                       class="m-portlet__nav-link btn btn-lg btn-secondary  m-btn m-btn--outline-2x m-btn--air m-btn--icon m-btn--icon-only m-btn--pill  m-dropdown__toggle">
                        <i class="la la-plus m--hide"></i>
                        <i class="la la-ellipsis-h"></i>
                    </a>
                    <div class="m-dropdown__wrapper">
                        <span class="m-dropdown__arrow m-dropdown__arrow--right m-dropdown__arrow--adjust"></span>
                        <div class="m-dropdown__inner">
                            <div class="m-dropdown__body">
                                <div class="m-dropdown__content">
                                    <ul class="m-nav">
                                        <li class="m-nav__section m-nav__section--first m--hide">
															<span class="m-nav__section-text">
																Quick Actions
															</span>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-share"></i>
                                                <span class="m-nav__link-text">
																	Activity
																</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-chat-1"></i>
                                                <span class="m-nav__link-text">
																	Messages
																</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-info"></i>
                                                <span class="m-nav__link-text">
																	FAQ
																</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__item">
                                            <a href="" class="m-nav__link">
                                                <i class="m-nav__link-icon flaticon-lifebuoy"></i>
                                                <span class="m-nav__link-text">
																	Support
																</span>
                                            </a>
                                        </li>
                                        <li class="m-nav__separator m-nav__separator--fit"></li>
                                        <li class="m-nav__item">
                                            <a href="#"
                                               class="btn btn-outline-danger m-btn m-btn--pill m-btn--wide btn-sm">
                                                Submit
                                            </a>
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <!-- END: Subheader -->
    <div class="m-content">
        @if ($errors->any())
            <div class="alert alert-danger">
                <ul>
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif
        <div class="row">
            <div class="col-lg-12">
                <!--begin::Portlet-->
                <div class="m-portlet">
                    <div class="m-portlet__head">
                        <div class="m-portlet__head-caption">
                            <div class="m-portlet__head-title">
												<span class="m-portlet__head-icon m--hide">
													<i class="la la-gear"></i>
												</span>
                                <h3 class="m-portlet__head-text">
                                    Customer Info
                                </h3>
                            </div>
                        </div>
                    </div>
                    <!--begin::Form-->
                    <form class="m-form" name="data-form" method="POST" action="{{route('customer_edit',$customer->id)}}">
                        {{ csrf_field() }}
                        <div class="m-portlet__body">
                            <input type="hidden" id="userId" value="{{$customer->id}}">
                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-2 col-form-label">
                                    Image
                                </label>
                                <div class="col-10">
                                    @include('customers.image')
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-text-input" class="col-1 col-form-label">
                                    Name
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="text" value="{{$customer->name}}" id="name" name="name">
                                </div>
                                <label for="example-search-input" class="col-1 col-form-label">
                                    Email
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="email" value="{{$customer->email}}" id="email" name="email">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-tel-input" class="col-1 col-form-label">
                                    Telephone
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="tel" value="{{$customer->phone}}" id="phone" name="phone">
                                </div>

                                <label for="example-number-input" class="col-1 col-form-label">
                                    Mobile
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="number" value="{{$customer->mobile}}" id="mobile" name="mobile">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-month-input" class="col-1 col-form-label">
                                    Contact Date
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="date" value="{{$customer->contact_date}}" id="contact_date" name="contact_date">
                                </div>

                                <label for="example-color-input" class="col-1 col-form-label">
                                    Address
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="text" value="{{$customer->address}}" id="address" name="address">
                                </div>
                            </div>

                            <div class="form-group m-form__group row">
                                <label for="example-color-input" class="col-1 col-form-label">
                                    Company
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="text" value="{{$customer->company}}" id="company" name="company">
                                </div>

                                <label for="example-color-input" class="col-1 col-form-label">
                                    Service
                                </label>
                                <div class="col-5">
                                    <input class="form-control m-input" type="text" value="{{$customer->service}}" id="service" name="service">
                                </div>
                            </div>
                        </div>
                        <div class="m-portlet__foot m-portlet__foot--fit">
                            <div class="m-form__actions m-form__actions">
                                <div class="row">
                                    <div class="col-lg-3"></div>
                                    <div class="col-lg-6">
                                        <button type="submit" class="btn btn-success">
                                            Submit
                                        </button>
                                        <a class="btn btn-secondary" href="{{route('customers')}}">Cancel</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </form>
                    <!--end::Form-->
                </div>
                <!--end::Portlet-->
            </div>
        </div>
    </div>

@endsection