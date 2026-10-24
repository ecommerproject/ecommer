@extends('admin.layouts.app')

@section('title', 'Subscribers')

@section('content')
    <div class="admin-page-heading">
        <div><span class="admin-eyebrow">CUSTOMER COMMUNITY</span><h1>Newsletter subscribers</h1><p>People who signed up to hear from your store.</p></div>
        <span class="admin-count-pill">{{ number_format($subscribers->total()) }} subscribers</span>
    </div>

    <section class="admin-panel admin-panel-flush">
        <div class="admin-table-wrap">
            <table class="admin-table">
                <thead><tr><th>Email address</th><th>Subscribed</th><th>Actions</th></tr></thead>
                <tbody>
                    @forelse ($subscribers as $subscriber)
                        <tr>
                            <td><span class="admin-product-name">{{ $subscriber->email }}</span></td>
                            <td>{{ \Illuminate\Support\Carbon::parse($subscriber->created_at)->format('M j, Y · g:i A') }}</td>
                            <td>
                                <form action="{{ route('admin.subscribers.destroy', $subscriber->id) }}" method="POST" onsubmit="return confirm('Remove this subscriber?')">
                                    @csrf
                                    @method('DELETE')
                                    <button class="admin-delete-button" type="submit">Remove</button>
                                </form>
                            </td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="admin-empty">No subscribers yet.</td></tr>
                    @endforelse
                </tbody>
            </table>
        </div>
        @if ($subscribers->hasPages())
            <div class="admin-pagination">{{ $subscribers->links() }}</div>
        @endif
    </section>
@endsection
