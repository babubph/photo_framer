<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Photo Framer</title>

    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">

    <style>
        body {
            margin: 0;
            padding: 0;
            background: #f5f5f5;
            font-family: Arial, sans-serif;
        }

        header {
            text-align: center;
            padding: 30px 10px;

        }

        header h1 {
            font-size: 32px;
            margin: 0;
            font-weight: 700;
            letter-spacing: 1px;
        }

        header .subtitle {
            font-size: 16px;
            margin-top: 8px;
            font-style: italic;
            opacity: 0.9;
        }



        .container {
            max-width: 700px;
            margin: auto;
            padding: 15px;
            text-align: center;
        }

        /* Responsive Frame Wrapper */
        .frame-wrapper {
            width: 100%;
            background: linear-gradient(#000000, #3a3a3a);
            padding: 15px;
            border-radius: 10px;
        }

        .frame-wrapper img {
            width: 100%;
            border-radius: 8px;
        }

        /* Buttons */
        .download-btn,
        .copy-btn,
        .share-btn {
            width: 100%;
            max-width: 320px;
            padding: 12px 18px;
            font-size: 16px;
            border-radius: 8px;
            border: none;
            cursor: pointer;
            margin: 8px auto;
            display: block;
        }

        .download-btn {
            background: #000;
            color: #fff;
        }

        .download-btn:hover {
            background: #222;
        }

        .copy-btn {
            background: #015836;
            color: #fff;
        }

        .copy-btn:hover {
            background: #027748;
        }

        .share-btn {
            background: #1877f2;
            color: white;
        }

        .share-btn:hover {
            background: #0f5ac6;
        }

        /* Caption Box */
        .caption-box {
            background: #1f3e2a;
            padding: 15px;
            color: white;
            font-size: 15px;
            line-height: 1.6;
            width: 100%;
            max-width: 700px;
            margin: 15px auto 0;
            border-radius: 6px;
            text-align: left;
        }

        footer {
            margin-top: 30px;
            color: #444;
        }

        /* Fully Responsive */
        @media (max-width: 600px) {
            .caption-box {
                font-size: 14px;
            }
            .download-btn, .copy-btn, .share-btn {
                font-size: 14px;
                padding: 10px;
            }

                header h1 {
                    font-size: 26px;
                }

                header .subtitle {
                    font-size: 14px;
                }
        }
    </style>
</head>
<body>

<div class="container">

      <header>
            <h1>Photo Framer</h1>
            <p class="subtitle">"Download your photo, share it, and stand a chance to win exciting prizes!"</p>
        </header>

    <!-- MAIN IMAGE -->
    <div class="frame-wrapper">
        <img id="finalPhoto" src="{{ asset('images/upload/' . $photo->photo) }}" alt="Framed Photo">
    </div>

    <!-- DOWNLOAD BUTTON -->
    <button class="download-btn" id="downloadBtn">
        <i class="fa fa-download"></i> Download & Set Profile Photo
    </button>

    <!-- COPY CAPTION + SHARE -->
    <button class="copy-btn" id="copyBtn">Copy Caption</button>
    <button class="share-btn"  id="fbShareBtn"><i class="fa-brands fa-facebook"></i>&nbsp;&nbsp;Share on Facebook</button>

    <!-- CAPTION -->
    <div class="caption-box" id="captionText">
১। Copy Caption বাটনে ক্লিক করে ক্যাপশন কপি করে ফেইসবুকে ছবি পোস্ট করুন।  </br>
২। ছবিতে হ্যাশট্যাগ ব্যবহার করুন: #HONOR400 #GOATofAI #HONORBangladesh  </br>
৩। সবচেয়ে বেশি রিয়্যাক্ট পাওয়া ছবির মধ্যে লটারির মাধ্যমে ২ জন পেয়ে যান HONOR X7 Lite Buds  </br>
৪। প্রতিযোগিতা চলবে ৫ই জুন ২০২৫ পর্যন্ত।</br>
    </div>

    <footer>
        Photo Framer © 2025 | Developed by Teamdjango
    </footer>

</div>

<script>
/* ===== COPY CAPTION BUTTON ===== */
document.getElementById("copyBtn").addEventListener("click", function () {
    const caption = document.getElementById("captionText").innerText;

    if (!navigator.clipboard) {
        // Fallback for older mobile browsers
        const temp = document.createElement("textarea");
        temp.value = caption;
        document.body.appendChild(temp);
        temp.select();
        document.execCommand("copy");
        document.body.removeChild(temp);
    } else {
        navigator.clipboard.writeText(caption);
    }

    // Change button text
    const btn = document.getElementById("copyBtn");
    btn.textContent = "Copied!";
    btn.style.background = "#0a8f55";

    setTimeout(() => {
        btn.textContent = "Copy Caption";
        btn.style.background = "#015836";
    }, 2000);
});

/* ===== DOWNLOAD BUTTON ===== */
document.getElementById("downloadBtn").addEventListener("click", function () {
    const image = document.getElementById("finalPhoto").src;

    const link = document.createElement("a");
    link.href = image;
    link.download = "framed-photo.png";
    link.click();

    const btn = document.getElementById("downloadBtn");
    btn.innerHTML = "<i class='fa fa-check'></i> Downloaded";

    btn.style.background = "#028a0f";

    setTimeout(() => {
        btn.innerHTML = "<i class='fa fa-download'></i> Download & Set Profile Photo";
        btn.style.background = "#000";
    }, 2500);
});
</script>

<script>
document.getElementById("fbShareBtn").addEventListener("click", function () {
    const photoURL = document.getElementById("finalPhoto").src;
    const caption = "Download your photo, share it, and stand a chance to win exciting prizes";

    // Facebook share URL
    const fbShareURL = `https://www.facebook.com/sharer/sharer.php?u=${encodeURIComponent(photoURL)}&quote=${caption}`;

    // Open in a new tab
    window.open(fbShareURL, '_blank');
});
</script>

</body>
</html>




