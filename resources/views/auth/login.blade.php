@extends('layouts.app')
@section('title', 'Masuk — Hotel California')

@section('content')
<div class="max-w-md mx-auto mt-14 px-4">
    <div class="bg-white p-8 rounded-2xl shadow-sm border border-stone-200">
        <div class="text-center mb-6">
            <h2 class="font-serif-brand text-2xl font-bold text-slate-900">Selamat Datang</h2>
            <p class="text-sm text-slate-500 mt-1">Masuk sebagai Tamu atau Staf Manajemen Hotel California</p>
        </div>

        @if($errors->any())
            <div class="mb-4 p-3 rounded-lg bg-rose-50 text-rose-700 text-xs border border-rose-200">
                {{ $errors->first() }}
            </div>
        @endif

        <form action="{{ route('login') }}" method="POST" class="space-y-4">
            @csrf
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Email</label>
                <input type="email" name="email" value="{{ old('email') }}" required placeholder="contoh: raka.tamu@gmail.com"
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:border-amber-600 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase tracking-wider text-slate-600 mb-1">Kata Sandi</label>
                <input type="password" name="password" required placeholder="••••••••"
                    class="w-full px-4 py-2.5 rounded-xl border border-stone-300 focus:outline-none focus:border-amber-600 text-sm">
            </div>
            <button type="submit" class="w-full bg-slate-900 hover:bg-amber-800 text-white font-medium py-2.5 rounded-xl transition text-sm">
                Masuk Sekarang
            </button>
        </form>

        <div class="mt-6 pt-5 border-t border-stone-100 text-xs text-slate-500 space-y-1">
            <p class="font-semibold text-slate-700">Akun Demo Cepat (Password: <code class="bg-stone-100 px-1 rounded">password123</code>):</p>
            <p>• Admin: <span class="text-amber-700">budi.admin@hotel.com</span></p>
            <p>• Tamu: <span class="text-amber-700">raka.tamu@gmail.com</span></p>
        </div>
    </div>
</div>
@endsection