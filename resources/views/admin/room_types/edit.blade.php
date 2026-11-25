@extends('layouts.admin')
@section('title', 'Edit Tipe Kamar — Hotel California')
@section('header', 'Edit Tipe Kamar')

@section('content')
<div class="max-w-3xl bg-white rounded-2xl shadow-sm border border-slate-200 p-6">
    <form action="{{ route('admin.room-types.update', $roomType) }}" method="POST" class="space-y-5">
        @csrf
        @method('PUT')
        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Nama Tipe Kamar</label>
            <input type="text" name="name" value="{{ old('name', $roomType->name) }}" required class="w-full text-sm border border-slate-300 rounded-xl px-4 py-2.5">
        </div>

        <div class="grid grid-cols-2 gap-4">
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Harga per Malam (Rp)</label>
                <input type="number" name="price_per_night" value="{{ old('price_per_night', $roomType->price_per_night) }}" required class="w-full text-sm border border-slate-300 rounded-xl px-4 py-2.5">
            </div>
            <div>
                <label class="block text-xs font-semibold text-slate-700 mb-1.5">Kapasitas Maksimal (Orang)</label>
                <input type="number" name="capacity" value="{{ old('capacity', $roomType->capacity) }}" min="1" required class="w-full text-sm border border-slate-300 rounded-xl px-4 py-2.5">
            </div>
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Ringkasan Fasilitas</label>
            <input type="text" name="facilities" value="{{ old('facilities', $roomType->facilities) }}" required class="w-full text-sm border border-slate-300 rounded-xl px-4 py-2.5">
        </div>

        <div>
            <label class="block text-xs font-semibold text-slate-700 mb-1.5">Deskripsi Lengkap (WYSIWYG Editor)</label>
            <textarea id="summernote" name="description" required>{{ old('description', $roomType->description) }}</textarea>
        </div>

        <div class="flex justify-end gap-3 pt-2">
            <a href="{{ route('admin.room-types.index') }}" class="px-5 py-2.5 rounded-xl text-xs font-medium text-slate-600 hover:bg-slate-100">Batal</a>
            <button type="submit" class="bg-amber-600 hover:bg-amber-700 text-white text-xs font-semibold px-6 py-2.5 rounded-xl transition">
                Perbarui Tipe Kamar
            </button>
        </div>
    </form>
</div>
@endsection

@push('scripts')
<script>
    $(document).ready(function() {
        $('#summernote').summernote({
            height: 180
        });
    });
</script>
@endpush