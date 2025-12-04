<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Photo Framer</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
   <link rel="stylesheet" href="{{asset('assets/style.css')}}">
</head>
<body>
    <div class="container">
        <header>
            <h1>Photo Framer</h1>
            <p class="subtitle">Upload your photo, drag to position and adjust zoom, apply frames, and save to server.</p>
        </header>
        
        <main>
            <button class="upload-btn" id="upload-button">
                <i class="fas fa-cloud-upload-alt"></i> Upload Photo
            </button>
            <input type="file" id="file-input" accept="image/*">
            
            <div class="main-content">
                <div class="working-area">
                   
                    <div class="image-frame-container" id="frame-container">
                        <div class="placeholder-text">Upload a photo to get started</div>
                        <canvas id="preview-canvas"></canvas>
                        <img id="frame-overlay" class="frame-overlay" src="" alt="Selected Frame">
                        <div class="zoom-indicator" id="zoom-indicator">100%</div>
                    </div>
                    
                    <div class="zoom-controls" style="margin-top:-10px;">
                        <div class="zoom-slider-container">
                            <div class="zoom-label">
                                <i class="fas fa-search"></i> Zoom Level
                            </div>
                            <input type="range" class="zoom-slider" id="zoom-slider" min="20" max="300" value="100" step="5">
                            <div class="zoom-value" id="zoom-value">100%</div>
                        </div>
                        <div class="zoom-buttons" style="display:none">
                            <button class="control-btn" id="zoom-in-btn">
                                <i class="fas fa-search-plus"></i> Zoom In
                            </button>
                            <button class="control-btn" id="zoom-out-btn">
                                <i class="fas fa-search-minus"></i> Zoom Out
                            </button>
                        </div>
                    </div>
                    
                    <div class="instructions"  style="display:none">
                        <p><i class="fas fa-mouse-pointer"></i> Drag to move | <i class="fas fa-mouse"></i> Scroll to zoom</p>
                    </div>
                    
                    <div class="controls" style="display:none">
                        <button class="control-btn" id="center-btn">
                            <i class="fas fa-bullseye"></i> Center
                        </button>
                        <button class="control-btn reset-btn" id="reset-btn">
                            <i class="fas fa-redo"></i> Reset All
                        </button>
                    </div>
                </div>
            </div>

            <div class="action-buttons" 
                id="save-area" 
                style="margin-top:-15px; display:none; justify-content:center; align-items:center;">

                <button class="full-width-btn" id="save-btn" disabled>
                    <i class="fas fa-share"></i> Click Here To Make Frame & Share
                </button>

            </div>
            
            <div class="frame-selector">
                <h3>Select your favourite Frame</h3>
                <div class="thumbnail-container">
                    @foreach ($frames as $frame)

                    @php 
                        if($loop->iteration == 1){
                            $isActive = "active";
                        }else{
                            $isActive = "";
                        }
                    @endphp

                    <div class="thumbnail {{$isActive}}" data-frame="frame{{ $loop->iteration }}">
                        <img src="{{asset('images/frames/'. $frame->frame_image)}}">
                    </div>
                    @endforeach
                    <!-- <div class="thumbnail" data-frame="frame2">
                        <img src="{{asset('images/frames/frame-2.png')}}">
                    </div>
                    <div class="thumbnail" data-frame="frame3">
                        <img src="{{asset('images/frames/frame-3.png')}}">
                    </div>
                    <div class="thumbnail" data-frame="frame4">
                        <img src="{{asset('images/frames/frame-4.png')}}">
                    </div> -->
                </div>
            </div>
            
            
        </main>
        
        <footer>
            <p>Photo Framer &copy; 2025 | Developed by Teamdjango</p>

        </footer>
    </div>

    <!-- Message Container -->
    <div class="message-container" id="message-container"></div>

    <script>
        // DOM elements
        const fileInput = document.getElementById('file-input');
        const uploadButton = document.getElementById('upload-button');
        const frameContainer = document.getElementById('frame-container');
        const frameOverlay = document.getElementById('frame-overlay');
        const placeholderText = document.querySelector('.placeholder-text');
        const zoomIndicator = document.getElementById('zoom-indicator');
        const zoomSlider = document.getElementById('zoom-slider');
        const zoomValue = document.getElementById('zoom-value');
        const previewCanvas = document.getElementById('preview-canvas');
        const thumbnails = document.querySelectorAll('.thumbnail');
        const saveBtn = document.getElementById('save-btn');
        const saveArea = document.getElementById('save-area');
        const messageContainer = document.getElementById('message-container');
        
        // Control buttons
        const zoomInBtn = document.getElementById('zoom-in-btn');
        const zoomOutBtn = document.getElementById('zoom-out-btn');
        const centerBtn = document.getElementById('center-btn');
        const resetBtn = document.getElementById('reset-btn');
        
        // CSRF Token (Laravel requires this for POST requests)
        // Get it from meta tag or set it manually
        const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || '{{ csrf_token() }}';
        
        // Frame definitions - Transparent frames with inner borders
       const frames = {
            @foreach ($frames as $index => $frame)
                ["frame{{ $index+1 }}"] : "{{ asset('images/frames/' . $frame->frame_image) }}",
            @endforeach
        };

        
        // State variables
        let currentFrame = 'frame1';
        let hasImage = false;
        let scale = 1.0;
        let posX = 0;
        let posY = 0;
        let isDragging = false;
        let startX, startY;
        let startPosX, startPosY;
        let image = null;
        let previewCtx = null;
        
        // Set initial frame
        frameOverlay.src = frames[currentFrame];
        frameOverlay.style.display = 'block';
        
        // Initialize canvas
        function initCanvas() {
            const rect = frameContainer.getBoundingClientRect();
            previewCanvas.width = rect.width;
            previewCanvas.height = rect.height;
            previewCtx = previewCanvas.getContext('2d');
        }
        
        // Show message
        function showMessage(text, type = 'info') {
            const message = document.createElement('div');
            message.className = `message ${type}`;
            message.innerHTML = `
                <i class="fas fa-${type === 'success' ? 'check-circle' : type === 'error' ? 'exclamation-circle' : 'info-circle'}"></i>
                <span>${text}</span>
            `;
            messageContainer.appendChild(message);
            
            // Show message
            setTimeout(() => message.classList.add('show'), 10);
            
            // Remove message after 5 seconds
            setTimeout(() => {
                message.classList.remove('show');
                setTimeout(() => {
                    if (message.parentNode === messageContainer) {
                        messageContainer.removeChild(message);
                    }
                }, 300);
            }, 5000);
        }
        
        // Update zoom indicator
        function updateZoomIndicator() {
            const zoomPercent = Math.round(scale * 100);
            zoomIndicator.textContent = `${zoomPercent}%`;
            zoomValue.textContent = `${zoomPercent}%`;
            zoomSlider.value = zoomPercent;
        }
        
        // Draw preview
        function drawPreview() {
            if (!hasImage || !image || !previewCtx) return;
            
            const canvasWidth = previewCanvas.width;
            const canvasHeight = previewCanvas.height;
            
            // Clear canvas
            previewCtx.clearRect(0, 0, canvasWidth, canvasHeight);
            
            // Draw white background
            previewCtx.fillStyle = 'white';
            previewCtx.fillRect(0, 0, canvasWidth, canvasHeight);
            
            // Frame dimensions (relative to canvas)
            const framePadding = 0.04; // 4% padding on each side
            const frameInnerSize = 1 - (framePadding * 2); // 92% inner area
            
            // Calculate visible area
            const visibleWidth = frameInnerSize / scale;
            const visibleHeight = frameInnerSize / scale;
            
            // Calculate center of canvas
            const canvasCenterX = canvasWidth / 2;
            const canvasCenterY = canvasHeight / 2;
            
            // Convert position from pixels to percentage of canvas
            const posXPercent = posX / canvasWidth;
            const posYPercent = posY / canvasHeight;
            
            // Calculate source rectangle in original image
            const imageCenterX = image.width / 2;
            const imageCenterY = image.height / 2;
            
            // Calculate the offset in image coordinates
            const imageOffsetX = posXPercent * image.width / scale;
            const imageOffsetY = posYPercent * image.height / scale;
            
            // Calculate source rectangle
            const sourceX = imageCenterX - (image.width * visibleWidth / 2) - imageOffsetX;
            const sourceY = imageCenterY - (image.height * visibleHeight / 2) - imageOffsetY;
            const sourceWidth = image.width * visibleWidth;
            const sourceHeight = image.height * visibleHeight;
            
            // Calculate destination rectangle
            const destX = canvasWidth * framePadding;
            const destY = canvasHeight * framePadding;
            const destWidth = canvasWidth * frameInnerSize;
            const destHeight = canvasHeight * frameInnerSize;
            
            // Draw the image
            previewCtx.drawImage(
                image,
                Math.max(0, sourceX), Math.max(0, sourceY),
                Math.min(sourceWidth, image.width - Math.max(0, sourceX)),
                Math.min(sourceHeight, image.height - Math.max(0, sourceY)),
                destX, destY,
                destWidth, destHeight
            );
            
            updateZoomIndicator();
        }
        
        // Reset image transform
        function resetZoom() {
            scale = 1.0;
            drawPreview();
        }
        
        // Center the image
        function centerImage() {
            posX = 0;
            posY = 0;
            drawPreview();
        }
        
        // Reset everything
        function resetAll() {
            scale = 1.0;
            posX = 0;
            posY = 0;
            drawPreview();
        }
        
        // Calculate max drag distance based on zoom level
        function getMaxDrag() {
            return previewCanvas.width * 0.5 * (scale - 1);
        }
        
        // Set zoom from slider value
        function setZoomFromSlider(value) {
            const oldScale = scale;
            scale = value / 100;
            
            posX = posX * (scale / oldScale);
            posY = posY * (scale / oldScale);
            
            drawPreview();
        }
        
        // Zoom with mouse wheel
        function zoomWithWheel(e, zoomIntensity = 0.1) {
            const oldScale = scale;
            
            // Determine zoom direction
            if (e.deltaY < 0) {
                scale = Math.min(3.0, scale + zoomIntensity);
            } else {
                scale = Math.max(0.5, scale - zoomIntensity);
            }
            
            // Get mouse position relative to canvas
            const rect = previewCanvas.getBoundingClientRect();
            const mouseX = e.clientX - rect.left;
            const mouseY = e.clientY - rect.top;
            
            // Calculate canvas center
            const canvasCenterX = rect.width / 2;
            const canvasCenterY = rect.height / 2;
            
            // Calculate where the mouse is relative to the image center
            const imageOffsetX = mouseX - canvasCenterX - posX;
            const imageOffsetY = mouseY - canvasCenterY - posY;
            
            // Adjust position to zoom toward mouse
            posX = posX - (imageOffsetX * (scale / oldScale - 1));
            posY = posY - (imageOffsetY * (scale / oldScale - 1));
            
            // Limit position
            const maxDrag = getMaxDrag();
            posX = Math.max(-maxDrag, Math.min(maxDrag, posX));
            posY = Math.max(-maxDrag, Math.min(maxDrag, posY));
            
            drawPreview();
        }
        
        // Create framed image and upload to server
       async function saveFramedImage() {
    if (!hasImage || !image) return;

    try {
        console.log('Starting upload process...');
        // Show loading state
        const originalText = saveBtn.innerHTML;
        saveBtn.innerHTML = '<i class="fas fa-spinner fa-spin"></i> Saving...';
        saveBtn.disabled = true;

        // Create high resolution canvas
        const highResCanvas = document.createElement('canvas');
        const highResCtx = highResCanvas.getContext('2d');
        const scaleFactor = 4;
        highResCanvas.width = previewCanvas.width * scaleFactor;
        highResCanvas.height = previewCanvas.height * scaleFactor;

        highResCtx.save();
        highResCtx.scale(scaleFactor, scaleFactor);
        highResCtx.drawImage(previewCanvas, 0, 0);

        // Draw the frame
        const frameImg = new Image();
        await new Promise((resolve, reject) => {
            frameImg.onload = resolve;
            frameImg.onerror = reject;
            frameImg.src = frames[currentFrame];
        });
        highResCtx.drawImage(frameImg, 0, 0, previewCanvas.width, previewCanvas.height);
        highResCtx.restore();

        // Convert canvas to Blob
        highResCanvas.toBlob(async (blob) => {
            console.log('Blob created:', blob);

            try {
                // Prepare FormData
                const csrfToken = document.querySelector('meta[name="csrf-token"]').content;
                const formData = new FormData();
                const fileName = `framed-photo-${Date.now()}.png`;
                console.log('Generated filename:', fileName);

                formData.append('framed_image', blob, fileName);
                formData.append('image_file_name', fileName);
                formData.append('frame_type', currentFrame);
                formData.append('_token', csrfToken);

                console.log('Sending FormData to server...');

                // Upload
                const uploadUrl = "{{ url('/upload-framed-photo') }}";
                const response = await fetch(uploadUrl, {
                    method: 'POST',
                    body: formData,
                    headers: {
                        'X-Requested-With': 'XMLHttpRequest'
                    }
                });

                console.log('Response received:', response);

                let result;
                try {
                    result = await response.json();
                    console.log('Parsed JSON:', result);
                } catch (e) {
                    const text = await response.text();
                    console.error('Failed to parse JSON, server returned:', text);
                    throw new Error('Server returned invalid JSON');
                }

                if (response.ok && result.success) {
                    console.log('Upload success! File path:', result.path);
                    showMessage(`Image saved successfully! Path: ${result.path}`, 'success');

                    // Optional: Trigger download
                    const downloadLink = document.createElement('a');
                    downloadLink.href = URL.createObjectURL(blob);
                    downloadLink.download = fileName;
                    document.body.appendChild(downloadLink);
                    downloadLink.click();
                    document.body.removeChild(downloadLink);

                } else {
                    throw new Error(result.message || 'Upload failed');
                }
            } catch (error) {
                console.error('Upload error:', error);
                showMessage(`Error: ${error.message}`, 'error');
            } finally {
                saveBtn.innerHTML = '<i class="fas fa-save"></i> Save to Server';
                saveBtn.disabled = false;
            }
        }, 'image/png', 1.0);

    } catch (error) {
        console.error('Error creating framed image:', error);
        showMessage(`Error: ${error.message}`, 'error');
        saveBtn.innerHTML = '<i class="fas fa-save"></i> Save to Server';
        saveBtn.disabled = false;
    }
}

        
        // Load image
        function loadImage(src) {
            return new Promise((resolve, reject) => {
                const img = new Image();
                img.onload = () => {
                    image = img;
                    hasImage = true;
                    placeholderText.style.display = 'none';
                    saveBtn.disabled = false;
                    resolve(img);
                    saveArea.style.display = 'block';
                };
                img.onerror = reject;
                img.src = src;
            });
        }
        
        // Event Listeners
        uploadButton.addEventListener('click', () => {
            fileInput.click();
        });
        
        fileInput.addEventListener('change', async (event) => {
            const file = event.target.files[0];
            if (file) {
                const reader = new FileReader();
                
                reader.onload = async function(e) {
                    try {
                        // Initialize canvas
                        initCanvas();
                        
                        // Load image
                        await loadImage(e.target.result);
                        
                        // Draw initial preview
                        drawPreview();
                        
                        showMessage('Photo uploaded successfully!', 'success');
                    } catch (error) {
                        console.error('Error loading image:', error);
                        showMessage('Error loading image. Please try again.', 'error');
                    }
                };
                
                reader.readAsDataURL(file);
            }
        });
        
        // Mouse drag to move
        frameContainer.addEventListener('mousedown', (e) => {
            if (!hasImage) return;
            
            isDragging = true;
            frameContainer.classList.add('dragging');
            startX = e.clientX;
            startY = e.clientY;
            startPosX = posX;
            startPosY = posY;
            
            e.preventDefault();
        });
        
        document.addEventListener('mousemove', (e) => {
            if (!isDragging || !hasImage) return;
            
            const dx = e.clientX - startX;
            const dy = e.clientY - startY;
            
            const maxDrag = getMaxDrag();
            posX = Math.max(-maxDrag, Math.min(maxDrag, startPosX + dx));
            posY = Math.max(-maxDrag, Math.min(maxDrag, startPosY + dy));
            
            drawPreview();
        });
        
        document.addEventListener('mouseup', () => {
            if (isDragging) {
                isDragging = false;
                frameContainer.classList.remove('dragging');
            }
        });
        
        // Mouse wheel zoom
        frameContainer.addEventListener('wheel', (e) => {
            if (!hasImage) return;
            e.preventDefault();
            
            zoomWithWheel(e);
        });
        
        // Zoom slider
        zoomSlider.addEventListener('input', function() {
            if (!hasImage) return;
            setZoomFromSlider(this.value);
        });
        
        // Touch support for mobile
        frameContainer.addEventListener('touchstart', (e) => {
            if (!hasImage) return;
            
            isDragging = true;
            frameContainer.classList.add('dragging');
            startX = e.touches[0].clientX;
            startY = e.touches[0].clientY;
            startPosX = posX;
            startPosY = posY;
            
            e.preventDefault();
        });
        
        document.addEventListener('touchmove', (e) => {
            if (!isDragging || !hasImage) return;
            
            const dx = e.touches[0].clientX - startX;
            const dy = e.touches[0].clientY - startY;
            
            const maxDrag = getMaxDrag();
            posX = Math.max(-maxDrag, Math.min(maxDrag, startPosX + dx));
            posY = Math.max(-maxDrag, Math.min(maxDrag, startPosY + dy));
            
            drawPreview();
            e.preventDefault();
        });
        
        document.addEventListener('touchend', () => {
            if (isDragging) {
                isDragging = false;
                frameContainer.classList.remove('dragging');
            }
        });
        
        // Control buttons
        zoomInBtn.addEventListener('click', () => {
            if (!hasImage) return;
            
            const zoomStep = 20;
            const newValue = Math.min(300, parseInt(zoomSlider.value) + zoomStep);
            zoomSlider.value = newValue;
            setZoomFromSlider(newValue);
        });
        
        zoomOutBtn.addEventListener('click', () => {
            if (!hasImage) return;
            
            const zoomStep = 20;
            const newValue = Math.max(50, parseInt(zoomSlider.value) - zoomStep);
            zoomSlider.value = newValue;
            setZoomFromSlider(newValue);
        });
        
        centerBtn.addEventListener('click', () => {
            if (!hasImage) return;
            centerImage();
        });
        
        resetBtn.addEventListener('click', () => {
            if (!hasImage) return;
            resetAll();
        });
        
        // Save button
        saveBtn.addEventListener('click', saveFramedImage);
        
        // Thumbnail click handlers
        thumbnails.forEach(thumbnail => {
            thumbnail.addEventListener('click', () => {
                // Remove active class from all thumbnails
                thumbnails.forEach(thumb => thumb.classList.remove('active'));
                
                // Add active class to clicked thumbnail
                thumbnail.classList.add('active');
                
                // Get frame type from data attribute
                currentFrame = thumbnail.getAttribute('data-frame');
                
                // Update the frame overlay
                frameOverlay.src = frames[currentFrame];
                
                showMessage(`Frame "${currentFrame}" selected`, 'info');
            });
        });
        
        // Handle frame overlay load
        frameOverlay.onload = function() {
            frameOverlay.style.display = 'block';
        };
        
        // Handle window resize
        window.addEventListener('resize', () => {
            initCanvas();
            if (hasImage) {
                drawPreview();
            }
        });
        
        // Initialize
        initCanvas();
        updateZoomIndicator();
    </script>
</body>
</html>