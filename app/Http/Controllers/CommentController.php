<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\CommentDetail;
use Exception;
use Illuminate\Http\Request;

class CommentController extends Controller
{
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
