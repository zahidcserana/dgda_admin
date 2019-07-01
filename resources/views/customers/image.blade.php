<div class="form-group">
    <div class="col-md-7 col-xs-8">
        <div class="alert alert-success image-profile" style="display: none">Image successfully uploaded</div>
        <img src="{{!empty($customer->image)?'/image/users/'.$customer->image:'/image/default-avatar.png'}}" id="base_image" alt="..." style="max-width: 150px; max-height: 150px">
        <div class="btn-group-vertical">
            <a href="javascript:void(0)" id="picture_change" class="btn btn-primary"><i class="fa fa-pencil-square-o" aria-hidden="true"></i></a>
        </div>
    </div>
</div>
<input type="hidden" id="image_width">
<input type="hidden" id="image_height">

{{--Image Upload Modal--}}
<div class="modal fade" id="modalChangePicture" role="dialog">
    <div class="modal-dialog">
        <div class="modal-content">
            <!--<div class="modal-header">
                <button id="modal_close" type="button" class="close" data-dismiss="modal">x</button>
                <h4 class="modal-title">Upload image</h4>
            </div>-->
            <div class="modal-body">
                <div class="f_section">
                    <div align="center">
                        <h4>Upload image</h4>
                    </div>
                    <div class="col-md-12" id="upImage" style="text-align: center;">
                        <div id="image-div1">
                            <img id="image_upload" src="" style="width: 100%;" alt="..." style='display: none;'>
                        </div>
                        <img id="imageCropped" src="" style="display: none; width:100%;">
                        <br>
                        <br>
                        <a href="javascript:void(0)" id="change_picture" class="btn btn-primary" style="display: none;">Change</a>
                        <div class="btn-group-horizontal">
                            <a href="javascript:void(0)" id="back" class="btn btn-primary" style="display: none;">Back</a>
                            <a href="javascript:void(0)" id="save" class="btn btn-primary" style="display: none;">Save</a>
                            <a href="javascript:void(0)" id="discard" class="btn btn-primary" style="display: none;">Cancel</a>
                            <input type='button' id='getCroppedImage' class="btn btn-primary" value='Get Cropped Area' >
                        </div>
                    </div>
                    <div class="col-md-12 col-sm-12 col-xs-12">
                        <input type="file" id="imageFile" style="display: none;">
                        <br>
                        <div class="progress" style="display: none;">
                            <div id="progressBar" class="progress-bar" role="progressbar" aria-valuenow="70" aria-valuemin="0" aria-valuemax="100" style="width:0%">0%</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
