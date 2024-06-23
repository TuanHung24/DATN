<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentDetail;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
    public function search(Request $request)
    {
        try{

            $query = $request->input('query');
            $listComment = Comment::where('name', 'like', '%' . $query . '%')
                            ->orWhere('email', 'like', '%' . $query . '%')
                            ->orWhere('phone', 'like', '%' . $query . '%')
                            ->orWhere('address', 'like', '%' . $query . '%')
                            ->paginate(5);
            return view('comment.list', compact('listComment', 'query'));
            
        }catch(Exception $e){
            return back()->with(['Error'=>'Không tìm thấy khách hàng']);
        }
    }
    public function getList()
    {
        $listComment = Comment::paginate(5);
        return view('comment.list', compact('listComment'));
    }
    public function Rep()
    {
        return view('comment.add-new');
    }
    public function hdRep(Request $request)
    {
        try {
            $commentDetail= new CommentDetail();
            $commentDetail->comment_id = $request->comment_id;
            $commentDetail->admin_id= $request->admin_id;
            $commentDetail->content= $request->content;
            $commentDetail->save();

            return redirect()->route('comment.list')->with(['Success' => 'Trả lời bình luận thành công!']);
        } catch (Exception $e) {
            return back()->with("error: " . $e);
        }
    }
}
