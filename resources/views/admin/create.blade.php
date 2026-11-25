@extends('layouts.admin')
@section('title', 'Tambah Tipe Kamar — Hotel California')
@section('header', 'Tambah Tipe Kamar Baru')

@push('styles')
<link href="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.css" rel="stylesheet">
@endpush

@section('content')
<div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <form action="{{ route('admin.room-types.store') }}" method="POST" enctype="multipart/form-data" class="space-y-4">
        @csrf
        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Nama Tipe Kamar</label>
                <input type="text" name="name" value="{{ old('name') }}" required placeholder="Misal: Presidential Suite" class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Harga per Malam (Rp)</label>
                <input type="number" name="price_per_night" value="{{ old('price_per_night') }}" required placeholder="850000" class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm">
            </div>
        </div>

        <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Kapasitas Tamu (Orang)</label>
                <input type="number" name="capacity" value="{{ old('capacity', 2) }}" required min="1" max="10" class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm">
            </div>
            <div>
                <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Foto Kamar (Opsional)</label>
                <input type="file" name="image" accept="image/*" class="w-full px-3 py-1.5 rounded-xl border border-slate-300 text-sm">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Ringkasan Fasilitas</label>
            <input type="text" name="facilities" value="{{ old('facilities') }}" required placeholder="King Bed, Wi-Fi, Smart TV, Sarapan..." class="w-full px-4 py-2 rounded-xl border border-slate-300 text-sm">
        </div>

        <div>
            <label class="block text-xs font-semibold uppercase text-slate-600 mb-1">Deskripsi Lengkap Kamar (WYSIWYG Editor)</label>
            <textarea id="summernote" name="description" required>{{ old('description') }}</textarea>
        </div>

        <div class="flex justify-end gap-3 pt-4">
            <a href="{{ route('admin.room-types.index') }}" class="px-4 py-2 rounded-xl border border-slate-300 text-sm text-slate-600">Batal</a>
            <button type="submit" class="px-6 py-2 rounded-xl bg-slate-900 hover:bg-amber-700 text-white text-sm font-medium transition">Simpan Tipe Kamar</button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script src="https://cdn.jsdelivr.net/npm/summernote@0.8.18/dist/summernote-lite.min.js"></script>
<script>
    $('#summernote').summernote({
        placeholder: 'Tulis deskripsi keunggulan kamar dengan format menarik...',
        tabsize: 2,
        height: 180
    });
</script>
@endpush