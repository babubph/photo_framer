<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frame;
use App\Models\UploadPhoto;

class PublicController extends Controller
{
    public function FramerHome(){
          $data['frames'] = Frame::where('status', 'Active')->limit(4)->get();
          return view('photo-framer', $data);
      }

    public function uploadFramedPhoto(Request $request)
    {
        try {
            // Validate the request
         

            // Get uploaded file
            $image = $request->file('framed_image');

            // Create unique filename
            $filename = $request->image_file_name;


            $image->move(public_path('images/upload'), $filename);
        
            $data['cdate'] = date('d-m-Y');
            $data['photo_id'] = substr($request->image_file_name, 0, -4);

            $data['photo'] = $request->image_file_name;

            UploadPhoto::create($data);

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

    public function ViewPhoto($photo_id){
          $data['photo'] = UploadPhoto::where('photo_id', $photo_id)->first();
          return view('view-photo', $data);
    }
}
