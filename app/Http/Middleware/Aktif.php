<?php

namespace App\Http\Middleware;

use App\Models\AdminInvoice;
use App\Models\Usaha;
use App\Models\Kecamatan;
use Closure;
use Illuminate\Http\Request;
use Session;
use Symfony\Component\HttpFoundation\Response;


class Aktif
{
    /**
     * Handle an incoming request.
     *
     * @param  \Closure(\Illuminate\Http\Request): (\Symfony\Component\HttpFoundation\Response)  $next
     */
    public function handle(Request $request, Closure $next): Response
    {
        $invoice = AdminInvoice::where([
            ['status', 'UNPAID'],
            ['lokasi', Session::get('lokasi')]
        ])->first();
        Session::put('invoice', $invoice);

        if ($invoice) {
            if ($request->is('dashboard')) {
                return $next($request);
            } else {
                return redirect('/dashboard');
            }
        }

        return $next($request);
    }
}
