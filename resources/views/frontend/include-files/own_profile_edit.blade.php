<div class="offcanvas offcanvas-end edit-profile scrollable" data-bs-backdrop="false" tabindex="-1" id="offcanvasRight" aria-labelledby="offcanvasRightLabel">
    <article class="animate-x">
        <div class="bg-white edit-profile-header position-sticky top-0 p-2" style="z-index: 2;">
            <header class="d-flex justify-content-between">
                <i class="fa fa-chevron-left fs-4" id="close-btn" data-bs-dismiss="offcanvas" aria-label="Close"></i>
            </header>
        </div>
        <section class="bg-white pb-4">
            <div class="">
                <table style="width: 100%; table-layout: fixed;">
                    <tr>
                        <td rowspan="2" colspan="2">
                            <div class="border border-primary bg-body-secondary rounded-2 m-1 m-md-2 d-flex justify-content-center align-items-center" style="height: 48vh; position: relative;" id="preview1">
                                <i class="fa fa-upload fs-1" id="upload1" style="cursor: pointer;" onclick="upload(1)"></i>
                                <label class="change_photo" id="label1" onclick="upload(1)" style="display:none;">Change</label>
                                <img ng-src="" id="image1" alt='preview image' width=100% height=100% style="object-fit: cover; display: none;"/>
                            </div>
                        </td>
                        <td>
                            <div class="border border-primary bg-body-secondary rounded-2 m-1 m-md-2 d-flex justify-content-center align-items-center" style="height: 23vh; position: relative;" id="preview2">
                                <i class="fa fa-upload fs-2" id="upload2" style="cursor: pointer;" onclick="upload(2)"></i></i>
                                <div class="bg-white rounded-2 position-absolute d-flex justify-content-center align-items-center" id="trash2" style="width: 25px; height: 25px; top: 5%; right: 5%; display:none !important;">
                                    <i class="fa fa-trash text-danger fs-4" id="trashicon2" style="cursor: pointer !important;" ng-click="deletePhoto('2')"></i>
                                </div>
                                <label class="change_photo" id="label2" onclick="upload(2)" style="display:none;">Change</label>
                                <img ng-src="" id="image2" alt='preview image' width=100% height=100% style="object-fit: cover; display: none;"/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="border border-primary bg-body-secondary rounded-2 m-1 m-md-2 d-flex justify-content-center align-items-center" style="height: 23vh; position: relative;" id="preview3">
                                <i class="fa fa-upload fs-2" id="upload3" style="cursor: pointer;" onclick="upload(3)"></i>
                                <div class="bg-white rounded-2 position-absolute d-flex justify-content-center align-items-center" id="trash3" style="width: 25px; height: 25px; top: 5%; right: 5%; display:none !important;">
                                    <i class="fa fa-trash text-danger fs-4" id="trashicon3" style="cursor: pointer !important;" ng-click="deletePhoto('3')"></i>
                                </div>
                                <label class="change_photo" id="label3" onclick="upload(3)" style="display:none;">Change</label>
                                <img ng-src="" id="image3" alt='preview image' width=100% height=100% style="object-fit: cover; display: none;"/>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <div class="border border-primary bg-body-secondary rounded-2 m-1 m-md-2 d-flex justify-content-center align-items-center" style="height: 23vh; position: relative;" id="preview4">
                                <i class="fa fa-upload fs-2" id="upload4" style="cursor: pointer;" onclick="upload(4)"></i>
                                <div class="bg-white rounded-2 position-absolute d-flex justify-content-center align-items-center" id="trash4" style="width: 25px; height: 25px; top: 5%; right: 5%; display:none !important;">
                                    <i class="fa fa-trash text-danger fs-4" id="trashicon4" style="cursor: pointer !important;" ng-click="deletePhoto('4')"></i>
                                </div>
                                <label class="change_photo" id="label4" onclick="upload(4)" style="display:none;">Change</label>
                                <img ng-src="" id="image4" alt='preview image' width=100% height=100% style="object-fit: cover; display: none;"/>
                            </div>
                        </td>
                        <td>
                            <div class="border border-primary bg-body-secondary rounded-2 m-1 m-md-2 d-flex justify-content-center align-items-center" style="height: 23vh; position: relative;" id="preview5">
                                <i class="fa fa-upload fs-2" id="upload5" style="cursor: pointer;" onclick="upload(5)"></i>
                                <div class="bg-white rounded-2 position-absolute d-flex justify-content-center align-items-center" id="trash5" style="width: 25px; height: 25px; top: 5%; right: 5%; display:none !important;">
                                    <i class="fa fa-trash text-danger fs-4" id="trashicon5" style="cursor: pointer !important;" ng-click="deletePhoto('5')"></i>
                                </div>
                                <label class="change_photo" id="label5" onclick="upload(5)" style="display:none;">Change</label>
                                <img ng-src="" id="image5" alt='preview image' width=100% height=100% style="object-fit: cover; display: none;"/>
                            </div>
                        </td>
                        <td>
                            <div class="border border-primary bg-body-secondary rounded-2 m-2 d-flex justify-content-center align-items-center" style="height: 23vh; position: relative;" id="preview6">
                                <i class="fa fa-upload fs-2" id="upload6" style="cursor: pointer;" onclick="upload(6)"></i>
                                <div class="bg-white rounded-2 position-absolute d-flex justify-content-center align-items-center" id="trash6" style="width: 25px; height: 25px; top: 5%; right: 5%; display:none !important;">
                                    <i class="fa fa-trash text-danger fs-4" id="trashicon6" style="cursor: pointer !important;" ng-click="deletePhoto('6')"></i>
                                </div>
                                <label class="change_photo" id="label6" onclick="upload(6)" style="display:none;">Change</label>
                                <img ng-src="" id="image6" alt='preview image' width=100% height=100% style="object-fit: cover; display: none;"/>
                            </div>
                        </td>
                    </tr>
                </table>
                <div id="input_container1">
                    <input type="file" style="display: none;" id="file1" name="file1" onchange="fileupload(1)"/>
                </div>
                <div id="input_container2">
                    <input type="file" style="display: none;" id="file2" name="file2" onchange="fileupload(2)"/>
                </div>
                <div id="input_container3">
                    <input type="file" style="display: none;" id="file3" name="file3" onchange="fileupload(3)"/>
                </div>
                <div id="input_container4">
                    <input type="file" style="display: none;" id="file4" name="file4" onchange="fileupload(4)"/>
                </div>
                <div id="input_container5">
                    <input type="file" style="display: none;" id="file5" name="file5" onchange="fileupload(5)"/>
                </div>
                <div id="input_container6">
                    <input type="file" style="display: none;" id="file6" name="file6" onchange="fileupload(6)"/>
                </div>
                <button class="d-block btn btn-dark rounded rounded-5 btn-lg mx-auto my-3" id="uploadButton" type="button" style="width: 96%;" ng-click="uploadPhotos()" disabled>Upload Photos</button>
                <div class="d-flex justify-content-between align-items-center mx-3 p-4 rounded-1" style="background-color: rgba(145,145,145,0.3)">
                    <div>
                        <span class="d-block fw-bold fs-4">@{{member.username}}, @{{member.age}}</span>
                        <span class="d-block">@{{member.gender_name}}, @{{member.city.name}}</span>
                    </div>
                    <span type="button" class="fs-4" aria-label="Back"><i class="fa fa-chevron-right"></i></span>
                </div>
            </div>
        </section>
        <div class="mx-3 mb-4 p-4 rounded-1" style="height: 100px; background-color: rgba(145,145,145,0.3);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="d-block fw-bold fs-4">Work</span>
                    <span class="d-block">@{{member.work}}</span>
                </div>
                <span type="button" class="fs-4" aria-label="Back"><i class="fa fa-chevron-right"></i></span>
            </div>
        </div>
        <div class="mx-3 mb-4 p-4 rounded-1" style="height: 100px; background-color: rgba(145,145,145,0.3);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="d-block fw-bold fs-4">Education</span>
                    <span class="d-block">@{{member.education}}</span>
                </div>
                <span type="button" class="fs-4" aria-label="Back"><i class="fa fa-chevron-right"></i></span>
            </div>
        </div>
        <div class="mx-3 mb-4 p-4 rounded-1" style="height: 100px; background-color: rgba(145,145,145,0.3);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="d-block fw-bold fs-4">About</span>
                    <span class="d-block">@{{member.about}}</span>
                </div>
                <span type="button" class="fs-4" aria-label="Back"><i class="fa fa-chevron-right"></i></span>
            </div>
        </div>
        <div class="mx-3 mb-4 p-4 rounded-1" style="height: 100px; background-color: rgba(145,145,145,0.3);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="d-block fw-bold fs-4">Height</span>
                    <span class="d-block">@{{member.height}}</span>
                </div>
                <span type="button" class="fs-4" aria-label="Back"><i class="fa fa-chevron-right"></i></span>
            </div>
        </div>
        <div class="mx-3 p-4 rounded-1" style="height: 100px; background-color: rgba(145,145,145,0.3);">
            <div class="d-flex justify-content-between align-items-center">
                <div>
                    <span class="d-block fw-bold fs-4">Phone</span>
                    <span class="d-block">@{{member.phone}}</span>
                </div>
                <span type="button" class="fs-4" aria-label="Back"><i class="fa fa-chevron-right"></i></span>
            </div>
        </div>
        <button class="d-block btn btn-dark rounded rounded-5 btn-lg mx-auto my-3" type="button" id="next_btn1" style="width: 96%;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasEditForm" aria-controls="offcanvasEditForm" ng-click="showForm()">Edit User Profile</button>
        <div ng-if="member.status == {{ getMemberRegisteredStatus()}} || member.status == {{ getMemberEmailVerifiedStatus()}}" class="mx-3 p-4 rounded-1" style="height: 100px; background-color: rgba(145,145,145,0.3);">
            <span class="d-block fw-bold fs-4">Get verified</span>
            <span class="d-block">Verification ups your chances by showing people they can trust you</span>
        </div>
        <button ng-if="member.status == {{ getMemberRegisteredStatus()}} || member.status == {{ getMemberEmailVerifiedStatus()}}" class="d-block btn btn-dark rounded rounded-5 btn-lg mx-auto my-3" type="button" id="next_btn1" style="width: 96%;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCapture" aria-controls="offcanvasCapture">Verify By Photo</button>
        <div ng-if="member.status == {{ getMemberPendingPhotoVerificationStatus()}}" class="mx-3 p-4 rounded-1 bg-warning mb-2" style="height: 100px;">
            <span class="d-block fw-bold fs-4">Verification Pending</span>
            <span class="d-block">Admin has not verified your uploaded photo and will show the update soon.</span>
        </div>
        <div ng-if="member.status == {{ getMemberRejectPhotoVerificationStatus()}}" class="mx-3 p-4 rounded-1 bg-danger text-white" style="height: 100px; background-color: rgba(145,145,145,0.3);">
            <span class="d-block fw-bold fs-4">Verification failed</span>
            <span class="d-block">Admin team does not verify your uploaded photo.</span>
        </div>
        <button ng-if="member.status == {{ getMemberRejectPhotoVerificationStatus()}}" class="d-block btn btn-dark rounded rounded-5 btn-lg mx-auto my-3" type="button" id="next_btn1" style="width: 96%;" data-bs-toggle="offcanvas" data-bs-target="#offcanvasCapture" aria-controls="offcanvasCapture">Try Verification Again</button>
        <div ng-if="member.status == {{ getMemberVerifiedStatus()}}" class="mx-3 p-4 rounded-1 mb-2" style="height: 100px; background-color: rgba(145,145,145,0.3);">
            <span class="d-block fw-bold fs-4"><i class="fa fa-check text-primary me-2" aria-hidden="true"></i>Admin Confirmed</span>
            <span class="d-block">This account is verified by photo.</span>
        </div>
    </article>
</div>