<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Support\Facades\DB;

class AdminSubscriberController extends Controller
{
    public function index(): View
    {
        return view('admin.subscribers.index', [
            'subscribers' => DB::table('newsletter_subscribers')
                ->orderByDesc('created_at')
                ->paginate(25),
        ]);
    }

    public function destroy(int $subscriber): RedirectResponse
    {
        $deleted = DB::table('newsletter_subscribers')->where('id', $subscriber)->delete();
        abort_unless($deleted, 404);

        return redirect()->route('admin.subscribers.index')->with('status', 'Subscriber removed successfully.');
    }
}
