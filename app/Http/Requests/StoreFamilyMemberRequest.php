<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyMemberRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     */
    public function rules(): array
    {
        return [
            'no_kk' => 'required|string|max:16|exists:penduduks,no_kk',
            'alamats_id' => 'required|exists:alamats,id',
            'nik' => 'required|string|max:16|unique:penduduks,nik',
            'nama' => 'required|string|max:255',
            'jk' => 'required|in:laki-laki,perempuan',
            'tmp_lahir' => 'required|string|max:100',
            'tgl_lahir' => 'required|date',
            'agamas_id' => 'required|exists:agamas,id',
            'pendidikans_id' => 'required|exists:pendidikans,id',
            'pekerjaans_id' => 'required|exists:pekerjaans,id',
            'stat_kawins_id' => 'required|exists:stat_kawins,id',
            'stat_hub_keluargas_id' => 'required|exists:stat_hub_keluargas,id',

            // Optional fields
            'pendidikan_sedangs_id' => 'nullable|exists:pendidikan_sedangs,id',
            'kewarganegaraan' => 'nullable|string|max:10',
            'ayah_nik' => 'nullable|string|max:16',
            'ayah_nama' => 'nullable|string|max:255',
            'ibu_nik' => 'nullable|string|max:16',
            'ibu_nama' => 'nullable|string|max:255',
            'gol_darahs_id' => 'nullable|exists:gol_darahs,id',
            'akta_lahir' => 'nullable|string|max:50',
            'dok_passport' => 'nullable|string|max:50',
            'tgl_akhir_passport' => 'nullable|date',
            'dok_kitas' => 'nullable|string|max:50',
            'akta_perkawinan' => 'nullable|string|max:50',
            'tgl_perkawinan' => 'nullable|date',
            'akta_perceraian' => 'nullable|string|max:50',
            'tgl_perceraian' => 'nullable|date',
            'cacats_id' => 'nullable|exists:cacats,id',
            'cara_kbs_id' => 'nullable|exists:cara_kbs,id',
            'stat_rekams_id' => 'nullable|exists:stat_rekams,id',
            'stat_dasars_id' => 'nullable|exists:stat_dasars,id',
            'suku' => 'nullable|string|max:50',
            'tag_id_card' => 'nullable|string|max:50',
            'asuransis_id' => 'nullable|exists:asuransis,id',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'no_kk.required' => 'Nomor KK wajib diisi',
            'no_kk.exists' => 'Nomor KK tidak ditemukan',
            'alamats_id.required' => 'Alamat wajib dipilih',
            'alamats_id.exists' => 'Alamat tidak valid',
            'nik.required' => 'NIK wajib diisi',
            'nik.unique' => 'NIK sudah terdaftar',
            'nik.max' => 'NIK maksimal 16 karakter',
            'nama.required' => 'Nama wajib diisi',
            'nama.max' => 'Nama maksimal 255 karakter',
            'jk.required' => 'Jenis kelamin wajib dipilih',
            'jk.in' => 'Jenis kelamin harus laki-laki atau perempuan',
            'tmp_lahir.required' => 'Tempat lahir wajib diisi',
            'tgl_lahir.required' => 'Tanggal lahir wajib diisi',
            'tgl_lahir.date' => 'Format tanggal lahir tidak valid',
            'agamas_id.required' => 'Agama wajib dipilih',
            'agamas_id.exists' => 'Agama yang dipilih tidak valid',
            'pendidikans_id.required' => 'Pendidikan wajib dipilih',
            'pendidikans_id.exists' => 'Pendidikan yang dipilih tidak valid',
            'pekerjaans_id.required' => 'Pekerjaan wajib dipilih',
            'pekerjaans_id.exists' => 'Pekerjaan yang dipilih tidak valid',
            'stat_kawins_id.required' => 'Status kawin wajib dipilih',
            'stat_kawins_id.exists' => 'Status kawin yang dipilih tidak valid',
            'stat_hub_keluargas_id.required' => 'Status hubungan keluarga wajib dipilih',
            'stat_hub_keluargas_id.exists' => 'Status hubungan keluarga yang dipilih tidak valid',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean and format the data before validation
        $this->merge([
            'nik' => trim($this->nik),
            'nama' => trim($this->nama),
            'tmp_lahir' => trim($this->tmp_lahir),
        ]);
    }
}
