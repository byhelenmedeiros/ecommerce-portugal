<?php
namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\CustomerTag;
use App\Models\User;
use App\Models\Tag;
use Illuminate\Http\Request;

class CustomerTagController extends Controller
{
    public function store(Request $request)
    {
        $request->validate([
            'user_id' => 'required|exists:users,id',
            'tag_id' => 'required|exists:tags,id',
        ]);

        CustomerTag::firstOrCreate([
            'user_id' => $request->user_id,
            'tag_id' => $request->tag_id,
        ]);

        return back()->with('success', 'Etiqueta associada ao cliente.');
    }

    public function destroy(CustomerTag $customerTag)
    {
        $customerTag->delete();

        return back()->with('success', 'Etiqueta removida do cliente.');
    }
    public function attach(Request $request, User $user)
{
    $request->validate(['tag_id' => 'required|exists:tags,id']);
    $user->tags()->attach($request->tag_id);
    return back()->with('success', 'Etiqueta adicionada.');
}

public function detach(User $user, Tag $tag)
{
    $user->tags()->detach($tag->id);
    return back()->with('success', 'Etiqueta removida.');
}
}
