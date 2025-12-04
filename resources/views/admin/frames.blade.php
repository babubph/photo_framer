@extends('admin.master_layout')
@section('content')
@push('scripts')

<!-- Summernote CSS -->
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

@endpush
<style>
/* Custom input field */
  .custom-input {
    padding: 10px 12px;         /* padding inside input */
    border: 1px solid #5ca4ec;    /* default border color */
    border-radius: 5px;
    font-size: 15px;
    width: 100%;
    transition: border-color 0.3s, box-shadow 0.3s;
    height: 50px;
    z-index: 1;
  }

  /* Focus state */
  .custom-input:focus {
    border-color: #84dfec;        /* custom border color on focus */
    outline: none;
    box-shadow: 0 0 5px rgba(23, 162, 184, 0.5);
  }

/* Image Cropper Modal */
.cropper-modal {
  display: none;
  position: fixed;
  z-index: 99999999;
  left: 0;
  top: 0;
  width: 100%;
  height: 100%;

  
}

.cropper-content {
  position: relative;
  background-color: #fefefe;
  margin: 2% auto;
  padding: 20px;
  width: 90%;
  max-width: 800px;
  border-radius: 8px;
}

.cropper-header {
  display: flex;
  justify-content: between;
  align-items: center;
  margin-bottom: 15px;
}

.cropper-title {
  font-size: 18px;
  font-weight: bold;
  color: #333;
}

.cropper-close {
  color: #aaa;
  float: right;
  font-size: 28px;
  font-weight: bold;
  cursor: pointer;
}

.cropper-close:hover {
  color: #000;
}

.cropper-body {
  display: flex;
  flex-direction: column;
  align-items: center;
}

.cropper-preview-container {
  width: 100%;
  height: 400px;
  margin-bottom: 15px;
  border: 1px solid #ddd;
  background-color: #f9f9f9;
}

.cropper-actions {
  display: flex;
  gap: 10px;
  justify-content: center;
  margin-top: 15px;
}

.cropper-preview {
  width: 150px;
  height: 150px;
  border: 1px solid #ddd;
  margin-top: 15px;
  overflow: hidden;
  border-radius: 4px;
}

/* Existing image upload styles remain the same */
.custom-file-upload_nid_front,
.custom-file-upload_nid_back,
.custom-file-upload_profile {
  display: inline-block;
  padding: 8px 15px;
  cursor: pointer;
  background-color: #e2e5e5;
  color: rgb(6, 150, 160);
  border-radius: 5px;
  font-size: 14px;
  transition: background-color 0.3s ease;
}

.custom-file-upload_nid_front:hover,
.custom-file-upload_nid_back:hover,
.custom-file-upload_profile:hover {
  background-color: #12acc0;
  color: #FFF;
}

.hidden-file-input_nid_front,
.hidden-file-input_nid_back,
.hidden-file-input_profile {
  display: none;
}

#imagePreview_nid_front,
#imagePreview_nid_back,
#imagePreview_profile {
  max-height: 80px;
  border: 1px solid #ccc;
  padding: 4px;
  border-radius: 4px;
  margin-top: 10px;
}


</style>
<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-2"></div>
          <div class="col-md-8">
          <div class="card" style="margin-top:10px;">
              <div class="card-header">
                      <table style="width:100%">
                      <tr>
                        <td><h3 class="card-title" style="font-size: 20px;"><b>Add New Frames</b></h3></td>
                        <td style="text-align: right">
                          
                        </td>
                      </tr>
                    </table>
                    @if(session('message'))
                        <div class="alert alert-{{ session('msg_type') == 'success' ? 'success' : 'danger' }} alert-dismissible fade show" role="alert">
                            {{ session('message') }}
                            <button type="button" class="close" data-dismiss="alert" aria-label="Close">
                                <span aria-hidden="true">&times;</span>
                            </button>
                        </div>
                    @endif
              </div>

              <form action="{{ route('save-frame') }}" class="form-horizontal" method="post" enctype="multipart/form-data">
                @csrf 

                <div class="card-body">
      
                   <div class="form-group row">
                    <label  class="col-sm-2 col-form-label">Name</label>
                    <div class="col-sm-4">
                      <input type="text" class="form-control custom-input" id="" name="frame_name" value="" required>
                    </div>
                  </div>

                  <div class="form-group row">
                      <label class="col-sm-2 col-form-label">Frame Image(PNG)</label>
                      <div class="col-sm-10">
                          <input type="file" id="fileUpload_profile" name="frame_image" 
                                accept="image/*">
             
                          <img id="imagePreview_profile" style="display: none; max-height: 180px; border: 1px solid #ccc; padding: 4px; border-radius: 4px; margin-top: 10px;">
                      </div>
                  </div>


        
                </div>

                <div class="card-footer">
                  <button type="submit" class="btn btn-info">Save</button>
                  <button type="button" class="btn btn-default float-right">Cancel</button>
                </div>
              </form>
            </div>
          </div>
          <div class="col-md-2"></div>
        </div>
    </div>
