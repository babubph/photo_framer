<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Frame;

class FramerController extends Controller
{
      public function NewFrame(){
        $data['frames'] = Frame::all();
        return view('admin.frames', $data);
    }

       public function SaveFrame(Request $request){
   
        $image = $request->frame_image;
        $filename = time() . '_' . $image->getClientOriginalName();
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


}
