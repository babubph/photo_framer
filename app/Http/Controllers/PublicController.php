<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class PublicController extends Controller
{
        public function FramerHome(){
          return view('photo-framer');
      }

    public function uploadFramedPhoto(Request $request)
{
    try {
        // Validate the request
        $request->validate([
            'framed_image' => 'required|image|mimes:png,jpg,jpeg|max:5120', // 5MB max
            
        ]);

        // Get uploaded file
        $image = $request->file('framed_image');

        // Create unique filename
        $filename = $request->image_file_name;


        $image->move(public_path('images/upload'), $filename);
        //$uploadPath = $_SERVER['DOCUMENT_ROOT'] . '/images/upload/';
        //$image->move($uploadPath, $filename);

        // Full URL path (optional)
        $publicPath = asset('images/upload/' . $filename);

        return response()->json([
            'success' => true,
            'message' => 'Framed photo uploaded successfully',
            'path' => $publicPath,
            'filename' => $filename,
            'frame_type' => $request->input('frame_type')
        ]);

    } catch (\Exception $e) {
        return response()->json([
            'success' => false,
            'message' => 'Error uploading framed photo: ' . $e->getMessage()
        ], 500);
    }
}
}