</section>

<section class="content">
    <div class="container-fluid">
        <div class="row">
        <div class="col-md-2"></div>
          <div class="col-md-8">
          <div class="card" style="margin-top:10px;">
              <div class="card-header">
                      <table style="width:100%">
                      <tr>
                        <td><h3 class="card-title" style="font-size: 20px;"><b>All Frame Image</b></h3></td>
                        <td style="text-align: right">
                          
                        </td>
                      </tr>
                    </table>
              
              </div>

                <div class="card-body">
                  <div class="row">
                    @foreach ($frames as $frame)
                       <div class="col-2">
                          <div style="padding:10px; margin-bottom:10px; border: solid 1px #ccc;">
                             @if($frame->frame_image)
                                 <img src="{{ asset('images/frames/' . $frame->frame_image) }}" alt="image" width="100%">
                              @else
                                <img src="https://placehold.co/600x400" class="service-image">
                             @endif
                             <div style="padding:10px 0">
                              <a class="btn btn-danger btn-sm" href="{{ route('delete-frame', $frame->id) }}" onClick="return confirmation()">Delete</a> &nbsp;&nbsp;&nbsp;
                              @if($frame->status == "Active")
                                  <a class="btn btn-success btn-sm" href="{{ route('inactive-frame', $frame->id) }}">Active</a>
                              @else 
                                  <a class="btn btn-danger btn-sm" href="{{ route('active-frame', $frame->id) }}">Inactive</a>
                              @endif

                            </div>
                          </div>
                       </div>
                    @endforeach
                   
                  </div>
            

        
                </div>

            </div>
          </div>
          <div class="col-md-2"></div>
        </div>
    </div>
</section>

<!-- Image Cropper Modal -->
<div id="cropperModal" class="cropper-modal">
  <div class="cropper-content">
    <div class="cropper-header">
      <div class="cropper-title">Crop Image</div>
      <span class="cropper-close">&times;</span>
    </div>
    <div class="cropper-body">
      <div class="cropper-preview-container">
        <img id="cropperImage" src="" style="max-width: 100%; max-height: 100%;">
      </div>
      <div class="cropper-actions">
        <button type="button" class="btn btn-secondary" id="rotateLeft">
          <i class="fa fa-rotate-left"></i> Rotate Left
        </button>
        <button type="button" class="btn btn-secondary" id="rotateRight">
          <i class="fa fa-rotate-right"></i> Rotate Right
        </button>
        <button type="button" class="btn btn-info" id="resetCrop">
          <i class="fa fa-refresh"></i> Reset
        </button>
        <button type="button" class="btn btn-success" id="cropImage">
          <i class="fa fa-check"></i> Crop & Save
        </button>
      </div>
      <div class="cropper-preview"></div>
    </div>
  </div>
</div>


@endsection

@push('js_scripts')

<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.20/dist/summernote.min.js"></script>

<script>
  $(document).ready(function() {
    $('.summernote').each(function() {
      $(this).summernote({
        placeholder: 'Type your content here...',
        tabsize: 2,
        height: 200
      });
    });
  });
</script>



<script>
// Image Cropper Variables
let cropper;
let originalFile = null;
let currentImageType = ''; // Add this missing variable

