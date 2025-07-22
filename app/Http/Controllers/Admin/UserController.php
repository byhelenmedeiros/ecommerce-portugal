<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Inertia\Inertia;
use Spatie\Activitylog\Models\Activity;

class UserController extends Controller
{


    public function index()
    {
        $users = User::whereDoesntHave('roles', function ($query) {
            $query->where('name', 'admin');
        })->select('id', 'name', 'email', 'phone', 'created_at')->get();

        return Inertia::render('Admin/Users/Index', [
            'clientes' => $users,
        ]);
    }
    public function show(User $user)
    {
        $user->load([
            'orders:id,user_id,total,status,created_at',
            'addresses:id,address,door,floor,location,postal_code,city,country,type',
            'tags:id,name,color'
        ]);

        $allTags = Tag::select('id', 'name', 'color')->get();

        $activities = Activity::where('subject_type', User::class)
            ->where('subject_id', $user->id)
            ->latest()
            ->take(50)
            ->get();

        // Estatísticas
        $totalPedidos = $user->orders->count();
        $valorTotal = $user->orders->sum('total');
        $ticketMedio = $totalPedidos > 0 ? $valorTotal / $totalPedidos : 0;
        $ultimoPedido = $user->orders->sortByDesc('created_at')->first()?->created_at;

        return Inertia::render('Admin/Users/Show', [
            'cliente' => $user,
            'stats' => [
                'total_pedidos' => $totalPedidos,
                'valor_total' => $valorTotal,
                'ticket_medio' => $ticketMedio,
                'ultimo_pedido' => $ultimoPedido,
            ],
            'allTags' => $allTags,
            'cliente' => $user,
            'activities' => $activities,
        ]);
    }

    public function edit(User $user)
    {
        return Inertia::render('Admin/Users/Index', [
            'cliente' => $user,
        ]);
    }
    public function update(Request $request, User $user)
    {
        $data = $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|max:255|unique:users,email,' . $user->id,
            'phone' => 'nullable|string|max:20',
        ]);

        if ($request->filled('password')) {
            $data['password'] = Hash::make($request->password);
        }

        activity()
            ->performedOn($user)
            ->causedBy(auth()->user())
            ->log("Atualizou o perfil (nome/email/telefone)");


        $user->update($data);

        return redirect()->route('admin.users.index')->with('success', 'Usuário atualizado com sucesso.');
    }
    public function destroy(User $user)
    {
        $user->delete();

        return redirect()->route('admin.users.index')->with('success', 'Usuário excluído com sucesso.');
    }
    public function updateNotes(Request $request, User $user)
    {
        $request->validate([
            'internal_notes' => ['nullable', 'string'],
        ]);

        $user->internal_notes = $request->internal_notes;
        $user->save();

        return back()->with('success', 'Notas atualizadas com sucesso.');
    }
}
