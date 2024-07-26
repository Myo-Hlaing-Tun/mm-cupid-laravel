<div class="offcanvas offcanvas-end edit-profile scrollable px-4" data-bs-backdrop="false" tabindex="-1" id="offcanvasCapture" aria-labelledby="offcanvasCapture">
    <div class="bg-white edit-profile-header position-sticky top-0 mt-4" style="z-index: 2;">
        <i class="fa fa-chevron-left fs-4" ng-click="closeVideo()"></i>
    </div>

    <video id="video" style="display:none; width: 100%; height: 55vh;"></video>
    <canvas id="canvas" style="display:none;"></canvas>
    <img id="photo" class="mt-2" src="" alt="Your photo will appear here" style="display: none;" />

    <button class="btn btn-dark rounded rounded-5 btn-lg mt-4 mb-2 photo-btn" type="button" id="openCamera" style="width: 100%;" ng-click="openCamera()">Open Camera</button>
    <button class="btn btn-dark rounded rounded-5 btn-lg mt-4 mb-2 photo-btn" type="button" id="takePhoto" style="width: 100%; display:none;" ng-click="takePhoto()">Take Photo</button>
    <div class="d-flex justify-content-between">
        <button class="btn btn-dark rounded rounded-5 btn-lg mt-4 mb-2 photo-btn" type="button" id="submit" style="width: 48%; display:none;" ng-click="submit()">Submit</button>
        <button class="btn btn-dark rounded rounded-5 btn-lg mt-4 mb-2 photo-btn" type="button" id="reset" style="width: 48%; display:none;" ng-click="reset()">Reset</button>
    </div>
</div>