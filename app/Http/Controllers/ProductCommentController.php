<?php

namespace App\Http\Controllers;

use App\Models\Comment;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductCommentController extends Controller
{
   public function store(Request $request, Product $product)
{
    $request->validate([
        'content' => 'required|string|max:2000',
    ]);

    $product->comments()->create([
        'user_id' => auth()->id(),
        'content' => $request->input('content'),
        'approved' => false, // aguardando aprovação
    ]);

    return back()->with('success', 'Comentário enviado para análise.');
}
    public function approve(Request $request, Comment $comment)
    {
     $this->authorize('approve', $comment);
    
     $comment->approved = true;
     $comment->save();
    
     return back()->with('success', 'Comentário aprovado com sucesso.');
    }
    public function destroy(Comment $comment)
    {
        $this->authorize('delete', $comment);
        
        $comment->delete();
        
        return back()->with('success', 'Comentário excluído com sucesso.');
    }
    public function index(Product $product)
    {
        $comments = $product->comments()->where('approved', true)->paginate(10);
        return inertia('Product/Comments/Index', compact('product', 'comments'));
    }

}
