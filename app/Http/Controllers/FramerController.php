<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frame;
use App\Models\UploadPhoto;

class FramerController extends Controller
{
      public function NewFrame(){
        $data['frames'] = Frame::all();
        return view('admin.frames', $data);
    }

       public function SaveFrame(Request $request){
   
        $image = $request->frame_image;

        // get original name without extension
        $originalName = pathinfo($image->getClientOriginalName(), PATHINFO_FILENAME);

        // convert to lowercase
        $cleanName = strtolower($originalName);

        // remove special characters & replace spaces with hyphen
        $cleanName = preg_replace('/[^a-z0-9]+/', '-', $cleanName);

        // remove repeated hyphens
        $cleanName = trim($cleanName, '-');

        // get extension (also lowercase)
        $ext = strtolower($image->getClientOriginalExtension());

        // final filename
        $filename = time() . '_' . $cleanName . '.' . $ext;

        // move file
        $image->move(public_path('images/frames'), $filename);

        $data = [

            'frame_name'   => $request->input('frame_name'),
            'frame_image'    => $filename,
            'status'    => "Active",
        ];

        Frame::create($data);

        return redirect()->route('new-frame')
            ->with('message', 'Save Successfully')
            ->with('msg_type', 'success');
    }

    public function DeleteFrame($id){

          $client = Frame::find($id);

          $client->delete();

         return redirect()->route('new-frame')
            ->with('message', 'Delete Successfully')
            ->with('msg_type', 'error');
    }

    public function ActiveFrame($id)
    {
        $frame = Frame::find($id);

        if ($frame) {
            $frame->update([
                'status' => "Active"
            ]);
        }

        return redirect()->route('new-frame')
            ->with('message', 'Update Successfully')
            ->with('msg_type', 'success');
    }

    public function InactiveFrame($id)
    {
        $frame = Frame::find($id);

       
        if ($frame) {
            $frame->update([
                'status' => "inactive"
            ]);
        }

        return redirect()->route('new-frame')
            ->with('message', 'Update Successfully')
            ->with('msg_type', 'success');
    }

     public function DeleteUploadedPhoto($id){

          $client = UploadPhoto::find($id);

          $client->delete();

         return redirect()->route('dashboard')
            ->with('message', 'Delete Successfully')
            ->with('msg_type', 'error');
    }



}
