@if(session()->has('impersonator_id'))
    <div class="bg-warning-500 text-black px-4 py-2 text-center text-sm font-bold flex justify-between items-center">
        <span>🕵️ You are impersonating {{ auth()->user()->name }}</span>
        <a href="{{ route('impersonate.leave') }}" class="underline hover:text-white">Leave Impersonation</a>
    </div>
@endif
