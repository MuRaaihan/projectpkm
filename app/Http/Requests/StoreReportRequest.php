<?php

namespace App\Http\Requests;

use Illuminate\Contracts\Validation\ValidationRule;
use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class StoreReportRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return $this->user()?->isSiswa() === true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, ValidationRule|array<mixed>|string>
     */
    public function rules(): array
    {
        return [
            'category_id' => [
                'required',
                Rule::exists('categories', 'id')->where('is_active', true),
            ],
            'reporter_role' => ['required', 'in:korban,saksi'],
            'incident_date' => ['required', 'date', 'before_or_equal:today'],
            'location' => ['required', 'string', 'max:150'],
            'description' => ['required', 'string', 'min:10', 'max:5000'],
            'accused_name' => ['nullable', 'string', 'max:255'],
            'is_hidden_identity' => ['nullable', 'boolean'],
            'attachments' => ['nullable', 'array', 'max:3'],
            'attachments.*' => ['file', 'mimes:jpg,jpeg,png,pdf', 'max:5120'], // Max 5 MB
        ];
    }

    /**
     * Pesan validasi Bahasa Indonesia
     */
    public function messages(): array
    {
        return [
            'category_id.required' => 'Silakan pilih kategori perundungan.',
            'category_id.exists' => 'Kategori yang dipilih tidak valid atau sudah tidak aktif.',
            'reporter_role.required' => 'Pilih apakah kamu sebagai korban atau saksi.',
            'reporter_role.in' => 'Pilihan peran pelapor tidak valid.',
            'incident_date.required' => 'Tanggal kejadian wajib diisi.',
            'incident_date.date' => 'Format tanggal kejadian tidak valid.',
            'incident_date.before_or_equal' => 'Tanggal kejadian tidak boleh melewati hari ini.',
            'location.required' => 'Lokasi atau tempat kejadian wajib diisi.',
            'location.max' => 'Lokasi kejadian maksimal 150 karakter.',
            'description.required' => 'Ceritakan kejadian yang kamu alami atau saksikan.',
            'description.min' => 'Cerita kejadian minimal 10 karakter.',
            'description.max' => 'Cerita kejadian maksimal 5.000 karakter.',
            'accused_name.max' => 'Nama pihak yang dilaporkan maksimal 255 karakter.',
            'attachments.max' => 'Kamu hanya dapat mengunggah maksimal 3 file bukti.',
            'attachments.*.file' => 'Bukti harus berupa file yang valid.',
            'attachments.*.mimes' => 'Format bukti yang diizinkan hanya JPG, PNG, atau PDF.',
            'attachments.*.max' => 'Ukuran setiap file bukti maksimal 5 MB.',
        ];
    }
}
