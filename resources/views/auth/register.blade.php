@extends('layouts.app')
@section('title', 'Daftar Tamu — Hotel California')

@section('content')
<div class="max-w-md mx-auto mt-12 px-4">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-stone-200">
        <div class="text-center mb-6">
            <h2 class="font-serif-brand text-2xl font-bold text-slate-900">Buat Akun Tamu</h2>
            <p class="text-sm text-slate-500 mt-1">Nikmati kemudahan reservasi di Hotel California</p>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-50 text-rose-700 text-xs border border-rose-200">
                <ul class="list-disc pl-4">
                    @foreach($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <form action="{{ route('register') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Nama Lengkap</label>
                <input type="text" name="name" value="{{ old('name') }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:border-amber-600 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:border-amber-600 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Nomor HP / WhatsApp</label>
                <input type="text" name="phone" value="{{ old('phone') }}" required class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:border-amber-600 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Kata Sandi</label>
                <input type="password" name="password" required class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:border-amber-600 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Konfirmasi Kata Sandi</label>
                <input type="password" name="password_confirmation" required class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:border-amber-600 text-sm">
            </div>
            <button type="submit" class="w-full bg-slate-900 hover:bg-amber-800 text-white font-medium py-2.5 rounded-xl transition text-sm">
                Daftar Akun
            </button>
        </form>
    </div>
</div>
@endsection