<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;

class StoreFamilyRequest extends FormRequest
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
            'no_kk' => 'required|string|digits:16',
            'family_members' => 'required|array|min:1',
            'family_members.*.nik' => 'required|string|digits:16|unique:penduduks,nik',
            'family_members.*.nama' => 'required|string|max:255',
            'family_members.*.jk' => 'required|in:laki-laki,perempuan',
            'family_members.*.tmp_lahir' => 'required|string|max:100',
            'family_members.*.tgl_lahir' => 'required|date',
            'family_members.*.agamas_id' => 'required|exists:agamas,id',
            'family_members.*.pendidikans_id' => 'required|exists:pendidikans,id',
            'family_members.*.pekerjaans_id' => 'required|exists:pekerjaans,id',
            'family_members.*.stat_kawins_id' => 'required|exists:stat_kawins,id',
            'family_members.*.stat_hub_keluargas_id' => 'required|exists:stat_hub_keluargas,id',
            'alamat' => 'required|string',
            'dusun' => 'required|string',
            'no_rt' => 'required|integer',
            'no_rw' => 'required|integer',
        ];
    }

    /**
     * Get custom messages for validator errors.
     */
    public function messages(): array
    {
        return [
            'no_kk.required' => 'Nomor KK wajib diisi',
            'no_kk.digits' => 'Nomor KK harus terdiri dari 16 digit',
            'family_members.required' => 'Minimal harus ada 1 anggota keluarga',
            'family_members.*.nik.required' => 'NIK wajib diisi',
            'family_members.*.nik.digits' => 'NIK harus terdiri dari 16 digit',
            'family_members.*.nik.unique' => 'NIK sudah terdaftar',
            'family_members.*.nama.required' => 'Nama wajib diisi',
            'family_members.*.jk.required' => 'Jenis kelamin wajib dipilih',
            'family_members.*.tmp_lahir.required' => 'Tempat lahir wajib diisi',
            'family_members.*.tgl_lahir.required' => 'Tanggal lahir wajib diisi',
            'alamat.required' => 'Alamat wajib diisi',
            'dusun.required' => 'Dusun wajib dipilih',
            'no_rt.required' => 'Nomor RT wajib diisi',
            'no_rw.required' => 'Nomor RW wajib diisi',
        ];
    }

    /**
     * Prepare the data for validation.
     */
    protected function prepareForValidation(): void
    {
        // Clean and format the data before validation
        $this->merge([
            'no_kk' => trim($this->no_kk),
            'alamat' => trim($this->alamat ?? ''),
        ]);
    }
}
