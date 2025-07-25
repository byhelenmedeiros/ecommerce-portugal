<?php

namespace App\Http\Middleware;

use Illuminate\Http\Request;
use Inertia\Middleware;
use Tighten\Ziggy\Ziggy;

class HandleInertiaRequests extends Middleware
{
    /**
     * The root template that is loaded on the first page visit.
     *
     * @var string
     */
    protected $rootView = 'app';

    /**
     * Determine the current asset version.
     */
    public function version(Request $request): string|null
    {
        return parent::version($request);
    }

    /**
     * Define the props that are shared by default.
     *
     * @return array<string, mixed>
     */
    public function share(Request $request): array
{
    return array_merge(parent::share($request), [
        'auth' => [
            'user' => fn () => $request->user()
                ? $request->user()->only([
                    'id',
                    'name',
                    'email',
                    'created_at',
                    'fiscalAddress',
                    'entregaAddress',
                    'phone',
                    'phone_alt',
                    'birth_date',
                    'billing_name',
                    'nif',
                    'nif_on_invoice',
                ]) + [
                    'wishlist_count' => $request->user()->wishlists()->count(),
                ]
                : null,
        ],
    ]);
}

}
