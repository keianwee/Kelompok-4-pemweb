@extends('layouts.admin')
@section('title', 'Backup & Restore Data — Hotel California')
@section('header', 'Backup Otomatis & Pemulihan Data (Disaster Recovery)')

@section('content')
<div class="grid md:grid-cols-2 gap-6">
    <!-- Panel Backup -->
    <div class="bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
        <h3 class="font-bold text-slate-900 mb-2">Backup Database Hotel</h3>
        <p class="text-xs text-slate-500 mb-4">Sistem secara otomatis mencadangkan seluruh data kamar, user, dan transaksi setiap hari. Anda juga dapat mengunduh cadangan manual kapan saja.</p>
        
        <a href="{{ route('admin.backup.download') }}" class="inline-block bg-slate-900 hover:bg-amber-700 text-white text-xs font-medium px-4 py-2.5 rounded-xl transition mb-6">
            Download Backup Sekarang (.json)
        </a>

        <h4 class="text-xs font-semibold uppercase text-slate-500 mb-2">Riwayat Auto-Backup Harian di Server</h4>
        <ul class="divide-y divide-slate-100 text-xs">
            @forelse($files as $file)
                <li class="py-2.5 flex justify-between items-center">
                    <span class="font-mono text-slate-700">{{ basename($file) }}</span>
                    <a href="{{ route('admin.backup.file', basename($file)) }}" class="text-amber-700 font-semibold hover:underline">Unduh</a>
                </li>
            @empty
                <li class="py-2 text-slate-400">Belum ada file auto-backup.</li>
            @endforelse
        </ul>
    </div>

    <!-- Panel Import / Restore -->
    <div class="bg-white rounded-2xl shadow-sm border border-rose-200 p-6">
        <h3 class="font-bold text-rose-800 mb-2">Import / Restore Data (Pemulihan Darurat)</h3>
        <p class="text-xs text-slate-600 mb-4">Gunakan fitur ini jika website mengalami gangguan atau data terhapus. Unggah file <strong>.json</strong> hasil backup untuk memulihkan seluruh kamar, akun, dan riwayat reservasi.</p>
        
        <form action="{{ route('admin.backup.import') }}" method="POST" enctype="multipart/form-data" onsubmit="return confirm('Yakin ingin menimpa data saat ini dengan file backup?')">
            @csrf
            <input type="file" name="backup_file" accept=".json" required class="block w-full text-xs text-slate-600 file:mr-4 file:py-2 file:px-4 file:rounded-xl file:border-0 file:text-xs file:font-semibold file:bg-amber-50 file:text-amber-800 hover:file:bg-amber-100 mb-4">
            <button type="submit" class="bg-rose-700 hover:bg-rose-800 text-white text-xs font-medium px-5 py-2.5 rounded-xl transition">
                Mulai Restore Data Sekarang
            </button>
        </form>
    </div>
</div>
@endsection