// Initialize Cropper
function initCropper(imageSrc, imageType) {
  const image = document.getElementById('cropperImage');
  const modal = document.getElementById('cropperModal');


    // Reset and show modal first
  modal.style.display = 'block';
  modal.style.opacity = '0.9';
  modal.style.visibility = 'visible';
  
  
  // Set current image type
  currentImageType = imageType;
  
  // Set image source first
  image.src = imageSrc;
  
  // Reset and show modal
  modal.style.display = 'block';

  // Destroy previous cropper instance if exists
  if (cropper) {
    cropper.destroy();
  }
  
  // Wait for image to load before initializing cropper
  image.onload = function() {
    // Initialize new cropper
    cropper = new Cropper(image, {
      aspectRatio: 1, // Square for profile
      viewMode: 1,
      autoCropArea: 0.8,
      responsive: true,
      restore: false,
      checkCrossOrigin: false,
      preview: '.cropper-preview',
      guides: true,
      center: true,
      highlight: false,
      cropBoxMovable: true,
      cropBoxResizable: true,
      toggleDragModeOnDblclick: false,
    });
  };
}

// Open cropper when file is selected
function openCropper(event, imageType) {
  const file = event.target.files[0];
  if (!file) return;
  
  // Check if file is an image
  if (!file.type.match('image.*')) {
    alert('Please select a valid image file.');
    return;
  }
  
  originalFile = file;
  const reader = new FileReader();
  
  reader.onload = function(e) {
    initCropper(e.target.result, imageType);
  };
  
  reader.readAsDataURL(file);
}

function previewImage_profile(event) {
  openCropper(event, 'profile');
}

// Cropper functionality - Fixed version
document.addEventListener('DOMContentLoaded', function() {
  const cropperModal = document.getElementById('cropperModal');
  const closeCropper = document.querySelector('.cropper-close');
  const rotateLeft = document.getElementById('rotateLeft');
  const rotateRight = document.getElementById('rotateRight');
  const resetCrop = document.getElementById('resetCrop');
  const cropImage = document.getElementById('cropImage');

  // Close cropper modal
  closeCropper.addEventListener('click', function() {
    cropperModal.style.display = 'none';
    if (cropper) {
      cropper.destroy();
      cropper = null;
    }
  });

  // Close modal when clicking outside
  window.addEventListener('click', function(event) {
    if (event.target === cropperModal) {
      cropperModal.style.display = 'none';
      if (cropper) {
        cropper.destroy();
        cropper = null;
      }
    }
  });

  // Rotate left
  rotateLeft.addEventListener('click', function() {
    if (cropper) {
      cropper.rotate(-90);
    }
  });

  // Rotate right
  rotateRight.addEventListener('click', function() {
    if (cropper) {
      cropper.rotate(90);
    }
  });

  // Reset crop
  resetCrop.addEventListener('click', function() {
    if (cropper) {
      cropper.reset();
    }
  });

  // Crop and save image - FIXED VERSION
  cropImage.addEventListener('click', function() {
    if (!cropper) {
      console.error('Cropper not initialized');
      return;
    }

    // Get cropped canvas
    const canvas = cropper.getCroppedCanvas({
      width: 800,
      height: 800,
      imageSmoothingEnabled: true,
      imageSmoothingQuality: 'high'
    });

    if (!canvas) {
      console.error('Could not get cropped canvas');
      return;
    }

    // Convert canvas to blob
    canvas.toBlob(function(blob) {
      if (!blob) {
        console.error('Could not create blob from canvas');
        return;
      }

      // Create file from blob
      const croppedFile = new File([blob], originalFile.name, {
        type: 'image/jpeg',
        lastModified: Date.now()
      });

      // Create data URL for preview
      const reader = new FileReader();
      reader.onload = function(e) {
        // Update preview image
        const previewId = 'imagePreview_profile'; // Fixed: directly use the ID
        const preview = document.getElementById(previewId);
        if (preview) {
          preview.src = e.target.result;
          preview.style.display = 'block';
        }

        // Create a new file input with the cropped file
        const fileInput = document.getElementById('fileUpload_profile');
        if (fileInput) {
          const dataTransfer = new DataTransfer();
          dataTransfer.items.add(croppedFile);
          fileInput.files = dataTransfer.files;
        }

        // Close modal
        cropperModal.style.display = 'none';
        if (cropper) {
          cropper.destroy();
          cropper = null;
        }
      };
      reader.readAsDataURL(blob);
    }, 'image/jpeg', 0.9);
  });
});

// Event listener for profile image upload
document.getElementById('fileUpload_profile').addEventListener('change', previewImage_profile);
</script>

  <script type="text/javascript">
        function confirmation() {
        return confirm('Are you sure you want to Delete this?');
          }
  </script>

@endpush

